<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreToDiscountRequest;
use App\Models\Lot;
use App\Models\LotToDiscount;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\ReasonToDiscount;
use App\Models\toDiscount;
use App\Models\TypeToDiscount;
use App\Models\UserToDiscount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ToDiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:to_discount_index')->only('index');
        $this->middleware('can:to_discount_create')->only('create','store');
        $this->middleware('can:to_discount_show')->only('show');
        $this->middleware('can:to_discount_edit')->only('edit','update');
        $this->middleware('can:to_discount_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $res)
    {
        $info = $res->search;
        $discounts = toDiscount::
            select('to_discounts.*')
            ->join('users AS a','a.id','to_discounts.user_id')
            ->join('profiles AS b','b.user_id','a.id')
            ->join('type_to_discounts AS c','to_discounts.type_to_discount_id','c.id')
            ->whereRaw("unaccent(a.email) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(a.username) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(b.name) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(b.lastname) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(c.description) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(to_char(to_discounts.created_at,'dd/mm/yy HH12:MI AM')) ILIKE unaccent('%".$info."%')")
            ->orderBy('id','desc')
            ->paginate(5);
        return view('toDiscount.index',compact('discounts','info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = TypeToDiscount::where('status',true)->get();
        $staff = Profile::select('profiles.name','profiles.lastname','profiles.id')->join('users','profiles.user_id','users.id')->where('status','=',true)->where('profiles.id','!=',1)->get();
        return view('toDiscount.create',compact('staff','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreToDiscountRequest $request)
    {

        $type   = $request->input('type_to_discount_id');
        $staff  = $request->input('staff');
        $user   = Auth::user()->id;
        $dolar  = $request->input('dolar');
        $reason = $request->reason;

        try {
            DB::beginTransaction();
            $toDiscount = toDiscount::create($request->only('type_to_discount_id')+['user_id'=>$user]);

            if($type==4 && !empty($staff)) {
                UserToDiscount::create(['user_id'=>$staff,'to_discount_id'=>$toDiscount['id']]);
            }

            if($type==3 || $type==4) {
                $reason_id = ReasonToDiscount::create(['to_discount_id'=>$toDiscount->id,'reason'=>$reason]);
            }

            // iterar lotes
            foreach ($request->prods as $key => $prod) {
                foreach ($prod['lots'] as $key => $data) {
                    $lot = Lot::findOrFail($data['id']);

                    if ($data['quantity'] > ($lot->quantity)-($lot->sold)) {
                        DB::rollBack();
                        return response()->json(['res'=>2,'info'=>'Error al registrar los datos, no puede pedir más que las existencias de un producto']);
                    } else {
                        try {
                            $lot->increment('sold', $data['quantity']);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return response()->json(['res'=>4,'info'=>'Error al incrementar la venta del lote']);
                        }

                        $total = $data['quantity']*$data['price'];

                        if($data['divisa']==2){
                            $bs  = $total*$dolar;
                            $usd = $total;
                        } else if($data['divisa']==1){
                            $bs  = $total;
                            $usd = $total/$dolar;
                        }

                        try {
                            $last = LotToDiscount::create([
                                'to_discount_id' => $toDiscount['id'],
                                'lot_id'         => $lot['id'],
                                'quantity'       => $data['quantity'],
                                'price_bs'       => $bs,
                                'price_usd'      => $usd
                            ]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            echo 5;
                        }
                    };
                }
            }
            DB::commit();
            return response()->json(['res'=>1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['res'=>3, 'info'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id       = Crypt::decrypt($id);
        $discount = toDiscount::with('todiscount.LotToDiscount.products')->findOrFail($id);
        return view('toDiscount.show',compact('discount'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id         = Crypt::decrypt($id);
        $toDiscount = toDiscount::findOrFail($id);
        $now = Carbon::now();
        try {
            DB::beginTransaction();
            foreach ($toDiscount->todiscount as $k => $v) {
                $lot = Lot::findOrFail($v->lot_id);
                $lot->sold = ($lot->sold-$v->quantity);
                $lot->updated_at = $now;
                $lot->save();
            }
            $toDiscount->updated_at = $now;
            $toDiscount->status = false;
            $toDiscount->save();
            DB::commit();
            return redirect()->route('tdscnt.index')->with('success','Descuento reversado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('success','No se pudo anular el descuento, motivo: '.$e->getMessage().'.')->with('type','danger');
        }
    }

    public function productByIdLot($id) {
        $product = Lot::where('cod_lot',$id)->where('status',true)->with('products')->first();
        $var     = response()->json($product);
        return $var;
    }
}

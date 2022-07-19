<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Models\Debt;
use App\Models\DebtorMovement;
use App\Models\DebtorMovementTransaction;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodTransaction;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sale_index')->only('index');
        $this->middleware('can:sale_create')->only('create','store');
        $this->middleware('can:sale_show')->only('show');
        $this->middleware('can:sale_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $res)
    {
        $info = $res->search;
        $sales = Transaction::
            select('transactions.*')
            ->selectRaw("CASE WHEN transaction_type = '1' THEN 'Venta de Contado' ELSE 'Venta a Crédito' END AS type")
            ->join('clients AS a','transactions.client_id','a.id')
            ->join('profiles AS b','transactions.user_id','b.id')
            ->whereRaw("unaccent(a.name) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(a.lastname) ILIKE unaccent('%".$info."%')")
            ->orWhere("a.ced",'ILIKE',$info)
            ->orWhere("b.identification",'ILIKE',$info)
            ->orWhereRaw("unaccent(b.name) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(b.lastname) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(CASE WHEN transaction_type = '1' THEN 'Venta de Contado' ELSE 'Venta a Crédito' END) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(to_char(transactions.created_at, 'dd/mm/yy HH12:MI AM')) ILIKE unaccent('%".$info."%')")
            ->orderBy('id','desc')
            ->paginate(5);
        // dd($sales);
        return view('sales.index',compact('sales','info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $method = PaymentMethod::where('status',true)->orderBy('description')->get();

        if(Product::where('status',true)->count('id')>=1) {
            return view('sales.create',compact('method'));
        } else {
            return back()->withInput()->with('success','No hay productos registrados en el sistema')->with('type','warning');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStoreRequest $request)
    {
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        try {
            DB::beginTransaction();
            $user = User::find(Auth::user()->id);
            $info = ['user_id'=>$user->id];
            $transaction = Transaction::create($request->only('transaction_type','client_id')+$info);
            if ($request->transaction_type==1) {
                foreach ($request->payment_method_id as $value) {
                    PaymentMethodTransaction::create(['payment_method_id'=>$value,'transaction_id'=>$transaction->id]);
                }
            }
            $total_prods = 0;
            foreach ($request->prods as $v) {
                if($v['sale_measure']==1 && strpos($v['sale'],'.')) {
                    DB::rollBack();
                    return response()->json(['res'=>2,'info'=>'La cantidad de un producto a vender, posee un formato no permitido']);
                }
                $product = Product::findOrFail($v['id']);
                $sale = $v['sale_measure']==1 ? intval($v['sale']) : floatval($v['sale']);
                if(($v['sale_measure']==1 && is_float($sale)||($v['sale_measure']==2 && is_int($sale)))){
                    DB::rollBack();
                    return response()->json(['res'=>2]);
                }
                if(count($v['price'])==1){
                    $price = floatval($v['price'][0]['price']);
                    $divisa = floatval($v['price'][0]['divisa']);
                } else {
                    foreach ($v['price'] as $value) {
                        if($value['selected']=='true'){
                            $price = floatval($value['price']);
                            $divisa = floatval($value['divisa']);
                        }
                    }
                }
                $total_prods = $total_prods+floatval($v['sale']);
                if($divisa==1) {
                    $bs = $price;
                    $usd = $price/$request->usd;
                } elseif($divisa==2){
                    $usd = $price;
                    $bs = $price*$request->usd;
                }
                ProductTransaction::create(['product_id'=>$product->id,'transaction_id'=>$transaction->id,'quantity'=>$v['sale'],'price_usd'=>round($usd,2),'price_bs'=>round($bs,2)]);
            }

            if($request->transaction_type==2) {
                $debt = Debt::where('client_id',$request->client_id)->where('status',true)->get()->last();



                $amount_bs=$bs*floatval($total_prods);
                $amount_usd=$usd*floatval($total_prods);

                // $debt = $debt ? Debt::create($request->only('client_id')) : $debt;
                if(!$debt) {
                    $debt = Debt::create($request->only('client_id'));
                }

                $data = [
                    'debt_id'=>$debt->id,
                    'amount_bs'=>$amount_bs,
                    'amount_usd'=>$amount_usd,
                    'movement_type'=>true
                ];
                $debtor_movement = DebtorMovement::create($data);
                DebtorMovementTransaction::create(['transaction_id'=>$transaction->id,'debtor_movement_id'=>$debtor_movement->id]);
            }

            DB::commit();
            return response()->json(['res'=>1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['res'=>3,'info'=>$e->getMessage()]);
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
        $id = Crypt::decrypt($id);
        $transaction = Transaction::findOrFail($id);
        return view('sales.show',compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id     = Crypt::decrypt($id);
        $transaction   = Transaction::findOrFail($id);
        try {
            if($transaction->transaction_type==2) {
                $transaction_bs = 0;
                $transaction_usd = 0;
                $debt_bs = 0;
                $debt_usd = 0;
                foreach ($transaction->products as $value) {
                    $transaction_bs = $transaction_bs+(floatval($value['price_bs'])*intval($value['quantity']));
                    $transaction_usd = $transaction_usd+(floatval($value['price_usd'])*intval($value['quantity']));
                }
                // dd($transaction->client->debts);
                foreach ($transaction->client->debts as $v) {
                    if ($v->status) {
                        $debt = Debt::find($v['id']);
                        foreach($debt->movements as $info) {
                            $debt_bs = $debt_bs + floatval($info['amount_bs']);
                            $debt_usd = $debt_usd + floatval($info['amount_usd']);
                        }
                    }
                }

                $debt_movement = DebtorMovement::find($transaction->debtMovement->DebtorMovement->id);
                $debt_movement->update(['status'=>false]);
                if (($transaction_bs-$debt_bs<=0) && ($transaction_usd-$debt_usd<=0)) {
                    $debt->update(['status'=>3]);
                    $transaction->update(['status'=>false]);
                }
            }
            $transaction->update(['status'=>false]);
            return redirect()->route('sls.show',Crypt::encrypt($id))->with('success','Transacción anulada');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sls.show',Crypt::encrypt($id))->with('success',$e->getMessage())->with('type','danger');
        }
    }

    public function salesWeek(Request $res)
    {
        $id = empty($res->id) ? auth()->user()->id : Crypt::decrypt($res->id);

        $transactions = Transaction::
            selectRaw("count(id), CASE WHEN to_char(created_at,'dy')='mon' THEN 'Lun' WHEN to_char(created_at,'dy')='tue' THEN 'Mar' WHEN to_char(created_at,'dy')='wed' THEN 'Mié' WHEN to_char(created_at,'dy')='Thu' THEN 'Jue' WHEN to_char(created_at,'dy')='fri' THEN 'Vie' WHEN to_char(created_at,'dy')='sat' THEN 'Sáb' WHEN to_char(created_at,'dy')='sun' THEN 'Dom' END AS dia, transaction_type AS type")
            ->where('user_id',$id)
            ->whereBetween('created_at',[Carbon::now()->subDays(7),now()])
            ->groupByRaw("to_char(created_at,'dy'),transaction_type")
            ->get();
        return response()->json($transactions);
    }

    public function lastTransaction(Request $res)
    {
        $id = empty($res->id) ? auth()->user()->id : Crypt::decrypt($res->id);
        $transaction = Transaction::
            selectRaw("created_at as date")
            ->where('user_id',$id)
            ->orderBy('id','desc')
            ->first();
        return response()->json($transaction);
    }

    public function clientSalesWeek(Request $res)
    {
        $id = empty($res->id) ? auth()->user()->id : Crypt::decrypt($res->id);

        $transactions = Transaction::
            selectRaw("count(id), CASE WHEN to_char(created_at,'dy')='mon' THEN 'Lun' WHEN to_char(created_at,'dy')='tue' THEN 'Mar' WHEN to_char(created_at,'dy')='wed' THEN 'Mié' WHEN to_char(created_at,'dy')='Thu' THEN 'Jue' WHEN to_char(created_at,'dy')='fri' THEN 'Vie' WHEN to_char(created_at,'dy')='sat' THEN 'Sáb' WHEN to_char(created_at,'dy')='sun' THEN 'Dom' END AS dia, transaction_type AS type")
            ->where('client_id',$id)
            ->whereBetween('created_at',[Carbon::now()->subDays(7),now()])
            ->groupByRaw("to_char(created_at,'dy'),transaction_type")
            ->get();

        return response()->json($transactions);
    }

}

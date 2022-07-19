<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRegisterRequest;
use App\Http\Requests\LotUpdateRequest;
use App\Models\Divisas;
use App\Models\Lot;
use App\Models\LotProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LotController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:lot_create')->only('store');
        $this->middleware('can:lot_show')->only('show');
        $this->middleware('can:lot_edit')->only('edit','update');
        $this->middleware('can:lot_destroy')->only('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LotRegisterRequest $request,$id)
    {
        $id = Crypt::decrypt($id);
        $prod = Product::findOrFail($id);
        if($prod->unit_box==null && $request->input('conteo')==2) {
            return redirect()->back()->with('success','Error al registrar el lote, no hay cantidad de unidades por caja registradas.')->with('type','danger')->withInput();
        }
        try {
            DB::beginTransaction();
            $total = $request->input('conteo')==2 ? $prod->unit_box*$request->input('quantity') : $request->input('quantity');
            $lot = Lot::create($request->only('price_bs','price_dollar','sell_price','expiration','cod_lot')+['divisa_id'=>$request->input('divisa'),'quantity'=>$total]);
            $prod->lots()->attach($lot);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('invntry.show',Crypt::encrypt($id))->with('success','No se pudo registrar el lote, motivo: '.$e->getMessage().'.')->with('type','danger');
        }
        return redirect()->route('invntry.show',Crypt::encrypt($id))->with('success','Éxito al registrar el lote "'.$lot->cod_lot.'"');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id      = Crypt::decrypt($id);
        $lot     = Lot::findOrFail($id);
        return view('batches.show',compact('lot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id      = Crypt::decrypt($id);
        $lot     = Lot::findOrFail($id);
        $divisas = Divisas::where('status','=',true)->get();
        return view('batches.edit',compact('lot'),compact('divisas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LotUpdateRequest $request, $id)
    {
        $id  = Crypt::decrypt($id);
        $lot = Lot::findOrFail($id);

        if($lot->product[0]->unit_box==null && $request->input('conteo')==2) {
            return redirect()->back()->with('success','Error al actualizar los datos del lote, no hay cantidad de unidades por caja registradas')->with('type','warning')->withInput();
        }
        if($request->quantity >= $lot->sold){
            if(($request->divisa==1 && $request->price_bs > $request->sell_price ) || ($request->divisa==2 && $request->price_dollar > $request->sell_price)) {
                return redirect()->back()->with('success','Error al actualizar los datos del lote, no puede vender un producto a un precio menor del precio de compra')->with('type','danger')->withInput();
            } else {
                if($lot->product[0]->unit_box) {
                    $total = $request->input('conteo')==2 ? $lot->product[0]->unit_box*$request->input('quantity') : $request->input('quantity');
                } else { $total = $request->quantity; }

                $data = $request->only(
                    'cod_name',
                    'price_bs',
                    'price_dollar',
                    'sell_price',
                    'divisa',
                    'expiration'
                )+['quantity'=>$total];

                $lot->update($data);

                return redirect()->route('invntry.show',Crypt::encrypt($lot->product[0]->id))->with('success','Éxito al actualizar la información del lote "'.$lot->cod_lot.'", perteneciente al producto "'.$lot->product[0]->name.'"');
            }
        } else {
            return redirect()->back()->with('success','Error al actualizar los datos del lote, no puede registrar menos productos en el lote que los que fueron vendidos')->with('type','danger')->withInput();
        }
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
        $lot    = Lot::findOrFail($id);
        $data   = array('status'=>!$lot->status);
        $action = $lot->status ? 'deshabilitado' : 'habilitado';
        $lot->update($data);
        return redirect()->route('invntry.show',Crypt::encrypt($lot->product[0]->id))->with('success','El lote "'.$lot->cod_lot.'" del producto "'.$lot->product[0]->name.'" fue '.$action.' correctamente');
    }

    public function showExpiring(){
        $lots = Lot::with('products')->where('expiration','<',now())->orWhereBetween('expiration',[Carbon::now()->format('Y-m-d'),Carbon::now()->add(30, 'day')->format('Y-m-d')])->where('status',true)->get();
        return response()->json($lots);
    }
}

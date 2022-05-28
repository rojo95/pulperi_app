<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRegisterRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Divisas;
use App\Models\Lot;
use App\Models\Product;
use App\Models\ProductsType;
use App\Models\sales_measures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inventory_index')->only('index');
        $this->middleware('can:inventory_create')->only('create','store');
        $this->middleware('can:inventory_show')->only('show');
        $this->middleware('can:inventory_edit')->only('edit','update');
        $this->middleware('can:inventory_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);
        return view('inventory.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tprod = ProductsType::where('status','=',true)->get();
        $divisas = Divisas::where('status','=',true)->get();
        $sale_measure = sales_measures::where('status',true)->get();
        return view('inventory.create', compact('tprod','divisas','sale_measure'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRegisterRequest $request)
    {
        $total = $request->input('conteo')==2 ? $request->input('unit_box')*$request->input('quantity') : $request->input('quantity');
        try {
            DB::beginTransaction();
            $product = Product::create($request->only('name','description','unit_box','bar_code','sales_measure_id')+['products_type_id'=>$request->input('tipo')]);

            $lot = Lot::create($request->only('expiration','cod_lot','price_bs','price_dollar','sell_price')+['quantity'=>$total,'divisa_id'=>$request->divisa]);

            $product->lots()->sync($lot);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('success','No se pudo registrar el producto, motivo: '.$e->getMessage().'.')->with('type','danger');
        }
        return redirect()->route('invntry.index')->with('success','Producto '.$product->name.' registrado correctamente');
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
        $product = Product::findOrFail($id);
        $divisas = Divisas::where('status','=',true)->get();
        return view('inventory.show',compact('product'),compact('divisas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tprod = ProductsType::where('status','=',true)->get();
        $id = Crypt::decrypt($id);
        $product = Product::findOrFail($id);
        return view('inventory.edit',compact('product'),compact('tprod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $id      = Crypt::decrypt($id);
        $product = Product::findOrFail($id);
        $data    = array(
            'name' => $request->name,
            'description' => $request->description,
            'unit_box' => $request->unit_box,
            'products_type_id' => $request->tipo,
        );
        $product->update($data);
        return redirect()->route('invntry.show',Crypt::encrypt($id))->with('success','Información del producto "'.$request->name.'" actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Consultar producto por nombres
    public function productByName(Request $request)
    {
        $prods = $request->prods;
        $info = $request->info;
        $p = array();

        $product = Product::with('lots')->where('products.status',true);

        if ($prods!=NULL) {
            foreach ($prods as $k => $v) {
                array_push($p,$v['id']);
            }
            $product = $product->whereNotIn('products.id',$p);
        }

        if(!empty($info)) {
            $info = '%'.$info.'%';
            $product = $product->where('name','ilike',$info)->orWhere('description','ilike',$info);
        }

        $product = $product->get();

        $arr = array();

        foreach ($product as $k => $v) {
            $prod = $v->name;
            $existence = 0;
            $desc = $v->description;
            foreach ($v->lots as $i => $d) {
                if($d->status==true){
                    $existence = $existence + ($d->quantity-$d->sold);
                }
                // $existence = 0;
            }
            array_push($arr,['id'=>$v->id,'prod'=>$prod,'quantity'=>$existence,'desc'=>$desc]);
        }
        return response()->json($arr);
    }

    public function productById(Request $request)
    {
        $id = $request->id;
        $prod = Product::findOrFail($id);
        $existence = 0;
        $arr = array();
        $price = array();
        $price_arr = array();
        foreach ($prod->lots as $k => $v) {
            $existence = $existence + ($v->quantity-$v->sold);
            $sell_price = $v->sell_price;
            array_push($price,['price'=>$sell_price,'divisa'=>$v->divisa_id,'selected'=>false]);
        }

        foreach ($price as $key => $value) {
            if(!in_array($value,$price_arr)){
                array_push($price_arr,$value);
            }
        }

        array_push($arr,['id'=>$prod->id,'img'=>$prod->img,'prod'=>$prod->name,'desc'=>$prod->desc,'existence'=>$existence,'price'=>$price_arr,'sale_measure'=>$prod->sales_measure_id]);
        return response()->json($arr);
    }
}

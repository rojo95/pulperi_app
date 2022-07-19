<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NotificationController extends Controller
{
    // ventana principal de las notificaciones.
    public function index(Request $res)
    {
        $info = $res->search;
        $prods = Lot::select('lots.*','products.*')
            ->join('lot_product','lots.id','lot_product.lot_id')
            ->join('products','lot_product.product_id','products.id')
            ->with('products')
            ->whereRaw("unaccent(cod_lot) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(name) ILIKE unaccent('%".$info."%')")
            ->where('expiration','<',now())
            ->orWhereBetween('expiration',[now()->format('Y-m-d'),now()->add(30, 'day')->format('Y-m-d')])
            ->where('lots.status',true)
            ->paginate(5);
        return view('notifications.index',compact('prods','info'));
    }

    public function show(Request $res)
    {
        $id = $res->id;
        $id = Crypt::decrypt($id);
        $prod = Lot::with('products')
            ->where('status',true)
            ->where('id',$id)
            ->first();
        return view('notifications.show',compact('prod'));
    }
}

@extends('layouts.main', ['activePage' => 'to-discount', 'titlePage' => 'Retiro realizado'])
@section('title','Retiro realizado')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Retiro realizado @if ($discount->status == false) <span class='badge badge-warning'>ANULADO</span> @endif</h1></h4>
                        <p class="card-category">Información y motivos del retiro de los productos del inventario</p>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-10 offset-sm-1">
                            <div class="row mb-3">
                                <div class="col-sm-3"><label class="col-form-label">Funcionario que Registró el Retiro:</label></div>
                                <div class="col-sm-9 mt-1">
                                    {{$discount->discounter->profile->name.' '.$discount->discounter->profile->lastname}}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><label class="col-form-label">Motivo del Retiro:</label></div>
                                <div class="col-sm-9 mt-1">
                                    {{$discount->type->description}}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Fecha de realización del descuento:</label>
                                </div>
                                <div class="col-sm-9 mt-1">
                                    {{$discount->created_at->format('d/m/Y h:i A')}}
                                </div>
                            </div>
                            @if ($discount->type_to_discount_id==4)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Personal que realizó el retiro:</label>
                                </div>
                                <div class="col-sm-9 mt-1">
                                </div>
                            </div>
                            @endif
                            @if ($discount->type_to_discount_id==4 || $discount->type_to_discount_id==3)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="reason" class="col-form-label">Descripción detallada de la razón:</label>
                                </div>
                                <div class="col-sm-9 mt-1">
                                    {{$discount->reason->reason}}
                                </div>
                            </div>
                            @endif
                            @if ($discount->status==false)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="reason" class="col-form-label text-danger">Fecha de Anulación de descuento:</label>
                                </div>
                                <div class="col-sm-9 mt-1">
                                    {{$discount->updated_at->format('d/m/Y h:i A')}}
                                </div>
                            </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="card" id="prods">
                                        <div class="card-header card-header-info d-none d-md-flex">
                                            <div class="row w-100 d-flex">
                                                <h5 class="card-title ml-2">Productos Deshabilitados</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td>Producto</td>
                                                        <td>Lote</td>
                                                        <td>Cantidad</td>
                                                        <td>Costo</td>
                                                        <td>Fecha de Vencimiento</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($discount->todiscount as $item)
                                                    <tr>
                                                        <td><strong class="text-primary">{{$item->LotToDiscount->products->name}}</strong></td>
                                                        <td>{{$item->LotToDiscount->cod_lot}}</td>
                                                        <td>{{$item->quantity}}</td>
                                                        <td>{{$item->price_bs}} Bs. = {{$item->price_usd}} USD</td>
                                                        <td>{{date('m/Y',strtotime($item->LotToDiscount->expiration))}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mx-auto mb-5">
                        <button class="btn btn-info btn-block text-white btn-back" >Volver</button>
                        @if ($discount->status)
                        <form action="{{ route('tdscnt.destroy',Illuminate\Support\Facades\Crypt::encrypt($discount->id)) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger btn-confirm">Anular Retiro</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

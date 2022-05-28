@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Lote'])
@section('title','Lote')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary ">
                        <div class="row">
                            <div class="col-sm-10 col-md-10">
                                <h4 class="card-title">Lote: {{$lot->cod_lot}}</h4>
                                <p class="card-category">Este lote perteneca al producto: <a href="{{route('invntry.show', Illuminate\Support\Facades\Crypt::encrypt($lot->products[0]->id))}}">{{$lot->products[0]->name}}<a>.</p>
                            </div>
                            <div class="col-sm-1 col-md-2 text-right">
                                <a class="nav-link" href="{{ route('lts.edit', Illuminate\Support\Facades\Crypt::encrypt($lot->id)) }}" title="Editar Lote">
                                    <button class="btn btn-secondary btn-sm custom-class"><i class="material-icons">edit</i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Estatus :</strong> </div>
                                                <div class="col">{{$lot->status == 0 ? "Deshabilitado" : "Activo";}}</div>
                                            </div>
                                        </button>
                                        @if ($lot->products[0]->unit_box)
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Unidades del Producto por Cajas :</strong>
                                                </div>
                                                <div class="col">
                                                    {{$lot->products[0]->unit_box}}<br>
                                                </div>
                                            </div>
                                        </button>
                                        @endif
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Total de Ingreso: </strong>
                                                </div>
                                                <div class="col">
                                                    {{$lot->quantity}}
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Total Vendidos: </strong>
                                                </div>
                                                <div class="col">
                                                    {{$lot->sold}}
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Total en Existencia: </strong>
                                                </div>
                                                <div class="col">
                                                    {{$lot->quantity-$lot->sold}} <br>
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Vendidos: </strong>
                                                </div>
                                                <div class="col">
                                                    {{$lot->sold}} <br>
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Fecha de Ingreso: </strong>
                                                </div>
                                                <div class="col">
                                                    {{date('d/m/Y H:i',strtotime($lot->created_at))}} <br>
                                                </div>
                                            </div>
                                        </button>
                                        @if ($lot->updated_at!=$lot->created_at || $lot->updated_at!='')
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Fecha de Última Modicicacón : </strong>
                                                </div>
                                                <div class="col">
                                                    {{date('d/m/Y H:i',strtotime($lot->updated_at))}} <br>
                                                </div>
                                            </div>
                                        </button>
                                        @endif
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <strong>Fecha de Vencimiento: </strong>
                                                </div>
                                                <div class="col">
                                                    {{date('m/Y',strtotime($lot->expiration))}} <br>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="list-group">
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Precio de Compra en Bs:</strong> </div>
                                                <div class="col">{{$lot->price_bs;}} Bs</div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Precio de Compra en USD:</strong> </div>
                                                <div class="col">{{$lot->price_dollar;}} USD</div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Precio de Venta Asignado:</strong> </div>
                                                <div class="col">
                                                        {{$lot->sell_price}} {{$lot->divisa_id == 1 ? 'Bs' : 'USD'}}
                                                </div>
                                            </div>
                                        </button>
                                        <button type="button" class="list-group-item list-group-item-action btn btn-success text-center">
                                            <span class="material-icons">insights</span> Ver Estadísticas del Producto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        <div class="button-container">
                            <button type="button" class="btn btn-info btn-back">
                                <i class="material-icons">undo</i>
                                Volver
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (session('success'))
<div class="alerta alert alert-{{session('type') ? session('type') : 'success';}} alert-dismissible fade show d-absolute" role="alert">
    {{session('success')}}.
    <a class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
@endif
@endsection

@extends('layouts.main', ['activePage' => 'sales', 'titlePage' => 'Transacción realizada'])
@section('title','Transacción realizada')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Transacción realizada @if (!$transaction->status)<span class='badge badge-warning'>ANULADO</span>@endif</h4>
                        </div>
                        @if ($transaction->status)
                        <div class="col-sm-2">
                            <form action="{{ route('sls.destroy',Illuminate\Support\Facades\Crypt::encrypt($transaction->id)) }}" method="post" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-anul" type="submit" rel="tooltip"><strong>ANULAR</strong>
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <form id="venta">
                        <div class="card-body">
                            @csrf
                            <div class="container">
                                <div class="row mt-3">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-5 mt-1"><label for="cliente"><h4 class="text-secondary">Cliente:</h4></label></div>
                                                    <div class="col">
                                                        <h4>
                                                            {{$transaction->client->name.' '.$transaction->client->lastname}}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-5 mt-1"><label for="cliente"><h4 class="text-secondary">Vendedor:</h4></label></div>
                                                    <div class="col">
                                                        <h4>
                                                            {{$transaction->seller->profile->id != 1 ? $transaction->seller->profile->name.' '.$transaction->seller->profile->lastname : $transaction->seller->profile->name}}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-5 mt-1"><label for="tipo"><h4 class="text-secondary">Tipo de Transacción:</h4></label></div>
                                                    <div class="col">
                                                        <h4>
                                                            {{$transaction->transaction_tupe==1 ? 'Venta de Contado' : 'Venta a Crédito'}}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (count($transaction->method)>0)
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-5 mt-1"><label for="tipo"><h4 class="text-secondary">Método de Pago:</h4></label></div>
                                                    <div class="col">
                                                        <h4>
                                                            @foreach ($transaction->method as $i)
                                                            <span class="badge badge-info">{{$i->description}}</span>
                                                            @endforeach
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-10 offset-md-1">
                                        <div class="card">
                                            <div class="card-header m-0">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <h4><strong class="text-primary">Lista de Compras</strong></h4>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <h4 class="text-secondary">
                                                            <div class="row p-0 m-0">
                                                                <div class="col-md-5 col-sm-12">
                                                                    Total de la Venta:
                                                                </div>
                                                                <div class="col-sm-12 col-md-7">
                                                                    @php
                                                                        $bs = 0;
                                                                        $usd = 0;
                                                                        foreach ($transaction->products as $value) {
                                                                            $bs = $bs+floatval($value->price_bs)*floatval($value->quantity);
                                                                            $usd = $usd+floatval($value->price_usd)*floatval($value->quantity);
                                                                        }
                                                                    @endphp
                                                                    {{$bs}}Bs / {{$usd}}USD
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-shopping table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Producto</th>
                                                                <th class="text-right">Precio</th>
                                                                <th class="text-right">Cantidad</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($transaction->products as $item)
                                                                <tr>
                                                                    <td class="td-name">
                                                                        <div class="row">
                                                                            <div class="col ml-3">
                                                                                <strong class="text-primary">{{$item->product->name}}</strong>
                                                                                <br><small>{{$item->product->description}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="td-number">
                                                                        {{$item->price_bs.'Bs / '.$item->price_usd.'USD'}}
                                                                    </td>
                                                                    <td class="td-number">
                                                                        {{floatval($item->quantity)}}
                                                                    </td>
                                                                    <td class="td-number total">
                                                                        {{(floatval($item->price_bs)*floatval($item->quantity)).'Bs / '.(floatval($item->price_usd)*floatval($item->quantity)).'USD'}}
                                                                    </td>
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
                        </div>
                        <div class="card-footer">
                            <div class="ml-auto mr-auto col-sm-12 text-center mt-3">
                                <button type="button" class="btn btn-info btn-back col-md-6"><i class="material-icons">undo</i> Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="info" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header ">
          <h5 class="modal-title text-primary" id="staticBackdropLabel">Productos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="text-center d-block loading">
                <div class="lds-hourglass"></div>
            </div>
            <div class="clientes d-none">
                <button class="d-none" id="reg_client" data-toggle="modal" data-target="#reg"></button>
            </div>
            <div class="productos d-none">
                <div class="list-group" id='existencias-venta'></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal registro clientes -->
  <div class="modal fade" id="reg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <form id="create_client">
            <div class="modal-header ">
            <h5 class="modal-title text-primary" id="staticLabel">Registrar Cliente</h5>
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12"><label for="ced"><h4 class="mtn-5 text-secondary">Número de Identificación del cliente:</h4></label></div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="custom-file input-group-lg">
                                        <input required type="text" autocomplete="off" class="form-control capitalize" name="ced" id="ced" placeholder="introduzca la cédula del cliente.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12"><label for="name"><h4 class="mtn-5 text-secondary">Nombres del cliente:</h4></label></div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="custom-file input-group-lg">
                                        <input required type="text" autocomplete="off" class="form-control capitalize" name="name" id="name" placeholder="introduzca los nombres del cliente.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12"><label for="lastname"><h4 class="mtn-5 text-secondary">Apellidos del cliente:</h4></label></div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="custom-file input-group-lg">
                                        <input required type="text" autocomplete="off" class="form-control capitalize" name="lastname" id="lastname" placeholder="introduzca los apellidos del cliente.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12"><label for="address"><h4 class="text-secondary">Dirección:</h4></label></div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="custom-file input-group-lg">
                                        <textarea class="form-control mayus" name="address" id="address" placeholder="introduzca la dirección del cliente."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">CERRAR</button>
                <button type="button" id="sumit" class="btn btn-primary">REGISTRAR CLIENTE</button>
            </div>
        </form>
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

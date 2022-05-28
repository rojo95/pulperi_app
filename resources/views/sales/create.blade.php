@extends('layouts.main', ['activePage' => 'sales', 'titlePage' => 'Registrar Venta'])
@section('title','Registrar Venta')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Venta</h4>
                            <p class="card-category">Realizar transacción de productos.</p>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                    <form id="venta">
                        <div class="card-body">
                            @csrf
                            <div class="container">
                                <div class="row mt-3">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-sm-3 mt-1"><label for="cliente"><h4 class="text-secondary">Cliente:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group" id="div-client">
                                                    <div class="custom-file input-group-lg">
                                                        <input type="text" autocomplete="off" class="form-control " name="client_search" id="client_search" placeholder="introduzca el nombre o la identificacion del cliente.">
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary btn-sm disabled" type="button" id="clientSearch" data-toggle="modal" data-target="#info">
                                                           <span class="material-icons">search</span>Buscar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-9 offset-md-3 p-0'><p id="client" class='error text-danger'></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-sm-3 mt-1"><label for="tipo"><h4 class="text-secondary">Tipo de Transacción:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group input-group-md">
                                                    <select id="tipo" class="form-control">
                                                        <option value="" selected disabled>SELECCIONE EL TIPO DE TRANSACCIÓN</option>
                                                        <option value="1">VENTA DE CONTADO</option>
                                                        <option value="2">VENTA A CREDITO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-9 offset-md-3 p-0'><p id="transaction_type" class='error text-danger'></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 d-none">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-sm-3 mt-1"><label for="tipo"><h4 class="text-secondary">Método de Pago:</h4></label></div>
                                            <div class="col">
                                                @foreach ($method as $i)
                                                    <div class="form-check m-0 p-0 " id="method">
                                                        <label class="form-check-label">
                                                            <input
                                                                type="checkbox"
                                                                class="form-check-input"
                                                                name="method[]"
                                                                id="{{$i->id}}"
                                                                value="{{$i->id}}"
                                                            >
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                            <h4 class="text-primary m-0">
                                                                {{$i->description}}
                                                            </h4>
                                                        </label>
                                                        <hr class="m-0 mb-2">
                                                    </div>
                                                @endforeach
                                                {{-- <div class="input-group input-group-md">
                                                    <select id="method" class="form-control">
                                                        <option value="" selected disabled>SELECCIONE EL MÉTODODE PAGO</option>
                                                        @foreach ($method as $item)
                                                        <option value="{{$item->id}}">{{$item->description}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-9 offset-md-3 p-0'><p id="payment_method_id" class='error text-danger'></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-sm-3 mt-1"><label for="producto"><h4 class="text-secondary">Producto:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group ">
                                                    <div class="custom-file input-group-lg">
                                                        <input id="producto" type="text" class="form-control" placeholder="Ingrese el producto a vender" autocomplete="off">
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary btn-sm disabled" type="button" id="searchProd" data-toggle="modal" data-target="#info">
                                                        <span class="material-icons">search</span>Buscar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-9 offset-md-3 p-0'><p id="prods" class='error text-danger'></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-10 offset-md-1">
                                        <div class="table-responsive">
                                            <table class="table table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th class="text-right col-sm-1">Precio</th>
                                                        <th class="text-right">Cantidad</th>
                                                        <th class="text-right">Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- <tr>
                                                        <td class="td-name">
                                                            <div class="row">
                                                                <div class="img-container d-none d-xs-none d-sm-block col">
                                                                    <img class="img-thumbnail" src="https://static.turbosquid.com/Preview/2015/07/19__05_23_26/AssaultRifleAK473dmodel01.jpg3fe8ef2c-c44b-49e4-8643-f6e7db63dd45Large.jpg" alt="PRODUCTO">
                                                                </div>
                                                                <div class="col">
                                                                    <strong class="text-primary">Ak-47</strong>
                                                                    <br><small>by U.R.S.S.</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="td-number">
                                                            <small>&#x20AC;</small>549
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-8 input-group offset-sm-4">
                                                                    <div class="custom-file input-group-lg">
                                                                        <input id="quantity" type="number" value="1" class="form-control" autocomplete="off" min="1" step="0.01">
                                                                    </div>
                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-round btn-info btn-sm less-prod"> <i class="material-icons">remove</i> </button>
                                                                        <button type="button" class="btn btn-round btn-info btn-sm plus-prod"> <i class="material-icons">add</i> </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="td-number total">
                                                            <small>&#x20AC;</small>549
                                                        </td>
                                                        <td class="td-actions">
                                                            <button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-danger">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td colspan="6">No se ha agregado ningún producto al carrito</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="ml-auto mr-auto col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-info btn-back col-md-6">Volver</button>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <button type="submit" class="btn btn-primary col-md-6">Concretar Venta</button>
                                    </div>
                                </div>
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
                                        <input required type="text" autocomplete="off" class="form-control numeric-only" name="ced" id="ced" placeholder="introduzca la cédula del cliente.">
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

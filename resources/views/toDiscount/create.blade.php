@extends('layouts.main', ['activePage' => 'to-discount', 'titlePage' => 'Productos a Retirar del Inventario'])
@section('title','Productos a Retirar del Inventario')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12">
                <form id='transaccion'>
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                                <h4 class="card-title">Productos a Retirar</h4>
                                <p class="card-category">Información y motivos del retiro de los productos del inventario</p>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-10 offset-sm-1">
                                <div class="row mb-3">
                                    <div class="col-sm-3"><label for="type_to_discount" class="col-form-label">Motivo del Retiro:</label></div>
                                    <div class="col-sm-9">
                                        <select name="type_to_discount" id="type_to_discount" class="form-control">
                                            <option value="" selected disabled>SELECCIONE UN MOTIVO POR EL CUAL EL PRODUCTO FUE RETIRADO DEL INVENTARIO</option>
                                            @foreach ($types as $type )
                                            <option value="{{$type->id}}">{{$type->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 d-none">
                                    <div class="col-sm-3">
                                        <label for="staff" class="col-form-label">Personal que realizó el retiro:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="staff" id="staff" class="form-control">
                                            <option value="" selected disabled>SELECCIONE AL TRABAJADOR QUE REALIZÓ EL RETIRO DEL INVENTARIO</option>
                                            @foreach ($staff as $item)
                                                <option value="{{$item->id}}">{{$item->lastname.' '.$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 d-none">
                                    <div class="col-sm-3">
                                        <label for="reason" class="col-form-label">Descripción detallada de la razón:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea name="reason" id="reason" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <label for="product_search" class="col-fom-label">Buscar producto:</label>
                                    </div>
                                    <div class="col-sm-9 input-group">
                                        <div class="custom-file">
                                            <input type="text" autocomplete="off" class="form-control " name="product_search" id="product_search" placeholder="introduzca el número de lote del producto.">
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-sm disabled" type="button" id="searchProdButton">
                                               <span class="material-icons">search</span>Buscar
                                            </button>
                                            {{-- <div class="input-group-append position-relative">
                                                <div class="popover-content popover-direction-l" id="escanear">
                                                    <div class="arrow-before"></div><div class="arrow-after"></div>
                                                    <div class="col text-center">
                                                        ¿Desea escanear el código del producto?
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-scan">
                                                            <span class="material-icons">qr_code_2</span>
                                                            Código QR
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-scan">
                                                            <i class="fas fa-barcode"></i>
                                                            Código de Barra
                                                        </button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-secondary btn-sm px-0 pop" type="button" data-target="escanear">
                                                    <span class="material-icons">arrow_drop_down</span>
                                                </button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="card" id="prods">
                                            <div class="card-header card-header-info d-none d-md-flex">
                                                <div class="row w-100 d-flex">
                                                    <div class="col-sm-3"><h5 class="card-title ml-2">Productos</h5></div>
                                                    <div class="col-sm-9 text-right">
                                                        <h5 class="card-title total">Total: 0</p></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-products">
                                                    <h6 class="card-category">
                                                        No se ha seleccionado ningún producto
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer mx-auto mb-5">
                            <a class="btn btn-info btn-block text-white" href="{{route('tdscnt.index')}}">Cancelar</a>
                            <button type="button" class="btn btn-primary" id="retiro-prods">Realizar Retiro</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-scan" tabindex="-1" aria-labelledby="modal-scan-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-scan-label">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ESCANER
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="searchProd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="searchProdLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="searchProdLabel">
              <div class="row">
                  <div class="col-sm-5 text-primary">Producto: </div>
                  <div class="prod-modal col-sm-7"></div>
                </div>
            </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label class="col-form-label">Código de lote del producto:</label>
                </div>
                <div class="col-sm-7"><p class="lot-modal mt-3"></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label class="col-form-label">Precio de venta del producto:</label>
                </div>
                <div class="col-sm-7"><p class="price-modal mt-3"></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label class="col-form-label">Total de producto en existencia:</label>
                </div>
                <div class="col-sm-7"><p class="total-modal mt-3"></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label class="col-form-label">Fecha de Expiración:</label>
                </div>
                <div class="col-sm-7"><p class="fecha-modal mt-3"></p></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label for="reason" class="col-form-label">Cantidad a Retirar del Inventario:</label>
                </div>
                <div class="col-sm-7">
                    <input type='number' name="quantity" id="quantity" class="form-control" min="1" max="" value="1">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="addProd">Aceptar</button>
        </div>
      </div>
    </div>
</div>
@endsection

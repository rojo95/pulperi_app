@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Producto'])
@section('title','Producto')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-9">
                            <h4 class="card-title">Producto</h4>
                            <p class="card-category">Información del producto.</p>
                        </div>
                        @can('inventory_edit')
                        <div class="col-sm-2">
                            <a class="nav-link" href="{{ route('invntry.edit', Illuminate\Support\Facades\Crypt::encrypt($product->id)) }}" title="Editar Producto">
                                <button class="btn btn-secondary btn-sm"><i class="material-icons">edit</i></button>
                            </a>
                        </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8 offset-sm-2">
                                <h4><strong>Producto:</strong> {{$product->name}}</h4>
                                <p>
                                    <strong>Tipo de Producto:</strong> {{$product->type->name}} <br>
                                    @if ($product->description)
                                    <strong>Descripción:</strong> {{$product->description}}<br>
                                    @endif
                                    @if ($product->unit_box)
                                    <strong>Unidades del Producto por Cajas :</strong> {{$product->unit_box}}<br>
                                    @endif
                                    <strong>Total Inventariado:</strong>
                                    @php
                                    $data = 0;
                                    foreach ($product->lots as $value) {
                                        if ($value->status==true) {
                                            $data = $data+$value->quantity-$value->sold;
                                        }
                                    }
                                    echo $data;
                                    @endphp
                                </p>
                                <hr>
                                @if (count($product->lots)>0)
                                    <h5><strong>Lotes:</strong></h5>
                                    <div class="lista-corta">
                                        <table class="table">
                                            <tbody>
                                                @foreach ($product->lots as $lot)
                                                <tr>
                                                    <td>
                                                        <p class="description">
                                                            Código de Lote: {{$lot->cod_lot}} <br>
                                                            Existencia: {{$lot->quantity-$lot->sold}} <br>
                                                            Fecha de Vencimiento: {{date('m/Y',strtotime($lot->expiration))}} <br>
                                                        </p>
                                                    </td>
                                                    <td class="td-actions text-right">
                                                        @can('lot_show')
                                                        <a href="{{route('lts.show',Illuminate\Support\Facades\Crypt::encrypt($lot->id))}}">
                                                            <button class="btn btn-info btn-sm"><i class="material-icons">visibility</i></button>
                                                        </a>
                                                        @endcan
                                                        @can('lot_edit')
                                                        <a href="{{route('lts.edit',Illuminate\Support\Facades\Crypt::encrypt($lot->id))}}">
                                                            <button class="btn btn-primary btn-sm"><i class="material-icons">edit</i></button>
                                                        </a>
                                                        @endcan
                                                        @can('lot_destroy')
                                                        <form action="{{ route('lts.destroy',Illuminate\Support\Facades\Crypt::encrypt($lot->id)) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-{{($lot->status==0) ? 'success' : 'danger'}} btn-confirm" type="submit" rel="tooltip">
                                                                <i class="material-icons">{{($lot->status==0) ? 'check' : 'close'}}</i>
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-danger">No posee lotes disponibles.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="ml-auto mr-auto col-sm-12">
                            <button type="button" class="btn btn-info btn-back col-md-6">Volver</button>
                        </div>
                    </div>
                </div>
            </div>
            @can('lot_create')
                <div class="col">
                    <form action="{{route('lts.store',Illuminate\Support\Facades\Crypt::encrypt($product->id))}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-primary d-flex">
                                <div class="col-sm-12">
                                    <h4 class="card-title">Ingreso de Mercancía</h4>
                                    <p class="card-category">Registrar el ingreso de mercancía del producto.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row col-md-12">
                                    <label for="cod_lot" class="col-sm-4 col-form-label">Número de Lote</label>
                                    <div class="col-sm-8 mb-3">
                                        <input type="text" class="form-control uppercase" min="0" name="cod_lot" value="{{old('cod_lot')}}" placeholder="Ingrese el número de lote del producto" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-lg-12">
                                                @if ($errors->has('cod_lot'))
                                                <span class="text-danger mt-0" for="input-cod_lot">{{$errors->first('cod_lot')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label for="quantity" class="col-sm-4 col-form-label">Cantidad de unidades</label>
                                    <div class="col-sm-8 d-flex m-0">
                                        <div class="col-sm-7 p-0 m-0">
                                            <input type="hidden" name="unit_box" id="unit_box" value="{{$product->unit_box}}">
                                            <input type="number" class="form-control" min="1" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="Ingrese cantidad del producto a ingresar" required>
                                        </div>
                                        <div class="col-sm-5 p-0">
                                            <select class="form-control" name="conteo" id="conteo">
                                                <option {{old('conteo')==1 ? 'selected' : ''}} value="1" >Unidades</option>
                                                <option {{old('conteo')==2 ? 'selected' : ''}} value="2" >Cajas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-lg-12">
                                                @if ($errors->has('quantity'))
                                                <span class="text-danger p-0 m-0" for="input-quantity">{{$errors->first('quantity')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label for="price" class="col-sm-4 col-form-label">Precio de Compra</label>
                                    <div class="col-sm-8 mb-3">
                                        <div class="row flex">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control col-md-12" min="1" step="0.01" name="price_bs" id="price_bs" placeholder="Precio de compra" required value="{{old('price_bs')}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control col-md-12" min="1" step="0.01" name="price_dollar" id="price_dollar" placeholder="Precio en dólares" required value="{{old('price_dollar')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-lg-12">
                                                @if ($errors->has('price_bs'))
                                                    <span class="text-danger mt-0" for="input-price_bs">{{$errors->first('price_bs')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label for="sell_price" class="col-sm-4 col-form-label">Precio de Venta</label>
                                    <div class="col-sm-8 d-flex m-0">
                                        <div class="col-sm-8 p-0 m-0">
                                            <input type="number" class="form-control col-md-12" min="1" step="0.01" name="sell_price" id="sell_price" placeholder="Precio de venta" required value="{{old('sell_price')}}">
                                        </div>
                                        <div class="col-md-4 px-0">
                                            <select class="form-control custom-select" name="divisa" id="divisa">
                                                @foreach ($divisas as $item)
                                                <option value="{{$item->id}}" {{$item->id==old('divisa') ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-lg-12">
                                                @if ($errors->has('sell_price'))
                                                    <span class="text-danger mt-0" for="input-sell_price">{{$errors->first('sell_price')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <label for="expiration" class="col-sm-4 col-form-label">Fecha de expiración</label>
                                    <div class="col-sm-8 mb-3">
                                        <input type="date" class="form-control" name="expiration" id="expiration" value="{{old('expiration')}}" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col col-lg-12">
                                                @if ($errors->has('expiration'))
                                                <span class="text-danger mt-0" for="input-expiration">{{$errors->first('expiration')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary btn-confirm">REGISTRAR INGRESO</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan
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

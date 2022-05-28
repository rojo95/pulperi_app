@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Editar Lote del Producto'])
@section('title','Editar Lote del Producto')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col-md-12">
                <form action="{{route('lts.update',Illuminate\Support\Facades\Crypt::encrypt($lot->id))}}" method="post" class="form-horizontal">
                    <div class="card">
                        <div class="card-header card-header-primary d-flex">
                            <div class="col-sm-12">
                                <h4 class="card-title">Editar Lote {{$lot->cod_lot}}</h4>
                                <p class="card-category">Modificar o actualizar información del lote perteneciente al producto {{$lot->products[0]->name}}.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-md-end">
                                    <div class="row col-md-10">
                                        <label for="cod_lot" class="col-sm-4 col-md-2 col-form-label">Número de Lote</label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="text" class="form-control uppercase" name="cod_lot" value="{{old('cod_lot',$lot->cod_lot)}}" placeholder="Ingrese el número de lote del producto" required autofocus>
                                            @if ($errors->has('cod_lot'))
                                                <span class="text-danger mt-0" for="input-cod_lot">{{$errors->first('cod_lot')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="quantity" class="col-sm-4 col-md-2 col-form-label">Cantidad de unidades</label>
                                        <div class="col-sm-8 col-sm-8 col-md-7 d-flex m-0">
                                            <div class="col-sm-7 p-0 m-0">
                                                <input type="hidden" name="unit_box" id="unit_box" value="{{$lot->unit_box}}">
                                                <input type="number" class="form-control disable-required-span" min="1" name="quantity" id="quantity" value="{{old('quantity',$lot->quantity)}}" placeholder="Ingrese cantidad del producto a ingresar" required>
                                            </div>
                                            <div class="col-sm-5 p-0">
                                                <select required class="form-control" name="conteo" id="conteo">
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
                                    <div class="row col-md-10 mb-3">
                                        <label for="price" class="col-sm-4 col-md-2 col-form-label">Precio de Compra</label>
                                        <div class="col-sm-8 col-md-7">
                                            <div class="row flex">
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control col-md-12" step="0.01" name="price_bs" id="price_bs" placeholder="Precio de compra" required value="{{old('price_bs',$lot->price_bs)}}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control col-md-12" step="0.01" name="price_dollar" id="price_dollar" placeholder="Precio en dólares" required value="{{old('price_dollar',$lot->price_dollar)}}">
                                                </div>
                                            </div>
                                            @if ($errors->has('price_bs'))
                                                <span class="text-danger mt-0" for="input-price_bs">{{$errors->first('price_bs')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10 mb-3">
                                        <label for="sell_price" class="col-sm-4 col-md-2 col-form-label">Precio de Venta</label>
                                        <div class="col-sm-8 col-md-7 d-flex m-0">
                                            <div class="col-sm-8 p-0 m-0">
                                                <input type="number" class="form-control col-md-12 disable-required-span" min="1" step="0.01" name="sell_price" id="sell_price" placeholder="Precio de venta" required value="{{old('sell_price',$lot->sell_price)}}">
                                            </div>
                                            <div class="col-md-4 px-0">
                                                <select required class="form-control custom-select" name="divisa" id="divisa">
                                                    @foreach ($divisas as $item)
                                                    <option value="{{$item->id}}" {{$item->id==old('tipo',$lot->divisa_id) ? 'selected' : ''}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row justify-content-md-center">
                                                <div class="col col-lg-12">
                                                    @if ($errors->has('sell_price'))
                                                    <span class="text-danger p-0 m-0" for="input-sell_price">{{$errors->first('sell_price')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="expiration" class="col-sm-4 col-md-2 col-form-label">Fecha de expiración</label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="date" class="form-control" name="expiration" id="expiration" required value="{{old('expiration',date('Y-m-d',strtotime($lot->expiration)))}}">
                                            @if ($errors->has('expiration'))
                                                <span class="text-danger mt-0" for="input-expiration">{{$errors->first('expiration')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="ml-auto mr-auto col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-info btn-back col-md-6">
                                            <i class="material-icons">undo</i>
                                            Volver
                                        </button>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <button type="submit" class="btn btn-md btn-primary col-md-6">
                                            <i class="material-icons">create</i>
                                            Actualizar Lote
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

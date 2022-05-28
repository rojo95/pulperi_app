@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Registrar Producto'])
@section('title','Registrar Producto')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{route('invntry.store')}}" method="post" class="form-horizontal">
                    <div class="card">
                        <div class="card-header card-header-primary d-flex">
                            <div class="col-sm-12">
                                <h4 class="card-title">Registrar Producto</h4>
                                <p class="card-category">Información básica del productos</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                @csrf
                                <div class="row justify-content-md-end">
                                    <div class="row col-md-10">
                                        <label for="name" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Nombre</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="text" class="form-control capitalize" name="name" value="{{old('name')}}" placeholder="Ingrese el nombre del producto" autofocus required autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="description" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Descripción</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-4">
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="5" placeholder="Ingrese una descripción acerca del producto">{{old('description')}}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger mt-0" for="input-description">{{$errors->first('description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="bar_code" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Código de barra</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="text" class="form-control" name="bar_code" id="bar_code" value="{{old('bar_code')}}" placeholder="Ingrese el nombre del producto" autofocus required autocomplete="off" maxlength="13" minlength="13">
                                            @if ($errors->has('bar_code'))
                                                <span class="text-danger mt-0" for="input-bar_code">{{$errors->first('bar_code')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="unit_box" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Cantidad de Unidades por Caja/Paquete</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="number" min='1' class="form-control" name="unit_box" id="unit_box" value="{{old('unit_box')}}" placeholder="Ingrese la cantidad de unidades que contiene una caja" autocomplete="off">
                                            @if ($errors->has('unit_box'))
                                                <span class="text-danger mt-0" for="input-unit_box">{{$errors->first('unit_box')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="tipo" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Tipo de producto</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <select class="form-control" name="tipo" id="tipo">
                                                <option value="" selected disabled>SELECCIONE EL TIPO DEL PRODUCTO A REGISTRAR</option>
                                                @foreach ($tprod as $item)
                                                <option value="{{$item->id}}" {{$item->id==old('tipo') ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select><span class="text-danger required">*</span>
                                            @if ($errors->has('tipo'))
                                                <span class="text-danger mt-0" for="input-tipo">{{$errors->first('tipo')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="cod_lot" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Número de Lote</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="text" class="form-control uppercase" name="cod_lot" value="{{old('cod_lot')}}" placeholder="Ingrese el número de lote del producto" required>
                                            @if ($errors->has('cod_lot'))
                                                <span class="text-danger mt-0" for="input-cod_lot">{{$errors->first('cod_lot')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="quantity" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Cantidad de unidades</h4></label>
                                        <div class="col-sm-8 col-md-7 d-flex m-0">
                                            <div class="col-sm-8 p-0 m-0">
                                                <input type="number" class="form-control disable-required-span" min="1" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="Ingrese cantidad del producto a ingresar" required>
                                            </div>
                                            <div class="col-sm-4 px-0">
                                                <select class="form-control" name="conteo" id="conteo" required>
                                                    <option {{old('conteo')==1 ? 'selected' : ''}} value="1" >Unidades/Kilos</option>
                                                    <option {{old('conteo')==2 ? 'selected' : ''}} value="2" >Cajas/Paquete</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 d-flex m-0 p-0">
                                            <div class="col-sm-4"></div>
                                            <div class="col-sm-6 p-0 mb-3">
                                                @if ($errors->has('quantity'))
                                                    <span class="text-danger p-0 m-0" for="input-quantity">{{$errors->first('quantity')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="sales_measure_id" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Tipo de forma de venta:</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <select class="form-control" name="sales_measure_id" id="sales_measure_id">
                                                <option value="" selected disabled>SELECCIONE LAS UNIDADES DE VENTA</option>
                                                @foreach ($sale_measure as $i)
                                                <option value="{{$i->id}}" {{$i->id==old('sales_measure_id') ? 'selected' : ''}}>{{$i->description}}</option>
                                                @endforeach
                                            </select><span class="text-danger required">*</span>
                                            @if ($errors->has('sales_measure_id'))
                                                <span class="text-danger mt-0" for="input-sales_measure_id">{{$errors->first('sales_measure_id')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="price" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Precio de Compra</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <div class="row flex">
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control col-md-12" min="1" step="0.01" name="price_bs" id="price_bs" placeholder="Precio de compra" required value="{{old('price_bs')}}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control col-md-12" min="1" step="0.01" name="price_dollar" id="price_dollar" placeholder="Precio en dólares" required value="{{old('price_dollar')}}">
                                                </div>
                                            </div>
                                            @if ($errors->has('price_bs'))
                                                <span class="text-danger mt-0" for="input-price_bs">{{$errors->first('price_bs')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="sell_price" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Precio de Venta</h4></label>
                                        <div class="col-sm-8 col-md-7 d-flex m-0">
                                            <div class="col-sm-8 p-0 m-0">
                                                <input type="number" class="form-control col-md-12 disable-required-span" min="1" step="0.01" name="sell_price" id="sell_price" placeholder="Precio de venta" required value="{{old('sell_price')}}">
                                            </div>
                                            <div class="col-md-4 px-0">
                                                <select class="form-control custom-select" name="divisa" id="divisa" required>
                                                    @foreach ($divisas as $divisa)
                                                    <option value="{{$divisa->id}}" {{$divisa->id==old('divisa') ? 'selected' : ''}}>{{$divisa->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 d-flex m-0 p-0">
                                            <div class="col-sm-4"></div>
                                            <div class="col-sm-6 p-0 mb-3">
                                                @if ($errors->has('sell_price'))
                                                    <span class="text-danger mt-0" for="input-sell_price">{{$errors->first('sell_price')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="expiration" class="col-sm-4 col-md-2 col-form-label text-secondary"><h4>Fecha de expiración</h4></label>
                                        <div class="col-sm-8 col-md-7 mb-3">
                                            <input type="date" class="form-control" name="expiration" id="expiration" required value="{{old('expiration')}}">
                                            @if ($errors->has('expiration'))
                                                <span class="text-danger mt-0" for="input-expiration">{{$errors->first('expiration')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary btn-confirm">REGISTRAR PRODUCTO</button>
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

@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Editar Producto'])
@section('title','Editar Producto')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="col">
                <form action="{{route('invntry.update',Illuminate\Support\Facades\Crypt::encrypt($product->id))}}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-primary d-flex">
                            <div class="col-sm-12">
                                <h4 class="card-title">Editar Producto</h4>
                                <p class="card-category">Modificar o actualizar información del producto {{$product->name}}.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                <div class="row justify-content-md-end">
                                    <div class="row col-md-12">
                                        <label for="name" class="col-sm-4 col-form-label">Nombre</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="text" class="form-control capitalize" name="name" value="{{old('name',$product->name)}}" placeholder="Ingrese el nombre del producto" autofocus required autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label for="description" class="col-sm-4 col-form-label">Descripción</label>
                                        <div class="col-sm-7 mb-4">
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="5" placeholder="Ingrese una descripción acerca del producto">{{old('description',$product->description)}}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger mt-0" for="input-description">{{$errors->first('description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label for="unit_box" class="col-sm-4 col-form-label">Cantidad de Unidades por Caja</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="number" min='1' class="form-control capitalize" name="unit_box" value="{{old('unit_box',$product->unit_box)}}" placeholder="Ingrese la cantidad de unidades que contiene una caja" autocomplete="off">
                                            @if ($errors->has('unit_box'))
                                                <span class="text-danger mt-0" for="input-unit_box">{{$errors->first('unit_box')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <label for="tipo" class="col-sm-4 col-form-label">Tipo de producto</label>
                                        <div class="col-sm-7 mb-3">
                                            <select class="form-control" name="tipo" id="tipo">
                                                <option value="" selected disabled>SELECCIONE TIPO DE PRODUCTO</option>
                                                @foreach ($tprod as $item)
                                                <option value="{{$item->id}}" {{$product->products_type_id==$item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('tipo'))
                                                <span class="text-danger mt-0" for="input-tipo">{{$errors->first('tipo')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary btn-confirm">ACTUALIZAR PRODUCTO</button>
                        </div>
                    </div>
                </form>
            </div>
            @can('lot_index')
            <div class="col">
                <div class="content">
                    <div class="row">
                        <div class="card">
                            <div class="card-header card-header-primary d-flex">
                                <div class="col-sm-12">
                                    <h4 class="card-title">Lotes del Producto</h4>
                                    <p class="card-category">Lotes registrados para el producto {{$product->name}}.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($product->lots as $lot)
                                            <tr>
                                                <td>
                                                    <p class="description">
                                                        @if ($lot->status==true)
                                                        Código de Lote: {{$lot->cod_lot}} <br>
                                                        Existencia: {{$lot->quantity}} <br>
                                                        Fecha de Vencimiento: {{date('m/Y',strtotime($lot->expiration))}} <br>
                                                        @endif
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
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                {{-- {{ $product->lots->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection

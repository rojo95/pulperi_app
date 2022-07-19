@extends('layouts.main', ['activePage' => 'inventory', 'titlePage' => 'Inventario'])
@section('title','Inventario')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary header-search">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">Inventario</h4>
                                <p class="card-category">Información básica de los productos registrados</p>
                            </div>
                            <div class="col-md-5 align-right">
                                <form action="{{route('invntry.index')}}">
                                    <div class="group-txt">
                                        <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Producto" value="{{$info}}">
                                        @can('inventory_create')
                                            <button class="btn btn-secondary btn-group-center" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a class="btn btn-secondary btn-group-right" href="{{ route('invntry.create') }}" title="Registrar Nuevo Producto">
                                                <i class="fas fa-cart-plus fa-lg"></i>
                                            </a>
                                        @endcan
                                        @cannot('inventory_create')
                                            <a class="btn btn-secondary btn-group-right" type="submit">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @endcannot
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-2">Nombre</th>
                                    <th class="col-sm-2">Existencia</th>
                                    <th class="col-sm-3">Lotes</th>
                                    <th class="col-sm-2">Tipo de Producto</th>
                                    <th class="text-right col-sm-2">Acción</th>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                @php
                                                $data = 0;
                                                foreach ($product->lots as $value) {
                                                    $data = $value->status==true ? $data+$value->quantity - $value->sold : $data;
                                                }
                                                echo $data;
                                                @endphp
                                            </td>
                                            <td>
                                                @foreach ($product->lots->take(10) as $item)
                                                    <span class="badge badge-info">{{$item->cod_lot}}</span>
                                                @endforeach
                                                @if (count($product->lots)>10)
                                                    <span class="badge badge-success">...+{{count($product->lots)-10}}</span>
                                                @endif
                                            </td>
                                            <td>{{$product->type->name}}</td>
                                            <td class="td-actions text-right">
                                                @can('inventory_show')
                                                <a href="{{ route('invntry.show', Illuminate\Support\Facades\Crypt::encrypt($product->id)) }}" class="btn btn-info">
                                                    <i class="material-icons">inventory</i>
                                                </a>
                                                @endcan
                                                @can('inventory_edit')
                                                <a href="{{ route('invntry.edit', Illuminate\Support\Facades\Crypt::encrypt($product->id)) }}" class="btn btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                @endcan
                                                @can('inventory_destroy')
                                                <form class="status-usr" action="{{ route('invntry.destroy',Illuminate\Support\Facades\Crypt::encrypt($product->id)) }}" method="post" style="display: inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-{{($product->status==true) ? 'danger' : 'success'}} btn-confirm" type="submit" rel="tooltip">
                                                        <i class="material-icons">{{($product->status==1) ? 'close' : 'check'}}</i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan='5'>
                                                No se han conseguido registros.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- <table class="table table-striped" id="inventario" style="width:100%">
                            <thead class="text-primary">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Lotes</th>
                                    <th>Cantidad</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tfoot class="text-primary">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Lotes</th>
                                    <th>Cantidad</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                        </table> --}}
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{ $products->links() }}
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

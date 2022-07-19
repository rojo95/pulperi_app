@extends('layouts.main', ['activePage' => 'sales', 'titlePage' => 'Lista de transacciones realizadas'])
@section('title','Lista de transacciones realizadas')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary header-search-md">
                        <div class="row">
                            <div class="col-sm-7">
                                <h4 class="card-title">Ventas</h4>
                                <p class="card-category">Transacciones realizadas.</p>
                            </div>
                            <div class="col-md-5 align-right">
                                <form action="{{route('sls.index')}}">
                                    <div class="group-txt">
                                        <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Venta" value="{{$info}}">
                                        @can('sale_create')
                                            <button class="btn btn-secondary btn-group-center" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a class="btn btn-secondary btn-group-right" href="{{ route('sls.create') }}" title="Registrar Nueva Venta">
                                                <i class="material-icons">attach_money</i>
                                            </a>
                                        @endcan
                                        @cannot('sale_create')
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
                                    <tr>
                                        <td class="col-sm-2">Fecha</td>
                                        <td class="col-sm-2">Cliente</td>
                                        <td class="col-sm-2">Tipo de Transacción</td>
                                        <td class="col-sm-2">Monto Total</td>
                                        <td class="col-sm-2">Vendedor</td>
                                        <td class="col-sm-2 text-right">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sales as $sale)
                                    <tr>
                                        <td>{{$sale->created_at->format('d/m/y h:i A')}}</td>
                                        <td>{{$sale->client->name.' '.$sale->client->lastname}}</td>
                                        <td>{{$sale->type}}</td>
                                        <td>@php
                                            $totalbs = 0;
                                            $totalusd = 0;
                                            foreach ($sale->products as $value) {
                                                $totalbs = $totalbs+($value->quantity*$value->price_bs);
                                                $totalusd = $totalusd+($value->quantity*$value->price_usd);
                                            }
                                        @endphp {{$totalbs.'Bs => '.$totalusd.'USD'}}
                                        </td>
                                        <td>{{$sale->seller->profile->id != 1 ? $sale->seller->profile->name.' '.$sale->seller->profile->lastname : $sale->seller->profile->name}}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('sls.show',Illuminate\Support\Facades\Crypt::encrypt($sale->id)) }}" class="btn btn-info">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            @if ($sale->status==true)
                                            <form action="{{ route('sls.destroy',Illuminate\Support\Facades\Crypt::encrypt($sale->id)) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-anul" type="submit" rel="tooltip">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            No se han conseguido registros.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{ $sales->links() }}
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

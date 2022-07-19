@extends('layouts.main', ['activePage' => 'clients', 'titlePage' => 'Registrar Cliente'])
@section('title','Registrar Cliente')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 class="card-title">{{$client->name.' '.$client->lastname}}</h4>
                                <p class="card-category">Datos personales del cliente.</p>
                            </div>
                            <div class="col-sm-2 text-right">
                                @can('client_edit')
                                <form action="{{ route('clnts.edit',Illuminate\Support\Facades\Crypt::encrypt($client->id)) }}">
                                    {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($client->id)) !!}
                                    <button class="btn btn-secondary" type="submit" title="Modificar información del cliente"><i class="material-icons">edit</i></button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="@if(auth()->user()->can('report_index')) col-md-6 @else col-md-12 @endif">
                                    <div class="row mt-2">
                                        <div class="col-sm-4 mt-2"><label for="ced"><h4 class="text-secondary">Número de Identificación del cliente:</h4></label></div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="custom-file input-group-lg">
                                                    <h4 class="mt-2">
                                                        {{$client->ced}}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-4 mt-2"><label for="name"><h4 class="text-secondary">Nombres del cliente:</h4></label></div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="custom-file input-group-lg">
                                                    <h4 class="mt-2">
                                                        {{$client->name}}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-4 mt-2"><label for="lastname"><h4 class="text-secondary">Apellidos del cliente:</h4></label></div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="custom-file input-group-lg">
                                                    <h4 class="mt-2">
                                                        {{$client->lastname}}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($client->address)
                                    <div class="row mt-4">
                                        <div class="col-sm-4 mt-2"><label for="address"><h4 class="text-secondary">Dirección:</h4></label></div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="custom-file input-group-lg">
                                                    <h4 class="mt-2">
                                                        {{$client->address}}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mt-4">
                                        <div class="col-sm-4 mt-2"><label for="address"><h4 class="text-secondary">Deuda:</h4></label></div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-md-{{count($client->debts)<=0 ? '12' : '5' }} p-sm-0">
                                                    <h4 class="mt-2">
                                                        @if (count($client->debts)<=0)
                                                            No ha registrado deudas.
                                                        @else
                                                            @php
                                                            $total_bs = 0;
                                                            $total_usd = 0;
                                                            foreach ($client->debts as $item){
                                                                foreach ($item->movements as $value) {
                                                                    if($value->status) {
                                                                        if($value->movement_type) {
                                                                            $total_bs = $total_bs+$value->amount_bs;
                                                                            $total_usd = $total_usd+$value->amount_usd;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            @endphp
                                                            {{$total_bs.'Bs / '.$total_usd.'USD'}}&nbsp;&nbsp;
                                                        @endif
                                                    </h4>
                                                </div>
                                                @if (count($client->debts)>0)
                                                <div class="col-sm-7">
                                                    <a href="{{route('dbts.show',Illuminate\Support\Facades\Crypt::encrypt($debt->id))}}" class="btn btn-success btn-block">
                                                        Ver Deuda Completa
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @can('report_index')
                                <div class="col">
                                    <div class="card card-chart">
                                        <div class="card-header ">
                                            <canvas id="transactionsClient" height="150"></canvas>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title strong">Transacciones de los últimos 7 días</h4>
                                            <h4 class="card-category text-secondary">
                                                Promedio de <span class="text-success"><i class="fas fa-shopping-cart"></i> <span id="promedio"></span> </span> ventas diarias.
                                                <br>
                                                Promedio de <span class="text-danger"><i class="fas fa-money-bill-wave"></i> <span id="promedioDebts"></span> </span> ventas a credito diarias.
                                            </h4>
                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <h4 class="text-secondary">
                                                    <i class="material-icons">access_time</i> Ultima transacción hace <span id="lastSale"></span>.
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('id', Crypt::encrypt($client->id)) !!}
                    @csrf
                    <div class="card-footer text-center">
                        <div class="ml-auto mr-auto col-sm-12">
                            <a href="{{route('clnts.index')}}" class="btn btn-info col-md-6">
                                <i class="material-icons">undo</i> Volver
                            </a>
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

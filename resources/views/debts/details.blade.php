@extends('layouts.main', ['activePage' => 'debts', 'titlePage' => 'Cuentas por Cobrar'])
@section('title','Cuentas por Cobrar')
@section('content')
<div class="content">
    @php
    $total = $total_bs.'Bs / '.$total_usd.'USD';
    $pagado = $pagado_bs.'Bs / '.$pagado_usd.'USD';
    $restante = ($total_bs-$pagado_bs).'Bs / '.($total_usd-$pagado_usd).'USD';
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Pagar Deuda de {{$debt->client->name.' '.$debt->client->lastname}}@if (!$movement->status) <span class='badge badge-warning'>ANULADO</span>@endif</h4>
                        </div>
                        @if ($movement->status)
                        <div class="col-sm-2">
                            <form action="{{ route('dbts.destroy',Illuminate\Support\Facades\Crypt::encrypt($movement->id)) }}" method="post" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($movement->id)) !!}
                                <button class="btn btn-danger btn-anul" type="submit" rel="tooltip"><strong>ANULAR</strong>
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="row mt-3">
                                        <div class="col-sm-4"><h4 class="text-secondary">Fecha de Pago:</h4></div>
                                        <div class="col">
                                            <h4>
                                                {{$movement->created_at->format('d/m/y h:i A')}}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-4"><h4 class="text-secondary">Pagado en Transacción:</h4></div>
                                        <div class="col">
                                            <h4>
                                                {{$movement->amount_bs.'BS / '.$movement->amount_usd.'USD'}}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-4">
                                            <h4 class="text-secondary">
                                                Método{{count($movement->paymentMethods)>1 ? 's' : ''}} de Pago:
                                            </h4>
                                        </div>
                                        <div class="col">
                                            @foreach ($movement->paymentMethods as $item)
                                                <h4><i>- {{$item->description}}</i></h4>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto mr-auto col-md-6">
                            <button type="button" class="btn btn-info btn-back col-md-12"><i class="material-icons">undo</i> Volver</button>
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

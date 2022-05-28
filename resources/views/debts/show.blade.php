@extends('layouts.main', ['activePage' => 'debts', 'titlePage' => 'Cuentas por Cobrar'])
@section('title','Cuentas por Cobrar')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Cuentas por Cobrar de {{$debt->client->name.' '.$debt->client->lastname}}</h4>
                            <p class="card-category">Información detallada de la cuenta por cobrar</p>
                        </div>
                        @can('debts_pay')
                            @if ($debt->status==1)
                                <div class="col-sm-2">
                                    <a class="nav-link" href="{{ route('dbts.edit',Illuminate\Support\Facades\Crypt::encrypt($debt->id)) }}" title="Pagar deuda">
                                        <button class="btn btn-secondary"><i class="material-icons">paid</i></button>
                                    </a>
                                </div>
                            @endif
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="text-secondary">
                                                Fecha de Inicio de la Deuda:
                                            </p>
                                        </div>
                                        <div class="col">
                                            {{date('d/m/y h:i A',strtotime($debt->created_at))}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="text-secondary">
                                                Estado de la Cuenta por Cobrar:
                                            </p>
                                        </div>
                                        <div class="col">
                                            @if ($debt->status==1)
                                                    <i class="text-danger">Activo</i>
                                                @elseif ($debt->status==2)
                                                    <i class="text-success">Pagada</i>
                                                @elseif ($debt->status==3)
                                                    <i class="text-secondary">Anulada</i>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="text-secondary">
                                                Deuda Total:
                                            </p>
                                        </div>
                                        <div class="col">
                                            {{$total_bs.'Bs / '.$total_usd.'USD'}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p class="text-secondary">
                                                Monto Pagado:
                                            </p>
                                        </div>
                                        <div class="col">
                                            {{$pagado_bs.'Bs / '.$pagado_usd.'USD'}}
                                        </div>
                                    </div>
                                    @if ($total_bs-$pagado_bs>0 && $total_usd-$pagado_usd>0)
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p class="text-secondary">
                                                    Restante a Pagar:
                                                </p>
                                            </div>
                                            <div class="col">
                                                {{($total_bs-$pagado_bs).'Bs / '.($total_usd-$pagado_usd).'USD'}}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header card-header-info">
                                                    <h5 class="card-title">
                                                        Movimientos realizados a la Deuda
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead class="text-primary">
                                                                <th class="col-sm-4">Tipo de Movimiento</th>
                                                                <th class="col-sm-4">Monto</th>
                                                                <th class="col-sm-4 text-right">Acción</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($debt->movements as $item)
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex mt-3">
                                                                            @if ($item->movement_type)
                                                                                <p class="text-danger">
                                                                                    Aumento de Deuda
                                                                                </p>
                                                                            @else
                                                                                <p class="text-success">
                                                                                    Pago de Deuda
                                                                                </p>
                                                                            @endif
                                                                            @if (!$item->status)
                                                                                <i class="text-secondary"> - Anulada</i>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$item->amount_bs.'Bs / '.$item->amount_usd.'USD'}}</td>
                                                                    <td class="text-right td-actions">
                                                                        <div class="row">
                                                                            <div class="col d-flex justify-content-end">
                                                                                @if ($item->transaction)
                                                                                    <a href="{{route('sls.show',Illuminate\Support\Facades\Crypt::encrypt($item->transaction->transaction->id))}}">
                                                                                        <button class="btn btn-info btn-sm">
                                                                                            <i class="material-icons">visibility</i>
                                                                                        </button>
                                                                                    </a>
                                                                                @else
                                                                                    <form action="{{route('dbts.detail')}}" method="post">
                                                                                        @csrf
                                                                                        {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($item->id),) !!}
                                                                                        <button type="submit" class="btn btn-info btn-sm">
                                                                                            <i class="material-icons">visibility</i>
                                                                                        </button>
                                                                                    </form>
                                                                                    @if ($item->status)
                                                                                    <form action="{{ route('dbts.destroy',Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" method="post" style="display: inline-block;">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($item->id)) !!}
                                                                                        <button title="Anular Pago" class="btn btn-{{($item->status) ? 'danger' : 'success' }} btn-sm btn-anul" type="submit" rel="tooltip">
                                                                                            <i class="material-icons">{{($item->status) ? 'delete' : 'check'}}</i>
                                                                                        </button>
                                                                                    </form>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="ml-auto mr-auto col-sm-12 text-center">
                            <a href="{{route('dbts.index')}}">
                                <button type="button" class="btn btn-info btn-back col-md-6"><i class="material-icons">undo</i> Volver</button>
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

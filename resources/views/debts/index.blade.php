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
                            <h4 class="card-title">Cuentas por Cobrar</h4>
                            <p class="card-category">Información básica de las cuentas por cobrar a los clientes</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-3">Cliente</th>
                                    <th class="col-sm-2">Fecha de Inicio</th>
                                    <th class="col-sm-3">Monto</th>
                                    <th class="col-sm-2">Estado</th>
                                    <th class="text-right col-sm-2">Acción</th>
                                </thead>
                                <tbody>
                                    @forelse ($debts as $debt)
                                        <tr>
                                            <td>{{ $debt->client->name.' '.$debt->client->lastname }}</td>
                                            <td>
                                                {{date('d/m/y h:i A',strtotime($debt->created_at))}} <br>
                                            </td>
                                            <td>
                                                @php
                                                    $total_bs = 0;
                                                    $total_usd = 0;
                                                    $pagado_bs = 0;
                                                    $pagado_usd = 0;
                                                    foreach ($debt->movements as $v) {
                                                        if($v->status){
                                                            if($v->movement_type) {
                                                                $total_bs = $total_bs+floatval($v->amount_bs);
                                                                $total_usd = $total_usd+floatval($v->amount_usd);
                                                            } else {
                                                                $pagado_usd = $pagado_usd+floatval($v->amount_usd);
                                                                $pagado_bs = $pagado_bs+floatval($v->amount_bs);
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                {{round(($total_bs-$pagado_bs),2).'Bs / '.round(($total_usd-$pagado_usd),2).'USD'}}
                                                @if ($total_bs<=0||$total_usd<=0)
                                                &nbsp;<span class="badge badge-info">Deuda Cancelada</span>
                                                @elseif($debt->status==3)
                                                &nbsp;<span class="badge badge-info">Deuda Anulada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($debt->status==1)
                                                    <i class="text-danger">Activo</i>
                                                @elseif ($debt->status==2)
                                                    <i class="text-success">Pagada</i>
                                                @elseif ($debt->status==3)
                                                    <i class="text-secondary">Anulada</i>
                                                @endif
                                            </td>
                                            <td class="td-actions text-right">
                                                @can('debts_show')
                                                    <a href="{{ route('dbts.show', Illuminate\Support\Facades\Crypt::encrypt($debt->id)) }}" class="btn btn-info">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                @endcan
                                                @can('debts_pay')
                                                    @if ($debt->status==1)
                                                        <a href="{{ route('dbts.edit', Illuminate\Support\Facades\Crypt::encrypt($debt->id)) }}" class="btn btn-primary">
                                                            <i class="material-icons">paid</i>
                                                        </a>
                                                    @endif
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
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{-- {{ $debts->links() }} --}}
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

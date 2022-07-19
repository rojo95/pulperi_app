@extends('layouts.main', ['activePage' => 'clients', 'titlePage' => 'Clientes'])
@section('title','Clientes')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-search-sm card-header-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Clientes</h4>
                                <p class="card-category d-none d-md-block">Clientes registrados.</p>
                            </div>
                            <div class="col-md-6">
                                <form action="{{route('clnts.index')}}">
                                    <div class="group-txt">
                                        <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Cliente" value="{{$info}}">
                                        @can('client_create')
                                            <button class="btn btn-secondary btn-group-center" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a class="btn btn-secondary btn-group-right" href="{{ route('clnts.create') }}" title="Agregar nuevo cliente" >
                                                <i class="material-icons">group_add</i>
                                            </a>
                                        @endcan
                                        @cannot('client_create')
                                            <button class="btn btn-secondary btn-group-right">
                                                <i class="fas fa-search"></i>
                                            </button>
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
                                    <th class="col-sm-5">Nombre</th>
                                    <th  class="col-sm-2">Estatus</th>
                                    <th class="col-sm-3">Deuda Actual</th>
                                    <th class="text-right col-sm-2">Acciones</th>
                                </thead>
                                <tbody>
                                    @forelse ($clients as $item)
                                        <tr>
                                            <td>
                                                {{$item->name.' '.$item->lastname}}
                                            </td>
                                            <td>
                                                @if ($item->status==1)
                                                <i class="text-success m-auto">
                                                    Activo
                                                </i>
                                                @else
                                                <i class="text-danger m-auto">
                                                    Inactivo
                                                </i>
                                                @endif
                                            </td>
                                            <td>
                                                @if (count($item->debts)>0)
                                                @php
                                                    $total_bs = 0;
                                                    $total_usd = 0;
                                                    foreach ($item->debts as $i){
                                                        foreach ($i->movements as $value) {
                                                            if ($value->status)
                                                                if($value->movement_type){
                                                                    $total_bs = $total_bs+$value->amount_bs;
                                                                    $total_usd = $total_usd+$value->amount_usd;
                                                                } else {
                                                                    $total_bs = $total_bs-$value->amount_bs;
                                                                    $total_usd = $total_usd-$value->amount_usd;
                                                                }
                                                            }
                                                        }
                                                @endphp
                                                @if ($total_bs<=0 && $total_usd<=0)
                                                <i class="text-secondary">Se han cancelado todas las deudas</i>
                                                @else
                                                {{$total_bs.'Bs / '.$total_usd.'USD'}}
                                                @endif
                                                @else
                                                No ha presentado deudas.
                                                @endif
                                            </td>
                                            <td class="td-actions d-flex justify-content-end">
                                                @can('client_show')
                                                <form action="{{ route('clnts.show', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" method="get">
                                                    {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($item->id)) !!}
                                                    <button class="btn btn-info">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </button>
                                                </form>
                                                @endcan
                                                @can('client_edit')
                                                <form action="{{ route('clnts.edit', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}">
                                                    {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($item->id)) !!}
                                                    <button class="btn btn-primary">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </form>
                                                @endcan
                                                @can('client_destroy')
                                                <form action="{{ route('clnts.destroy',Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('delete')
                                                    {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($item->id)) !!}
                                                    <button class="btn btn-{{($item->status==0) ? 'success' : 'danger'}} btn-confirm" type="submit" rel="tooltip">
                                                        <i class="material-icons">{{($item->status==0) ? 'check' : 'close'}}</i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                No se han encontrado registros...
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{$clients->links()}}
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

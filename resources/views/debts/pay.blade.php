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
                            <h4 class="card-title">Pagar Deuda de {{$debt->client->name.' '.$debt->client->lastname}}</h4>
                            {{-- <p class="card-category">Información básica de las cuentas por cobrar a los clientes</p> --}}
                        </div>
                    </div>
                    <form id="pay_debt">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="id" value="{{Illuminate\Support\Facades\Crypt::encrypt($debt->id)}}">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <div class="row mt-3">
                                            <div class="col-sm-4"><h4 class="text-secondary">Total Deuda:</h4></div>
                                            <div class="col">
                                                <h4>
                                                    {{$total}}
                                                </h4>
                                            </div>
                                        </div>
                                        @if ($pagado_bs>0 || $pagado_usd>0)
                                        <div class="row mt-3">
                                            <div class="col-sm-4"><h4 class="text-secondary">Deuda Pagada:</h4></div>
                                            <div class="col">
                                                <h4>
                                                    {{$pagado}}
                                                </h4>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row mt-3">
                                            <div class="col-sm-4"><h4 class="text-secondary">Restante a Pagar:</h4></div>
                                            <div class="col">
                                                <h4>
                                                    {{$restante}}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-4"><h4 class="text-secondary">Monto a Pagar:</h4></div>
                                            <div class="col">
                                                <div class="col d-flex m-0 pl-0">
                                                    <div class="col-sm-8 p-0 m-0 custom-file input-group-lg">
                                                        <input type="number" class="form-control col-md-12 disable-required-span" min="1" step="0.01" name="amount" id="amount" placeholder="Monto a pagar." required value="{{old('amount')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-md-4 px-0 custom-file input-group-md">
                                                        <select class="form-control custom-select" name="divisa" id="divisa" required>
                                                            @foreach ($divisas as $item)
                                                            <option value="{{$item->id}}" {{$item->id==old('divisa') ? 'selected' : ''}}>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <h4 class="text-danger"><p id="amount" class="error"></p></h4>
                                                <h4 class="text-danger"><p id="divisa" class="error"></p></h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-4">
                                                <h4 class="text-secondary">
                                                    Monto a Pagar al Cambio:
                                                </h4>
                                            </div>
                                            <div class="col">
                                                <h4 id="cambio"></h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-sm-4">
                                                <h4 class="text-secondary">
                                                    Método de Pago:
                                                </h4>
                                            </div>
                                            <div class="col">
                                                @foreach ($metodos as $i)
                                                    <div class="form-check m-0 p-0">
                                                        <label class="form-check-label">
                                                            <input
                                                                type="checkbox"
                                                                class="form-check-input"
                                                                name="payment_method[]"
                                                                @if ( is_array(old('payment_method')) && in_array($i->id,old('payment_method')) ) checked @endif
                                                                value="{{$i->id}}"
                                                            >
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                            <h4 class="text-primary m-0">
                                                                {{$i->description}}
                                                            </h4>
                                                        </label>
                                                        <hr class="m-1">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="text-danger"><p id="payment_method" class="error"></p></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="ml-auto mr-auto col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn btn-info btn-back col-md-6"><i class="material-icons">undo</i> Volver</button>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <button type="submit" class="btn btn-primary col-md-6">Pagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

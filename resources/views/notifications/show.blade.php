@extends('layouts.main', ['activePage' => 'notifications', 'titlePage' => 'Notificaciones'])
@section('title','Notificaciones')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-8">
                            <h4 class="card-title">Notificación</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <h4 class="strong">
                                            Producto:
                                        </h4>
                                    </div>
                                    <div class="col">
                                        <h4>
                                            {{$prod->products->name}}
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <h4 class="strong">
                                            Lote:
                                        </h4>
                                    </div>
                                    <div class="col">
                                        <h4>
                                            {{$prod->cod_lot}}
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <h4 class="strong">
                                            Cantidad restante:
                                        </h4>
                                    </div>
                                    <div class="col">
                                        <h4>
                                            {{floatval($prod->quantity)-floatval($prod->sold)}}
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <h4 class="strong">
                                            Estatus:
                                        </h4>
                                    </div>
                                    <div class="col">
                                        @if ($prod->expiration < now())
                                            <h4>
                                                <span class="badge badge-lg badge-danger">
                                                    <i class="fas fa-skull-crossbones"></i>
                                                    Producto Expirado
                                                </span>
                                            </h4>
                                        @else
                                            <h4>
                                                <span class="badge badge-lg badge-warning">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Prócimo a Expirar
                                                </span>
                                            </h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button class="btn btn-info btn-block btn-back">Volver</button>
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

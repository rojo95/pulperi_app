@extends('layouts.main', ['activePage' => 'clients', 'titlePage' => 'Registrar Cliente'])
@section('title','Registrar Cliente')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Registrar Cliente</h4>
                            <p class="card-category">Registra los datos personales del cliente.</p>
                        </div>
                    </div>
                    <form id="createClient">
                        @csrf
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="row mt-2">
                                            <div class="col-sm-4 mt-2"><label for="ced"><h4 class="text-secondary">Número de Identificación del cliente:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="custom-file input-group-lg">
                                                        <input required type="text" autocomplete="off" class="form-control numeric-only" name="ced" id="ced" placeholder="introduzca la cédula del cliente.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-sm-4 mt-2"><label for="name"><h4 class="text-secondary">Nombres del cliente:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="custom-file input-group-lg">
                                                        <input required type="text" autocomplete="off" class="form-control capitalize" name="name" id="name" placeholder="introduzca los nombres del cliente.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-sm-4 mt-2"><label for="lastname"><h4 class="text-secondary">Apellidos del cliente:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="custom-file input-group-lg">
                                                        <input required type="text" autocomplete="off" class="form-control capitalize" name="lastname" id="lastname" placeholder="introduzca los apellidos del cliente.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-4 mt-2"><label for="address"><h4 class="text-secondary">Dirección:</h4></label></div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="custom-file input-group-lg">
                                                        <textarea class="form-control mayus" name="address" id="address" placeholder="introduzca la dirección del cliente."></textarea>
                                                    </div>
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
                                        <button type="button" class="btn btn-info btn-back col-md-6">Volver</button>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <button type="button" id="sumit" class="btn btn-primary col-md-6">REGISTRAR CLIENTE</button>
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

@extends('layouts.main', ['activePage' => 'settings', 'titlePage' => 'Configuración'])
@section('title','Productos Descontados del Inventario')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col col-sm-10">
                                <h4 class="card-title">Configuración del Sistema</h4>
                                {{-- <p class="card-category d-none d-md-flex">Información básica de los descuentos de inventario realizados.</p> --}}
                            </div>
                        </div>
                    </div>
                    <form action="">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="col-md-10 offset-md-2">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-secondary">
                                            <label for="change">
                                                Utilizar Cambio de Moneda Definido por el Usuario:

                                            </label>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div class="togglebutton">
                                            <label>
                                              <input name="change" id="change" type="checkbox" {{$settings[0]->status ? 'checked' : ''}}>
                                                <span class="toggle"></span>
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-secondary">
                                            <label for="limit">
                                                Límite de Deuda Permitida:
                                            </label>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="togglebutton">
                                                    <label>
                                                      <input name="limit" id="limit" type="checkbox" {{$settings[1]->status ? 'checked' : ''}}>
                                                        <span class="toggle"></span>
                                                        Activar/Desactivar
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input disabled placeholder="Límite permitido para la deuda" step="0.01" name="limit_amount" id="limit_amount" type="number" class="form-control">
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
                                        <button type="submit" class="btn btn-primary col-md-6">Concretar Venta</button>
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

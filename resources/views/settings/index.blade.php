@extends('layouts.main', ['activePage' => 'settings', 'titlePage' => 'Configuración'])
@section('title','Configuración')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">attach_money</i>
                            </div>
                            <p class="card-category">Divisas </p>
                            <h4 class="card-title">Cambios de moneda
                            </h4>
                          </div>
                          <div class="card-footer">
                            <div class="stats">
                                <a href="#">
                                    <button class="btn btn-success btn-sm">Ver Todos</button>
                                </a>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">female</i>
                            </div>
                            <p class="card-category">Géneros </p>
                            <h4 class="card-title">Gestionar Géneros
                            </h4>
                          </div>
                          <div class="card-footer">
                            <div class="stats">
                              <a href="#">
                                <button class="btn btn-primary btn-sm">Ver Todos</button>
                              </a>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">settings</i>
                            </div>
                            <p class="card-category">Sistema </p>
                            <h4 class="card-title">Configuración General</h4>
                          </div>
                          <div class="card-footer">
                            <div class="stats">
                                <a href="{{route('settings.config')}}">
                                    <button class="btn btn-warning btn-sm">Configurar</button>
                                </a>
                            </div>
                          </div>
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

@extends('layouts.main',['activePage' => 'permission', 'titlePage'=>'Información del Permiso'])
@section('title','Información del Permiso')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Permiso</h4>
                            <p class="card-category">Vista detallada del permiso.</p>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h4 class="text-primary strong">Nombre del Permiso: </h4>
                                            </div>
                                            <div class="col">
                                                <h4>
                                                    {{$permission->name}}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <h4 class="text-primary strong">Descripción: </h4>
                                            </div>
                                            <div class="col">
                                                <h4>
                                                    {{$permission->description}}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto col-sm-112">
                            <div class="button-container col-sm-12 d-flex">
                                <a href="{{route('prmssns.index')}}" class="btn btn-md btn-info col-sm-6">
                                    <i class="material-icons">undo</i>
                                    Volver
                                </a>
                                <a href="{{ route('prmssns.edit', Illuminate\Support\Facades\Crypt::encrypt($permission->id)) }}" class="btn btn-md btn-primary ">
                                    <i class="material-icons">create</i>
                                    Editar Permiso
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

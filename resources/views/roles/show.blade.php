@extends('layouts.main',['activePage' => 'role', 'titlePage'=>'Información del Permiso'])
@section('title','Información del Permiso')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Rol</h4>
                            <p class="card-category">Vista detallada del permiso.</p>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row justify-content-md-center">
                                    <div class="row col-md-10 d-flex">
                                        <div class="col-md-3">
                                            <p class="text-primary">Nombre del rol: </p>
                                        </div>
                                        <div class="col-md-9">
                                            {{$role->name}}
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                            <div class="col-md-3">
                                                <p class="text-primary">Permisos asociados: </p>
                                            </div>
                                            <div class="col-md-9">
                                                @forelse ($role->permissions as $permission)
                                                <span class="badge rounded-pill bg-dark text-white">{{$permission->name}}</span>
                                                @empty
                                                <span class="badge rounded-pill bg-danger text-white">Sin permisos asignados</span>
                                                @endforelse
                                            </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <div class="col-md-3">
                                            <p class="text-primary">Permisos Totales: </p>
                                        </div>
                                        <div class="col-md-9">
                                            @php
                                                $i = 0;
                                                foreach ($role->permissions as $value) {
                                                    $i = ++$i;
                                                }
                                                echo $i;
                                            @endphp
                                        </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto col-sm-112">
                            <div class="button-container col-sm-12 d-flex">
                                <button class="btn btn-md btn-info col-sm-6 btn-back">
                                    <i class="material-icons">undo</i>
                                    Volver
                                </button>
                                <a href="{{ route('rls.edit', Illuminate\Support\Facades\Crypt::encrypt($role->id)) }}" class="btn btn-md btn-primary ">
                                    <i class="material-icons">create</i>
                                    Editar Rol
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

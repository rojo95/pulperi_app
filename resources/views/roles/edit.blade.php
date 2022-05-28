@extends('layouts.main', ['activePage' => 'role', 'titlePage' => 'Editar Rol'])
@section('title','Editar Permiso')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('rls.update',Illuminate\Support\Facades\Crypt::encrypt($role->id)) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Rol</h4>
                            <p class="card-category">Modificar datos del rol</p>
                        </div>
                        <div class="card-body">
                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="container ">
                                        <div class="row">
                                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10 mb-3">
                                                <input type="text" class="form-control capitalize" name="name" value="{{old('name',$role->name)}}" placeholder="Ingrese el nombre del permiso" autofocus required>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-sm-5 text-center"><input id="noasignados" type="text" placeholder="Buscar permiso" class="form-control"></div>
                                            <div class="col col-sm-5 offset-sm-2 text-center"><input id="asignados" type="text" placeholder="Buscar permiso" class="form-control"></div>
                                            <div class="col col-sm-5">
                                                <div class="form-group unaccess lista-corta lista-corta-solida">
                                                    @foreach ($permissions as $id => $item)
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="form-check-input permiso-ckeck"
                                                                            name="permission[]"
                                                                            id="{{$id}}"
                                                                            value="{{$id}}"
                                                                            {{$role->permissions->contains($id) ? 'checked' : ''}}
                                                                        >
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm">
                                                                <label class="mt-3">
                                                                    {{$item}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <hr class="mt-0">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col col-sm-2 position-relative vertical-m">
                                                <div class="row ">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-success permission-all">
                                                            <span class="material-icons">arrow_forward_ios</span>
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" class="btn btn-warning permission-none">
                                                            <span class="material-icons">arrow_back_ios</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-sm-5">
                                                <div class="form-group access lista-corta lista-corta-solida">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button class="btn btn-md btn-info col-sm-6 btn-back">
                                <i class="material-icons">undo</i>
                                Volver
                            </button>
                            <button type="submit" class="btn btn-primary btn-confirm"><i class="material-icons">create</i> Editar Rol</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

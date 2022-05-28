@extends('layouts.main',['activePage' => 'profile', 'titlePage'=>'Editar Perfil'])
@section('title','Editar Perfil')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <form
                            action="{{route('prfl.update')}}"
                            method="post" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">{{auth()->user()->id==1 ? 'Administrador' : 'Perfil'}}</h4>
                                    <p class="card-category">Editar datos del usuario</p>
                                </div>
                                <div class="card-body">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col col-md-8 offset-md-2">
                                                @if (auth()->user()->id!=1)
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="name" class="col-sm-4 col-form-label">Nombres</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <input type="text" class="form-control capitalize" name="name" value="{{old('name',$user->profile->name)}}" placeholder="Ingrese los nombres del vendedor" autofocus required>
                                                                @if ($errors->has('name'))
                                                                    <span class="text-danger" for="input-name">{{$errors->first('name')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="lastname" class="col-sm-4 col-form-label">Apellidos</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <input type="text" class="form-control capitalize" name="lastname" value="{{old('lastname',$user->profile->lastname)}}" placeholder="Ingrese los apellidos del vendedor" required>
                                                                @if ($errors->has('lastname'))
                                                                    <span class="text-danger" for="input-lastname">{{$errors->first('lastname')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="identification" class="col-sm-4 col-form-label">Identificación</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <input type="text" class="form-control capitalize" name="identification" value="{{old('identification',$user->profile->identification)}}" placeholder="Ingrese los apellidos del vendedor" required>
                                                                @if ($errors->has('identification'))
                                                                    <span class="text-danger" for="input-identification">{{$errors->first('identification')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="genere" class="col-sm-4 col-form-label">Genero</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <select name="genere" id="genere" class="form-control">
                                                                    <option value="" disabled>SELECCIONE EL GENERO DEL USUARIO</option>
                                                                    <option value="0" {{$user->status == 0 ? 'selected' : ''}}>Masculino</option>
                                                                    <option value="1" {{$user->status == 1 ? 'selected' : ''}}>Femenino</option>
                                                                </select>
                                                                @if ($errors->has('genere'))
                                                                    <span class="text-danger mt-0" for="input-genere">{{$errors->first('genere')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="email" class="col-sm-4 col-form-label">Correo Electrónico del Usuario</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <input type="email" class="form-control " name="email" value="{{old('email',$user->email)}}" placeholder="Ingrese el correo electrónico" required>
                                                                @if ($errors->has('email'))
                                                                    <span class="text-danger" for="input-email">{{$errors->first('email')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-sm-12">
                                                            <label for="username" class="col-sm-4 col-form-label">Nombre del Usuario</label>
                                                            <div class="col-sm-8 mb-3">
                                                                <input type="text" class="form-control " name="username" value="{{old('username',$user->username)}}" placeholder="Ingrese el nombre de usuario" required>
                                                                @if ($errors->has('username'))
                                                                    <span class="text-danger" for="input-username">{{$errors->first('username')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header card-header-info">
                                                                <h4 class="card-title">Cambiar contraseña</h4>
                                                                <p class="card-category">Completar los datos SÓLO en caso de querer actualizar su contraseña</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <label for="password" class="col-form-label">Contraseña Actual</label>
                                                                            </div>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="password" class="form-control " name="current_password" placeholder="Coloque la contraseña sólo en caso de querer actualizarla">
                                                                                @if ($errors->has('current_password'))
                                                                                    <span class="text-danger" for="input-current_password">{{$errors->first('current_password')}}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <label for="password" class="col-form-label">Nueva Contraseña</label>
                                                                            </div>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <input type="password" class="form-control " name="password" placeholder="Coloque la contraseña sólo en caso de querer actualizarla">
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <input type="password" class="form-control " name="password_confirmation" placeholder="Repita la nueva contraseña sólo en caso de querer actualizarla">
                                                                                        @if ($errors->has('password_confirmation'))
                                                                                            <span class="text-danger" for="input-password_confirmation">{{$errors->first('password_confirmation')}}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                @if ($errors->has('password'))
                                                                                    <span class="text-danger" for="input-password">{{$errors->first('password')}}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row col-sm-12">
                                                        <label for="password" class="col-sm-4 col-form-label">Cambiar Contraseña</label>
                                                        <div class="col-sm-8 mb-3">
                                                            <input type="password" class="form-control " name="password" placeholder="Coloque la contraseña sólo en caso de querer actualizarla">
                                                            @if ($errors->has('password'))
                                                                <span class="text-danger" for="input-password">{{$errors->first('password')}}</span>
                                                            @endif
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <div class="button-container">
                                        <button type="button" class="btn btn-info btn-back">
                                            <i class="material-icons">undo</i>
                                            Volver
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="material-icons">create</i>
                                            Actualizar Datos
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <x-users.form-edit type="2" name="{{$user->name}}" lastname="{{$user->lastname}}" username="{{$user->username}}" email="{{$user->email}}" id="{{$user->id}}" /> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

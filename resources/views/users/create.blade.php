@extends('layouts.main',['activePage' => 'user-management', 'titlePage'=>'Crear Usuario'])
@section('title','Crear Usuario')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('usrs.store') }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="d-flex">
                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Usuario</h4>
                                        <p class="card-category">Ingresar datos para el nuevo usuario</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="row">
                                                <div class="row col-sm-12">
                                                    <label for="name" class="col-sm-4 col-form-label">Nombres</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="text" class="form-control capitalize" name="name" value="{{old('name')}}" placeholder="Ingrese los nombres del vendedor" autofocus required>
                                                        @if ($errors->has('name'))
                                                            <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="lastname" class="col-sm-4 col-form-label">Apellidos</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="text" class="form-control capitalize" name="lastname" value="{{old('lastname')}}" placeholder="Ingrese los apellidos del vendedor" required>
                                                        @if ($errors->has('lastname'))
                                                            <span class="text-danger mt-0" for="input-lastname">{{$errors->first('lastname')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="identification" class="col-sm-4 col-form-label">Identificación</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="text" class="form-control numeric-only" id="identification" name="identification" value="{{old('identification')}}" placeholder="Ingrese el número de identificación del vendedor" required>
                                                        @if ($errors->has('identification'))
                                                            <span class="text-danger mt-0" for="input-identification">{{$errors->first('identification')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="genere" class="col-sm-4 col-form-label">Genero</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <select name="genere" id="genere" class="form-control">
                                                            <option value="" selected disabled>SELECCIONE EL GENERO DEL USUARIO</option>
                                                            @foreach ($generes as $i)
                                                            <option value="{{$i->id}}" {{old('genere')==$i->id ? 'selected' : ''}}>{{$i->description}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('genere'))
                                                            <span class="text-danger mt-0" for="input-genere">{{$errors->first('genere')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="username" class="col-sm-4 col-form-label">Nombre del Nuevo Usuario</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="text" class="form-control" name="username" value="{{old('username')}}" placeholder="Ingrese el nombre de usuario" required>
                                                        @if ($errors->has('username'))
                                                            <span class="text-danger mt-0" for="input-username">{{$errors->first('username')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="email" class="col-sm-4 col-form-label">Correo Electrónico del Nuevo Usuario</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Ingrese el correo electrónico" required>
                                                        @if ($errors->has('email'))
                                                            <span class="text-danger mt-0" for="input-email">{{$errors->first('email')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row col-sm-12">
                                                    <label for="password" class="col-sm-4 col-form-label">Contraseña del Nuevo Usuario</label>
                                                    <div class="col-sm-8 mb-3">
                                                        <input type="password" class="form-control" name="password" placeholder="Ingrese la contraseña que tendrá el vendedor" required>
                                                        @if ($errors->has('password'))
                                                            <span class="text-danger mt-0" for="input-password">{{$errors->first('password')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer ml-auto mr-auto">
                                        <button type="submit" class="btn btn-primary btn-confirm">{{ __('CREAR USUARIO') }}</button>
                                      </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Roles</h4>
                                        <p class="card-category">Elija los Roles que tendrá Asociados</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-sm-12 mb-3">
                                                        <div class="form-group">
                                                            <div class="tab-content">
                                                                <div class="tab-plane active">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach ($roles as $item)
                                                                                @if ($item->id==1)
                                                                                    @if (in_array(1,$own_roles))
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check">
                                                                                                    <label class="form-check-label">
                                                                                                        <input type="checkbox" class="form-check-input" name="roles[]" {{old('roles') && in_array($item->id,old('roles')) ? 'checked' : ''}} value="{{$item->id}}">
                                                                                                        <span class="form-check-sign">
                                                                                                            <span class="check"></span>
                                                                                                        </span>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td>
                                                                                                {{$item->name}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @else
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="form-check">
                                                                                                <label class="form-check-label">
                                                                                                    <input type="checkbox" class="form-check-input" name="roles[]" {{old('roles') && in_array($item->id,old('roles')) ? 'checked' : ''}} value="{{$item->id}}">
                                                                                                    <span class="form-check-sign">
                                                                                                        <span class="check"></span>
                                                                                                    </span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            {{$item->name}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

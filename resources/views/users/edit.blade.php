@extends('layouts.main',['activePage' => 'user-management', 'titlePage'=>'Editar Usuario'])
@section('title','Editar Usuario')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <form
                            action="{{ route('usrs.update',Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" method="post" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{Illuminate\Support\Facades\Crypt::encrypt($user->id)}}">
                            <div class="d-flex">
                                <div class="col-lg-6 col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-primary">
                                            <h4 class="card-title">Usuario {{$user->id==1 ? 'Administrador' : '';}}</h4>
                                            <p class="card-category">Editar datos del usuario</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="content">
                                                @if ($user->id!=1)
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
                                                                    @foreach ($generes as $i)
                                                                        <option value="{{$i->id}}" {{$i->id==$user->profile->genere_id ? 'selected' : ''}}>{{$i->description}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('genere'))
                                                                    <span class="text-danger mt-0" for="input-genere">{{$errors->first('genere')}}</span>
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
                                                @endif
                                                <div class="row">
                                                    <div class="row col-sm-12">
                                                        <label for="password" class="col-sm-4 col-form-label">Contraseña del Usuario</label>
                                                        <div class="col-sm-8 mb-3">
                                                            <input type="password" class="form-control " name="password" placeholder="Coloque la contraseña sólo en caso de querer actualizarla">
                                                            @if ($errors->has('password'))
                                                                <span class="text-danger" for="input-password">{{$errors->first('password')}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($user->id==1)
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="col">
                                                            <div class="alert alert-warning alert-dismissible fade show d-absolute" role="alert">
                                                                El usuario predeterminado entregado a los usuarios finales no puede ser editado, sólo actualizar su contraseña.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-primary">
                                            <h4 class="card-title">Roles</h4>
                                            <p class="card-category">Roles Asociados</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="content">
                                                <div class="row">
                                                    <div class="row col-md-12">
                                                        <div class="col-sm-12 mb-3">
                                                            <div class="form-group">
                                                                <div class="tab-content">
                                                                    <div class="tab-plane active">
                                                                        @if (auth()->user()->id==$user->id)
                                                                            <div class="alert alert-warning" role="alert">
                                                                                <strong>
                                                                                    No puedes modificar tus propios roles.
                                                                                </strong>
                                                                            </div>
                                                                        @else
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    @foreach ($roles as $item)
                                                                                        @if ($item->id==1)
                                                                                            @if (in_array(1,$own_roles))
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <div class="form-check">
                                                                                                            <label class="form-check-label">
                                                                                                                <input type="checkbox" class="form-check-input"
                                                                                                                    name="roles[]"
                                                                                                                    value="{{$item->id}}" {{$user->roles->contains($item->id) ? 'checked' : ''}}>
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
                                                                                                            <input type="checkbox" class="form-check-input"
                                                                                                                name="roles[]"
                                                                                                                value="{{$item->id}}" {{$user->roles->contains($item->id) ? 'checked' : ''}}>
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
                                                                        @endif
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
                    {{-- <x-users.form-edit type="1" name="{{$user->name}}" lastname="{{$user->lastname}}" username="{{$user->username}}" email="{{$user->email}}" id="{{$user->id}}" /> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

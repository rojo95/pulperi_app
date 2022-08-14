@extends('layouts.main', ['activePage' => 'profile', 'titlePage' => 'Perfil'])
@section('title','Perfil')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Perfil</h4>
                            <p class="card-category">Vista detallada del usuario.</p>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-user">
                                        <div class="card-body">
                                            <p class="card-text">
                                                <div class="author">
                                                    <a href="#" class="d-flex">
                                                        @if(auth()->user()->img)
                                                            <img src="{{asset('/img/faces/'.
                                                            (auth()->user()->img ? auth()->user()->img : (auth()->user()->profile->genere_id == 1 ? 'card-profile1-square' : 'avatar'))
                                                            .'.jpg')}}" alt="image" class="avatar">
                                                        @else
                                                            <i class="material-icons" style="font-size: 35px">account_circle</i>
                                                        @endif
                                                        <h3 class="title mx-3 my-0">{{$user->username!='admin' ? $user->profile->name.' '.$user->profile->lastname : $user->profile->name}}</h3>
                                                    </a>
                                                    <h4 class="description text-secondary">
                                                        @if ($user->username!='admin')
                                                        Identificación: {{$user->profile->identification}} <br>
                                                        @endif
                                                        Estatus:
                                                        @if ($user->status == 1)
                                                        <i class="text-success">Activo</i>
                                                        @else
                                                        <i class="text-danger">Inactivo</i>
                                                        @endif
                                                        <br>
                                                        Usuario: {{$user->username}} <br>
                                                        @if ($user->username!='admin')
                                                        Email: {{$user->email}} <br>
                                                        Genero: {{$user->profile->genere->description}} <br>
                                                        Fecha de Ingreso: {{$user->created_at->toFormattedDateString()}} <br>
                                                        @endif
                                                    </h4>
                                                </div>
                                            </p>
                                            <hr>
                                            <div class="card-description text-secondary">
                                                <h4>
                                                    roles del usuario:
                                                    <br>
                                                    <ul>
                                                        @forelse ($user->roles as $role)
                                                            <li>
                                                                {{$role->name}}
                                                            </li>
                                                        @empty
                                                            <p class="text-danger">Sin roles Asignados.</p>
                                                        @endforelse
                                                    </ul>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-6 p-0 pr-1">
                                                        <button type="button" class="btn btn-info btn-back btn-sm btn-block">
                                                            <i class="material-icons">undo</i>
                                                            Volver
                                                        </button>
                                                    </div>
                                                    <div class="col-6 p-0">
                                                        <a href="{{ route('prfl.edit')}}" class="btn btn-sm btn-primary btn-block">
                                                            <i class="material-icons">create</i>
                                                            Editar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-chart">
                                        <div class="card-header ">
                                            <canvas id="weekSales" height="200"></canvas>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title strong">Transacciones de los últimos 7 días</h4>
                                            <h4 class="card-category text-secondary">
                                                Promedio de <span class="text-success"><i class="fas fa-shopping-cart"></i> <span id="promedio"></span> </span> ventas diarias.
                                                <br>
                                                Promedio de <span class="text-danger"><i class="fas fa-money-bill-wave"></i> <span id="promedioDebts"></span> </span> ventas a credito diarias.
                                            </h4>
                                        </div>
                                        <div class="card-footer">
                                            <div class="stats">
                                                <h4 class="text-secondary">
                                                    <i class="material-icons">access_time</i> Ultima transacción hace <span id="lastSale"></span>.
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <x-users.ficha-usuario type="1" name="{{$user->name.' '.$user->lastname}}" username="{{$user->username}}" created_at="{{$user->user_created_at}}" email="{{$user->email}}"/> --}}
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

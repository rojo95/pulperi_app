@extends('layouts.main',['activePage' => 'user-management', 'titlePage'=>'Usuario'])
@section('title','Usuario')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Usuario</h4>
                            <p class="card-category">Vista detallada del usuario.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-user">
                                        <div class="card-body">
                                            <p class="card-text">
                                                <div class="author">
                                                    <a href="#" class="d-flex">
                                                        <img src="{{asset('/img/faces/card-profile1-square.jpg')}}" alt="image" class="avatar">
                                                        <h5 class="title mx-3">{{$user->id==1 ? $user->profile->name : $user->profile->name.' '.$user->profile->lastname}}</h5>
                                                    </a>
                                                    <p class="description">
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
                                                        Fecha de Ingreso: {{$user->created_at ? $user->created_at->format('d/m/y h:i A') : "Siempre ha estado aquí..."}} <br>
                                                        @endif
                                                    </p>
                                                </div>
                                            </p>
                                            <hr>
                                            <div class="card-description">
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
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{route('usrs.index')}}" class="btn btn-sm btn-info col-md-6">
                                                <i class="material-icons">undo</i>
                                                Volver
                                            </a>
                                            <a href="{{$user->id==auth()->user()->id ? route('prfl.edit') : route('usrs.edit', Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="btn btn-sm btn-primary col-md-6">
                                                <i class="material-icons">create</i>
                                                Editar Usuario
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-chart">
                                                <div class="card-header card-header-success">
                                                    <div class="ct-chart" id="dailySalesChart"></div>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title">Ventas del Día</h4>
                                                    <p class="card-category">
                                                        <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> Aumento en las ventas diarias.
                                                    </p>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="stats">
                                                        <i class="material-icons">access_time</i> Ultima venta hace 4 minutos.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-chart">
                                                <div class="card-header card-header-danger">
                                                    <div class="ct-chart" id="completedTasksChart"></div>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title">Ventas a crédito.</h4>
                                                    <p class="card-category">Last Campaign Performance</p>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="stats">
                                                        <i class="material-icons">access_time</i> Se fió hace 2 días.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <x-users.ficha-usuario type="2" roles="{{$user->roles}}" id="{{$user->id}}" name="{{$user->name.' '.$user->lastname}}" username="{{$user->username}}" created_at="{{$user->created_at->toFormattedDateString()}}" email="{{$user->email}}"/> --}}
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

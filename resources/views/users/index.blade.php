@extends('layouts.main', ['activePage' => 'user-management', 'titlePage' => 'Usuarios'])
@section('title','Usuarios')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary d-flex">
                            <div class="col-sm-10">
                                <h4 class="card-title">Usuarios</h4>
                                <p class="card-category">Información básica de los usuarios registrados</p>
                            </div>
                            <div class="col-sm-2">
                                <a class="nav-link" href="{{ route('usrs.create') }}" title="Crear nuevo usuario">
                                      <button class="btn btn-secondary"><i class="fas fa-user-plus fa-lg"></i></button>
                                  </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="text-primary">
                                        <th class="col-md-3">Nombre</th>
                                        <th class="col-md-1">Usuario</th>
                                        <th class="col-md-3">Roles</th>
                                        <th class="col-md-1">Estatus</th>
                                        <th class="col-md-2">Creación</th>
                                        <th class="col-md-2 text-right">Acción</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $roles = [];
                                        @endphp
                                        @foreach ($users as $user)
                                            @php
                                                $roles = [];
                                                foreach ($user->roles as $v) {
                                                    array_push($roles,$v->id);
                                                }
                                            @endphp
                                            @if (in_array(1,$roles))
                                                @if (in_array(1,$own_roles))
                                                    <tr class="bg-warning">
                                                        <td class="col-md-3">{{ $user->profile->name.' '.$user->profile->lastname }}</td>
                                                        <td class="col-md-1">{{ $user->username }}</td>
                                                        <td class="col-md-3">
                                                            @forelse ($user->roles as $rol)
                                                            <span class="badge badge-info">{{$rol->name}}</span>
                                                            @empty
                                                            <p class="text-danger m-auto">No posee roles asociados.</p>
                                                            @endforelse
                                                        </td>
                                                        <td class="col-md-1">
                                                            @if ($user->status==1)
                                                                <strong>
                                                                    Activo
                                                                </strong>
                                                            @else
                                                            <p class="text-danger m-auto">
                                                                Inactivo
                                                            </p>
                                                            @endif
                                                        </td>
                                                        <td class="col-md-2">
                                                            {{ $user->created_at->format('d/m/y h:i A') }}
                                                        </td>
                                                        <td class="td-actions text-right col-md-2">
                                                            <a href="{{ $user->id==auth()->user()->id ? route('prfl.show') : route('usrs.show', Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="btn btn-info">
                                                                <i class="material-icons">person</i>
                                                            </a>
                                                            <a href="{{$user->id==auth()->user()->id ? route('prfl.edit') : route('usrs.edit', Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="btn btn-primary">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <form class="status-usr" action="{{ route('usrs.status',Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" method="post" style="display: inline-block;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button class="btn btn-{{($user->status==1) ? 'danger' : 'success'}} btn-confirm" type="submit" rel="tooltip">
                                                                    <i class="material-icons">{{($user->status==1) ? 'close' : 'check'}}</i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td class="col-md-3">{{ $user->profile->name.' '.$user->profile->lastname }}</td>
                                                    <td class="col-md-1">{{ $user->username }}</td>
                                                    <td class="col-md-3">
                                                        @forelse ($user->roles as $r)
                                                            <span class="badge badge-info">{{$r->name}}</span>
                                                        @empty
                                                            <p class="text-danger m-auto">No posee roles asociados.</p>
                                                        @endforelse
                                                    </td>
                                                    <td class="col-md-1">
                                                        @if ($user->status==1)
                                                        <p class="text-success m-auto">
                                                            Activo
                                                        </p>
                                                        @else
                                                        <p class="text-danger m-auto">
                                                            Inactivo
                                                        </p>
                                                        @endif
                                                    </td>
                                                    <td class="col-md-2">
                                                        {{ $user->created_at->toFormattedDateString() }}
                                                    </td>
                                                    <td class="td-actions text-right col-md-2">
                                                        <a href="{{$user->id==auth()->user()->id ? route('prfl.show') : route('usrs.show', Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="btn btn-info">
                                                            <i class="material-icons">person</i>
                                                        </a>
                                                        <form class="status-usr" action="{{$user->id==auth()->user()->id ? route('prfl.edit') : route('usrs.edit', Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" method="get" style="display: inline-block;">
                                                            @csrf
                                                            {!! \Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($user->id)) !!}
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                        </form>
                                                        @if ($user->id!=auth()->user()->id)
                                                        <form class="status-usr" action="{{ route('usrs.status',Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" method="post" style="display: inline-block;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-{{($user->status==1) ? 'danger' : 'success'}} btn-confirm" type="submit" rel="tooltip">
                                                                <i class="material-icons">{{($user->status==1) ? 'close' : 'check'}}</i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            {{ $users->links() }}
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

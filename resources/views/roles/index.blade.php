@extends('layouts.main', ['activePage' => 'role', 'titlePage' => 'Roles'])
@section('title','Roles')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header">
                        <div class="row">
                            <div class="col-sm-7">
                                <h4 class="card-title">Roles</h4>
                                <p class="card-category">Roles registrados.</p>
                            </div>
                            <div class="col-md-5">
                                <form action="{{route('rls.index')}}">
                                    <div class="group-txt">
                                        <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Permiso" value="{{$info}}">
                                        @can('permission_create')
                                            <button class="btn btn-secondary btn-group-center" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a class="btn btn-secondary btn-group-right" href="{{ route('rls.create') }}" title="Crear nuevo permiso">
                                                <i class="material-icons">post_add</i>
                                            </a>
                                        @endcan
                                        @cannot('permission_create')
                                            <a class="btn btn-secondary btn-group-right" type="submit">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        @endcannot
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-4">Nombre</th>
                                    <th class="col-sm-1">Estatus</th>
                                    <th class="col-sm-2">Creación</th>
                                    <th class="col-sm-3">Permisos</th>
                                    <th class="text-right col-sm-2">Acciones</th>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if ($item->status==1)
                                                Activo
                                            @else
                                                <p class="text-danger m-auto">
                                                    Inactivo
                                                </p>
                                            @endif
                                        </td>
                                        <td>{{$item->created_at->format('d/m/y h:i A')}}</td>
                                        {{-- <td>{{$item->created_at->toFormattedDateString()}}</td> --}}
                                        <td>
                                            @forelse ($item->permissions->take(5) as $permissions)
                                                <span class="badge badge-info">{{$permissions->name}}</span>
                                            @empty
                                                <span class="badge badge-danger">Sin permisos asignados</span>
                                            @endforelse
                                            @if (count($item->permissions)>5)
                                                <span class="badge badge-success">...+{{count($item->permissions)-5}}</span>
                                            @endif
                                        </td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('rls.show', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" class="btn btn-info">
                                                <i class="material-icons">ballot</i>
                                            </a>
                                            <a href="{{ route('rls.edit', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" class="btn btn-primary">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form class="status-usr" action="{{ route('rls.destroy',Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-{{($item->status==1) ? 'danger' : 'success'}} btn-confirm" type="submit" rel="tooltip">
                                                    <i class="material-icons">{{($item->status==1) ? 'close' : 'check'}}</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            No hay permisos registrados aún...
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{ $roles->links() }}
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

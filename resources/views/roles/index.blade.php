@extends('layouts.main', ['activePage' => 'role', 'titlePage' => 'Roles'])
@section('title','Roles')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Roles</h4>
                            <p class="card-category">Roles registrados.</p>
                        </div>
                        <div class="col-sm-2">
                            <a class="nav-link" href="{{ route('rls.create') }}" title="Crear nuevo usuario">
                                <button class="btn btn-secondary"><i class="material-icons">post_add</i></button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-4">Nombre</th>
                                    <th  class="col-sm-2">Guard</th>
                                    <th  class="col-sm-1">Estatus</th>
                                    <th class="col-sm-2">Creación</th>
                                    <th class="col-sm-1">Permisos</th>
                                    <th class="text-right col-sm-2">Acciones</th>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->guard_name}}</td>
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
                                    No hay permisos registrados aún...
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

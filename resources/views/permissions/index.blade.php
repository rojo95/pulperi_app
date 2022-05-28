@extends('layouts.main', ['activePage' => 'permission', 'titlePage' => 'Permisos'])
@section('title','Permisos')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="col-sm-10">
                            <h4 class="card-title">Permisos</h4>
                            <p class="card-category">Permisos registrados.</p>
                        </div>
                        <div class="col-sm-2">
                            @can('permission_create')
                            <a class="nav-link" href="{{ route('prmssns.create') }}" title="Crear nuevo permiso">
                                <button class="btn btn-secondary"><i class="material-icons">add_moderator</i></button>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-6">Nombre</th>
                                    <th  class="col-sm-2">Estatus</th>
                                    <th class="col-sm-2">Creación</th>
                                    <th class="text-right col-sm-2">Acciones</th>
                                </thead>
                                <tbody>
                                    @forelse ($permissions as $item)
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
                                        <td class="td-actions text-right">
                                            @can('permission_show')
                                            <a href="{{ route('prmssns.show', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" class="btn btn-info">
                                                <i class="material-icons">shield</i>
                                            </a>
                                            @endcan
                                            @can('permission_edit')
                                            <a href="{{ route('prmssns.edit', Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" class="btn btn-primary">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            @endcan
                                            @can('permission_destroy')
                                            <form action="{{ route('prmssns.destroy',Illuminate\Support\Facades\Crypt::encrypt($item->id)) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-{{($item->status==0) ? 'success' : 'danger'}} btn-confirm" type="submit" rel="tooltip">
                                                    <i class="material-icons">{{($item->status==0) ? 'check' : 'close'}}</i>
                                                </button>
                                            </form>
                                            @endcan
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
                        {{ $permissions->links() }}
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

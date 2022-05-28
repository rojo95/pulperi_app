@extends('layouts.main', ['activePage' => 'to-discount', 'titlePage' => 'Productos Descontados del Inventario'])
@section('title','Productos Descontados del Inventario')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col col-sm-10">
                                <h4 class="card-title">Descuentos Realizados</h4>
                                <p class="card-category d-none d-md-flex">Información básica de los descuentos de inventario realizados.</p>
                            </div>
                            @can('to_discount_create')
                            <div class="col col-sm-2 vertical-m">
                                <a class="nav-link" href="{{ route('tdscnt.create') }}" title="Registrar Nuevo Producto">
                                    <button class="btn btn-secondary"><span class="material-icons">money_off</span></button>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <tr>
                                        <td class="col-sm-4">Funcionario</td>
                                        <td class="col-sm-4">Motivo</td>
                                        <td class="col-sm-2">Fecha</td>
                                        <td class="col-sm-2 text-right">Acción</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($discounts as $discount)
                                    <tr>
                                        <td>{{$discount->discounter->profile->name.' '.$discount->discounter->profile->lastname}}</td>
                                        <td>{{$discount->type->description}}</td>
                                        <td>{{$discount->created_at->format('d/m/y h:i A')}}<i class="text-secondary">{{$discount->status ? '' : ' Anulado'}}</i></td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('tdscnt.show',Illuminate\Support\Facades\Crypt::encrypt($discount->id)) }}" class="btn btn-info">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            @can('to_discount_destroy')
                                            @if ($discount->status==true)
                                            <form action="{{ route('tdscnt.destroy',Illuminate\Support\Facades\Crypt::encrypt($discount->id)) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-confirm" type="submit" rel="tooltip">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </form>
                                            @endif
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            No se han conseguido registros.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{ $discounts->links() }}
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

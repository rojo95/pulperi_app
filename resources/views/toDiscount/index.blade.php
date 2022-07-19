@extends('layouts.main', ['activePage' => 'to-discount', 'titlePage' => 'Productos Descontados del Inventario'])
@section('title','Productos Descontados del Inventario')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary header-search-sm">
                        <div class="row">
                            <div class="col col-sm-7">
                                <h4 class="card-title">Descuentos Realizados</h4>
                                <p class="card-category d-none d-md-flex">Información básica de los descuentos de inventario realizados.</p>
                            </div>
                            <div class="col-md-5 align-right">
                                <form action="{{route('tdscnt.index')}}">
                                    <div class="group-txt">
                                        <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Descuento" value="{{$info}}">
                                        @can('to_discount_create')
                                            <button class="btn btn-secondary btn-group-center" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a class="btn btn-secondary btn-group-right" href="{{ route('tdscnt.create') }}" title="Retirar Producto del Inventario">
                                                <span class="material-icons">money_off</span>
                                            </a>
                                        @endcan
                                        @cannot('to_discount_create')
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

@extends('layouts.main', ['activePage' => 'notifications', 'titlePage' => 'Notificaciones'])
@section('title','Notificaciones')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary header-search">
                        <div class="row">
                            <div class="col-sm-8">
                                <h4 class="card-title">Notificaciones</h4>
                                <p class="card-category">Información acerca de productos vencidos o próximos a vencerse.</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col">
                                        <form action="{{route('ntfctns')}}">
                                            <div class="group-txt">
                                                <input type="text" name="search" id="search" class="input-group-left" autocomplete="off" placeholder="Producto" value="{{$info}}">
                                                <button class="btn btn-secondary btn-group-right">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-primary">
                                    <th class="col-sm-3">Producto</th>
                                    <th class="col-sm-1">Lote</th>
                                    <th class="col-sm-3">Existencia</th>
                                    <th class="col-sm-3">Estatus</th>
                                    <th class="text-right col-sm-2">Ver Más</th>
                                </thead>
                                <tbody>
                                    @forelse ($prods as $prod)
                                        <tr>
                                            <td>{{ $prod->products->name}}</td>
                                            <td>{{ $prod->cod_lot }}</td>
                                            <td>
                                                {{$prod->quantity}}
                                            </td>
                                            <td>
                                                @if ($prod->expiration < now())
                                                    <h5>
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-skull-crossbones"></i>
                                                            Producto Expirado
                                                        </span>
                                                    </h5>
                                                @else
                                                    <h5>
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-exclamation-triangle"></i>

                                                            Próximo a Expirar
                                                        </span>
                                                    </h5>
                                                @endif
                                            </td>
                                            <td class="td-actions text-right">
                                                <form action="{{route('ntfctns.show')}}" method="post">
                                                    @csrf
                                                    {!! Form::hidden('id', Illuminate\Support\Facades\Crypt::encrypt($prod->id)) !!}
                                                    <button type="submit" class="btn btn-info">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan='5'>
                                                No se han conseguido registros.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {{ $prods->links() }}
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

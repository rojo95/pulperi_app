@extends('layouts.main', ['activePage' => 'permission', 'titlePage' => 'Crear Permiso'])
@section('title','Crear Permiso')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('prmssns.store') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Permiso</h4>
                            <p class="card-category">Ingresar datos del nuevo permiso</p>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                <div class="row justify-content-md-end">
                                    <div class="row col-md-10">
                                        <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="text" class="form-control lowercase" name="name" value="{{old('name')}}" placeholder="Ingrese el nombre del permiso" autofocus required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="row col-md-10">
                                        <label for="route" class="col-sm-2 col-form-label">Ruta</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="text" class="form-control capitalize" name="route" value="{{old('route')}}" placeholder="Ingrese la ruta donde podrá acceder con el permiso" required>
                                            @if ($errors->has('route'))
                                                <span class="text-danger mt-0" for="input-route">{{$errors->first('route')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row col-md-10">
                                        <label for="description" class="col-sm-2 col-form-label">Descripción</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="text" class="form-control" name="description" value="{{old('description')}}" placeholder="Ingrese la descripción del permiso" required>
                                            @if ($errors->has('description'))
                                                <span class="text-danger mt-0" for="input-description">{{$errors->first('description')}}</span>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary btn-confirm">{{ __('CREAR PERMISO') }}</button>
                          </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

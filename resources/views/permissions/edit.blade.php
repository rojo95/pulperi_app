@extends('layouts.main', ['activePage' => 'permission', 'titlePage' => 'Editar Permiso'])
@section('title','Editar Permiso')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('prmssns.update',Illuminate\Support\Facades\Crypt::encrypt($permission->id)) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Permiso</h4>
                            <p class="card-category">Ingresar datos del permiso</p>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                <div class="row justify-content-md-end">
                                    <div class="row col-md-10">
                                        <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-7 mb-3">
                                            <input type="text" class="form-control" name="name" value="{{old('name',$permission->name)}}" placeholder="Ingrese el nombre del permiso" autofocus required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger mt-0" for="input-name">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto col-sm-112">
                            <div class="button-container col-sm-12 d-flex">
                                <button class="btn btn-md btn-info col-sm-6 btn-back">
                                    <i class="material-icons">undo</i>
                                    Volver
                                </button>
                                <button type="submit" class="btn btn-primary btn-confirm"><i class="material-icons">create</i> EDITAR PERMISO</button>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                          </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

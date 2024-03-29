@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => 'Pulperi-App'])

@section('title','Pulperi-App')

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">

        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-primary text-center">
                        <h4 class="card-title"><strong>{{ __('Acceso') }}</strong></h4>
                        <div class="social-line d-none">
                            <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        &nbsp;
                        {{-- Username --}}
                        <div class="bmd-form-group{{ $errors->has('username') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                </div>
                                <input type="text" name="username" class="form-control" autofocus placeholder="{{ __('Correo Electrónico o Usuario...') }}" value="{{ old('username', null) }}" required>
                            </div>
                            @if ($errors->has('username'))
                                <div id="username-error" class="error text-danger pl-3" for="username" style="display: block;">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Contraseña...') }}" required>
                            </div>
                            @if ($errors->has('password'))
                                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-check mr-auto ml-3 mt-3"></div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('INICIAR SESIÓN') }}</button>
                    </div>
                </div>
            </form>
            {{-- <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-light">
                            <small>{{ __('¿Olvidaste tu Contraseña?') }}</small>
                        </a>
                    @endif
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection

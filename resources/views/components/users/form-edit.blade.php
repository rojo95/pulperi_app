<div>
    <form
        action="{{ route('usrs.update',Illuminate\Support\Facades\Crypt::encrypt($id)) }}"
        method="post" class="form-horizontal">

        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">{{$type==1 ? 'Usuario' : 'Perfil';}}</h4>
                <p class="card-category">Editar datos del usuario</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <label for="name" class="col-sm-2 col-form-label">Nombres</label>
                    <div class="col-sm-7 mb-3">
                        <input type="text" class="form-control capitalize" name="name" value="{{old('name',$name)}}" placeholder="Ingrese los nombres del vendedor" autofocus required>
                        @if ($errors->has('name'))
                            <span class="text-danger" for="input-name">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="lastname" class="col-sm-2 col-form-label">Apellidos</label>
                    <div class="col-sm-7 mb-3">
                        <input type="text" class="form-control capitalize" name="lastname" value="{{old('lastname',$lastname)}}" placeholder="Ingrese los apellidos del vendedor" required>
                        @if ($errors->has('lastname'))
                            <span class="text-danger" for="input-lastname">{{$errors->first('lastname')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="username" class="col-sm-2 col-form-label">Nombre del Usuario</label>
                    <div class="col-sm-7 mb-3">
                        <input type="text" class="form-control " name="username" value="{{old('username',$username)}}" placeholder="Ingrese el nombre de usuario" required>
                        @if ($errors->has('username'))
                            <span class="text-danger" for="input-username">{{$errors->first('username')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="email" class="col-sm-2 col-form-label">Correo Electrónico del Usuario</label>
                    <div class="col-sm-7 mb-3">
                        <input type="email" class="form-control " name="email" value="{{old('email',$email)}}" placeholder="Ingrese el correo electrónico" required>
                        @if ($errors->has('email'))
                            <span class="text-danger" for="input-email">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="password" class="col-sm-2 col-form-label">Contraseña del Usuario</label>
                    <div class="col-sm-7 mb-3">
                        <input type="password" class="form-control " name="password" placeholder="Coloque la contraseña sólo en caso de querer actualizarla">
                        @if ($errors->has('password'))
                            <span class="text-danger" for="input-password">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
                <div class="button-container">
                    <button type="button" class="btn btn-info btn-back">
                        <i class="material-icons">undo</i>
                        Volver
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons">create</i>
                        Actualizar Datos
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>


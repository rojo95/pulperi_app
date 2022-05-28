<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">{{$type==1 ? 'Perfil' : 'Usuario'}}</h4>
        <p class="card-category">Vista detallada del usuario.</p>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success" role="success">{{session('success')}}</div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="card-body">
                        <p class="card-text">
                            <div class="author">
                                <a href="#" class="d-flex">
                                    <img src="{{asset('/img/faces/card-profile1-square.jpg')}}" alt="image" class="avatar">
                                    <h5 class="title mx-3">{{$name}}</h5>
                                </a>
                                <p class="description">
                                    Usuario: {{$username}} <br>
                                    Email: {{$email}} <br>
                                    Fecha de Ingreso: {{$created_at}} <br>
                                </p>
                            </div>
                        </p>
                        <hr>
                        <div class="card-description">
                            roles del usuario
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="button-container col-sm-12">
                            @if ($type==2)
                            <a href="{{route('usrs.index')}}" class="btn btn-sm btn-info col-sm-6">
                                <i class="material-icons">undo</i>
                                Volver
                            </a>
                            <a href="{{ route('usrs.edit', Illuminate\Support\Facades\Crypt::encrypt($id)) }}" class="btn btn-sm btn-primary ">
                            @else
                            <a href="{{ route('prfl.edit')}}" class="btn btn-sm btn-primary btn-block">
                            @endif
                                <i class="material-icons">create</i>
                                {{$type==1 ? 'Editar Perfil' : 'Editar Usuario'}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header card-header-success">
                                <div class="ct-chart" id="dailySalesChart"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Ventas del Día</h4>
                                <p class="card-category">
                                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> Aumento en las ventas diarias.
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> Ultima venta hace 4 minutos.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header card-header-danger">
                                <div class="ct-chart" id="completedTasksChart"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Ventas a crédito.</h4>
                                <p class="card-category">Last Campaign Performance</p>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> Se fió hace 2 días.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



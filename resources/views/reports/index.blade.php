@extends('layouts.main', ['activePage' => 'charts', 'titlePage' => 'Reportes'])
@section('title','Reportes')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary d-flex">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title">Transacciones de la semana</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="lastSevenDays"></canvas>
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

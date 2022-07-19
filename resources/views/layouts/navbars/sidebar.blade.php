<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('img/sidebar-1.jpg') }}">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            Pulperi-App
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }} d-none d-sm-none d-md-block">
                <a class="nav-link" href="{{ route('home') }}">
                <i class="material-icons">dashboard</i>
                    <p>Inicio</p>
                </a>
            </li>
            @if (Illuminate\Support\Facades\Gate::allows('permission_index') || Illuminate\Support\Facades\Gate::allows('role_index'))
                <li class="nav-item {{ ($activePage == 'role' || $activePage == 'permission') ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#permisos" aria-expanded="{{ ($activePage == 'role' || $activePage == 'permission') ? 'true' : 'false' }}">
                        <p class="nav-icon">
                            <i class="fas fa-shield-alt fa-lg"></i>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            Roles y Permisos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ ($activePage == 'role' || $activePage == 'permission') ? ' show' : 'hidden' }}" id="permisos">
                        <ul class="nav">
                            @can('permission_index')
                            <li class="nav-item {{ $activePage == 'permission' ? ' active' : '' }} second-level">
                                <a class="nav-link d-flex" href="{{route('prmssns.index')}}">
                                    <span class="material-icons">
                                        verified_user
                                    </span>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <p>Permisos</p>
                                </a>
                            </li>
                            @endcan
                            @can('role_index')
                            <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }} second-level">
                                <a class="nav-link {{ $activePage == 'role' ? '' : 'nav-icon' }}" href="{{route('rls.index')}}">
                                    <span class="material-icons">
                                        fact_check
                                    </span>
                                    &nbsp;
                                    &nbsp;
                                    Roles
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif
            @can('user_indexUsers')
            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="{{ ($activePage == 'profile' || $activePage == 'user-management') ? 'true' : 'false' }}">
                    <p class="nav-icon">
                        <i class="fas fa-users "></i>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        Gestión usuarios
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' show' : 'hidden' }}" id="laravelExample">
                    <ul class="nav">
            @endcan

                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }} {{ Gate::check('user_indexUsers') ? 'second-level' : '';}}">
                            <a class="nav-link {{ $activePage == 'profile' ? '' : 'nav-icon' }}" href="{{route('prfl.show')}}">
                                <i class="fas fa-user-edit fa-lg"></i>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                Perfil de Usuario
                            </a>
                        </li>
            @can('user_indexUsers')
                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }} second-level">
                            <a class="nav-link {{ $activePage == 'user-management' ? '' : 'nav-icon' }}" href="{{ route('usrs.index') }}">
                                <i class="fas fa-address-book fa-lg"></i>
                                &nbsp;
                                &nbsp;
                                &nbsp;
                                Administrar Usuarios
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('inventory_index')
            <li class="nav-item{{ ($activePage == 'inventory' || $activePage == 'to-discount') ? ' active' : ''}}">
                <a class="nav-link" href="#inventario" data-toggle="collapse" aria-expanded="{{ ($activePage == 'inventory' || $activePage == 'to-discount') ? 'true' : 'false' }}">
                    <p class="nav-icon">
                        <i class="material-icons">assignment</i>
                        Inventario
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($activePage == 'inventory' || $activePage == 'to-discount') ? ' show' : 'hidden' }}" id="inventario">
                    <ul class="nav">
                        @can('inventory_index')
                        <li class="nav-item{{ $activePage == 'inventory' ? ' active' : ''}} second-level">
                            <a href="{{route('invntry.index')}}" class="nav-link">
                                <i class="material-icons">add_shopping_cart</i>
                                Existencias
                            </a>
                        </li>
                        @endcan
                        @can('to_discount_index')
                        <li class="nav-item{{ $activePage == 'to-discount' ? ' active' : ''}} second-level">
                            <a href="{{route('tdscnt.index')}}" class="nav-link">
                                <i class="material-icons">reply</i>
                                Descontar
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcan
            @can('client_index')
            <li class="nav-item {{ $activePage == 'clients' ? ' active' : '' }}">
                <a href="{{route('clnts.index')}}" class="nav-link">
                    <i class="material-icons">face</i>
                    <p>Clientes</p>
                </a>
            </li>
            @endcan
            @if (Illuminate\Support\Facades\Gate::any(['sale_index','sale_create','sale_show','sale_destroy']))
            <li class="nav-item{{ $activePage == 'sales' ? ' active' : '' }}">
                <a class="nav-link"
                @can('sale_index')
                href="{{route('sls.index')}}"
                @elsecan('sale_create')
                href="{{route('sls.create')}}"
                @endcan
                >
                    <i class="material-icons">add_shopping_cart</i>
                    <p>Ventas</p>
                </a>
            </li>
            @endif
            @can('debts_index')
            <li class="nav-item{{ $activePage == 'debts' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('dbts.index')}}">
                    <i class="material-icons">money_off</i>
                    <p class="">Deudas</p>
                </a>
            </li>
            @endcan
            <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('ntfctns')}}">
                    <i class="material-icons notif">notifications</i>
                    <p class="">Notificaciones</p>
                </a>
            </li>
            @can('report_index')
            <li class="nav-item{{ $activePage == 'charts' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('rprts')}}">
                    <i class="material-icons">bar_chart</i>
                    <p>Reportes</p>
                </a>
            </li>
            @endcan
            {{-- @can('configuration_index') --}}
                <li class="nav-item{{ $activePage == 'settings' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('settings.index')}}">
                        <i class="material-icons">settings</i>
                        <p>Configuración de Sistema</p>
                    </a>
                </li>
            {{-- @endcan --}}
        </ul>
    </div>
</div>

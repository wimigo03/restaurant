<div class="nav-menu">
    <ul>
        @can('cargos.index')
            <li>
                <a href="{{ route('cargos.index') }}">
                        <i class="fas fa-portrait"></i>&nbsp;Cargos
                </a>
            </li>
        @endcan
        @can('sucursal.index')
            <li>
                <a href="{{ route('sucursal.indexAfter') }}">
                        <i class="fas fa-house-damage"></i>&nbsp;Sucursales
                </a>
            </li>
        @endcan
        @can('categorias.index')
            <li>
                <a href="{{ route('categorias.indexAfter') }}">
                    <i class="fas fa-poll-h"></i>&nbsp;Categorias
                </a>
            </li>
        @endcan
        @can('unidades.index')
            <li>
                <a href="{{ route('unidades.indexAfter') }}">
                    <i class="fas fa-balance-scale"></i>&nbsp;Unidades
                </a>
            </li>
        @endcan
        @can('productos.index')
            <li>
                <a href="{{ route('productos.indexAfter') }}">
                    <i class="fas fa-wine-glass-alt"></i>&nbsp;Productos
                </a>
            </li>
        @endcan
        @can('personal.index')
            <li>
                <a href="{{ route('personal.indexAfter') }}">
                    <i class="fas fa-user-friends"></i>&nbsp;Personal
                </a>
            </li>
        @endcan
        @can('clientes.index')
            <li>
                <a href="{{ route('clientes.index') }}">
                    <i class="fas fa-address-card"></i>&nbsp;Clientes
                </a>
            </li>
        @endcan
        @canany(['users.index','roles.index','permissions.index'])
            <li>
                <a href="" data-toggle="collapse" data-target="#dashboard_users" class="active collapsed" aria-expanded="false">
                    <i class="fa-solid fa-gift"></i>
                    <span class="nav-label mr-3">Usuarios</span>
                    <span class="fa fa-arrow-circle-left float-right"></span>
                </a>
                <ul class="sub-menu collapse" id="dashboard_users">
                    @can('users.index')
                        <li>
                            <a href="{{ route('users.index') }}">
                                <span class="nav-label mr-4">
                                    <i class="fas fa-users"></i>&nbsp;Listar
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('roles.index')
                        <li>
                            <a href="{{ route('roles.index') }}">
                                <span class="nav-label mr-4">
                                    <i class="fas fa-user-shield"></i>&nbsp;Roles
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('permissions.index')
                        <li>
                            <a href="{{ route('permissions.index') }}">
                                <span class="nav-label mr-4">
                                    <i class="fas fa-user-cog"></i>&nbsp;Permisos
                                </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
</div>
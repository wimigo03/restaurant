@can('configuracion.index')
    <li class="nav-item has-treeview">
        <a href="{{ route('configuracion.index') }}" class="nav-link">
            <i class="nav-icon fa-solid fa-gear fa-fw"></i>&nbsp;<p>Configuracion</p>
        </a>
    </li>
@endcan
@canany(['pi.clientes.index','users.index','roles.index','permissions.index'])
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-gear fa-fw"></i>
            <p>Administracion<i class="right fa fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
            @can('pi.clientes.index')
                <li class="nav-item">
                    <a href="{{ route('pi.clientes.index') }}" class="nav-link pl-4">&nbsp;
                        <i class="fas fa-address-card fa-fw"></i>
                        <p>Clientes</p>
                    </a>
                </li>
            @endcan
            @can('users.index')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link pl-4">&nbsp;
                        <i class="fas fa-users fa-fw"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
            @endcan
            @can('roles.index')
                <li class="nav-item">
                    <a href="{{ route('roles.indexAfter') }}" class="nav-link pl-4">&nbsp;
                        <i class="fas fa-user-shield fa-fw"></i>
                        <p>Roles</p>
                    </a>
                </li>
            @endcan
            @can('permissions.index')
                <li class="nav-item">
                    <a href="{{ route('permissions.indexAfter') }}" class="nav-link pl-4">&nbsp;
                        <i class="fas fa-user-cog fa-fw"></i>
                        <p>Permisos</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany

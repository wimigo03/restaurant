@canany(['pi.clientes.index','users.index','roles.index','permissions.index'])
    <li>
        <a href="" data-toggle="collapse" data-target="#dashboard_setting" class="active collapsed" aria-expanded="false">
            <i class="fa-solid fa-gear fa-fw mr-1"></i>&nbsp;Administracion
            <span class="fa fa-arrow-circle-left float-right"></span>
        </a>
        <ul class="sub-menu collapse" id="dashboard_setting">
            @can('pi.clientes.index')
                <li>
                    <a href="{{ route('pi.clientes.index') }}">
                        <i class="fas fa-address-card fa-fw mr-1"></i>&nbsp;Clientes
                    </a>
                </li>
            @endcan
            @can('users.index')
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users fa-fw mr-1"></i>&nbsp;Usuarios
                    </a>
                </li>
            @endcan
            @can('roles.index')
                <li>
                    <a href="{{ route('roles.indexAfter') }}">
                        <i class="fas fa-user-shield fa-fw mr-1"></i>&nbsp;Roles
                    </a>
                </li>
            @endcan
            @can('permissions.index')
                <li>
                    <a href="{{ route('permissions.indexAfter') }}">
                        <i class="fas fa-user-cog fa-fw mr-1"></i>&nbsp;Permisos
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany

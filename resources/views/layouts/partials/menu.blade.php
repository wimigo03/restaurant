<div class="nav-menu">
    <ul>
        @can('plan.cuentas.index')
            <li>
                <a href="{{ route('plan_cuentas.indexAfter') }}">
                    <i class="fa-regular fa-chart-bar fa-fw mr-1"></i>&nbsp;Plan de Cuentas
                </a>
            </li>
        @endcan
        @can('plan.cuentas.auxiliar.index')
            <li>
                <a href="{{ route('plan_cuentas.auxiliar.indexAfter') }}">
                    <i class="fas fa-user-friends fa-fw mr-1"></i>&nbsp;Plan de Cuentas Auxiliares
                </a>
            </li>
        @endcan
        @can('tipo.cambio.index')
            <li>
                <a href="{{ route('tipo.cambio.indexAfter') }}">
                    <i class="fa-solid fa-circle-dollar-to-slot fa-fw mr-1"></i>&nbsp;Tipo de Cambio
                </a>
            </li>
        @endcan
        @can('comprobante.index')
            <li>
                <a href="{{ route('comprobante.indexAfter') }}">
                    <i class="fa-solid fa-file-invoice-dollar fa-fw mr-1"></i>&nbsp;Comprobantes
                </a>
            </li>
        @endcan
        @can('mesas.index')
            <li>
                <a href="{{ route('mesas.indexAfter') }}">
                    <i class="fas fa-utensils fa-fw mr-1"></i>&nbsp;Mesas
                </a>
            </li>
        @endcan
        @can('zonas.index')
            <li>
                <a href="{{ route('zonas.indexAfter') }}">
                    <i class="fa-solid fa-house-laptop fa-fw mr-1"></i>&nbsp;Zonas
                </a>
            </li>
        @endcan
        @can('sucursal.index')
            <li>
                <a href="{{ route('sucursal.indexAfter') }}">
                    <i class="fa-solid fa-house-damage fa-fw mr-1"></i>&nbsp;Sucursales
                </a>
            </li>
        @endcan
        {{--@can('categorias.index')
            <li>
                <a href="{{ route('categorias.indexAfter') }}">
                    <i class="fas fa-poll-h fa-fw mr-1"></i>&nbsp;Categorias
                </a>
            </li>
        @endcan--}}
        {{--@can('unidades.index')
            <li>
                <a href="{{ route('unidades.indexAfter') }}">
                    <i class="fas fa-balance-scale fa-fw mr-1"></i>&nbsp;Unidades
                </a>
            </li>
        @endcan--}}
        @can('productos.index')
            <li>
                <a href="{{ route('productos.indexAfter') }}">
                    <i class="fas fa-wine-glass-alt fa-fw mr-1"></i>&nbsp;Productos
                </a>
            </li>
        @endcan
        @canany(['cargos.index','personal.index'])
            <li>
                <a href="" data-toggle="collapse" data-target="#dashboard_rrhh" class="active collapsed" aria-expanded="false">
                    <i class="fa-solid fa-gift fa-fw mr-1"></i>&nbsp;Recursos Humanos
                    <span class="fa fa-arrow-circle-left float-right"></span>
                </a>
                <ul class="sub-menu collapse" id="dashboard_rrhh">
                    @can('cargos.index')
                        <li>
                            <a href="{{ route('cargos.indexAfter') }}">
                                <i class="fa-solid fa-diagram-project fa-fw mr-2"></i>&nbsp;Cargos
                            </a>
                        </li>
                    @endcan
                    @can('personal.index')
                        <li>
                            <a href="{{ route('personal.indexAfter') }}">
                                <i class="fas fa-user-friends fa-fw mr-2"></i>&nbsp;Personal
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['clientes.index','users.index','roles.index','permissions.index'])
            <li>
                <a href="" data-toggle="collapse" data-target="#dashboard_setting" class="active collapsed" aria-expanded="false">
                    <i class="fa-solid fa-gear fa-fw mr-1"></i>&nbsp;Configuracion
                    <span class="fa fa-arrow-circle-left float-right"></span>
                </a>
                <ul class="sub-menu collapse" id="dashboard_setting">
                    @can('clientes.index')
                        <li>
                            <a href="{{ route('clientes.index') }}">
                                <i class="fas fa-address-card fa-fw mr-2"></i>&nbsp;Clientes
                            </a>
                        </li>
                    @endcan
                    @can('users.index')
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-users fa-fw mr-2"></i>&nbsp;Listar
                            </a>
                        </li>
                    @endcan
                    @can('roles.index')
                        <li>
                            <a href="{{ route('roles.index') }}">
                                <i class="fas fa-user-shield fa-fw mr-2"></i>&nbsp;Roles
                            </a>
                        </li>
                    @endcan
                    @can('permissions.index')
                        <li>
                            <a href="{{ route('permissions.index') }}">
                                <i class="fas fa-user-cog fa-fw mr-2"></i>&nbsp;Permisos
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
</div>
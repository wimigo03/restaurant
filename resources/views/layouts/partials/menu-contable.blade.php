@canany(['estado.resultado.index','balance.apertura.index','plan.cuentas.index','plan.cuentas.auxiliar.index','tipo.cambio.index','comprobante.index'])
    @can('balance.apertura.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('balance.apertura.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Balance Apertura</p>
            </a>
        </li>
    @endcan
    @canany(['estado.resultado.index'])
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-list fa-fw"></i>
                <p>Reportes<i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @can('estado.resultado.index')
                    <li class="nav-item">
                        <a href="{{ route('estado.resultado.index') }}" class="nav-link pl-4">&nbsp;
                        <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Estado de Resultado</p>
                        </a>
                    </li>
                @endcan
                @can('balance.general.index')
                    <li class="nav-item">
                        <a href="{{ route('balance.general.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Balance General</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['libro.mayor.cuenta.general.index','libro.mayor.auxiliar.general.index'])
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-list fa-fw"></i>
                <p>Libros<i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @can('libro.mayor.cuenta.general.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.general.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta-General</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.auxiliar.general.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.auxiliar.general.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Auxiliar-General</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.y.auxiliar.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.y.auxiliar.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta y Auxiliar</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.1.99.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.1.99.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta 1-99</p>
                        </a>
                    </li>
                @endcan
                @can('libro.sumas.y.saldos.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.sumas.y.saldos.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Sumas y Saldos</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.centro.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Centro</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.cuenta.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.centro.cuenta.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Centro y Cuenta</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @can('tipo.cambio.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('tipo.cambio.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-circle-dollar-to-slot fa-fw"></i>&nbsp;<p>Cotizaciones</p>
            </a>
        </li>
    @endcan
    @can('plan.cuentas.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('plan_cuentas.indexAfter') }}" class="nav-link">
            <i class="nav-icon fa-regular fa-chart-bar fa-fw"></i>&nbsp;<p>Plan de Cuentas</p>
            </a>
        </li>
    @endcan
    @can('plan.cuentas.auxiliar.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('plan_cuentas.auxiliar.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user-friends fa-fw"></i>&nbsp;<p>Plan de Cuentas Auxiliares</p>
            </a>
        </li>
    @endcan
    @can('comprobante.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('comprobante.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-file-invoice-dollar fa-fw"></i>&nbsp;<p>Comprobantes</p>
            </a>
        </li>
    @endcan
    @can('centros.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('centros.index') }}" class="nav-link">
                <i class="nav-icon fas fa-donate fa-fw"></i>&nbsp;<p>Centros</p>
            </a>
        </li>
    @endcan
    @can('asiento.automatico.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('asiento.automatico.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Asientos Automaticos</p>
            </a>
        </li>
    @endcan
@endcanany

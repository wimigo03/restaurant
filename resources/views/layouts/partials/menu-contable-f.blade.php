@canany(['comprobantef.index','balance.apertura.f.index','estado.resultado.f.index','balance.general.f.index'])
    @can('balance.apertura.f.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('balance.apertura.f.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Balance Apertura</p>
            </a>
        </li>
    @endcan
    @canany(['estado.resultado.f.index','balance.general.f.index'])
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-list fa-fw"></i>
                <p>Reportes<i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @can('estado.resultado.f.index')
                    <li class="nav-item">
                        <a href="{{ route('estado.resultado.f.index') }}" class="nav-link pl-4">&nbsp;
                           <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Estado de Resultado</p>
                        </a>
                    </li>
                @endcan
                @can('balance.general.f.index')
                    <li class="nav-item">
                        <a href="{{ route('balance.general.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Balance General</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['libro.mayor.cuenta.general.f.index','libro.mayor.auxiliar.general.f.index'])
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fa-solid fa-list fa-fw"></i>
                <p>Libros<i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @can('libro.mayor.cuenta.general.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.general.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta-General</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.auxiliar.general.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.auxiliar.general.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Auxiliar-General</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.y.auxiliar.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.y.auxiliar.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta y Auxiliar</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.1.99.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.cuenta.1.99.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Cuenta 1-99</p>
                        </a>
                    </li>
                @endcan
                @can('libro.sumas.y.saldos.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.sumas.y.saldos.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Sumas y Saldos</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.centro.f.index') }}" class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Centro</p>
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.cuenta.f.index')
                    <li class="nav-item">
                        <a href="{{ route('libro.mayor.centro.cuenta.f.index') }}"class="nav-link pl-4">&nbsp;
                            <i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Mayor por Centro y Cuenta</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @can('comprobantef.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('comprobantef.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-file-invoice-dollar fa-fw"></i>&nbsp;<p>Comprobantes</p>
            </a>
        </li>
    @endcan
@endcanany

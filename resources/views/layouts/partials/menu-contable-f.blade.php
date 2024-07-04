@canany(['comprobantef.index','balance.apertura.f.index','estado.resultado.f.index','balance.general.f.index'])
    @can('comprobantef.index')
        <li>
            <a href="{{ route('comprobantef.index') }}">
                <i class="fa-solid fa-file-invoice-dollar fa-fw mr-1"></i>&nbsp;Comprobantes
            </a>
        </li>
    @endcan
    @can('balance.apertura.f.index')
        <li>
            <a href="{{ route('balance.apertura.f.index') }}">
                <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Balance Apertura
            </a>
        </li>
    @endcan
    @canany(['estado.resultado.f.index','balance.general.f.index'])
        <li>
            <a href="" data-toggle="collapse" data-target="#dashboard_reportes_contabilidad_f" class="active collapsed" aria-expanded="false">
                <i class="fa-solid fa-list fa-fw mr-1"></i>&nbsp;Reportes
                <span class="fa fa-arrow-circle-left float-right"></span>
            </a>
            <ul class="sub-menu collapse" id="dashboard_reportes_contabilidad_f">
                @can('estado.resultado.f.index')
                    <li>
                        <a href="{{ route('estado.resultado.f.index') }}">
                           &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Estado de Resultado
                        </a>
                    </li>
                @endcan
                @can('balance.general.f.index')
                    <li>
                        <a href="{{ route('balance.general.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Balance General
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['libro.mayor.cuenta.general.f.index','libro.mayor.auxiliar.general.f.index'])
        <li>
            <a href="" data-toggle="collapse" data-target="#dashboard_libros_contabilidad" class="active collapsed" aria-expanded="false">
                <i class="fa-solid fa-list fa-fw mr-1"></i>&nbsp;Libros
                <span class="fa fa-arrow-circle-left float-right"></span>
            </a>
            <ul class="sub-menu collapse" id="dashboard_libros_contabilidad">
                @can('libro.mayor.cuenta.general.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.general.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta-General
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.auxiliar.general.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.auxiliar.general.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Auxiliar-General
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.y.auxiliar.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.y.auxiliar.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta y Auxiliar
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.1.99.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.1.99.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta 1-99
                        </a>
                    </li>
                @endcan
                @can('libro.sumas.y.saldos.f.index')
                    <li>
                        <a href="{{ route('libro.sumas.y.saldos.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Sumas y Saldos
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.centro.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Centro
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.cuenta.f.index')
                    <li>
                        <a href="{{ route('libro.mayor.centro.cuenta.f.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Centro y Cuenta
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
@endcanany

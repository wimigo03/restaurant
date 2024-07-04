@canany(['estado.resultado.index','balance.apertura.index','plan.cuentas.index','plan.cuentas.auxiliar.index','tipo.cambio.index','comprobante.index'])
    @can('comprobante.index')
        <li>
            <a href="{{ route('comprobante.index') }}">
                <i class="fa-solid fa-file-invoice-dollar fa-fw mr-1"></i>&nbsp;Comprobantes
            </a>
        </li>
    @endcan
    @can('balance.apertura.index')
        <li>
            <a href="{{ route('balance.apertura.index') }}">
                <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Balance Apertura
            </a>
        </li>
    @endcan
    @canany(['estado.resultado.index'])
        <li>
            <a href="" data-toggle="collapse" data-target="#dashboard_reportes_contabilidad" class="active collapsed" aria-expanded="false">
                <i class="fa-solid fa-list fa-fw mr-1"></i>&nbsp;Reportes
                <span class="fa fa-arrow-circle-left float-right"></span>
            </a>
            <ul class="sub-menu collapse" id="dashboard_reportes_contabilidad">
                @can('estado.resultado.index')
                    <li>
                        <a href="{{ route('estado.resultado.index') }}">
                           &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Estado de Resultado
                        </a>
                    </li>
                @endcan
                @can('balance.general.index')
                    <li>
                        <a href="{{ route('balance.general.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Balance General
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @canany(['libro.mayor.cuenta.general.index','libro.mayor.auxiliar.general.index'])
        <li>
            <a href="" data-toggle="collapse" data-target="#dashboard_libros_contabilidad" class="active collapsed" aria-expanded="false">
                <i class="fa-solid fa-list fa-fw mr-1"></i>&nbsp;Libros
                <span class="fa fa-arrow-circle-left float-right"></span>
            </a>
            <ul class="sub-menu collapse" id="dashboard_libros_contabilidad">
                @can('libro.mayor.cuenta.general.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.general.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta-General
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.auxiliar.general.index')
                    <li>
                        <a href="{{ route('libro.mayor.auxiliar.general.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Auxiliar-General
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.y.auxiliar.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.y.auxiliar.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta y Auxiliar
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.cuenta.1.99.index')
                    <li>
                        <a href="{{ route('libro.mayor.cuenta.1.99.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Cuenta 1-99
                        </a>
                    </li>
                @endcan
                @can('libro.sumas.y.saldos.index')
                    <li>
                        <a href="{{ route('libro.sumas.y.saldos.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Sumas y Saldos
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.index')
                    <li>
                        <a href="{{ route('libro.mayor.centro.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Centro
                        </a>
                    </li>
                @endcan
                @can('libro.mayor.centro.cuenta.index')
                    <li>
                        <a href="{{ route('libro.mayor.centro.cuenta.index') }}">
                            &nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw mr-2"></i>&nbsp;Mayor por Centro y Cuenta
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcanany
    @can('tipo.cambio.index')
        <li>
            <a href="{{ route('tipo.cambio.index') }}">
                <i class="fa-solid fa-circle-dollar-to-slot fa-fw mr-1"></i>&nbsp;Tipo de Cambio
            </a>
        </li>
    @endcan
    @can('centros.index')
        <li>
            <a href="{{ route('centros.index') }}">
                <i class="fas fa-donate fa-fw mr-1"></i>&nbsp;Centros
            </a>
        </li>
    @endcan
    @can('plan.cuentas.index')
        <li>
            <a href="{{ route('plan_cuentas.indexAfter') }}">
            <i class="fa-regular fa-chart-bar fa-fw mr-1"></i>&nbsp;Plan de Cuentas
            </a>
        </li>
    @endcan
    @can('plan.cuentas.auxiliar.index')
        <li>
            <a href="{{ route('plan_cuentas.auxiliar.index') }}">
                <i class="fas fa-user-friends fa-fw mr-1"></i>&nbsp;Auxiliares
            </a>
        </li>
    @endcan
    @can('asiento.automatico.index')
        <li>
            <a href="{{ route('asiento.automatico.index') }}">
                <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Asientos Automaticos
            </a>
        </li>
    @endcan
    {{--<li>
        <a href="" data-toggle="collapse" data-target="#dashboard_contabilidad" class="active collapsed" aria-expanded="false">
            <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Contabilidad
            <span class="fa fa-arrow-circle-left float-right"></span>
        </a>
        <ul class="sub-menu collapse" id="dashboard_contabilidad">

        </ul>
    </li>--}}
@endcanany

@canany(['caja.venta.index','sucursal.index','mesas.index','productos.index'])
    @can('caja.venta.index')
        <li>
            <a href="{{ route('caja.venta.index') }}">
                <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Cajas Ventas
            </a>
        </li>
    @endcan
    @can('sucursal.index')
        <li>
            <a href="{{ route('sucursal.index') }}">
                <i class="fa-solid fa-house-damage fa-fw mr-1"></i>&nbsp;Sucursales
            </a>
        </li>
    @endcan
    @can('mesas.index')
        <li>
            <a href="{{ route('mesas.index') }}">
                <i class="fas fa-utensils fa-fw mr-1"></i></i>&nbsp;Mesas
            </a>
        </li>
    @endcan
    @can('productos.index')
        <li>
            <a href="{{ route('productos.index') }}">
                <i class="fas fa-wine-glass-alt fa-fw mr-1"></i>&nbsp;Productos
            </a>
        </li>
    @endcan
    {{--<li>
        <a href="" data-toggle="collapse" data-target="#dashboard_restaurant" class="active collapsed" aria-expanded="false">
            <i class="fa-solid fa-layer-group fa-fw mr-1"></i>&nbsp;Restaurant
            <span class="fa fa-arrow-circle-left float-right"></span>
        </a>
        <ul class="sub-menu collapse" id="dashboard_restaurant">

        </ul>
    </li>--}}
@endcanany

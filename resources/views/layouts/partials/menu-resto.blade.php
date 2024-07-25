@canany(['caja.venta.index','sucursal.index','mesas.index','productos.index'])
    @can('caja.venta.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('caja.venta.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-layer-group fa-fw"></i>&nbsp;<p>Cajas Ventas</p>
            </a>
        </li>
    @endcan
    @can('sucursal.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('sucursal.index') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-house-damage fa-fw"></i>&nbsp;<p>Sucursales</p>
            </a>
        </li>
    @endcan
    @can('mesas.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('mesas.index') }}" class="nav-link">
                <i class="nav-icon fas fa-utensils fa-fw"></i></i>&nbsp;<p>Mesas</p>
            </a>
        </li>
    @endcan
    @can('pedidos.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('pedidos.create') }}" class="nav-link">
                <i class="nav-icon fas fa-utensils fa-fw"></i></i>&nbsp;<p>Pedidos</p>
            </a>
        </li>
    @endcan
    @can('productos.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('productos.index') }}" class="nav-link">
                <i class="nav-icon fas fa-wine-glass-alt fa-fw"></i>&nbsp;<p>Productos</p>
            </a>
        </li>
    @endcan
@endcanany

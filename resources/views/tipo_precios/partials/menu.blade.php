<div class="form-group row font-roboto-12" id="subMenuPrecioVentas">
    @can('categorias.index')
        <div class="col-md-3 px-1 sub-botones-producto">
            {{--<a href="{{ route('categorias.index',['empresa_id' => $empresa->id, 'status_platos' => '[]', 'status_insumos' => '[]']) }}" class="btn btn-outline-secondary btn-block font-roboto-12">--}}
            <a href="{{ route('categorias.indexAfter') }}" class="btn btn-outline-secondary btn-block font-roboto-12">
                <i class="fas fa-poll-h fa-fw"></i>&nbsp;Categorias
            </a>
        </div>
    @endcan
    @can('unidades.index')
        <div class="col-md-2 pr-1 sub-botones-producto">
            <a href="{{ route('unidades.index') }}" class="btn btn-outline-secondary btn-block font-roboto-12">
                <i class="fas fa-balance-scale fa-fw"></i>&nbsp;Unidades
            </a>
        </div>
    @endcan
    @can('productos.index')
        <div class="col-md-3 pr-1 sub-botones-producto">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-block font-roboto-12">
                <i class="fas fa-wine-glass-alt fa-fw"></i>&nbsp;Productos
            </a>
        </div>
    @endcan
    @can('tipo.precios.index')
        <div class="col-md-2 pr-1 sub-botones-producto">
            <a href="{{ route('tipo.precios.index') }}" class="btn btn-info btn-block font-roboto-12">
                <i class="fas fa-dollar fa-fw fa-beat"></i>&nbsp;Tipos de Precio
            </a>
        </div>
    @endcan
    @can('precio.productos.index')
        <div class="col-md-2 pr-1 sub-botones-producto">
            <a href="{{ route('precio.productos.index') }}" class="btn btn-outline-secondary btn-block font-roboto-12">
                <i class="fa-solid fa-tag fa-fw"></i>&nbsp;Precios
            </a>
        </div>
    @endcan
</div>

@canany(['cargos.index','personal.index'])
    @can('cargos.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('cargos.indexAfter') }}" class="nav-link">
                <i class="nav-icon fa-solid fa-diagram-project fa-fw"></i>&nbsp;<p>Cargos</p>
            </a>
        </li>
    @endcan
    @can('personal.index')
        <li class="nav-item has-treeview">
            <a href="{{ route('personal.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user-friends fa-fw"></i>&nbsp;<p>Personal</p>
            </a>
        </li>
    @endcan
@endcanany

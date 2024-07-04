@canany(['cargos.index','personal.index'])
@can('cargos.index')
    <li>
        <a href="{{ route('cargos.indexAfter') }}">
            <i class="fa-solid fa-diagram-project fa-fw mr-1"></i>&nbsp;Cargos
        </a>
    </li>
@endcan
@can('personal.index')
    <li>
        <a href="{{ route('personal.indexAfter') }}">
            <i class="fas fa-user-friends fa-fw mr-1"></i>&nbsp;Personal
        </a>
    </li>
@endcan
    {{--<li>
        <a href="" data-toggle="collapse" data-target="#dashboard_rrhh" class="active collapsed" aria-expanded="false">
            <i class="fa-solid fa-gift fa-fw mr-1"></i>&nbsp;Recursos Humanos
            <span class="fa fa-arrow-circle-left float-right"></span>
        </a>
        <ul class="sub-menu collapse" id="dashboard_rrhh">

        </ul>
    </li>--}}
@endcanany

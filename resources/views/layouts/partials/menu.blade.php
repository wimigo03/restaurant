<div id="dashboard-content">
    @if(Session::get('menu') == 'OPERATIVO')
        @include('layouts.partials.menu-operativo')
    @endif
    @if(Session::get('menu') == 'CONTABLE')
        @include('layouts.partials.menu-contable')
    @endif
    @if(Session::get('menu') == 'CONTABLEF')
        @include('layouts.partials.menu-contable-f')
    @endif
    @if(Session::get('menu') == 'RESTO')
        @include('layouts.partials.menu-resto')
    @endif
    @if(Session::get('menu') == 'RRHH')
        @include('layouts.partials.menu-rrhh')
    @endif
</div>

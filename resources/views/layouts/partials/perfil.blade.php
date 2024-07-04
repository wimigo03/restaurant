<div class="profile">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @if (isset($empresa))
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img src="{{ url($empresa->url_logo) }}" alt="{{ $empresa->url_logo }}" class="img-fluid">
        </a>
        <h3 class="name">{{ $empresa->nombre_comercial }}</h3>
        <span class="country">{{ auth()->user()->cargo_header }}</span>
    @else
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img src="/images/pi-resto.jpeg" alt="pi-resto" class="img-fluid">
        </a>
        <br>
        <span class="country">{{ auth()->user()->cargo_header }}</span>
    @endif
    <div class="row abs-center">
        <div class="col-md-10">
            <select name="menu_dashboard" id="menu_dashboard" class="form-control font-roboto-13" onchange="goToDashboardType(this.value);">
                {{--<option value="HOME" @if(Session::get('menu') == 'HOME') selected @endif>Inicio</option>
                <option value="ADM" @if(Session::get('menu') == 'ADM') selected @endif>Administracion</option>--}}
                <option value="CONTABLE" @if(Session::get('menu') == 'CONTABLE') selected @endif>Contable</option>
                <option value="CONTABLEF" @if(Session::get('menu') == 'CONTABLEF') selected @endif>Contablef</option>
                <option value="RESTO" @if(Session::get('menu') == 'RESTO') selected @endif>Restaurant</option>
                <option value="RRHH" @if(Session::get('menu') == 'RRHH') selected @endif>Recursos Humanos</option>
            </select>
        </div>
    </div>
</div>

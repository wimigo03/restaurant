<div class="profile">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <img src="{{ url(Auth()->user()->cliente->url_img) }}" alt="img" class="img-fluid">
    </a>
    <br>
    <span class="country">{{ auth()->user()->cargo_header }}</span>
    <div class="row abs-center">
        <div class="col-md-10">
            <select name="menu_dashboard" id="menu_dashboard" class="form-control font-roboto-12 bg-light" onchange="goToDashboardType(this.value);">
                <option value="OPERATIVO" @if(Session::get('menu') == 'OPERATIVO') selected @endif>OPERATIVO</option>
                @canany(['estado.resultado.index','balance.apertura.index','plan.cuentas.index','plan.cuentas.auxiliar.index','tipo.cambio.index','comprobante.index'])
                    <option value="CONTABLE" @if(Session::get('menu') == 'CONTABLE') selected @endif>CONTABLE</option>
                @endcanany
                @canany(['estado.resultado.f.index','balance.apertura.f.index','comprobantef.index'])
                    <option value="CONTABLEF" @if(Session::get('menu') == 'CONTABLEF') selected @endif>CONTABLEF</option>
                @endcanany
                @canany(['caja.venta.index','sucursal.index','mesas.index','productos.index'])
                    <option value="RESTO" @if(Session::get('menu') == 'RESTO') selected @endif>RESTAURANT</option>
                @endcanany
                @canany(['cargos.index','personal.index'])
                    <option value="RRHH" @if(Session::get('menu') == 'RRHH') selected @endif>RECURSOS HUMANOS</option>
                @endcanany
            </select>
        </div>
    </div>
</div>

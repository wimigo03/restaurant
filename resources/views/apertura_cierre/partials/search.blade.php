<form action="#" method="get" id="form">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 px-0 pr-1">
            <input type="text" name="codigo" value="{{ request('codigo') }}" id="codigo" placeholder="--Codigo--" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select name="user_id" id="user_id" class="form-control">
                <option value="">-</option>
                @foreach ($users as $index => $value)
                    <option value="{{ $index }}" @if(request('user_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <select name="cargo_id" id="cargo_id" class="form-control">
                <option value="">-</option>
                @foreach ($cargos as $index => $value)
                    <option value="{{ $index }}" @if(request('cargo_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 px-0 pl-1">
            <input type="text" name="monto" value="{{ request('monto') }}" id="monto" placeholder="--Monto--" class="form-control font-roboto-12 intro">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 px-0 pr-1">
            <input type="text" name="fecha_inicio" value="{{ request('fecha_inicio') }}" id="fecha_inicio" placeholder="--Fecha Inicio--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="fecha_cierre" value="{{ request('fecha_cierre') }}" id="fecha_cierre" placeholder="--Fecha Cierre--" class="form-control font-roboto-12 intro">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<form action="#" method="get" id="form">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
    <input type="hidden" name="sucursal_id" value="{{ $sucursal->id }}" id="sucursal_id">
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="codigo" placeholder="--Codigo--" value="{{ request('codigo') }}" class="form-control font-roboto-bg intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="nombre" placeholder="--Zona--" value="{{ request('nombre') }}" class="form-control font-roboto-bg intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <input type="text" name="mesas" placeholder="--Mesas--" value="{{ request('mesas') }}" class="form-control font-roboto-bg intro" oninput="this.value = this.value.toUpperCase(); valideNumberSinDecimal();">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="detalle" placeholder="--Detalle--" value="{{ request('detalle') }}" class="form-control font-roboto-bg intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-2 pl-1">
            <select name="estado" id="estado" class="form-control">
                <option value="">-</option>
                @foreach ($estados as $index => $value)
                    <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

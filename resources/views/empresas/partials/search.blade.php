<form action="#" method="get" id="form">
    <div class="form-group row">
        <div class="col-md-2 pr-1">
            <input type="text" name="codigo" placeholder="--Codigo--" value="{{ request('codigo') }}" class="form-control font-verdana-bg intro" onkeypress="return valideNumberInteger(event);">
        </div>
        <div class="col-md-5 pr-1 pl-1">
            <input type="text" name="nombre_comercial" placeholder="--Nombre Comercial--" value="{{ request('nombre_comercial') }}" class="form-control font-verdana-bg intro" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <input type="text" name="telefono" placeholder="--Telefono--" value="{{ request('telefono') }}" class="form-control font-verdana-bg intro" onkeypress="return valideNumberInteger(event);">
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

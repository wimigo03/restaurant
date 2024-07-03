<br>
<div class="form-group row">
    <div class="col-md-3 pr-1 font-roboto-12">
        <label for="empresa" class="d-inline">Empresa</label>
        <select name="empresa_id" id="empresa_id" class="form-control select2">
            <option value="">-</option>
            @foreach ($empresas as $index => $value)
                <option value="{{ $index }}" @if(request('empresa_id') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 pr-1 font-roboto-12">
        <label for="nombre" class="d-inline">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-roboto-12 obligatorio" oninput="this.value = this.value.toUpperCase(); verificarObligatorio();">
    </div>
    <div class="col-md-4 pr-1 font-roboto-12">
        <label for="ciudad" class="d-inline">Ciudad</label>
        <input type="text" name="ciudad" value="{{ old('ciudad') }}" id="ciudad" class="form-control font-roboto-12 obligatorio" oninput="this.value = this.value.toUpperCase(); verificarObligatorio();">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 pr-1 font-roboto-12">
        <label for="direccion" class="d-inline">Direccion</label>
        <input type="text" name="direccion" value="{{ old('direccion') }}" id="direccion" class="form-control font-roboto-12 obligatorio" oninput="this.value = this.value.toUpperCase(); verificarObligatorio();">
    </div>
    <div class="col-md-2 pr-1 font-roboto-12">
        <label for="celular" class="d-inline">Telefono</label>
        <input type="text" name="celular" value="{{ old('celular') }}" class="form-control font-roboto-12" onkeypress="return valideNumberSinDecimal(event);">
    </div>
</div>

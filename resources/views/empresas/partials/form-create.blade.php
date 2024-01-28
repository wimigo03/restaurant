<div class="form-group row">
    <div class="col-md-6 pr-1 font-verdana-bg">
        <label for="cliente" class="d-inline">Cliente</label>
        <input type="text" value="{{ $cliente->nombre }}" class="form-control font-verdana-bg" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4 pr-1 font-verdana-bg">
        <label for="nombre_comercial" class="d-inline">Nombre Comercial <i class="fas fa-asterisk"></i></label>
        <input type="text" name="nombre_comercial" value="{{ old('nombre_comercial') }}" class="form-control font-verdana-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="col-md-4 pr-1 pl-1 font-verdana-bg">
        <label for="logo" class="d-inline">Logo</label>
        <input type="file" name="logo" class="form-control font-verdana-bg">
    </div>
    <div class="col-md-4 pl-1 font-verdana-bg">
        <label for="cover" class="d-inline">Cover</label>
        <input type="file" name="cover" class="form-control font-verdana-bg">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-8 pr-1 font-verdana-bg">
        <label for="direccion" class="d-inline">Direccion <i class="fas fa-asterisk"></i></label>
        <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control font-verdana-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="col-md-2 pr-1 pl-1 font-verdana-bg">
        <label for="telefono" class="d-inline">Telefono</label>
        <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control font-verdana-bg" onkeypress="return valideNumberInteger(event);">
    </div>
    <div class="col-md-2 pr-1 font-verdana-bg">
        <label for="alias" class="d-inline">Alias <i class="fas fa-asterisk"></i></label>
        <input type="text" name="alias" value="{{ old('alias') }}" class="form-control font-verdana-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
</div>
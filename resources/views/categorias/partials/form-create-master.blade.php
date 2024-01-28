<div class="form-group row">
    <div class="col-md-7 pr-1 font-verdana-bg">
        <label for="cliente_id" class="d-inline">Cliente</label>
        <input type="hidden" name="cliente_id" value="{{ $empresa->cliente_id }}">
        <input type="text" value="{{ $empresa->cliente->razon_social }}" class="form-control font-verdana-bg" disabled>
    </div>
    <div class="col-md-5 pl-1 font-verdana-bg">
        <label for="empresa_id" class="d-inline">Empresa</label>
        <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
        <input type="text" value="{{ $empresa->nombre_comercial }}" class="form-control font-verdana-bg" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-5 pr-1 font-verdana-bg">
        <label for="categoria" class="d-inline">Categoria Master</label>
        <input type="text" name="categoria" value="{{ old('categoria') }}" class="form-control font-verdana-bg obligatorio" oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="col-md-2 pr-1 pl-1 font-verdana-bg">
        <label for="codigo" class="d-inline">Codigo</label>
        <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control font-verdana-bg obligatorio" oninput="this.value = this.value.toUpperCase()">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-6 pr-1 font-verdana-bg">
        <label for="detalle" class="d-inline">Detalle</label>
        <input type="text" name="detalle" value="{{ old('detalle') }}" class="form-control font-verdana-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="col-md-3 pr-1 pl-1 font-verdana-bg">
        <label for="tipo" class="d-inline">tipo</label>
        <input type="hidden" name="tipo" value="1" class="form-control font-verdana-bg">
        <input type="text" value="PLATOS FINAL" class="form-control font-verdana-bg" disabled>
    </div>
    <div class="col-md-3 pl-1 font-verdana-bg">
        <label for="plan_cuenta" class="d-inline">Plan Cuenta</label>
        <select name="plan_cuenta_id" id="plan_cuenta_id" class="form-control font-verdana-bg select2">
            <option value="">--Seleccionar--</option>
            @foreach ($plan_cuentas as $index => $value)
                <option value="{{ $index }}" @if(old('plan_cuenta_id') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
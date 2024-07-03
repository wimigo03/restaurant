<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}" id="mesa_id">
    <input type="hidden" name="pi_cliente_id" value="{{ $empresa->pi_cliente_id }}" id="pi_cliente_id">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
    <div class="form-group row font-roboto-12">
        <div class="col-md-3 pr-1 pl-1">
            <label for="zona" class="d-inline">Empresa</label>
            <input type="text" value="{{ $empresa->nombre_comercial }}" class="form-control font-roboto-12" disabled>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="sucursal" class="d-inline">Sucursal</label>
            <select name="sucursal_id" id="sucursal_id" class="form-control select2">
                @foreach ($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}"
                        @if($sucursal->id == old('sucursal_id') || (isset($mesa) && $mesa->sucursal_id == $sucursal->id))
                            selected
                        @endif>
                        {{ $sucursal->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 pr-1 pl-1">
            <input type="hidden" value="{{ $mesa->zona_id }}" id="request_zona_id">
            <label for="zona" class="d-inline">Zona</label>
            <select id="zona_id" name="zona_id" class="form-control font-roboto-12 select2">
            </select>
        </div>
        <div class="col-md-2 px-1 pl-1">
            <label for="numero" class="d-inline">N° de Mesa</label>
            <input type="text" name="numero" value="{{ $mesa->numero }}" id="numero" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
    <div class="form-group row font-roboto-12">
        <div class="col-md-2 px-1 pr-1">
            <label for="sillas" class="d-inline">Cant. Sillas</label>
            <input type="text" name="sillas" value="{{ $mesa->sillas }}" id="sillas" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
        <div class="col-md-10 px-1 pl-1">
            <label for="detalle" class="d-inline">Descripcion</label>
            <input type="text" name="detalle" value="{{ $mesa->detalle }}" id="detalle" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
</form>
<div class="form-group row">
    <div class="col-md-12 px-1 text-right">
        <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
            <i class="fas fa-paper-plane fa-fw"></i>&nbsp;Actualizar
        </span>
        <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
            <i class="fas fa-times fa-fw"></i>&nbsp;Cancelar
        </span>
        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>

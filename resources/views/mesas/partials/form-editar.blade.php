<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="mesa_id" value="{{ $mesa->id }}" id="mesa_id">
    <input type="hidden" name="cliente_id" value="{{ $empresa->cliente_id }}" id="cliente_id">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
    <div class="form-group row font-roboto-bg">
        <div class="col-md-4 pr-1">
            <label for="sucursal" class="d-inline">Sucursal</label>
            <div class="select2-container--obligatorio" id="obligatorio_sucursal_id">
                <select name="sucursal_id" id="sucursal_id" class="form-control select2" onchange="obligatorio();">
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
        </div>
        <div class="col-md-4">
            <label for="zona" class="d-inline">Zona</label>
            <div class="select2-container--obligatorio" id="obligatorio_zona_id">
                <select id="zona_id" name="zona_id" class="form-control font-verdana-bg select2" onchange="obligatorio();">
                    <option value="">--Seleccionar--</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="numero" class="d-inline">N° de Mesa</label>
            <input type="text" name="numero" value="{{ $mesa->numero }}" id="numero" class="form-control font-roboto-bg obligatorio intro" oninput="this.value = this.value.toUpperCase(); obligatorio();">
        </div>
        <div class="col-md-2 pl-1">
            <label for="sillas" class="d-inline">Cant. Sillas</label>
            <input type="text" name="sillas" value="{{ $mesa->sillas }}" id="sillas" class="form-control font-roboto-bg obligatorio intro" oninput="this.value = this.value.toUpperCase(); obligatorio();">
        </div>
    </div>
    <div class="form-group row font-roboto-bg">
        <div class="col-md-11 pr-1">
            <label for="detalle" class="d-inline">Descripcion</label>
            <input type="text" name="detalle" value="{{ $mesa->detalle }}" id="detalle" class="form-control font-roboto-bg intro" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
</form>
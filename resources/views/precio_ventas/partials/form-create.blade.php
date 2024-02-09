<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="cliente_id" value="{{ $empresa->cliente_id }}" id="cliente_id">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
    <div class="form-group row font-roboto-bg">
        <div class="col-md-4 pr-1">
            <label for="tipo" class="d-inline">Tipo</label>
            <select name="tipo_precio_id" id="tipo_precio_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($tipos_precio as $index => $value)
                    <option value="{{ $index }}" @if(old('tipo_precio_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="p_descuento" class="d-inline">% de Descuento</label>
            <input type="text" name="p_descuento" value="{{ old('p_descuento') }}" placeholder="0" id="p_descuento" class="form-control font-roboto-bg obligatorio intro"  onkeypress="return valideNumberConDecimal(event);">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1">
            <span class="text-danger font-italic font-roboto">Al introducir un nuevo descuento se reestrablecera todos los descuento detalle.-<span>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <table id="table-precios" class="table display responsive table-striped">
                <thead>
                    <tr class="font-roboto-bg">
                        <td class="text-left p-1"><b>CODIGO</b></td>
                        <td class="text-left p-1"><b>PRODUCTO</b></td>
                        <td class="text-left p-1"><b>CATEGORIA</b></td>
                        <td class="text-left p-1"><b>SUB CATEGORIA</b></td>
                        <td class="text-right p-1"><b>PRECIO</b></td>
                        <td class="text-right p-1"><b>% DESC.</b></td>
                        <td class="text-right p-1"><b>PRECIO FINAL</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $datos)
                        <tr class="detalle-{{ $datos->id }} font-roboto">
                            <td class="text-left p-1">
                                <input type="hidden" name="producto_id[]" value="{{ $datos->id }}" class="input-producto-id">
                                <input type="hidden" name="categoria_id[]" value="{{ $datos->categoria_id }}">
                                <input type="hidden" name="categoria_master_id[]" value="{{ $datos->categoria_master_id }}">
                                <input type="hidden" name="plan_cuenta_id[]" value="{{ $datos->plan_cuenta_id }}">
                                <input type="hidden" name="moneda_id[]" value="{{ $datos->moneda_id }}">
                                <input type="hidden" name="pais_id[]" value="{{ $datos->pais_id }}">
                                <input type="hidden" name="unidad_id[]" value="{{ $datos->unidad_id }}">
                                {{ $datos->codigo }}
                            </td>
                            <td class="text-left p-1">{{ $datos->nombre }}</td>
                            <td class="text-left p-1">{{ $datos->categoria_m->nombre }}</td>
                            <td class="text-left p-1">{{ $datos->categoria->nombre }}</td>
                            <td class="text-right p-1" width="150px">
                                <input type="text" name="precio[]" value="{{ old('precio[]') }}" placeholder="0" class="form-control font-roboto-bg text-right input-precio" onKeyUp="PrecioTotal({{ $datos->id }})">
                            </td>
                            <td class="text-right p-1" width="150px">
                                <input type="text" name="descuento[]" value="{{ old('descuento[]') }}" placeholder="0" class="form-control font-roboto-bg text-right input-descuento" onKeyUp="PrecioTotal({{ $datos->id }})">
                            </td>
                            <td class="text-right p-1" width="150px">
                                <input type="text" name="precio_final[]" value="{{ old('precio_final[]') }}" placeholder="0" class="form-control font-roboto-bg text-right input-precio-final" readonly>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>
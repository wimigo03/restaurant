<br>
<div class="form-group row">
    <div class="col-md-5 pr-1 font-roboto-bg">
        <label for="nombre_familiar_input" class="d-inline">Nombre del Familiar</label>
        <input type="text" value="{{ old('nombre_familiar_input') }}" id="nombre_familiar_input" class="form-control font-roboto-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="col-md-3 pr-1 pl-1 font-roboto-bg">
        <label for="tipo_familiar_input" class="d-inline">Tipo</label><br>
        <select id="tipo_familiar_input" class="form-control select2">
            <option value="">-</option>
            @foreach ($tipo_familiares as $index => $value)
                <option value="{{ $index }}" @if(old('tipo_familiar_input') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 pr-1 pl-1 font-roboto-bg">
        <label for="edad_familiar_input" class="d-inline">Edad</label>
        <input type="text" value="{{ old('edad_familiar_input') }}" id="edad_familiar_input" class="form-control font-roboto-bg" onkeypress="return valideNumberSinDecimal(event);">
    </div>
    <div class="col-md-2 pl-1 font-roboto-bg">
        <label for="telefono_familiar_input" class="d-inline">Telefono</label>
        <input type="text" value="{{ old('telefono_familiar_input') }}" id="telefono_familiar_input" class="form-control font-roboto-bg" onkeypress="return valideNumberSinDecimal(event);">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-3 pr-1 font-roboto-bg">
        <label for="ocupacion_familiar_input" class="d-inline">Ocupacion</label><br>
        <select id="ocupacion_familiar_input" class="form-control select2">
            <option value="">-</option>
            @foreach ($ocupaciones as $index => $value)
                <option value="{{ $index }}" @if(old('ocupacion_familiar_input') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 pr-1 pl-1 font-roboto-bg">
        <label for="nivel_estudio_familiar_input" class="d-inline">Nivel de Estudio</label>
        <select id="nivel_estudio_familiar_input" class="form-control select2">
            <option value="">-</option>
            @foreach ($niveles_estudio as $index => $value)
                <option value="{{ $index }}" @if(old('nivel_estudio_familiar_input') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 pr-1 font-roboto-bg" id="form_otro_tipo">
        <label for="otro_tipo_familiar_input" class="d-inline">Otro Tipo Familiar</label>
        <input type="text" value="{{ old('otro_tipo_familiar_input') }}" id="otro_tipo_familiar_input" class="form-control font-roboto-bg" oninput="this.value = this.value.toUpperCase()">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 pl-1 font-roboto-bg text-right">
        <span class="tts:left tts-slideIn tts-custom" aria-label="Registrar Familiar">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="agregarFamiliar();">
                &nbsp;<i class="fa fa-lg fa-plus-circle"></i>&nbsp;
            </button>
        </span>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table id="detalle_tabla" class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-roboto-bg">
                    <td class="text-left p-1"><b>FAMILIAR</b></td>
                    <td class="text-left p-1"><b>TIPO</b></td>
                    <td class="text-left p-1"><b>EDAD</b></td>
                    <td class="text-left p-1"><b>TELEFONO</b></td>
                    <td class="text-left p-1"><b>OCUPACION</b></td>
                    <td class="text-left p-1"><b>NIVEL ESTUDIO</b></td>
                    <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
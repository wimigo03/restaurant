<form action="#" method="get" id="form">
    <div class="form-group row font-roboto-12 abs-center">
        <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
        <div class="col-md-3 px-0 pr-1">
            @can('estado.resultado.index')
                <br>
                <span class="tts:right tts-slideIn tts-custom" aria-label="Cambiar" style="cursor: pointer;">
                    <button class="btn btn-outline-secondary font-roboto-12" type="button" onclick="cambiari();">
                        <i class="fa-solid fa-file-invoice-dollar fa-fw"></i>
                    </button>
                </span>
            @endcan
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="fecha_i" class="d-inline">Fecha Inicial</label>
            <input type="text" name="fecha_i" value="{{ request('fecha_i') }}" id="fecha_i" placeholder="(desde) - dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="fecha_f" class="d-inline">Fecha Final</label>
            <input type="text" name="fecha_f" value="{{ request('fecha_f') }}" id="fecha_f" placeholder="(hasta) - dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1">
            <label for="estado" class="d-inline">Estado</label>
            <select name="estado" id="estado" class="form-control select2">
                <option value='_todos_' @if(request('estado') == '_todos_') selected @endif>Todos</option>
                <option value='2' @if(request('estado') == '2') selected @endif>Solo Aprobados</option>
                <option value="1" @if(request('estado') == '1') selected @endif>Solo Pendientes</option>
            </select>
        </div>
        <div class="col-md-3 px-0 pl-1 text-right">
            <br>
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="search();">
                &nbsp;<i class="fas fa-search fa-fw"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fas fa-eraser fa-fw"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>

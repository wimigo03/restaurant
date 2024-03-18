<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="configuracion_id" value="{{ $configuracion->id }}">
    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
    <div class="form-group row abs-center">
        <div class="col-md-4 font-roboto-12 text-center">
            <span><b>_{{ $configuracion->nombre }}_</b></span>
        </div>
    </div>
    {{--<div class="form-group row abs-center">
        <div class="col-md-3 font-roboto-12">
            <input type="text" name="fecha" value="{{ old('fecha') }}" id="fecha" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
    </div>--}}
    <div class="form-group row abs-center">
        <div class="col-md-3 px-0 pr-1">
            <select name="dia" id="dia" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($dias as $index => $value)
                    <option value="{{ $index }}" @if(old('dia') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <select name="mes" id="mes" class="form-control font-roboto-12 select2">
                <option value="">--Seleccionar--</option>
                @foreach ($meses as $index => $value)
                    <option value="{{ $index }}" @if(old('mes') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fas fa-paper-plane"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
</form>

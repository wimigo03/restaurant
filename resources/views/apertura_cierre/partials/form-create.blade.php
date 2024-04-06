<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row">
        <div class="col-md-3 px-0 pr-1 font-roboto-12">
            <label for="empresa" class="d-inline">Empresa</label>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id }}" id="empresa_id">
            <input type="text" value="{{ $empresa->nombre_comercial }}" id="empresa" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase()" disabled>
        </div>
        <div class="col-md-4 pr-1 pl-1 font-roboto-12">
            <label for="user" class="d-inline">Usuario</label>
            <select name="user_id" id="user_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($users as $index => $value)
                    <option value="{{ $index }}" @if(old('user_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2 px-0 pr-1 font-roboto-12">
            <label for="fecha_inicial" class="d-inline">Fecha de Apertura</label>
            <input type="text" name="fecha_inicial" value="{{ old('fecha_inicial') }}" id="fecha_inicial" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" data-language="es">
        </div>
        <div class="col-md-2 pr-1 pl-1 font-roboto-12">
            <label for="monto" class="d-inline">Monto</label>
            <input type="text" name="monto" value="{{ old('monto') }}" id="monto" class="form-control font-roboto-12">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-9 px-0 pr-1 font-roboto-12">
            <label for="concepto" class="d-inline">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();">{{ old('observaciones') }}</textarea>
        </div>
    </form>
    </div>

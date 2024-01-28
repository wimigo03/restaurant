<div class="form-group row">
    <div class="col-md-6 pr-1 font-verdana-bg">
        <label for="empresa" class="d-inline">Empresa</label>
        <select name="empresa_id" id="empresa_id" class="form-control select2">
            <option value="">-</option>
            @foreach ($empresas as $index => $value)
                <option value="{{ $index }}" @if(old('empresa_id') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 pr-1 pl-1 font-verdana-bg">
        <label for="nombre" class="d-inline">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-verdana obligatorio">
    </div>
</div>
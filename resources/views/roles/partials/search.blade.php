<div class="form-group row">
    <div class="col-md-6 pr-1">
        <select name="empresa_id" id="empresa_id" class="form-control select2">
            <option value="">-</option>
            @foreach ($empresas as $index => $value)
                <option value="{{ $index }}" @if(request('empresa_id') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 pr-1 pl-1">
        <input type="text" name="nombre" placeholder="--Nombre--" value="{{ request('nombre') }}" class="form-control font-verdana-bg intro">
    </div>
</div>

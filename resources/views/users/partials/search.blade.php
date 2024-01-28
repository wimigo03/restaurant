<div class="form-group row">
    <div class="col-md-3 pr-1">
        <select name="empresa_id" id="empresa_id" class="form-control select2">
            <option value="">-</option>
            @foreach ($empresas as $index => $value)
                <option value="{{ $index }}" @if(request('empresa_id') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <select id="cargo_id" name="cargo_id" placeholder="--Seleccionar--" class="form-control select2">
            <option value="">-</option>
        </select>
    </div>
    <div class="col-md-3 pr-1 pl-1">
        <select id="role_id" name="role_id" placeholder="--Seleccionar--" class="form-control select2">
            <option value="">-</option>
        </select>
    </div>
    <div class="col-md-3 pl-1">
        <input type="text" name="nombre" placeholder="--Nombre--" value="{{ request('nombre') }}" class="form-control font-verdana-bg intro">
    </div>
</div>
<div class="form-group row">
    <div class="col-md-3 pr-1">
        <input type="text" name="username" placeholder="--Usuario--" value="{{ request('username') }}" class="form-control font-verdana-bg intro">
    </div>
    <div class="col-md-4 pr-1 pl-1">
        <input type="text" name="email" placeholder="--Correo Electronico--" value="{{ request('email') }}" class="form-control font-verdana-bg intro">
    </div>
    <div class="col-md-2 pr-1 pl-1">
        <select name="estado" id="estado" class="form-control select2">
            <option value="">-</option>
            @foreach ($estados as $index => $value)
                <option value="{{ $index }}" @if(request('estado') == $index) selected @endif >{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

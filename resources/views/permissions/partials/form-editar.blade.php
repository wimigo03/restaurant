<div class="form-group row">
    <div class="col-md-4 pr-1 font-verdana">
        <label for="cliente_id" class="d-inline">Cliente</label>
        <input type="hidden" name="cliente_id" value="{{ $user->cliente_id }}">
        <input type="text" value="{{ $user->cliente->razon_social }}" class="form-control form-control-sm font-verdana" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 font-verdana">
        <label for="empresa_id" class="d-inline">Empresa</label>
        <input type="hidden" name="empresa_id" value="{{ $user->empresa_id }}">
        <input type="text" value="{{ $user->empresa->nombre_comercial }}" class="form-control form-control-sm font-verdana" disabled>
    </div>
    <div class="col-md-5 pl-1 font-verdana">
        <label for="cargo_id" class="d-inline">Cargo</label>
        <input type="hidden" name="cargo_id" value="{{ $user->cargo_id }}">
        <input type="text" value="{{ $user->cargo->nombre }}" class="form-control form-control-sm font-verdana" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-5 pr-1 font-verdana">
        <label for="nombre" class="d-inline">Nombre</label>
        <input type="text" name="nombre" value="{{ $user->name }}" class="form-control form-control-sm font-verdana">
    </div>
    <div class="col-md-2 pr-1 pl-1 font-verdana">
        <label for="username" class="d-inline">Usuario</label>
        <input type="text" value="{{ $user->username }}" class="form-control form-control-sm font-verdana" disabled>
    </div>
    <div class="col-md-3 pr-1 pl-1 font-verdana">
        <label for="email" class="d-inline">Correo Electronico</label>
        <input type="text" name="email" value="{{ $user->email }}" class="form-control form-control-sm font-verdana">
    </div>
    <div class="col-md-2 pl-1 font-verdana">
        <label for="estado" class="d-inline">Estado</label>
        <input type="text" value="{{ $user->status }}" class="form-control form-control-sm font-verdana" disabled>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-3 pr-1 font-verdana">
        <label for="password" class="d-inline">Clave de Acceso</label>
        <input type="password" name="password" class="form-control form-control-sm font-verdana">
    </div>
</div>
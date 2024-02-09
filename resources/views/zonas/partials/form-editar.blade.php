<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-bg">
        <div class="col-md-4 pr-1">
            <label for="sucursal" class="d-inline">Sucursal</label>
            <input type="hidden" name="sucursal_id" value="{{ $sucursal->id }}" id="sucursal_id">
            <input type="text" value="{{ $sucursal->nombre }}" id="sucursal" class="form-control font-roboto-bg" disabled>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="nombre" class="d-inline">Zona</label>
            <input type="hidden" name="zona_id" value="{{ $zona->id }}" id="zona_id">
            <input type="text" name="nombre" value="{{ $zona->nombre }}" id="nombre" class="form-control font-roboto-bg obligatorio" oninput="this.value = this.value.toUpperCase(); obligatorio();">
        </div>
        <div class="col-md-2 pl-1">
            <label for="codigo" class="d-inline">Codigo</label>
            <input type="text" name="codigo" value="{{ $zona->codigo }}" id="codigo" class="form-control font-roboto-bg obligatorio" oninput="this.value = this.value.toUpperCase(); obligatorio();">
        </div>
    </div>
    <div class="form-group row font-roboto-bg">
        <div class="col-md-10 pr-1">
            <label for="detalle" class="d-inline">Descripcion</label>
            <input type="text" name="detalle" value="{{ $zona->detalle }}" id="detalle" class="form-control font-roboto-bg" oninput="this.value = this.value.toUpperCase();">
        </div>
    </div>
</form>
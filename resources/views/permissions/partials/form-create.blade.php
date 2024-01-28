<div class="form-group row">
    <div class="col-md-6 pr-1 font-verdana-bg">
        <label for="titulo" class="d-inline">Titulo</label>
        <select name="titulo" id="titulo" placeholder="--Seleccionar--" class="form-control select2">
            <option value="">-</option>
            @foreach ($titulos as $titulo)
                <option value="{{ $titulo->title }}"
                    @if($titulo->title == old('titulo'))
                        selected
                    @endif>
                    {{ strtoupper($titulo->title) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4 pr-1 font-verdana-bg">
        <label for="nombre" class="d-inline">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-verdana-bg obligatorio intro" oninput="this.value = this.value.toLowerCase();">
    </div>
    <div class="col-md-8 pl-1 font-verdana-bg">
        <label for="descripcion" class="d-inline">Descripcion</label>
        <input type="text" name="descripcion" value="{{ old('descripcion') }}" id="descripcion" class="form-control font-verdana obligatorio intro">
    </div>
</div>
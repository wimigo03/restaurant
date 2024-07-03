<form action="#" method="post" id="form">
    @csrf
    <div class="form-group row font-roboto-12 abs-center">
        <div class="col-md-3 px-1 pr-1">
            <label for="empresa" class="d-inline">Empresa</label>
            <select name="empresa_id" id="empresa_id" class="form-control select2">
                <option value="">-</option>
                @foreach ($empresas as $index => $value)
                    <option value="{{ $index }}" @if(old('empresa_id') == $index) selected @endif >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 pr-1 pl-1">
            <label for="nombre" class="d-inline">Tipo</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" id="nombre" class="form-control font-roboto-12 obligatorio intro" oninput="this.value = this.value.toUpperCase(); obligatorio();">
        </div>
    </div>
    <div class="form-group row font-roboto-12 abs-center">
        <div class="col-md-6 pr-1 pl-1">
            <label for="observaciones" class="d-inline">Observaciones</label>
            <textarea name="observaciones" value="{{ old('observaciones') }}" id="observaciones" class="form-control font-roboto-12 intro" oninput="this.value = this.value.toUpperCase();"></textarea>
        </div>
    </div>
</form>

<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" name="sucursal_id" id="sucursal_old_id">
    <input type="hidden" name="zona_id" id="zona_old_id">
    <input type="hidden" name="_filas" id="filas">
    <input type="hidden" name="_columnas" id="columnas">
    {{--<div class="card card-body">--}}
        <div class="form-group row">
            <div class="col-md-12 text-center">
                <b class="font-roboto-20">REGISTRAR PEDIDO</b>
            </div>
        </div>
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-3 font-roboto-12">
                <label for="empresa" class="d-inline">Empresa</label>
                <select name="empresa_id" id="empresa_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($empresas as $index => $value)
                        <option value="{{ $index }}" @if(request('empresa_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="sucursal" class="d-inline">Sucursal</label>
                <select id="sucursal_id" class="form-control select2">
                </select>
            </div>
        </div>
        <div id="zonas-container" class="form-group row font-roboto-12 abs-center">
            {{-- jquery zonas --}}
        </div>
        <div class="form-group row abs-center" {{--id="configuracion-mesas"--}}>
            <div class="col-md-10 text-center">
                <div id="grid-container">
                </div>
            </div>
        </div>
    {{--</div>--}}
</form>

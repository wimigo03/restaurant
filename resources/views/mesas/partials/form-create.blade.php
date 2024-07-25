<form action="#" method="post" id="form">
    @csrf
    <input type="hidden" value="{{ request('sucursal_id') }}" id="sucursal_old_id">
    <input type="hidden" name="zona_id" value="{{ request('zona_id') }}" id="zona_id">
    <input type="hidden" name="_filas" value="{{ $zona != null ? $zona->filas : '#'}}" id="filas">
    <input type="hidden" name="_columnas" value="{{ $zona != null ? $zona->columnas : '#' }}" id="columnas">
    {{--<div class="card card-body">--}}
        <div class="form-group row">
            <div class="col-md-12 text-center">
                <b class="font-roboto-20">CONFIGURACION DE MESAS</b>
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
                <select name="sucursal_id" id="sucursal_id" class="form-control select2">
                </select>
            </div>
        </div>
        <div id="zonas-container" class="form-group row font-roboto-12 abs-center">
            {{-- jquery --}}
        </div>
        <div class="form-group row">
            <div class="col-md-11">
                <span class="btn btn-sm btn-primary font-roboto-12" onclick="decrementar_filas_columnas()">
                    <i class="fas fa-search-minus fa-lg"></i>
                </span>
                <span class="btn btn-sm btn-primary font-roboto-12" onclick="incrementar_filas_columnas()">
                    <i class="fas fa-search-plus fa-lg"></i>
                </span>
            </div>
        </div>
        <div class="form-group row" id="configuracion-mesas">
            <div class="col-md-9 text-center">
                <div id="grid-container">
                </div>
            </div>
            <div class="col-md-3">
                <div class="grid-sillas">
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/una_silla.jpg') }}"
                            id="1"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/dos_sillas.jpg') }}"
                            id="2"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/tres_sillas.jpg') }}"
                            id="3"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/cuatro_sillas.jpg') }}"
                            id="4"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/cinco_sillas.jpg') }}"
                            id="5"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/seis_sillas.jpg') }}"
                            id="6"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/siete_sillas.jpg') }}"
                            id="7"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                    <div class="grid-item-sillas">
                        <img
                            src="{{ asset('images/blanca_con_numero/ocho_sillas.jpg') }}"
                            id="8"
                            class="draggable-cursor"
                            draggable="true"
                            ondragstart="drag(event)"
                            ondrag="dragging(event)"
                            ondragend="endDrag(event)"/>
                    </div>
                </div>
            </div>
        </div>
    {{--</div>--}}
</form>

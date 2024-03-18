<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-results__option {
        font-size: 12px;
    }
</style>
@section('content')
    @include('precio_productos.partials.menu')
    @include('precio_productos.partials.search')
    @if (isset($precio_productos))
        <form action="#" method="post" id="form-precios">
            @csrf
            <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            <div class="form-group row font-roboto-12">
                <div class="col-md-2 px-0 pl-1">
                    <label for="tipo_cambio" class="d-inline">T. Cambio</label>
                    <input type="text" name="tipo_cambio" value="{{ $tipo_cambio->dolar_oficial }}" placeholder="0" id="tipo_cambio" class="form-control font-roboto-12" readonly>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="tipo_movimiento" class="d-inline">¿Subir - Bajar?</label>
                    <select name="tipo_movimiento" id="tipo_movimiento" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($tipo_movimientos as $index => $value)
                            <option value="{{ $index }}" @if(request('tipo_movimiento') == $index) selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 pr-1 pl-1">
                    <label for="porcentaje" class="d-inline">Porc.</label>
                    <input type="text" name="porcentaje" value="{{ old('porcentaje') }}" placeholder="0" id="porcentaje" class="form-control font-roboto-12">
                </div>
                <div class="col-md-1 pr-1 pl-1 font-roboto-15">
                    <br>
                    <b>%</b>
                </div>
                <div class="col-md-6 px-0 pl-1 text-right">
                    <br>
                    <button class="btn btn-primary font-verdana" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i>&nbsp;Actualizar
                    </button>
                    <button class="btn btn-danger font-verdana" type="button" onclick="limpiar();">
                        <i class="fas fa-times fa-fw"></i>&nbsp;Cancelar
                    </button>
                </div>
            </div>
            @include('precio_productos.partials.table-tipo-base')
        </form>
    @endif
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            var tabla = document.getElementById("table-precios");
            var celdasPrecioActual = tabla.getElementsByClassName("input-porcentaje-detalle");
            for (var i = 0; i < celdasPrecioActual.length; i++) {
                document.getElementsByClassName("input-precio-final")[i].value = '';
                document.getElementsByClassName("input-precio-final-sus")[i].value = '';
                document.getElementsByClassName("input-porcentaje-detalle")[i].value = '';
            }
            new Cleave('#porcentaje', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });

            $('.input-precio-final').each(function() {
                /*var formattedValue = Number($(this).val()).toLocaleString('es-ES');
                $(this).val(formattedValue);*/
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            $('.input-porcentaje-detalle').each(function() {
                /*var formattedValue = Number($(this).val()).toLocaleString('es-ES');
                $(this).val(formattedValue);*/
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#tipo_precio_id').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo Precio--",
                width: '100%'
            });

            $('#categoria_master_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria Master--",
                width: '100%'
            });

            $('#categoria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            if($("#categoria_master_id >option:selected").val() != ''){
                var id = $("#categoria_master_id >option:selected").val();
                var empresa_id = $("#empresa_id").val();
                getCategorias(id,empresa_id);
            }

            if($("#porcentaje").val() != ''){
                actualizarTablaPrecios();
            }
        });

        $('#categoria_master_id').change(function() {
            localStorage.clear();
            var id = $(this).val();
            var empresa_id = $("#empresa_id").val();
            getCategorias(id,empresa_id);
        });

        function getCategorias(id,empresa_id){
            $.ajax({
                type: 'GET',
                url: '/precio-productos/get_subcategorias_precio_productos/'+empresa_id+'/'+id,
                data: {
                    empresa_id: empresa_id,
                    id: id
                },
                success: function(data){
                    if(data.subcategorias){
                        var arr = Object.values($.parseJSON(data.subcategorias));
                        $("#categoria_id").empty();
                        var select = $("#categoria_id");
                        select.append($("<option></option>").attr("value", '').text('--Categoria--'));
                        var categoriaIdSeleccionado = localStorage.getItem('categoriaIdSeleccionado');
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == categoriaIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                        select.on('change', function() {
                            localStorage.setItem('categoriaIdSeleccionado', $(this).val());
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }
        
        function valideNumberConDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 46 || code === 8) {
                if (code === 46 && evt.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        $("#toggleSubMenu").click(function(){
            $("#subMenuPrecioVentas").slideToggle(250);
        });

        $('#tipo_movimiento').on('change', function() {
            actualizarTablaPrecios();
        });

        $('#porcentaje').on('input', function () {
            if($("#tipo_movimiento >option:selected").val() == ''){
                alerta("<center><b>[SE DEBE SELECCIONAR UN TIPO DE MOVIMIENTO]</b></center>");
                document.getElementById("porcentaje").value = '';
            }else{
                actualizarTablaPrecios();
            }
        });

        function actualizarTablaPrecios(){
            var tipo_movimiento = $("#tipo_movimiento >option:selected").val();
            var porcentaje = $("#porcentaje").val();
            var tipo_cambio = $("#tipo_cambio").val();
            var tabla = document.getElementById("table-precios");
            var celdasPrecioActual = tabla.getElementsByClassName("input-porcentaje-detalle");
            if(porcentaje != '' && porcentaje != 0){
                if(tipo_movimiento === '1'){
                    for (var i = 0; i < celdasPrecioActual.length; i++) {
                        document.getElementsByClassName("input-porcentaje-detalle")[i].value = porcentaje;
                    }
                }else{
                    for (var i = 0; i < celdasPrecioActual.length; i++) {
                        document.getElementsByClassName("input-porcentaje-detalle")[i].value = -porcentaje;
                    }
                }
                
                var celdasId = tabla.getElementsByClassName("input-precio-producto-id");
                for (var i = 0; i < celdasId.length; i++) {
                    var id = celdasId[i].value;
                    var precio_producto_id = $('.detalle-'+id+' .input-precio-producto-id').val();
                    var precio_final = PrecioFinal(tipo_movimiento,precio_producto_id,tipo_cambio);
                }
            }

            if(porcentaje == ''){
                for (var i = 0; i < celdasPrecioActual.length; i++) {
                    document.getElementsByClassName("input-porcentaje-detalle")[i].value = '';
                    document.getElementsByClassName("input-precio-final")[i].value = '';
                }
            }
        }

        function CalcularCambioPorcentaje(id) {
            var tipo_cambio = $("#tipo_cambio").val();
            var tipo_movimiento = $("#tipo_movimiento >option:selected").val();
            var precio_base = $('.detalle-'+id+' .input-precio-base').val();
            var porcentaje_detalle = $('.detalle-'+id+' .input-porcentaje-detalle').val();
            precio_base = (isNaN(parseFloat(precio_base)))? 0 : parseFloat(precio_base);
            porcentaje_detalle = porcentaje_detalle.replace(/,/g, '');
            porcentaje_detalle = (isNaN(parseFloat(porcentaje_detalle)))? 0 : parseFloat(porcentaje_detalle);
            try{    
                var precio_final = precio_base + (porcentaje_detalle * precio_base / 100);
                var precio_final_sus = precio_final / tipo_cambio;
                $('.detalle-'+id+' .input-precio-final').each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    }).setRawValue(precio_final);
                });
                $('.detalle-'+id+' .input-precio-final-sus').each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    }).setRawValue(precio_final_sus);
                });
            }catch(e){
                console.log('ERROR')
            }
        }

        function CalcularCambioPrecioFinal(id) {
            var tipo_cambio = parseFloat($("#tipo_cambio").val());
            var tipo_movimiento = $("#tipo_movimiento >option:selected").val();
            var precio_base = $('.detalle-'+id+' .input-precio-base').val();
            precio_base = (isNaN(parseFloat(precio_base)))? 0 : parseFloat(precio_base);
            var precio_final_detalle = $('.detalle-'+id+' .input-precio-final').val();
            precio_final_detalle = precio_final_detalle.replace(/,/g, '');
            precio_final_detalle = (isNaN(parseFloat(precio_final_detalle)))? 0 : parseFloat(precio_final_detalle);
            try{
                if(precio_final_detalle != 0){
                    var porcentaje = (precio_final_detalle - precio_base) / precio_base * 100;
                    var precio_final_sus = precio_final_detalle / tipo_cambio;
                    $('.detalle-'+id+' .input-porcentaje-detalle').each(function() {
                        new Cleave(this, {
                            numeral: true,
                            numeralThousandsGroupStyle: 'thousand'
                        }).setRawValue(porcentaje);
                    });
                    $('.detalle-'+id+' .input-precio-final-sus').each(function() {
                        new Cleave(this, {
                            numeral: true,
                            numeralThousandsGroupStyle: 'thousand'
                        }).setRawValue(precio_final_sus);
                    });
                }
            }catch(e){
                console.log('ERROR')
            }
        }

        function PrecioFinal(tipo_movimiento,precio_producto_id,tipo_cambio) {
            var porcentaje = $('.detalle-'+precio_producto_id+' .input-porcentaje-detalle').val();
            var precio_base = $('.detalle-'+precio_producto_id+' .input-precio-base').val();
            tipo_cambio = parseFloat(tipo_cambio);
            precio_base = (isNaN(parseFloat(precio_base)))? 0 : parseFloat(precio_base);
            porcentaje = (isNaN(parseFloat(porcentaje)))? 0 : parseFloat(porcentaje);
            try{   
                precio_base = parseFloat(precio_base.toFixed(2));
                var precio_final = precio_base + (porcentaje * precio_base / 100);
                var precio_final_sus = precio_final / tipo_cambio;
                var resultado = Number.parseFloat(precio_final).toFixed(2);
                var resultado_sus = Number.parseFloat(precio_final_sus).toFixed(2);

                $('.detalle-'+precio_producto_id+' .input-precio-final').each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    }).setRawValue(resultado);
                });

                $('.detalle-'+precio_producto_id+' .input-precio-final-sus').each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    }).setRawValue(resultado_sus);
                });
            }catch(e){
                console.log('ERROR')
            }
        }

        function alerta(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            /*if(!validar()){
                return false;
            }*/
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        /*function validar(){
            var tabla = document.getElementById("table-precios");
            var celdasId = tabla.getElementsByClassName("input-precio-producto-id");
            for (var i = 0; i < celdasId.length; i++) {
                var id = celdasId[i].value;
                var porcentaje_detalle = $('.detalle-'+id+' .input-porcentaje-detalle').val();
                console.log(porcentaje_detalle);
            }
            return true;
        }*/

        function confirmar(){
            var url = "{{ route('precio.productos.store') }}";
            $("#form-precios").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form-precios").submit();
        }

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var tipo_precio_id = $("#tipo_precio_id option:selected").val();
            if(tipo_precio_id === '1'){
                var url = "{{ route('precio.productos.search.tipo.base',':id') }}";
            }else{
                var url = "{{ route('precio.productos.search.tipo',':id') }}";
            }
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('precio.productos.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
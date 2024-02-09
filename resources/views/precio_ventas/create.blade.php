<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 11px;
    }
    .select2-results__option {
        font-size: 13px;
    }
    .obligatorio {
        border: 1px solid red !important;
    }
    .font-weight-bold {
        font-weight: bold;
    }
    .select2-container--obligatorio .select2-selection {
        border-color: red !important;
    }
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('layouts.partials.header')
        @include('precio_ventas.partials.form-create')
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane"></i>&nbsp;Procesar
                </button>
                <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                    &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
                </button>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            if($("#tipo_precio_id >option:selected").val() != ''){
                var id = $("#tipo_precio_id >option:selected").val();
                cargarPreciosbyTipo(id);
            }

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        $('#tipo_precio_id').change(function() {
            var id = $(this).val();
            cargarPreciosbyTipo(id);
        });

        function cargarPreciosbyTipo(tipo_precio_id){
            $(".btn").hide();
            $(".spinner-btn").show();
            var empresa_id = $("#empresa_id").val();
            var url = "{{ route('precio.ventas.create',[':empresa_id',':tipo_precio_id']) }}";
            url = url.replace(':empresa_id',empresa_id);
            url = url.replace(':tipo_precio_id',tipo_precio_id);
            window.location.href = url;
        }

        function alerta(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

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

        $('#p_descuento').on('input', function () {
            var descuento = $("#p_descuento").val();
            if(descuento != ''){
                if(parseFloat(descuento) <= 100){
                    var tabla = document.getElementById("table-precios");
                    var celdasDescuento = tabla.getElementsByClassName("input-descuento");
                    for (var i = 0; i < celdasDescuento.length; i++) {
                        document.getElementsByClassName("input-descuento")[i].value = descuento;
                    }

                    var celdasId = tabla.getElementsByClassName("input-producto-id");
                    for (var i = 0; i < celdasId.length; i++) {
                        var id = celdasId[i].value;
                        var producto_id = $('.detalle-'+id+' .input-producto-id').val();
                        PrecioTotal(producto_id);
                    }
                }else{
                    alerta("<center>El descuento no puede ser mayor a <b>[100]</b>...</center>");
                    document.getElementById("p_descuento").value = '';
                }
            }
        });

        function PrecioTotal(id) {
            var precio = $('.detalle-'+id+' .input-precio').val();
            var descuento = $('.detalle-'+id+' .input-descuento').val();
            try{
                precio = (isNaN(parseFloat(precio)))? 0 : parseFloat(precio);
                descuento = (isNaN(parseFloat(descuento)))? 0 : parseFloat(descuento);
                var precio_total = precio - (descuento * precio / 100);
                var resultado = Number.parseFloat(precio_total).toFixed(2);
                $('.detalle-'+id+' .input-precio-final').val(resultado);
            }catch(e){
                console.log('ERROR')
            }
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#tipo_precio_id >option:selected").val() == ""){
                alerta("<center>El campo <b>[TIPO]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#p_descuento").val() == ""){
                alerta("<center>El campo <b>[DESCUENTO]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#costo_final").val() == ""){
                alerta("<center>El campo <b>[PRECIO FINAL]</b> es un dato obligatorio...</center>");
                return false;
            }
            if(!validarTabla()){
                alerta("<center>Los porcentajes de <b>[% DESCUENTO]</b> no son correctos...</center>");
                return false;
            }
            return true;
        }

        function validarTabla(){
            var tabla = document.getElementById("table-precios");
            var celdasId = tabla.getElementsByClassName("input-producto-id");
            var cont = 0;
            for (var i = 0; i < celdasId.length; i++) {
                var id = celdasId[i].value;
                var descuento = $('.detalle-'+id+' .input-descuento').val();
                if(parseFloat(descuento) > 100){
                    cont = cont + 1;
                }
            }
            if(cont > 0){
                return false;
            }else{
                return true
            }
        }

        function confirmar(){
            var url = "{{ route('precio.ventas.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('precio.ventas.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
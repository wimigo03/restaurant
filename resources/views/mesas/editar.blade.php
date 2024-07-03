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
    @include('mesas.partials.form-editar')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            if($("#sucursal_id >option:selected").val() != ''){
                var id = $("#sucursal_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getZonas(id,CSRF_TOKEN);
            }
        });

        $('#sucursal_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getZonas(id,CSRF_TOKEN);
        });

        function getZonas(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/zonas/get_datos_by_sucursal',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.zonas){
                        var arr = Object.values($.parseJSON(data.zonas));
                        $("#zona_id").empty();
                        var select = $("#zona_id");
                        select.append($("<option></option>").attr("value", '').text('--Zona--'));
                        var zonaIdSeleccionado = $("#request_zona_id").val();
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == zonaIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
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

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#empresa_id >option:selected").val() == ""){
                alerta("[El campo <b>EMPRESA</b> es obligatorio]");
                return false;
            }
            if($("#sucursal_id >option:selected").val() == ""){
                alerta("[El campo <b>SUCURSAL</b> es obligatorio]");
                return false;
            }
            if($("#zona_id >option:selected").val() == ""){
                alerta("[El campo <b>ZONA</b> es obligatorio]");
                return false;
            }
            if($("#numero").val() == ""){
                alerta("[El campo <b>MESAS</b> es obligatorio]");
                return false;
            }
            if($("#sillas").val() == ""){
                alerta("[El campo <b>SILLAS</b> es obligatorio]");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('mesas.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('mesas.index') }}";
            window.location.href = url;
        }
    </script>
@stop

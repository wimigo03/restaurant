<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('mesas.index') }}"> Mesas</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
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
    @include('mesas.partials.form-create')
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

            if($("#empresa_id >option:selected").val() != ''){
                var id = $("#empresa_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getSucursales(id,CSRF_TOKEN);
            }

            $('#sucursal_id').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    alerta("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
            });

            if($("#sucursal_id >option:selected").val() != undefined){
                if($("#sucursal_id >option:selected").val() !== ""){
                    var id = $("#sucursal_id >option:selected").val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    getZonas(id,CSRF_TOKEN);
                }
            }

            $('#zona_id').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    alerta("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
                if($("#sucursal_id >option:selected").val() == ""){
                    alerta("Para continuar se debe seleccionar una <b>[SUCURSAL]</b>.");
                }
            });
            obligatorio();
        });

        $('#empresa_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getSucursales(id,CSRF_TOKEN);
        });

        function getSucursales(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/mesas/get_datos_by_empresa',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.sucursales){
                        var arr = Object.values($.parseJSON(data.sucursales));
                        $("#sucursal_id").empty();
                        var select = $("#sucursal_id");
                        select.append($("<option></option>").attr("value", '').text('--Sucursal--'));
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

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
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
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
            var url = "{{ route('mesas.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('mesas.index') }}";
            window.location.href = url;
        }
    </script>
@stop

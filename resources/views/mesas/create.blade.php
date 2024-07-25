<!DOCTYPE html>
@extends('layouts.dashboard')
    <link rel="stylesheet" href="{{ asset('css/styles/dashboard-mesas-pedidos.css') }}" rel="stylesheet">
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('mesas.index') }}"> Mesas</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
@include('mesas.partials.modal-datos')
@section('content')
    {{--<div class="card-custom">
        <div class="card-header bg-white">
            <b>CONFIGURACION DE MESAS</b>
        </div>
    </div>--}}
    @include('mesas.partials.form-create')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script src="{{ asset('js/dashboard-mesas.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#configuracion-mesas").hide();
            
            recuperar_mesas(cont, filas, columnas);

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

            if($("#sucursal_old_id").val() != undefined){
                if($("#sucursal_old_id").val() !== ""){
                    $("#configuracion-mesas").show();
                    var id = $("#sucursal_old_id").val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    getZonas(id,CSRF_TOKEN);
                }
            }

            /*$('#zona_id').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    alerta("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
                if($("#sucursal_id >option:selected").val() == ""){
                    alerta("Para continuar se debe seleccionar una <b>[SUCURSAL]</b>.");
                }
            });*/
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
                        var sucursalIdSeleccionado = $("#sucursal_old_id").val();
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == sucursalIdSeleccionado) {
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

        $('#sucursal_id').change(function() {
            var id = $(this).val();
            $("#configuracion-mesas").hide();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getZonas(id,CSRF_TOKEN);
        });

        function getZonas(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/mesas/get_datos_by_sucursal',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.zonas){
                        var arr = Object.values(data.zonas);
                        var container = $("#zonas-container");
                        container.empty();
                        $.each(arr, function(index, json) {
                            var zonaDiv = $("<div class='col-md-2'></div>");
                            var zonaLink = $("<a></a>")
                                .addClass("btn btn-block font-roboto-12")
                                .addClass(function() {
                                    if ($("#zona_id").val() == json.id) {
                                        return "btn-dark";
                                    } else {
                                        return "btn-outline-dark";
                                    }
                                })
                                .attr("href", "#")
                                .html("<i class='fas fa-table'></i><br>" + json.nombre)
                                .click(function() {
                                    $("#zona_id").val(json.id);
                                    update();
                                });

                            zonaDiv.append(zonaLink);
                            container.append(zonaDiv);
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

        function update() {
            var url = "{{ route('mesas.create') }}";
            $("#form").attr('action', url);
            $("#form").attr('method', 'GET');
            $("#form").submit();
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
            if($("#empresa_id >option:selected").val() == ""){
                alerta("[El campo <b>EMPRESA</b> es obligatorio]");
                return false;
            }
            if($("#sucursal_id >option:selected").val() == ""){
                alerta("[El campo <b>SUCURSAL</b> es obligatorio]");
                return false;
            }
            if($("#zona_id").val() == ""){
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

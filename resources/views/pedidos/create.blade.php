<!DOCTYPE html>
@extends('layouts.dashboard')
<link rel="stylesheet" href="{{ asset('css/styles/dashboard-mesas-pedidos.css') }}" rel="stylesheet">
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{-- route('pedidos.index') --}}"> Pedidos</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
@include('pedidos.partials.modal-pedido')
@section('content')
    @include('pedidos.partials.form-create')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script src="{{ asset('js/dashboard-pedidos.js') }}"></script>
    <script>


        $(document).ready(function() {
            $("#pedido-container").hide();
            $("#btn-pedido-procesar").hide();
            $("#btn-pedido-pendiente").hide();
            $("#btn-pedido-cancelar").hide();

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
        });

        function abrirModalPedido() {
            $('#modalpedido').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        }
        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        $('#empresa_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getSucursales(id,CSRF_TOKEN);
        });

        function getSucursales(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/pedidos/get_sucursales_by_empresa',
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
            $("#sucursal_old_id").val(id);
            $("#zona_old_id").val("#");
            $("#configuracion-mesas").hide();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getZonas(id,CSRF_TOKEN);
        });

        function getZonas(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/pedidos/get_zonas_by_sucursales',
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
                                .addClass("btn-outline-dark")
                                .attr("href", "#")
                                .html("<i class='fas fa-table'></i><br>" + json.nombre)
                                .click(function() {
                                    $("#zona_old_id").val(json.id);
                                    updateColorZona(json.id, arr, container);
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

        function updateColorZona(zona_id, arr, container){
            container.empty();
            dibujarCuadros(zona_id);
            $.each(arr, function(index, json) {
                var zonaDiv = $("<div class='col-md-2'></div>");
                var zonaLink = $("<a></a>")
                    .addClass("btn btn-block font-roboto-12")
                    .addClass(function() {
                        if (zona_id == json.id) {
                            return "btn-dark";
                        } else {
                            return "btn-outline-dark";
                        }
                    })
                    .attr("href", "#")
                    .html("<i class='fas fa-table'></i><br>" + json.nombre)
                    .click(function() {
                        $("#zona_old_id").val(json.id);
                        updateColorZona(json.id, arr, container);
                    });

                zonaDiv.append(zonaLink);
                container.append(zonaDiv);
            });
        }

        function dibujarCuadros(id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/pedidos/get_datos_by_zona',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data){
                        getMesasPorZona(data.filas,data.columnas)
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
            if($("#nro-pedido").val() == ""){
                alerta("<b>[ERROR].</b> Numero de pedido.");
                return false;
            }
            if($("#cantidad_clientes").val() == ""){
                alerta("<b>[ERROR].</b> Cantidad de clientes.");
                return false;
            }

            var cont = 0;

            $('.input-cantidad').each(function() {
                var valor = $(this).val();
                valor = (isNaN(parseFloat(valor))) ? 0 : parseFloat(valor);

                if (valor == 0) {
                    cont += 1;
                }
            });

            if(cont != 0){
                alerta("<b>[ERROR].</b> Existe una cantidad incorrecta.");
                return false;
            }

            return true;
        }

        function confirmar() {
            document.getElementById('nro-pedido').disabled = false;
            var url = "{{ route('pedidos.store') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#form").serialize(),
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            document.getElementById('nro-pedido').disabled = true;
            $('#modal_confirmacion').modal('hide');
            $('#modalpedido').modal('hide');
            dibujarCuadros($("#zona_old_id").val());
        }

        function pendiente() {
            document.getElementById('nro-pedido').disabled = false;
            var url = "{{ route('pedidos.pendiente') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#form").serialize(),
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            document.getElementById('nro-pedido').disabled = true;
            $('#modal_confirmacion').modal('hide');
            $('#modalpedido').modal('hide');
            dibujarCuadros($("#zona_old_id").val());
        }

        function cancelar() {
            document.getElementById('nro-pedido').disabled = false;
            var url = "{{ route('pedidos.anular') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#form").serialize(),
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            document.getElementById('nro-pedido').disabled = true;
            $('#modal_confirmacion').modal('hide');
            $('#modalpedido').modal('hide');
            $("#pedido-container").hide();
            $("#btn-pedido-procesar").hide();
            $("#btn-pedido-pendiente").hide();
            $("#btn-pedido-cancelar").hide();
            dibujarCuadros($("#zona_old_id").val());
        }
    </script>
@stop

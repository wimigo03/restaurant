<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('caja.venta.index') }}"> Cajas Venta</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
@section('content')
    @include('caja_venta.partials.form-create')
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

            var cleave = new Cleave('#monto', {
                numeral: true,
                numeralDecimalScale: 2,
                rawValueTrimPrefix: true
            });

            if($("#empresa_id >option:selected").val() != ''){
                var id = $("#empresa_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getSucursales(id,CSRF_TOKEN);
            }

            $('#sucursal_id').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
            });
        });

        function Modal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        $('#empresa_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getSucursales(id,CSRF_TOKEN);
        });

        function getSucursales(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/caja-venta/get_sucursales',
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

        function procesar() {
            if(!validar()){
                return false;
            }

            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#sucursal_id >option:selected").val() == ""){
                Modal("<center>[LA SUCURSAL ES REQUERIDA]</center>");
                return false;
            }
            if($("#user_id >option:selected").val() == ""){
                Modal("<center>[LA USUARIO ES REQUERIDO]</center>");
                return false;
            }
            if($("#monto:selected").val() == ""){
                Modal("<center>[EL MONTO ES REQUERIDO]</center>");
                return false;
            }

            return true;
        }

        function confirmar(){
            var url = "{{ route('caja.venta.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var id = $("#empresa_id").val();
            var url = "{{ route('caja.venta.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

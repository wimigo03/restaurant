<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @include('apertura_cierre.partials.form-create')
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

            $("#fecha_inicial").datepicker({
                inline: false,
                dateFormat: "dd/mm/yy",
                autoClose: true
            });

            var cleave = new Cleave('#monto', {
                numeral: true,
                numeralDecimalScale: 2,
                rawValueTrimPrefix: true
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

        function procesar() {
            if(!validar()){
                return false;
            }

            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#user_id >option:selected").val() == ""){
                Modal("<center>[LA USUARIO ES REQUERIDO]</center>");
                return false;
            }
            if($("#fecha_inicial").val() == ""){
                Modal("<center>[LA FECHA INICIAL ES REQUERIDA.]</center>");
                return false;
            }
            if($("#monto:selected").val() == ""){
                Modal("<center>[EL MONTO ES REQUERIDO]</center>");
                return false;
            }

            return true;
        }

        function confirmar(){
            var url = "{{ route('apertura.cierre.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var id = $("#empresa_id").val();
            var url = "{{ route('apertura.cierre.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

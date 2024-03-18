<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @include('configuracion.partials.FormInicioMesFiscal')
    @if (count($anteriores) > 0)
        @include('configuracion.partials.TableInicioMesFiscal')    
    @endif
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

            $('#dia').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar dia--",
                width: '100%'
            });

            $('#mes').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar mes--",
                width: '100%'
            });

            $("#fecha").datepicker({
                inline: false, 
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            var fechaInput = document.getElementById('fecha');
            if(fechaInput != null){
                var cleave = new Cleave(fechaInput, {
                    date: true,
                    datePattern: ['d', 'm', 'Y']
                });
            }
        });

        function alert(mensaje){
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
            if($("#fecha").val() == ""){
                alert("[CAMPO OBLIGATORIO]");
                return false;
            }

            return true;
        }

        function confirmar(){
            var url = "{{ route('configuracion.inicio.mes.fiscal.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();            
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('configuracion.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
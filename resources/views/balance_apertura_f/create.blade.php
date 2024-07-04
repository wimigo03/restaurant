<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('balance.apertura.f.index') }}"> Balances de apertura</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
@section('content')
    @include('balance_apertura_f.partials.form-create')
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
        });

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
            if($("#anho").val() == ""){
                alerta("[LA GESTION ES UN DATO REQUERIDO0]");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('balance.apertura.f.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('balance.apertura.f.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

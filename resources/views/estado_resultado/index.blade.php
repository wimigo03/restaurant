<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @include('estado_resultado.partials.search')
    @if (isset($ingresos))
        @include('estado_resultado.partials.table')
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

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_i', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            var cleave = new Cleave('#fecha_f', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_i").datepicker({
                inline: false, 
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $("#fecha_f").datepicker({
                inline: false, 
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('estado.resultado.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('estado.resultado.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
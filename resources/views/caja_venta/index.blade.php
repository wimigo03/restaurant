<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span>Caja Venta</span>
@endsection
@section('content')
    @include('caja_venta.partials.search')
    @include('caja_venta.partials.table')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
                width: '100%'
            });

            $('#sucursal_id').select2({
                theme: "bootstrap4",
                placeholder: "--Sucursales--",
                width: '100%'
            });

            $('#user_id').select2({
                theme: "bootstrap4",
                placeholder: "--Asignado a--",
                width: '100%'
            });

            $('#user_asignado_id').select2({
                theme: "bootstrap4",
                placeholder: "--Asignado por--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
                inline: false,
                dateFormat: "dd/mm/yy",
                autoClose: true,
            });

            var cleave = new Cleave('#monto', {
                numeral: true,
                numeralDecimalScale: 2,
                rawValueTrimPrefix: true
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('caja.venta.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('caja.venta.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('caja.venta.index') }}";
            window.location.href = url;
        }
    </script>
@stop


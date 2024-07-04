<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('sucursal.index') }}"> Sucursales</a><span>&nbsp;/&nbsp;
    <span>Zonas</span>
@endsection
@section('content')
    @include('zonas.partials.search')
    @include('zonas.partials.table')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var id = $("#sucursal_id").val()
            var url = "{{ route('zonas.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function search(){
            var id = $("#sucursal_id").val();
            var url = "{{ route('zonas.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            var id = $("#sucursal_id").val();
            var url = "{{ route('zonas.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function retroceder(){
            var url = "{{ route('sucursal.index') }}";
            window.location.href = url;
        }
    </script>
@stop

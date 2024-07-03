<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @include('unidades.partials.menu')
    @include('unidades.partials.search')
    @include('unidades.partials.table')
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
            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
                width: '100%'
            });
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });
        });

        $("#toggleSubMenu").click(function(){
            $("#subMenuUnidades").slideToggle(250);
        });

        function create(){
            var url = "{{ route('unidades.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('unidades.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('unidades.index') }}";
            window.location.href = url;
        }
    </script>
@stop

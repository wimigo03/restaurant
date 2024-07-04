<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span>Productos</span>
@endsection
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 13px;
    }
    .select2-results__option {
        font-size: 13px;
    }
</style>
@section('content')
    @include('productos.partials.menu')
    @include('productos.partials.search')
    @include('productos.partials.table')
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
            $('#categoria_master_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria Master--",
                width: '100%'
            });
            $('#categoria_id').select2({
                theme: "bootstrap4",
                placeholder: "--Categoria--",
                width: '100%'
            });
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });
        });

        $("#toggleSubMenu").click(function(){
            $("#subMenuProductos").slideToggle(250);
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var url = "{{ route('productos.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('productos.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('productos.index') }}";
            window.location.href = url;
        }
    </script>
@stop

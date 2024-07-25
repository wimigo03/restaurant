<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item active">Listar Balances de apertura</li>
@endsection
@section('content')
    <div class="card-custom">
        <div class="card-header bg-gradient-secondary text-white">
            <b>BALANCE DE APERTURA</b>
        </div>
    </div>
    @include('balance_apertura.partials.search')
    @include('balance_apertura.partials.table')
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
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){

        }

        function cambiarf(){
            var url = "{{ route('balance.apertura.f.index') }}";
            window.location.href = url;
        }

        function limpiar(){
            var url = "{{ route('balance.apertura.index') }}";
            window.location.href = url;
        }

        function create(){
            var url = "{{ route('balance.apertura.create') }}";
            window.location.href = url;
        }
    </script>
@stop

<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span>Personal</span>
@endsection
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-results__option {
        font-size: 12px;
    }
</style>
@section('content')
    @include('personal.partials.search')
    @include('personal.partials.table')
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

            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
                width: '100%'
            });

            $('#cargo_id').select2({
                theme: "bootstrap4",
                placeholder: "--Cargo--",
                width: '100%'
            });

            $('#file_contrato').select2({
                theme: "bootstrap4",
                placeholder: "--Contratos--",
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

        function create(){
            var url = "{{ route('personal.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('personal.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('personal.index') }}";
            window.location.href = url;
        }

        function redireccionar(id) {
            var input = document.getElementById(id);
            if(input.value == "Editar"){
                var url = '{{ route("personal.editar", ":personal") }}';
                url = url.replace(':personal', id);
                input.value = "Seleccionar";
                window.location.href = url;
            }else if(input.value == "Ver"){
                var url = '{{ route("personal.show", ":personal") }}';
                url = url.replace(':personal', id);
                input.value = "Seleccionar";
                window.location.href = url;
            }else if(input.value == "Retirar Fiscal"){
                input.value = "Seleccionar";
                var tipo = "F";
                var url = '{{ route("personal.retirar", [":personal",":tipo"]) }}';
                url = url.replace(':personal', id);
                url = url.replace(':tipo', tipo);
                window.location.href = url;
            }else if(input.value == "Retirar Interno"){
                input.value = "Seleccionar";
                var tipo = "I";
                var url = '{{ route("personal.retirar", [":personal",":tipo"]) }}';
                url = url.replace(':personal', id);
                url = url.replace(':tipo', tipo);
                window.location.href = url;
            }else if(input.value == "Retirar Servicio"){
                input.value = "Seleccionar";
                var tipo = "S";
                var url = '{{ route("personal.retirar", [":personal",":tipo"]) }}';
                url = url.replace(':personal', id);
                url = url.replace(':tipo', tipo);
                window.location.href = url;
            }else if(input.value == "File Contrato"){
                var url = '{{ route("personal.file.contrato", ":personal") }}';
                url = url.replace(':personal', id);
                input.value = "Seleccionar";
                window.location.href = url;
            }
        }
    </script>
@stop

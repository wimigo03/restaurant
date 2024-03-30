<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 11px;
    }
    .select2-results__option {
        font-size: 13px;
    }
</style>
@section('content')
    @include('permissions.partials.search')
    <div class="form-group row">
        <div class="col-md-6 px-0 pr-1">
            @can('permissions.create')
                <button class="btn btn-outline-success font-roboto-12" type="button" onclick="create();">
                    &nbsp;<i class="fas fa-plus"></i>&nbsp;
                </button>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 pr-1 pl-1 text-right">
            <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="search();">
                &nbsp;<i class="fas fa-search"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="limpiar();">
                &nbsp;<i class="fas fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
    @include('permissions.partials.table')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#modulo_id').select2({
                theme: "bootstrap4",
                placeholder: "--Modulo--",
                width: '100%'
            });

            $('#titulo').select2({
                theme: "bootstrap4",
                placeholder: "--Titulo--",
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
            var id = $("#empresa_id").val();
            var url = "{{ route('permissions.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            var id = $("#empresa_id").val();
            var url = "{{ route('permissions.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function create(){
            var id = $("#empresa_id").val()
            var url = "{{ route('permissions.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

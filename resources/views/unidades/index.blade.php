<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card-header header">
                    <b>{{ $empresa->nombre_comercial }} - UNIDADES</b>
                </div>
            </div>
        </div>
        @if (isset($unidades))
            @include('unidades.partials.search')
            <div class="form-group row">
                <div class="col-md-6 pr-1">
                    @can('unidades.create')
                        <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                            &nbsp;<i class="fas fa-plus"></i>&nbsp;
                            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                        </button>
                    @endcan
                </div>
                <div class="col-md-6 pl-1 text-right">
                    <button class="btn btn-outline-primary font-verdana" type="button" onclick="search();">
                        &nbsp;<i class="fas fa-search"></i>&nbsp;Buscar
                    </button>
                    <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                        &nbsp;<i class="fas fa-eraser"></i>&nbsp;Limpiar
                    </button>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
            @include('unidades.partials.table')
        @endif
    </div>
</div>
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
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Tipo--",
                width: '100%'
            });
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val()
            var url = "{{ route('unidades.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('unidades.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('unidades.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
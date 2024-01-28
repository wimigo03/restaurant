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
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header font-verdana-bg bg-gradient-secondary text-white">
                <b>PERMISOS</b>
            </div>
            <div class="card-body">
                <form action="#" method="get" id="form">
                    @include('permissions.partials.search')
                </form>
                <div class="form-group row">
                    <div class="col-md-6">
                        @can('permissions.create')
                            <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                                &nbsp;<i class="fas fa-plus"></i>&nbsp;
                            </button>
                        @endcan
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-outline-primary font-verdana" type="button" onclick="search();">
                            &nbsp;<i class="fas fa-search"></i>&nbsp;Buscar
                        </button>
                        <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                            &nbsp;<i class="fas fa-eraser"></i>&nbsp;Limpiar
                        </button>
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
                @include('permissions.partials.table')
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#titulo').select2({
                theme: "bootstrap4",
                placeholder: "--Titulo--",
                width: '100%'
            });
        });

        function search(){
            var url = "{{ route('permissions.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('permissions.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('permissions.create') }}";
        }
    </script>
@stop
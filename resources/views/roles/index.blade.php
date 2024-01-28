<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 13px;
    }
    .select2-results__option {
        font-size: 13px;
    }
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-header font-verdana-bg bg-gradient-secondary text-white">
                <b>ROLES</b>
            </div>
            <div class="card-body">
                <form action="#" method="get" id="form">
                    @include('roles.partials.search')
                </form>
                <div class="form-group row">
                    <div class="col-md-6 pr-1">
                        @can('roles.create')
                            <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                                &nbsp;<i class="fas fa-plus"></i>&nbsp;
                            </button>
                        @endcan
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
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
                @include('roles.partials.table')
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
            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
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
            var url = "{{ route('roles.search') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.index') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.create') }}";
        }
    </script>
@stop
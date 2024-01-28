<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    #empresa_id + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
    #estado + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
    .select2 + .select2-container .select2-selection__rendered {
        font-size: 11px;
    }
    .select2-results__option {
        font-size: 13px;
    }
    .obligatorio {
        border: 1px solid red !important;
    }
    .font-weight-bold {
        font-weight: bold;
    }
    .select2-container--obligatorio .select2-selection {
        border-color: red;
    }
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card-header header">
                    <b>{{ $empresa->nombre_comercial }} - SUCURSALES</b>
                </div>
            </div>
        </div>
        @if (isset($sucursales))
            @include('sucursal.partials.search')
            <div class="form-group row">
                <div class="col-md-6 pr-1">
                    @can('sucursal.create')
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
            @include('sucursal.partials.table')
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
        });

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val()
            var url = "{{ route('sucursal.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('sucursal.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('sucursal.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
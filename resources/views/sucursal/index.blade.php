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
                    <div class="row">
                        <div class="col-md-8">
                            <b><i class="fa-solid fa-house-damage fa-fw"></i> {{ $empresa->nombre_comercial }} - SUCURSALES</b>
                        </div>
                        <div class="col-md-4 text-right">
                            @if (count($empresas_info) > 0)
                                @foreach ($empresas_info as $empresa)
                                    <img src="{{ url($empresa->url_logo) }}" alt="{{ $empresa->url_logo }}" class="imagen-menu">
                                @endforeach
                            @else
                                <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-menu">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($sucursales))
            @include('sucursal.partials.search')
            <div class="form-group row">
                <div class="col-md-6 pr-1">
                    @can('sucursal.create')
                        <span class="tts:right tts-slideIn tts-custom" aria-label="Crear" style="cursor: pointer;">
                            <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                                &nbsp;<i class="fas fa-plus"></i>&nbsp;
                            </button>
                        </span>
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
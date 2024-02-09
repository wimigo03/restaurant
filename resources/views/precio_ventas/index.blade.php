<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        @include('layouts.partials.header')
        @include('precio_ventas.partials.search')
        <div class="form-group row">
            <div class="col-md-6 pr-1">
                @can('precio.ventas.create')
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Crear" style="cursor: pointer;">
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
        @include('precio_ventas.partials.table')
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

            $('#sucursal_id').select2({
                theme: "bootstrap4",
                placeholder: "--Sucursal--",
                width: '100%'
            });

            $('#zona_id').select2({
                theme: "bootstrap4",
                placeholder: "--Zona--",
                width: '100%'
            });

            if($("#sucursal_id >option:selected").val() != ''){
                var id = $("#sucursal_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getZonas(id,CSRF_TOKEN);
            }
        });

        $('#sucursal_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getZonas(id,CSRF_TOKEN);
        });

        function getZonas(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/zonas/get_datos_by_sucursal',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.zonas){
                        var arr = Object.values($.parseJSON(data.zonas));
                        $("#zona_id").empty();
                        var select = $("#zona_id");
                        select.append($("<option></option>").attr("value", '').text('--Zona--'));
                        var zonaIdSeleccionado = localStorage.getItem('zonaIdSeleccionado');
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == zonaIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                        select.on('change', function() {
                            localStorage.setItem('zonaIdSeleccionado', $(this).val());
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var empresa_id = $("#empresa_id").val();
            var tipo_precio_id = '[]';
            var url = "{{ route('precio.ventas.create',[':empresa_id','tipo_precio_id']) }}";
            url = url.replace(':empresa_id',empresa_id);
            url = url.replace(':tipo_precio_id',tipo_precio_id);
            window.location.href = url;
        }

        function search(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('precio.ventas.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('mesas.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
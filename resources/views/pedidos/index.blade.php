<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item active">Mesas</li>
@endsection
@section('content')
    {{--<div class="card-custom">
        <div class="card-header bg-gradient-secondary text-white">
            MESAS
        </div>
    </div>--}}
    {{--<div class="card card-body">--}}
        <div class="form-group row">
            <div class="col-md-12 text-center">
                <b class="font-roboto-20">MESAS</b>
            </div>
        </div>
        @include('mesas.partials.search')
        @include('mesas.partials.table')
    {{--</div>--}}
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
            var url = "{{ route('mesas.create') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('mesas.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('mesas.index') }}";
            window.location.href = url;
        }

        function Modal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }
    </script>
@stop

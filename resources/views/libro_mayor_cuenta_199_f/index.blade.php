<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span>Libro Mayor por Cuenta 1 a 99</span>
@endsection
@section('content')
    @include('libro_mayor_cuenta_199_f.partials.search')
    @include('libro_mayor_cuenta_199_f.partials.table')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });

            var cleave = new Cleave('#fecha_i', {
                date: true,
                datePattern: ['d', 'm', 'Y'],
                delimiter: '-'
            });

            var cleave = new Cleave('#fecha_f', {
                date: true,
                datePattern: ['d', 'm', 'Y'],
                delimiter: '-'
            });

            $("#fecha_i").datepicker({
                inline: false,
                dateFormat: "dd-mm-yy",
                autoClose: true,
            });

            $("#fecha_f").datepicker({
                inline: false,
                dateFormat: "dd-mm-yy",
                autoClose: true,
            });

            $('#plan_cuenta_id1').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
            });

            $('#plan_cuenta_id2').on('select2:open', function(e) {
                if($("#empresa_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <b>[EMPRESA]</b>.");
                }
            });

            if($("#empresa_id >option:selected").val() != ''){
                var id = $("#empresa_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getPlanCuentas1(id,CSRF_TOKEN);
                getPlanCuentas2(id,CSRF_TOKEN);
            }
        });

        $('#empresa_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getPlanCuentas1(id,CSRF_TOKEN);
            getPlanCuentas2(id,CSRF_TOKEN);
        });

        function getPlanCuentas1(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/libro-mayor-cuenta-1-99/get_plancuentas',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.plan_cuentas){
                        var arr = Object.values($.parseJSON(data.plan_cuentas));
                        $("#plan_cuenta_id1").empty();
                        var select = $("#plan_cuenta_id1");
                        select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.cuenta_contable);
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function getPlanCuentas2(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/libro-mayor-cuenta-1-99/get_plancuentas',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.plan_cuentas){
                        var arr = Object.values($.parseJSON(data.plan_cuentas));
                        $("#plan_cuenta_id2").empty();
                        var select = $("#plan_cuenta_id2");
                        select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.cuenta_contable);
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function Modal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            search();
        }

        function validar(){
            if($("#empresa_id >option:selected").val() == ""){
                Modal("[EMPRESA ES REQUERIDA]");
                return false;
            }
            if($("#fecha_i").val() == ""){
                Modal("[FECHA INICIAL REQUERIDA]");
                return false;
            }
            if($("#fecha_f").val() == ""){
                Modal("[FECHA FINAL REQUERIDA]");
                return false;
            }
            if($("#plan_cuenta_id >option:selected").val() == ""){
                Modal("[PLAN DE CUENTA NO SELECCIONADO.]");
                return false;
            }
            return true;
        }

        function search(){
            var url = "{{ route('libro.mayor.cuenta.1.99.f.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('libro.mayor.cuenta.1.99.f.index') }}";
            window.location.href = url;
        }

        function excel() {
            var url = "{{ route('libro.mayor.cuenta.1.99.f.excel') }}";
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var form = $("#form");
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'libro_mayor_cuenta_199.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
        }

        function pdf() {
            var url = "{{ route('libro.mayor.cuenta.1.99.f.pdf') }}";
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var form = $("#form");
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'libro_mayor_cuenta_199.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
        }

        function cambiari(){
            var url = "{{ route('libro.mayor.cuenta.1.99.index') }}";
            window.location.href = url;
        }
    </script>
@stop

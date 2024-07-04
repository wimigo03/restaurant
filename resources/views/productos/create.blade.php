<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('productos.index') }}"> Productos</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
<style>
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
        border-color: red !important;
    }
</style>
@section('content')
    {{--@include('productos.partials.menu')--}}
    @include('productos.partials.form-create')
    @include('productos.partials.modal-create-unidad')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            if($("#categoria_master_id >option:selected").val() != ''){
                var id = $("#categoria_master_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getCategorias(id,CSRF_TOKEN);
            }

            if($("#categoria_id >option:selected").val() != ''){
                var id = $("#categoria_id >option:selected").val();
                getCodigo(id);
            }

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $("#subMenuProductos").hide();
        });

        $("#toggleSubMenu").click(function(){
            $("#subMenuProductos").slideToggle(250);
        });

        function alertaModal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('#categoria_master_id').change(function() {
            localStorage.clear();
            var id = $(this).val();
            getCodigoMaster(id);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getCategorias(id,CSRF_TOKEN);
        });

        function getCodigoMaster(id){
            $.ajax({
                type: 'GET',
                url: '/productos/get_codigo_master/'+id,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(json){
                    $('#codigo').val(json.codigo);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function getCategorias(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/categorias/get_datos_subcategorias',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.subcategorias != '[]'){
                        var arr = Object.values($.parseJSON(data.subcategorias));
                        $("#categoria_id").empty();
                        var select = $("#categoria_id");
                        select.append($("<option></option>").attr("value", '').text('--Categoria--'));
                        var categoriaIdSeleccionado = localStorage.getItem('categoriaIdSeleccionado');
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.nombre);
                            if (json.id == categoriaIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                        select.on('change', function() {
                            localStorage.setItem('categoriaIdSeleccionado', $(this).val());
                        });
                    }else{
                        var categoria_master_id = $("#categoria_master_id >option:selected").val();
                        getCodigoSinCategoria(categoria_master_id);
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        $('#categoria_id').change(function() {
            var id = $(this).val();
            getCodigo(id);
        });

        function getCodigo(id){
            $.ajax({
                type: 'GET',
                url: '/productos/get_codigo/'+id,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(json){
                    $('#codigo').val(json.codigo);
                    $('#categoria_master').val(json.categoria_master);
                    $('#categoria_master_id').val(json.categoria_master_id);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function getCodigoSinCategoria(id){
            $.ajax({
                type: 'GET',
                url: '/productos/get_codigo_sin/'+id,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(json){
                    $('#codigo').val(json.codigo);
                    //$('#categoria_master').val(json.categoria_master);
                    //$('#categoria_master_id').val(json.categoria_master_id);
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

        function valideNumberConDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 46 || code === 8) {
                if (code === 46 && evt.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        function procesar() {
            if(!validarDatos()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validarDatos(){
            if($("#empresa_id >option:selected").val() == ""){
                alertaModal("<center>La <b>[EMPRESA]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#categoria_master_id").val() == ""){
                alertaModal("<center>La <b>[CATEGORIA MASTER]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#nombre").val() == ""){
                alertaModal("<center>El <b>[NOMBRE]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#nombre_factura").val() == ""){
                alertaModal("<center>El <b>[NOMBRE DE LA FACTURA]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#codigo").val() == ""){
                alertaModal("<center>El <b>[CODIGO]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#detalle").val() == ""){
                alertaModal("<center>El <b>[DETALLE]</b> es un dato obligatorio...</center>");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('productos.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('productos.index') }}";
            window.location.href = url;
        }

        function storeUnidadMedida(){
            var url = "{{ route('unidades.store') }}";
            $("#form-unidad-medida").attr('action', url);
            $("#form-unidad-medida").submit();
        }
    </script>
@stop

<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .jstree li > a > .jstree-icon {  
        display:none !important; 
    }

    #treeview {
        min-height: 200px;            
    }
    #contenido {
        min-height: 200px;
    }
    #treeview li a {
        font-size: 12px;
        font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    #empresa_id + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <b><u>{{ $empresa->nombre_comercial }}</u></b>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card-header header">
                    <div class="row">
                        <div class="col-md-6 pr-1 text-bottom">
                            <b><i class="fa-regular fa-chart-bar fa-fw"></i> PLAN DE CUENTAS</b>
                        </div>
                        <div class="col-md-2 pr-1 pl-1 text-right">
                            @if (count($empresas_info) > 0)
                                @foreach ($empresas_info as $empresa)
                                    <img src="{{ url($empresa->url_logo) }}" alt="{{ $empresa->url_logo }}" class="imagen-menu">
                                @endforeach
                            @else
                                <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-menu">
                            @endif
                        </div>
                        <div class="col-md-4 pl-1 empresa-id-select-container">
                            <form action="#" method="get" id="form_estructura">
                                <select name="empresa_id" id="empresa_id" class="form-control form-control-sm">
                                    <option value="">-</option>
                                    @foreach ($empresas as $index => $value)
                                        <option value="{{ $index }}" @if(isset($empresa_id) ? $empresa_id : request('empresa_id') == $index) selected @endif >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($plan_de_cuentas))
            <div class="row">
                <div class="col-md-12">
                    @include('plan_cuentas.partials.treeview')
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $("#btn_deshabilitar").hide();
            $("#btn_habilitar").hide();
            $("#btn_sub_master").hide();
            $("#btn_modificar").hide();

            var plancuenta_id = $('#plancuenta_id').val();
            if ($('#plancuenta_id option[value="' + plancuenta_id + '"]').length !== 0) {
                if($('#plancuenta_id').val() !== '#'){
                    datosPlanCuenta(document.getElementById('plancuenta_id').value);
                }
            }
            
            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
                width: '100%'
            });
        });

        $('#empresa_id').change(function() {
            var id = $(this).val();
            cargosByEmpresa(id);
        });

        function cargosByEmpresa(id){
            $(".btn").hide();
            $(".empresa-id-select-container").hide();
            $(".spinner-btn").show();
            var status = '[]';
            var url = "{{ route('plan_cuentas.index',[':id',':status']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status',status);
            window.location.href = url;
        }

        $(function () {
            var nodo_id = {{ request('nodeId', 0) }};

            $('#treeview').jstree({
                'core': {
                    'data': {!! json_encode($tree) !!},
                    'themes' : {
                        'variant' : 'large',
                        'animation' : 0
                    }
                }
            });

            $('#treeview').on('activate_node.jstree', function (e, data) {
                if (data.node && data.node.children.length > 0) {
                    $('#treeview').jstree('toggle_node', data.node);
                }
                datosPlanCuenta(data.node.id);
            });

            $('#treeview').on('ready.jstree', function () {
                $('#treeview').jstree('select_node', nodo_id);
                if(nodo_id != ''){
                    datosPlanCuenta(nodo_id);
                }
            });
        });
        
        function datosPlanCuenta(id){
            $.ajax({
                type: 'GET',
                url: '/plan-cuentas/get_datos_plan_cuenta/'+id,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(json){
                    $('#plancuenta_id').val(json.id);
                    $('#nombre').text(json.nombre);
                    $('#codigo').text(json.codigo);
                    $('#nivel').text(json.nivel);
                    if(json.estado === '1'){
                        $("#btn_deshabilitar").show();
                        $("#btn_habilitar").hide();
                        $("#btn_master").show();
                        $("#btn_sub_master").show();
                        $("#btn_modificar").show();
                    }else{
                        $("#btn_deshabilitar").hide();
                        $("#btn_habilitar").show();
                        $("#btn_sub_master").hide();
                        $("#btn_modificar").hide();
                    }
                    if(json.detalle === '1'){
                        $('#detalle').text('NO ES CUENTA DETALLE');
                    }else{
                        $('#detalle').text('SI ES CUENTA DETALLE');
                    }
                    if(json.cheque === '1'){
                        $('#cheque').text('NO TIENE CHEQUE');
                    }else{
                        $('#cheque').text('SI TIENE CHEQUE');
                    }
                    if(json.auxiliar === '1'){
                        $('#auxiliar').text('NO TIENE AUXILIAR');
                    }else{
                        $('#auxiliar').text('SI TIENE AUXILIAR');
                    }
                    if(json.estado === '1'){
                        $('#estado').text('HABILITADO');
                    }else{
                        $('#estado').text('NO HABILITADO');
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function create(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id >option:selected").val()
            var url = "{{ route('plan_cuentas.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function createSub(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#plancuenta_id").val();
            var url = "{{ route('plan_cuentas.create_sub',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function editar(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#plancuenta_id").val();
            var url = "{{ route('plan_cuentas.editar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function habilitar(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#plancuenta_id").val();
            var url = "{{ route('plan_cuentas.habilitar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function deshabilitar(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#plancuenta_id").val();
            var url = "{{ route('plan_cuentas.deshabilitar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function solo_habilitados(){
            $(".btn").hide();
            $(".empresa-id-select-container").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id >option:selected").val()
            var status = '1';
            var url = "{{ route('plan_cuentas.index',[':id',':status']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status',status);
            window.location.href = url;
        }

        function todos(){
            $(".btn").hide();
            $(".empresa-id-select-container").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id >option:selected").val()
            var status = '[]';
            var url = "{{ route('plan_cuentas.index',[':id',':status']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status',status);
            window.location.href = url;
        }
    </script>
@stop
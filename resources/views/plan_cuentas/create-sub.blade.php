<!DOCTYPE html>
@extends('layouts.dashboard')
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
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card-header header">
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar" style="cursor: pointer;">
                        <span class="btns btn btn-sm btn-info font-verdana" onclick="limpiar();">
                            <i class="fa-solid fa-folder-tree fa-fw"></i>
                        </span>
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </span>
                    <b class="btns"><u>{{ $empresa->nombre_comercial }} - CREAR PLAN DE CUENTA DEPENDIENTE</u></b>
                </div>
            </div>
        </div>
        @include('plan_cuentas.partials.form-create-sub')
        <div class="form-group row">
            <div class="col-md-12 text-right">
                <button class="btns btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane"></i>&nbsp;Procesar
                </button>
                <button class="btns btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                    &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
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
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            obligatorio();
        });

        function obligatorio(){
            if($("#nombre").val() !== ""){
                $("#nombre").removeClass('obligatorio');
            }else{
                $("#nombre").addClass('obligatorio');
            }
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });
        
        function procesar() {
            var url = "{{ route('plan_cuentas.store_sub') }}";
            $("#form").attr('action', url);
            $(".btns").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var status = '[]';
            var url = "{{ route('plan_cuentas.index',[':id',':status']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status',status);
            window.location.href = url;
        }

        function limpiar(){
            $(".btns").hide();
            $(".spinner-btn").show();
            var id = $("#plancuenta_id").val();
            var url = "{{ route('plan_cuentas.create_sub',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
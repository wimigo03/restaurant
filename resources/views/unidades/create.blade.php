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
    .font-weight-bold {
        font-weight: bold;
    }
    .select2-container--obligatorio .select2-selection {
        border-color: red !important;
    }
</style>
@section('content')
    @include('unidades.partials.menu')
    {{--<input type="hidden" value="{{ $empresa->id }}" id="empresa_input_id">--}}
    <form action="#" method="post" id="form">
        @csrf
        @include('unidades.partials.form-create')
    </form>
    <div class="form-group row">
        <div class="col-md-12 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                <i class="fas fa-paper-plane"></i>&nbsp;Procesar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
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
            $("#subMenuUnidades").hide();
        });

        $("#toggleSubMenu").click(function(){
            $("#subMenuUnidades").slideToggle(250);
        });

        function alertaModal(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
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
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#empresa_id >option:selected").val() == ""){
                alertaModal("<center>La <b>[EMPRESA]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#nombre").val() == ""){
                alertaModal("<center>El <b>[NOMBRE]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#codigo").val() == ""){
                alertaModal("<center>El <b>[CODIGO]</b> es un dato obligatorio...</center>");
                return false;
            }
            if($("#tipo").val() == ""){
                alertaModal("<center>El <b>[TIPO]</b> es un dato obligatorio...</center>");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('unidades.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('unidades.index') }}";
            window.location.href = url;
        }
    </script>
@stop

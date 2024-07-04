<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('cargos.index', $empresa->id) }}">Cargos</a><span>&nbsp;/&nbsp;
    <span>Registrar</span>
@endsection
@section('content')
    @include('cargos.partials.form-create')
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

            if($("#tipo >option:selected").val() == "1"){
                $("#cuenta_contable").show();
            }else{
                $("#cuenta_contable").hide();
            }
        });

        $('#tipo').on('change', function() {
            if($("#tipo >option:selected").val() == "1"){
                $("#cuenta_contable").show();
            }else{
                $("#cuenta_contable").hide();
            }
        });

        function procesar() {
            var url = "{{ route('cargos.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('cargos.index',[':id']) }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-header font-verdana-bg bg-gradient-warning text-white">
                <b>USUARIOS Y ROLES</b>
            </div>
            <div class="card-body">
                @include('users.partials.form-asignar')
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                            <i class="fas fa-paper-plane"></i>&nbsp;Asignar Roles
                        </button>
                        <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                            &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
                        </button>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
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
        });

        function procesar() {
            var url = "{{ route('users.asignacion') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('users.index') }}";
        }
    </script>
@stop
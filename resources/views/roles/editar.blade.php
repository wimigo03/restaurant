<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header bg-gradient-warning text-white font-verdana-bg">
                <b>ROLES Y PERMISOS</b>
            </div>
            <div class="card-body">
                @include('roles.partials.form-editar')
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

        function marcarTodo(id) {
            input = document.getElementById(id);
            checks = document.getElementsByClassName(id);
            if (input.value == 0) {
                for (let index = 0; index < checks.length; index++) {
                    checks[index].checked = true;
                }
                input.value = 1;
            }else{
                for (let index = 0; index < checks.length; index++) {
                    checks[index].checked = false;
                }
                input.value = 0;
            }
        }

        function procesar() {
            var url = "{{ route('roles.update') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.index') }}";
        }
    </script>
@stop
<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @include('apertura_cierre.partials.search')
    <div class="form-group row">
        <div class="col-md-6 px-0 pr-1">
            @can('apertura.cierre.create')
                <span class="tts:right tts-slideIn tts-custom" aria-label="Crear Asiento" style="cursor: pointer;">
                    <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                        <i class="fas fa-plus fa-fw"></i>
                    </button>
                </span>
            @endcan
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
        <div class="col-md-6 px-0 pl-1 text-right">
            <button class="btn btn-outline-primary font-verdana" type="button" onclick="search();">
                &nbsp;<i class="fas fa-search"></i>&nbsp;Buscar
            </button>
            <button class="btn btn-outline-danger font-verdana" type="button" onclick="limpiar();">
                &nbsp;<i class="fas fa-eraser"></i>&nbsp;Limpiar
            </button>
            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
        </div>
    </div>
    @include('apertura_cierre.partials.table')
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                theme: "bootstrap4",
                placeholder: "--Usuario--",
                width: '100%'
            });

            $('#cargo_id').select2({
                theme: "bootstrap4",
                placeholder: "--Cargo--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_inicio', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            var cleave = new Cleave('#fecha_cierre', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_inicio").datepicker({
                inline: false,
                dateFormat: "dd/mm/yy",
                autoClose: true,
            });

            $("#fecha_cierre").datepicker({
                inline: false,
                dateFormat: "dd/mm/yy",
                autoClose: true,
            });

            var cleave = new Cleave('#monto', {
                numeral: true,
                numeralDecimalScale: 2,
                rawValueTrimPrefix: true
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function create(){
            var id = $("#empresa_id").val()
            var url = "{{ route('apertura.cierre.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function search(){
            var id = $("#empresa_id").val();
            var url = "{{ route('apertura.cierre.search',':id') }}";
            $("#form").attr('action', url);
            url = url.replace(':id',id);
            window.location.href = url;
            $("#form").submit();
        }

        function limpiar(){
            var id = $("#empresa_id").val();
            var url = "{{ route('apertura.cierre.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop


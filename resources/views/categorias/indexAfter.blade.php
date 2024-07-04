<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span>Categorias</span>
@endsection
@section('content')
    <div class="form-group row font-roboto-12 abs-center">
        <div class="col-md-4 px-1">
            <form action="#" method="get" id="form_estructura">
                <select name="empresa_id" id="empresa_id" class="form-control">
                    <option value="">-</option>
                    @foreach ($empresas as $index => $value)
                        <option value="{{ $index }}" @if(isset($empresa_id) ? $empresa_id : request('empresa_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            if($("#empresa_id >option:selected").val() != ''){
                var id = $("#empresa_id >option:selected").val();
                cargosByEmpresa(id);
            }

            $('#empresa_id').select2({
                theme: "bootstrap4",
                placeholder: "--Empresa--",
                width: '100%'
            });
        });

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        $('#empresa_id').change(function() {
            var id = $(this).val();
            cargosByEmpresa(id);
        });

        function cargosByEmpresa(id){
            $(".btn").hide();
            $(".empresa-id-select-container").hide();
            $(".spinner-btn").show();
            var status_platos = '[]';
            var status_insumos = '[]';
            var url = "{{ route('categorias.index',[':id',':status_platos',':status_insumos']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status_platos',status_platos);
            url = url.replace(':status_insumos',status_insumos);
            window.location.href = url;
        }
    </script>
@stop

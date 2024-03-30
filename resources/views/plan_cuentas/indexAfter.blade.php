<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    <div class="form-group row">
        <div class="col-md-12">
            <div class="card-header header">
                <div class="row">
                    <div class="col-md-8 font-roboto-17" style="display: flex; align-items: flex-end;">
                        <span class="btn btn-sm btn-outline-dark font-roboto-12" id="toggleSubMenu" style="cursor: pointer;">
                            <i class="fa-regular fa-chart-bar fa-fw fa-beat"></i>
                        </span>&nbsp;
                        <b>PLAN DE CUENTAS</b>
                    </div>
                    <div class="col-md-4 font-roboto-12">
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
    <div class="form-group row">
        <div class="col-md-12 text-center">
            <img src="/images/pi-resto.jpeg" alt="pi-resto" class="imagen-pi-resto">
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
            var status = '[]';
            var url = "{{ route('plan_cuentas.index',[':id',':status']) }}";
            url = url.replace(':id',id);
            url = url.replace(':status',status);
            window.location.href = url;
        }
    </script>
@stop

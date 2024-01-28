<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    #empresa_id + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
</style>
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card-header header">
                    <div class="row">
                        <div class="col-md-8">
                            <b>SUCURSALES</b>
                        </div>
                        <div class="col-md-4 empresa-id-select-container">
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
            var url = "{{ route('sucursal.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header font-verdana-bg bg-gradient-warning text-white">
                <b>{{ $cliente->nombre }} - EMPRESAS</b>
                <input type="hidden" value="{{ $cliente->id }}" id="cliente_id">
            </div>
            <div class="card-body">
                @include('empresas.partials.search')
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        {{--<button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
                        </button>--}}
                        <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                            &nbsp;<i class="fas fa-plus"></i>&nbsp;Registrar
                        </button>
                        <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
                @include('empresas.partials.table')
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
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#cliente_id").val();
            var url = "{{ route('empresas.create',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function valideNumberInteger(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code>=48 && code<=57){
                return true;
            }else{
                return false;
            }
        }
    </script>
@stop
<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header font-verdana-bg">
                <b>CLIENTES</b>
            </div>
            <div class="card-body">
                {{--@can('clientes.create')
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-outline-success font-verdana" type="button" onclick="create();">
                                &nbsp;<i class="fas fa-plus"></i>&nbsp;Registrar
                            </button>
                            <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                @endcan--}}
                @include('clientes.partials.table')
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
            
        });

        function create(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('clientes.create') }}";
        }
    </script>
@stop
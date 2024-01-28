<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    #empresa_id + .select2-container .select2-selection__rendered {
        font-size: 12px;
    }
    .mesa {
        width: 50px;
        height: 50px;
        background-color: #a0a0a0;
        margin: 10px;
    }
    .plano {
        width: 100%;
        height: 400px;
        border: 2px dashed #000;
        /*position: relative;*/
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
                            <i class="fa-duotone fa-lg fa-cart-shopping text-danger"></i> <b>PRODUCTOS</b>
                        </div>
                        <div class="col-md-4 empresa-id-select-container">
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
                    <div id="mesa1" class="mesa" draggable="true"></div>
                    <div id="mesa2" class="mesa" draggable="true"></div>
                    <!-- Agrega más mesas según sea necesario -->
                    <div id="plano" class="plano" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
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
        function allowDrop(event) {
            event.preventDefault();
        }

        function drop(event) {
            event.preventDefault();
            var mesaId = event.dataTransfer.getData("text");
            var mesa = document.getElementById(mesaId);

            var offsetX = event.clientX - mesa.clientWidth / 2;
            var offsetY = event.clientY - mesa.clientHeight / 2;

            mesa.style.position = "absolute";
            mesa.style.left = offsetX + "px";
            mesa.style.top = offsetY + "px";

            // Aquí puedes almacenar la posición de la mesa en tu sistema
        }

        document.addEventListener("DOMContentLoaded", function () {
            var mesas = document.querySelectorAll(".mesa");

            mesas.forEach(function (mesa) {
                mesa.addEventListener("dragstart", function (event) {
                    event.dataTransfer.setData("text", event.target.id);
                });
            });
        });

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
            var url = "{{ route('productos.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop
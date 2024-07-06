<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <span><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a><span>&nbsp;/&nbsp;
    <span><a href="{{ route('sucursal.index') }}"> Sucursales</a><span>&nbsp;/&nbsp;
    <span>Configuracion de mesas</span>
@endsection
    <style>
        .table-container {
            display: inline-block;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
        }
        td {
            border: 1px solid #ccc;
            width: 50px;
            height: 50px;
            text-align: center;
            vertical-align: middle;
        }
        img {
            width: 100%;
            height: auto;
            max-width: 40px;
            display: block;
            margin: 0 auto;
            cursor: move;
        }
    </style>
@section('content')
    {{--@include('mesas.partials.form-setting')--}}

    <div class="table-container">
        <table id="sortable-table">
            <tbody>
                @for ($i = 0; $i < 4; $i++)
                    <tr>
                        @for ($j = 0; $j < 4; $j++)
                            <td></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="image-container">
        <img src="{{ url(Auth()->user()->cliente->url_img) }}" alt="Draggable Image" id="draggable-image">
    </div>

    @include('mesas.partials.modal-asignar-mesa')
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            /*var primerZonaId = $('#myTabs .nav-link:first').data('zona-id');
            document.getElementById("zona_id").value = primerZonaId;*/

        });

        document.addEventListener('DOMContentLoaded', function () {
            var table = document.getElementById('sortable-table');
            var draggableImage = document.getElementById('draggable-image');
            var originalPosition = null;

            // Guardar la posición original de la imagen
            draggableImage.addEventListener('dragstart', function (ev) {
                originalPosition = ev.target.closest('td');
                ev.dataTransfer.setData('text', ev.target.id);
            });

            // Permitir soltar la imagen dentro de la celda
            table.addEventListener('dragover', function (ev) {
                ev.preventDefault();
            });

            // Manejar el evento de soltar la imagen
            table.addEventListener('drop', function (ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData('text');
                var draggedImage = document.getElementById(data);
                var cell = ev.target.closest('td');

                if (cell) {
                    // Mover la imagen a la nueva celda solo si es una celda de la tabla
                    cell.appendChild(draggedImage); // Mueve la imagen a la nueva celda
                } else {
                    // Si la imagen se suelta fuera de la tabla, vuelve a su posición original
                    if (originalPosition) {
                        originalPosition.appendChild(draggedImage);
                    }
                }
            });
        });


        /*new Sortable(example2Left, {
            group: 'shared',
            animation: 150
        });

        new Sortable(example2Right, {
            group: 'shared',
            animation: 150
        });*/

        function alternarDatos() {
            var datosMesa = document.getElementById("datos-mesa");
            datosMesa.classList.toggle("hiddenContent");
            var mapaMesa = document.getElementById("mapa-mesa");
            if (datosMesa.style.display === "none") {
                mapaMesa.classList.remove("col-md-12");
                mapaMesa.classList.add("col-md-8");
                datosMesa.style.display = "block";
            } else {
                datosMesa.style.display = "none";
                mapaMesa.classList.remove("col-md-8");
                mapaMesa.classList.add("col-md-12");
            }
        }

        $('#myTabs a').on('shown.bs.tab', function (e) {
            var zonaId = $(e.target).data('zona-id');
            document.getElementById("zona_id").value = zonaId;
        });

        function alerta(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }
        function cargarMesas(i,j) {
            var zona_id = $("#zona_id").val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getMesasByZona(i,j,zona_id,CSRF_TOKEN);
        }

        function getMesasByZona(i,j,zona_id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/mesas/get_mesas_by_zona',
                data: {
                    _token: CSRF_TOKEN,
                    id: zona_id
                },
                success: function(data){
                    if(data.mesas){
                        var arr = Object.values($.parseJSON(data.mesas));
                        $("#mesa_id").empty();
                        var select = $("#mesa_id");
                        document.getElementById("fila").value = i;
                        document.getElementById("columna").value = j;
                        select.append($("<option></option>").attr("value", '').text('--Mesa--'));
                        var mesaIdSeleccionado = localStorage.getItem('mesaIdSeleccionado');
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.id).text(json.numero_sillas);
                            if (json.id == mesaIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                        select.on('change', function() {
                            localStorage.setItem('mesaIdSeleccionado', $(this).val());
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function cancelarCargarMesa(){
            localStorage.clear();
        }

        function storeCargarMesa(){
            localStorage.clear();
            var url = "{{ route('mesas.store.cargar') }}";
            $("#form-asignar-mesa").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form-asignar-mesa").submit();
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('mesas.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#empresa_id").val();
            var url = "{{ route('mesas.index',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@stop

<!DOCTYPE html>
@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('comprobante.index') }}"> Listar comprobantes</a></li>
    <li class="breadcrumb-item active">Detalle del comprobante</li>
@endsection
@section('content')
    <div class="card-custom">
        <div class="card-header bg-gradient-secondary">
            <b>DETALLE COMPROBANTE</b>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12 px-1 text-right">
                @if ($comprobante->estado == '1')
                    @can('comprobante.aprobar')
                        <span class="btn btn-success font-roboto-12" onclick="procesar();">
                            <i class="fas fa-paper-plane fa-fw"></i>&nbsp;Aprobar
                        </span>
                    @endcan
                    @can('comprobante.aprobar')
                        <span class="btn btn-danger font-roboto-12" onclick="anular();">
                            <i class="fas fa-lock fa-fw"></i>&nbsp;Anular
                        </span>
                    @endcan
                @endif
                @can('comprobante.pdf')
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar a Pdf" style="cursor: pointer;">
                        <span class="btn btn-warning font-roboto-12" onclick="pdf();">
                            <i class="fa-solid fa-print fa-fw"></i>
                        </span>
                    </span>
                @endcan
                <span class="btn btn-danger font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i>&nbsp;Cancelar
                </span>
                <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div><hr>
        <div class="form-group row">
            <div class="col-md-6 px-1 pr-1 font-roboto-13">
                <input type="hidden" value="{{ $comprobante->id }}" id="comprobante_id">
                <input type="hidden" value="{{ $empresa->id }}" id="empresa_id">
                <b>Nro.- </b>{{ $comprobante->nro_comprobante }}
            </div>
            <div class="col-md-6 pr-1 pl-1 font-roboto-13">
                @can('comprobantef.show')
                    @if ($comprobantef != null)
                        @can('comprobantef.show')
                            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir" style="cursor: pointer;">
                                <a href="{{ route('comprobantef.show',$comprobantef->id) }}">
                                    <span class="badge-with-padding
                                        @if($comprobantef->estado == "1")
                                            badge badge-secondary font-roboto-12
                                        @else
                                            @if($comprobantef->estado == "2")
                                                badge badge-success font-roboto-12
                                            @else
                                                badge badge-danger font-roboto-12
                                            @endif
                                        @endif">
                                        {{ $comprobantef->nro_comprobante }}
                                    </span>
                                </a>
                            </span>
                        @endcan
                    @endif
                @endcan
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 pr-1 pl-1 font-roboto-13">
                <b>Tipo de Cambio.- </b>{{ $comprobante->tipo_cambio }}
            </div>
            <div class="col-md-2 pr-1 pl-1 font-roboto-13">
                <b>Ufv.- </b>{{ $comprobante->ufv }}
            </div>
            <div class="col-md-3 pr-1 pl-1 font-roboto-13">
                <b>Usuario.- </b>{{ $comprobante->user->username }}
            </div>
            <div class="col-md-3 px-1 pl-1 font-roboto-13">
                <b>Estado.- </b>
                @if ($comprobante->estado == '1')
                    <span class="text-secondary"><b><u>{{ $comprobante->status }}</u></b></span>
                @endif
                @if ($comprobante->estado == '2')
                    <span class="text-success"><b><u>{{ $comprobante->status }}</u></b></span>
                @endif
                @if ($comprobante->estado == '3')
                    <span class="text-danger"><b><u>{{ $comprobante->status }}</u></b></span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 px-1 pr-1 font-roboto-13">
                <b>Moneda.- </b>{{ $comprobante->moneda }}
            </div>
            <div class="col-md-3 pr-1 pl-1 font-roboto-13">
                <b>Empresa.- </b>{{ $comprobante->empresa->nombre_comercial }}
            </div>
            <div class="col-md-2 pr-1 pl-1 font-roboto-13">
                <b>Fecha.- </b>{{ \Carbon\Carbon::parse($comprobante->fecha)->format('d-m-Y') }}
            </div>
            <div class="col-md-2 pr-1 pl-1 font-roboto-13">
                <b>Tipo.- </b>{{ App\Models\Comprobante::TIPOS[$comprobante->tipo] }}
            </div>
            <div class="col-md-3 px-1 pl-1 font-roboto-13 text-center">
                <b>¿Con Copia?.- </b>{{ $comprobante->copia == '1' ? 'SI' : 'NO' }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 font-roboto-13">
                <b>Concepto.- </b>{{ $comprobante->concepto }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 px-1 pr-1 font-roboto-13">
                @if ($comprobante->tipo != '3')
                    @if ($comprobante->tipo == '1')
                        <b>Hemos recibido de </b>
                    @else
                        <b>Hemos entregado a </b>
                    @endif
                    {{ $comprobante->entregado_recibido }}
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 px-1 table-responsive">
                <table id="tabla_comprobante_detalle" class="table display table-bordered responsive" style="width:100%;">
                    <thead>
                        <tr class="font-roboto-11">
                            <td class="text-center p-1"><b>N°</b></td>
                            <td class="text-center p-1"><b>CUENTA</b></td>
                            <td class="text-center p-1"><b>AUXILIAR</b></td>
                            <td class="text-center p-1"><b>CENTRO</b></td>
                            <td class="text-center p-1"><b>SUBCENTRO</b></td>
                            <td class="text-center p-1"><b>GLOSA</b></td>
                            <td class="text-center p-1"><b>DEBE</b></td>
                            <td class="text-center p-1"><b>HABER</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cont = 1
                        @endphp
                        @foreach ($comprobante_detalles as $datos)
                            <tr class="font-roboto-11">
                                <td class="text-left p-1">{{ $cont++ }}</td>
                                <td class="text-left p-1">{{ $datos->plan_cuenta->nombre }}</td>
                                <td class="text-left p-1">{{ $datos->plan_cuenta_auxiliar != null ? $datos->plan_cuenta_auxiliar->nombre : '-' }}</td>
                                <td class="text-left p-1">{{ $datos->centro->nombre }}</td>
                                <td class="text-left p-1">{{ $datos->subcentro->nombre }}</td>
                                <td class="text-left p-1">{{ $datos->glosa }}</td>
                                <td class="text-right p-1">{{ number_format($datos->debe,2,'.',',') }}</td>
                                <td class="text-right p-1">{{ number_format($datos->haber,2,'.',',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-roboto-11">
                            <td class="text-center p-1" colspan="6"><b>TOTAL</b></td>
                            <td class="text-right p-1"><b>{{ number_format($total_debe,2,'.',',') }}</b></td>
                            <td class="text-right p-1"><b>{{ number_format($total_haber,2,'.',',') }}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    @include('layouts.notificaciones')
    <script>
        $(document).ready(function() {
            $('#tabla_comprobante_detalle').DataTable({
                "processing":true,
                "iDisplayLength": 10,
                "order": [[ 0, "asc" ]],
                language: datatableLanguageConfig
            });
        });

        function alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#comprobante_id").val();
            var url = "{{ route('comprobante.aprobar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function anular(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var id = $("#comprobante_id").val();
            var url = "{{ route('comprobante.anular',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function pdf(){
            var id = $("#comprobante_id").val();
            var url = "{{ route('comprobante.pdf', ':id') }}";
            url = url.replace(':id', id);
            window.open(url, '_blank');
        }

        function cancelar(){
            var url = "{{ route('comprobante.index') }}";
            window.location.href = url;
        }
    </script>
@stop

<div class="form-group row">
    <div class="col-md-12">
        <table class="table display responsive table-striped hover-orange">
            <thead>
                <tr class="font-roboto-12 bg-warning text-white">
                    <td class="text-left p-1"><b>FECHA</b></td>
                    <td class="text-left p-1"><b>NRO. COMPROBANTE</b></td>
                    <td class="text-left p-1"><b>CONCEPTO</b></td>
                    <td class="text-center p-1"><b>EMPRESA</b></td>
                    <td class="text-right p-1"><b>MONTO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['comprobante.editar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($comprobantes as $datos)
                    <tr class="font-roboto-12">
                        <td class="text-left p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                        <td class="text-left p-1">{{ $datos->nro_comprobante }}</td>
                        <td class="text-left p-1">{{ $datos->concepto }}</td>
                        <td class="text-center p-1">{{ $datos->empresa->alias }}</td>
                        <td class="text-right p-1">{{ number_format($datos->monto,2,'.',',') }}</td>
                        <td class="text-center p-1">
                            <span class="badge-with-padding
                                @if($datos->status == "PENDIENTE")
                                    badge badge-secondary
                                @else
                                    @if($datos->status == "APROBADO")
                                        badge badge-success
                                    @else
                                        badge badge-danger
                                    @endif
                                @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['comprobante.editar'])
                            <td class="text-center p-1">
                                @can('comprobantef.pdf')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Pdf" style="cursor: pointer;">
                                        <a href="{{ route('comprobantef.pdf',$datos->id) }}" class="badge-with-padding badge badge-danger" target="_blank">
                                            <i class="fa-solid fa-file-pdf fa-fw"></i>
                                        </a>
                                    </span>
                                @endcan
                                @can('comprobantef.show')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                        <a href="{{ route('comprobantef.show',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                            <i class="fa-solid fa-list-check fa-fw"></i>
                                        </a>
                                    </span>
                                @endcan
                                @if ($datos->estado == '1')
                                    @can('comprobantef.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('comprobantef.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                @else
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar No Permitido" style="cursor: pointer;">
                                        <a href="#" class="badge-with-padding badge badge-secondary">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                @endif
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row font-roboto-12">
            <div class="col-md-6">
                <p class="text- muted">Mostrando
                    <strong>{{$comprobantes->count()}}</strong> registros de
                    <strong>{{$comprobantes->total()}}</strong> totales
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $comprobantes->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <table class="table display responsive table-striped hover-orange">
            <thead>
                <tr class="font-roboto-12 bg-secondary text-white">
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>USUARIO</b></td>
                    <td class="text-center p-1"><b>CARGO</b></td>
                    <td class="text-center p-1"><b>FECHA APERTURA</b></td>
                    <td class="text-center p-1"><b>FECHA CIERRE</b></td>
                    <td class="text-center p-1"><b>MONTO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    {{--@canany(['asiento.automatico.editar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany--}}
                </tr>
            </thead>
            <tbody>
                @foreach ($aperturas_cierres as $datos)
                    <tr class="font-roboto-12">
                        <td class="text-center p-1">{{ $datos->codigo }}</td>
                        <td class="text-center p-1">{{ $datos->user->username }}</td>
                        <td class="text-center p-1">{{ $datos->cargo->nombre }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_inicial)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">{{ $datos->fecha_cierre != null ? \Carbon\Carbon::parse($datos->fecha_cierre)->format('d/m/Y') : '' }}</td>
                        <td class="text-right p-1">{{ number_format($datos->monto_apertura,2,'.',',') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->color_badge_status}}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        {{--@canany(['asiento.automatico.editar','asiento.automatico.habilitar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @if ($datos->estado == '1')
                                        @can('asiento.automatico.editar')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('asiento.automatico.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
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
                                    &nbsp;
                                    @can('asiento.automatico.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('asiento.automatico.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('asiento.automatico.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        @endcanany--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row font-roboto-12">
            <div class="col-md-6">
                <p class="text- muted">Mostrando
                    <strong>{{$aperturas_cierres->count()}}</strong> registros de
                    <strong>{{$aperturas_cierres->total()}}</strong> totales
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $aperturas_cierres->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-12">
        <table class="table display responsive table-striped">
            <thead>
                <tr class="font-roboto-12">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>FECHA</b></td>
                    <td class="text-right p-1"><b>UFV</b></td>
                    <td class="text-right p-1"><b>OFICIAL</b></td>
                    <td class="text-right p-1"><b>COMPRA</b></td>
                    <td class="text-right p-1"><b>VENTA</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['tipo.cuenta.editar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($tipo_cambios as $datos)
                    <tr class="font-roboto-12">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                        <td class="text-right p-1">{{ $datos->ufv }}</td>
                        <td class="text-right p-1">{{ $datos->dolar_oficial }}</td>
                        <td class="text-right p-1">{{ $datos->dolar_compra }}</td>
                        <td class="text-right p-1">{{ $datos->dolar_venta }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="@if($datos->status == "H") HABILITADO @else DESHABILITADO @endif" style="cursor: pointer;">
                                <span class="badge-with-padding @if($datos->status == "H") badge badge-success @else badge badge-danger @endif">
                                    &nbsp;{{ $datos->status }}&nbsp;
                                </span>
                            </span>
                        </td>
                        @canany(['tipo.cuenta.editar'])
                            <td class="text-center p-1">
                                @can('tipo.cuenta.editar')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('tipo.cambio.editar',$datos->id) }}" class="badge-with-padding badge badge-warning">
                                            <i class="fas fa-lg fa-edit text-white"></i>
                                        </a>
                                    </span>
                                @endcan
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-roboto-12">
            {!! $tipo_cambios->links() !!}
        </div>
    </div>
</div>
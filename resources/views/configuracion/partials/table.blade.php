<div class="form-group row abs-center">
    <div class="col-md-8">
        <table id="table-precios" class="table display responsive table-striped hover-orange">
            <thead>
                <tr class="font-roboto-12">
                    <td class="text-center p-1"><b>ID</b></td>
                    <td class="text-center p-1"><b>NOMBRE</b></td>
                    <td class="text-center p-1"><b>DETALLE</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['comprobante.inicio.mes.fiscal'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($configuraciones as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->detalle }}</td>
                        <td class="text-center p-1" width="150px">
                            <span class="badge-with-padding 
                                @if($datos->status == "PENDIENTE") 
                                    badge badge-secondary 
                                @else 
                                    badge badge-success 
                                @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['comprobante.inicio.mes.fiscal'])
                            <td class="text-center p-1">
                                @can('comprobante.inicio.mes.fiscal')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Historial" style="cursor: pointer;">
                                        <a href="{{ route('configuracion.show',$datos->id) }}" class="badge-with-padding badge badge-info text-white">
                                            <i class="fa-solid fa-bars-staggered fa-fw"></i>
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
            {!! $configuraciones->links() !!}
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12">
        <table class="table display responsive table-striped">
            <thead>
                <tr class="font-roboto-bg">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>CODIGO</b></td>
                    <td class="text-left p-1"><b>PRODUCTO</b></td>
                    <td class="text-left p-1"><b>TIPO</b></td>
                    <td class="text-right p-1"><b>PRECIO</b></td>
                    <td class="text-right p-1"><b>% DESC.</b></td>
                    <td class="text-right p-1"><b>P. FINAL</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    {{--@canany(['mesas.editar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany--}}
                </tr>
            </thead>
            <tbody>
                @foreach ($precios as $datos)
                    <tr class="font-roboto">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->producto->codigo }}</td>
                        <td class="text-left p-1">{{ $datos->producto->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->tipo_p->nombre }}</td>
                        <td class="text-right p-1">{{ $datos->costo }}</td>
                        <td class="text-right p-1">{{ $datos->p_descuento }}</td>
                        <td class="text-right p-1">{{ $datos->costo_final }}</td>
                        <td class="text-center p-1">
                            <span class="badge-with-padding @if($datos->status == "HABILITADO") badge badge-success @else badge badge-danger @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                        {{--<td class="text-center p-1">
                            @can('mesas.editar')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                    <a href="{{ route('mesas.editar',$datos->id) }}" class="badge-with-padding badge badge-warning text-white">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                </span>
                            @endcan
                            @can('mesas.habilitar')
                                @if($datos->status == "HABILITADO")
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                        <a href="{{ route('mesas.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                            <i class="fas fa-lg fa-arrow-alt-circle-down"></i>
                                        </a>
                                    </span>
                                @else
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                        <a href="{{ route('mesas.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                            <i class="fas fa-lg fa-arrow-alt-circle-up"></i>
                                        </a>
                                    </span>
                                @endif
                            @endcan
                        </td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-roboto-bg">
            {!! $precios->links() !!}
        </div>
    </div>
</div>
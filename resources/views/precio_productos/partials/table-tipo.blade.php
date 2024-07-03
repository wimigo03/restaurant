<div class="form-group row">
    <div class="col-md-12">
        <table id="table-precios" class="table display responsive table-striped hover-orange">
            <thead>
                <tr class="font-roboto-12">
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>EMP.</b></td>
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>TIPO</b></td>
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>CODIGO</b></td>
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>PRODUCTO</b></td>
                    <td class="text-center p-1" colspan="2"><b>PRECIO ACTUAL</b></td>
                    <td class="text-center p-1" colspan="2"><b>NUEVO PRECIO</b></td>
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>(%)</b></td>
                    <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b>ESTADO</b></td>
                    @canany(['precio.productos.show'])
                        <td class="text-center p-1" rowspan="2" style="vertical-align: bottom;"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
                <tr class="font-roboto-12">
                    <td class="text-center p-1"><b>$U$</b></td>
                    <td class="text-center p-1"><b>BS.</b></td>
                    <td class="text-center p-1"><b>$U$</b></td>
                    <td class="text-center p-1"><b>BS.</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($precio_productos as $datos)
                    <tr class="detalle-{{ $datos->id }} font-roboto-11">
                        <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->empresa->alias }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">
                            <input type="hidden" name="precio_producto_id[]" value="{{ $datos->id }}" class="input-precio-producto-id">
                            {{ $datos->tipo_p->nombre }}
                        </td>
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $datos->producto->codigo }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">{{ $datos->producto->nombre }}</td>
                        <td class="text-right p-1" style="vertical-align: middle;">
                            {{ number_format($datos->precio/$datos->tipo_cambio,2,'.',',') }}
                        </td>
                        <td class="text-right p-1 bg-warning" style="vertical-align: middle;">
                            <input type="hidden" value="{{ $datos->precio }}" class="form-control font-roboto-12 input-precio-actual">
                            {{ number_format($datos->precio,2,'.',',') }}
                        </td>
                        <td class="text-right p-1" width="100px">
                            <input type="text" placeholder="0" class="form-control font-roboto-11 text-right input-precio-final-sus" readonly>
                        </td>
                        <td class="text-right p-1" width="100px">
                            <input type="text" name="precio_final[]" placeholder="0" class="form-control font-roboto-11 text-right input-precio-final" onKeyUp="CalcularCambioPrecioFinal({{ $datos->id }})">
                        </td>
                        <td class="text-right p-1" width="70px">
                            <input type="text" name="porcentaje_detalle[]" placeholder="0" class="form-control font-roboto-11 text-right input-porcentaje-detalle" onKeyUp="CalcularCambioPorcentaje({{ $datos->id }})">
                        </td>
                        <td class="text-center p-1" width="150px">
                            <span class="badge-with-padding
                                @if($datos->status == "HABILITADO")
                                    badge badge-success
                                @else
                                    @if($datos->status == "NO HABILITADO")
                                        badge badge-danger
                                    @else
                                        badge badge-warning text-white
                                    @endif
                                @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['precio.productos.show'])
                            <td class="text-center p-1">
                                @can('precio.productos.show')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Historial" style="cursor: pointer;">
                                        <a href="{{ route('precio.productos.show',$datos->producto_id) }}" class="badge-with-padding badge badge-info text-white">
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
    </div>
</div>

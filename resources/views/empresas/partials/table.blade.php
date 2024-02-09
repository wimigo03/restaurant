<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-left p-1"><b>COD.</b></td>
                    <td class="text-left p-1"><b>NOMBRE COMERCIAL</b></td>
                    <td class="text-left p-1"><b>ALIAS</b></td>
                    <td class="text-left p-1"><b>URL_LOGO</b></td>
                    <td class="text-left p-1"><b>DIRECCION</b></td>
                    <td class="text-left p-1"><b>TELEFONO</b></td>
                    <td class="text-left p-1"><b>URL_COVER</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($empresas as $datos)
                    <tr class="font-verdana">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre_comercial }}</td>
                        <td class="text-left p-1">{{ $datos->alias }}</td>
                        <td class="text-left p-1">
                            <a href="{{ asset($datos->url_logo) }}" target="_blank">
                                {{ $datos->url_logo }}
                            </a>
                        </td>
                        <td class="text-left p-1">{{ $datos->direccion }}</td>
                        <td class="text-left p-1">{{ $datos->telefono }}</td>
                        <td class="text-left p-1">
                            <a href="{{ asset($datos->url_cover) }}" target="_blank">
                                {{ $datos->url_cover }}
                            </a>
                        </td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Editar" style="cursor: pointer;">
                                <a href="{{ route('empresas.editar',$datos->id) }}" class="text-secondary">
                                    &nbsp;<i class="fas fa-lg fa-edit"></i>&nbsp;
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana">
                    <td colspan="12">
                        {{ $empresas->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$empresas->count()}}</strong> registros de
                            <strong>{{$empresas->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
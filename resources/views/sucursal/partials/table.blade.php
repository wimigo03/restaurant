<div class="form-group row">
    <div class="col-md-12">
        <table class="table display {{--table-bordered--}} responsive table-striped">
            <thead>
                <tr class="font-roboto-bg">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>CIUDAD</b></td>
                    <td class="text-left p-1"><b>DIRECCION</b></td>
                    <td class="text-left p-1"><b>CELULAR</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @can(['sucursal.modificar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($sucursales as $datos)
                    <tr class="font-roboto">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->ciudad }}</td>
                        <td class="text-left p-1">{{ $datos->direccion }}</td>
                        <td class="text-left p-1">{{ $datos->celular }}</td>
                        <td class="text-center p-1">
                            <span class="badge-with-padding @if($datos->status == "HABILITADO") badge badge-success @else badge badge-danger @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @can('sucursal.modificar')
                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                    <a href="{{ route('sucursal.editar',$datos->id) }}" class="text-primary">
                                        <i class="fas fa-lg fa-edit"></i>
                                    </a>
                                </span>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-roboto-bg">
            {!! $sucursales->links() !!}
        </div>
    </div>
</div>
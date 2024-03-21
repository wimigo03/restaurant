<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive">
            <thead>
                <tr class="font-verdana-bg">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>EMPRESA</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    @canany(['roles.editar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $datos)
                    <tr class="font-verdana-bg">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->empresa != null ? $datos->empresa->nombre_comercial : '-' }}</td>
                        <td class="text-left p-1">{{ $datos->name }}</td>
                        @can('roles.editar')
                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                    <a href="{{ route('roles.editar',$datos->id) }}" class="text-info">
                                        <i class="fas fa-lg fa-list"></i>
                                    </a>
                                </span>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-verdana">
            {!! $roles->links() !!}
        </div>
    </div>
</div>
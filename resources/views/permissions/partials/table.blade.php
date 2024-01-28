<div class="form-group row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table display table-bordered responsive">
                <thead>
                    <tr class="font-verdana-bg">
                        <td class="text-left p-1"><b>ID</b></td>
                        <td class="text-left p-1"><b>TITULO</b></td>
                        <td class="text-left p-1"><b>NOMBRE</b></td>
                        <td class="text-left p-1"><b>DESCRIPCION</b></td>
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $datos)
                        <tr class="font-verdana-bg">
                            <td class="text-left p-1">{{ $datos->id }}</td>
                            <td class="text-left p-1">{{ $datos->title }}</td>
                            <td class="text-left p-1">{{ $datos->name }}</td>
                            <td class="text-left p-1">{{ $datos->description }}</td>
                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                    {{--<a href="{{ route('users.editar',$datos->id) }}" class="text-warning"> --}}
                                        <i class="fas fa-lg fa-list"></i>
                                    {{--</a> --}}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end font-verdana-bg">
                {!! $permissions->links() !!}
            </div>
        </div>
    </div>
</div>
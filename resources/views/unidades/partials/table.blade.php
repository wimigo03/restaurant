<div class="form-group row abs-center">
    <div class="col-md-8 px-1 pr-1">
        <table class="table display {{--table-bordered--}} responsive table-striped">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>EMP.</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>TIPO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($unidades as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->empresa->alias }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->codigo }}</td>
                        <td class="text-center p-1">{{ $datos->tipo_categoria }}</td>
                        <td class="text-center p-1">
                            <span class="badge-with-padding @if($datos->status == "HABILITADO") badge badge-success @else badge badge-danger @endif">
                                {{ $datos->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-roboto-11">
            {!! $unidades->links() !!}
        </div>
    </div>
</div>

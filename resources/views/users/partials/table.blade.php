<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana-bg">
                    <td class="text-left p-1"><b>EMPRESA</b></td>
                    <td class="text-left p-1"><b>CARGO</b></td>
                    <td class="text-left p-1"><b>ROLES</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>USUARIO</b></td>
                    <td class="text-left p-1"><b>CORREO ELECTRONICO</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['users.editar','users.habilitar','users.asignar'])
                        <td class="text-center p-1"><b><i class="fas fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $datos)
                    <tr class="font-verdana-bg">
                        <td class="text-left p-1">{{ $datos->empresa->alias }}</td>
                        <td class="text-left p-1">{{ $datos->cargo != null ? $datos->cargo->nombre : '#' }}</td>
                        <td class="text-left p-1">
                            @php
                                $roles = DB::table('model_has_roles as a')->join('roles as b','a.role_id','b.id')->where('a.model_id',$datos->id)->get();
                                if($roles != null){
                                    foreach($roles as $r){
                                        echo $r->name;
                                    }
                                }
                            @endphp
                        </td>
                        <td class="text-left p-1">{{ $datos->name }}</td>
                        <td class="text-left p-1">{{ $datos->username }}</td>
                        <td class="text-left p-1">{{ $datos->email }}</td>
                        <td class="text-center p-1">{{ $datos->status }}</td>
                        @canany(['users.editar','users.habilitar','users.asignar'])
                            <td class="text-center p-1">
                                @can('users.editar')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('users.editar',$datos->id) }}" class="text-warning">
                                            <i class="fas fa-lg fa-edit"></i>
                                        </a>
                                    </span>
                                @endcan
                                @can('users.habilitar')
                                    @if (App\Models\User::ESTADOS[$datos->estado] == 'HABILITADO')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                            <a href="{{ route('users.deshabilitar',$datos->id) }}" class="text-danger">
                                                <i class="fas fa-lg fa-arrow-alt-circle-down"></i>
                                            </a>
                                        </span>
                                    @else
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                            <a href="{{ route('users.habilitar',$datos->id) }}" class="text-success">
                                                <i class="fas fa-lg fa-arrow-alt-circle-up"></i>
                                            </a>
                                        </span>
                                    @endif
                                @endcan
                                @can('users.asignar')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Asignar Roles" style="cursor: pointer;">
                                        <a href="{{ route('users.asignar',$datos->id) }}" class="text-primary">
                                            <i class="fas fa-lg fa-users"></i>
                                        </a>
                                    </span>
                                @endcan
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end font-verdana-bg">
            {!! $users->links() !!}
        </div>
    </div>
</div>
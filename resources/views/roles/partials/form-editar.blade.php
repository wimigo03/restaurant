<div class="form-group row font-verdana-bg">
    <div class="col-md-6 px-0 pr-1">
        <input type="text" value="{{ $role->name }}" class="form-control form-control-sm font-verdana-bg text-center bg-info" disabled>
    </div>
    <div class="col-md-6 px-0 pl-1 text-right">
        <button class="btn btn-outline-primary font-verdana" type="button" onclick="procesar();">
            <i class="fas fa-paper-plane"></i>&nbsp;Procesar Cambios
        </button>
        <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
            &nbsp;<i class="fas fa-times"></i>&nbsp;Cancelar
        </button>
        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
    </div>
</div>
<div class="form-group row font-verdana-bg">
    <div class="col-md-12"> 
        <form action="#" method="post" id="form">
            @csrf
            <input type="hidden" name="role_id" value="{{ $role->id }}">
            <div style="height:600px;overflow-y: scroll; width: 100%;">
                @for ($i = 0; $i < count($permisosOrdenados); $i++)
                    <div class="form-group row font-verdana-bg">
                        <div class="col-md-4 pr-1">
                            <ul class="list-group list-group-sm">
                                <li class="list-group-item list-group-item-dark">
                                    <label class="">
                                        <input type="checkbox" name="modelo" value="0" id="{{ $permisosOrdenados[$i][0] }}" onchange="marcarTodo(this.id);">
                                        {{$permisosOrdenados[$i][0]}}
                                    </label>
                                </li>
                                @for ($j = 1; $j < count($permisosOrdenados[$i]); $j+=2)
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permissions[]" value="{{ $permisosOrdenados[$i][$j] }}" class="{{ $permisosOrdenados[$i][0] }}" {{ $role->hasPermissionTo($permisosOrdenados[$i][$j]) ? 'checked' : '' }}>
                                        {{$permisosOrdenados[$i][$j + 1]}}
                                    </li>
                                @endfor
                                @php
                                    $i++;
                                @endphp
                            </ul>
                        </div>
                        @if ($i < count($permisosOrdenados))
                            <div class="col-md-4 pr-1 pl-1">
                                <ul class="list-group list-group-sm">
                                    <li class="list-group-item list-group-item-dark">
                                        <label class="">
                                            <input type="checkbox" name="modelo" value="0" id="{{ $permisosOrdenados[$i][0] }}" onchange="marcarTodo(this.id);">
                                            {{$permisosOrdenados[$i][0]}}
                                        </label>
                                    </li>
                                    @for ($j = 1; $j < count($permisosOrdenados[$i]); $j+=2)
                                        <li class="list-group-item">
                                            <input type="checkbox" name="permissions[]" value="{{ $permisosOrdenados[$i][$j] }}" class="{{ $permisosOrdenados[$i][0] }}" {{ $role->hasPermissionTo($permisosOrdenados[$i][$j]) ? 'checked' : '' }}>
                                            {{$permisosOrdenados[$i][$j + 1]}}
                                        </li>
                                    @endfor
                                    @php
                                        $i++;
                                    @endphp
                                </ul>
                            </div>
                            @if ($i < count($permisosOrdenados))
                                <div class="col-md-4 pl-1">
                                    <ul class="list-group list-group-sm">
                                        <li class="list-group-item list-group-item-dark">
                                            <label class="">
                                                <input type="checkbox" name="modelo" value="0" id="{{ $permisosOrdenados[$i][0] }}" onchange="marcarTodo(this.id);">
                                                {{$permisosOrdenados[$i][0]}}
                                            </label>
                                        </li>
                                        @for ($j = 1; $j < count($permisosOrdenados[$i]); $j+=2)
                                            <li class="list-group-item">
                                                <input type="checkbox" name="permissions[]" value="{{ $permisosOrdenados[$i][$j] }}" class="{{ $permisosOrdenados[$i][0] }}" {{ $role->hasPermissionTo($permisosOrdenados[$i][$j]) ? 'checked' : '' }}>
                                                {{$permisosOrdenados[$i][$j + 1]}}
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                    <hr>
                @endfor
            </div>
        </form>
    </div>
</div>
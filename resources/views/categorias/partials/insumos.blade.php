<br>
<div class="form-group row">
    <div class="col-md-7 pr-1">
        <div class="card card-body">
            @if (isset($categorias_insumos))
                <div class="row">
                    <div class="col-md-10">
                        <div id="treeview_insumos"></div>
                    </div>
                    <div class="col-md-2 text-right">
                        <i class="fa fa-spinner custom-spinner fa-spin fa-fw spinner-btn" style="display: none;"></i>
                        @if (count($estado_insumos) == 1)
                            <div class="form-group row" id="btn_todos_los_insumos">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Mostrar Todos" style="cursor: pointer;">
                                        <span class="btns font-verdana text-primary" onclick="todos_los_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-users-gear"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="form-group row" id="btn_solo_habilitados_insumos">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Mostrar Solo Habilitados" style="cursor: pointer;">
                                        <span class="btns font-verdana text-success" onclick="solo_habilitados_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-users-gear"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endif
                        @can('categorias.create.insumos.master')
                            <div class="form-group row" style="margin-top: -15px;" id="btn_insumos_master">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Crear Categoria Master" style="cursor: pointer;">
                                        <span class="btns font-verdana text-secondary" onclick="crear_insumos_master();">
                                            &nbsp;<i class="fa-solid fa-2x fa-user-plus"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endcan
                        @can('categorias.create.insumos')
                            <div class="form-group row" style="margin-top: -15px;" id="btn_sub_insumos_master">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Crear SubCategoria" style="cursor: pointer;">
                                        <span class="btns font-verdana text-secondary" onclick="crear_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-user-minus"></i>&nbsp;
                                        </span> 
                                    </span>
                                </div>
                            </div>
                        @endcan
                        @can('categorias.habilitar')
                            <div class="form-group row" style="margin-top: -10px;" id="btn_deshabilitar_insumos">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                        <span class="btns font-verdana text-danger" onclick="deshabilitar_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-user-xmark"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endcan
                        @can('categorias.habilitar')
                            <div class="form-group row" style="margin-top: -10px;" id="btn_habilitar_insumos">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                        <span class="btns font-verdana text-success" onclick="habilitar_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-user-check"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endcan
                        @can('categorias.modificar')
                            <div class="form-group row" style="margin-top: -10px;" id="btn_modificar_insumos">
                                <div class="col-md-12">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <span class="btns font-verdana text-secondary" onclick="modificar_insumos();">
                                            &nbsp;<i class="fa-solid fa-2x fa-users-gear"></i>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-5 pl-1">
        <div class="card card-body">
            <div id="contenido_insumos">
                <input type="hidden" value="#" name="categoria_insumo_id" id="categoria_insumo_id">    
                <input type="hidden" value="2" id="tipo_insumos">
                @if (isset($categorias_insumos))
                    @include('categorias.partials.contenido_insumos')
                @endif
            </div>
        </div>
    </div>
</div>
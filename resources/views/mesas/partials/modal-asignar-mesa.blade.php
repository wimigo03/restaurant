<div class="modal fade" id="ModalAsignarMesa" tabindex="-1" role="dialog" aria-labelledby="ModalAsignarMesaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="margin-top: -50px;">
        <div class="modal-content">
            <div class="modal-body">
                <br>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-12 px-1">
                        <form action="#" method="post" id="form-asignar-mesa">
                            @csrf
                            <input type="hidden" name="fila" value="" id="fila">
                            <input type="hidden" name="columna" value="" id="columna">
                            <select id="mesa_id" name="mesa_id" class="form-control select2">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 px-1 text-right">
                        <span class="btn btn-outline-primary font-roboto-12" onclick="storeCargarMesa();">
                            <i class="fas fa-paper-plane"></i>&nbsp;Asignar Mesa
                        </span>
                        <span class="btn btn-outline-danger font-roboto-12" data-dismiss="modal" onclick="cancelarCargarMesa();">
                            <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
                        </span>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

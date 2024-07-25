<!-- Modal -->
<div class="modal fade" id="modalpedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLabel">
                    REGISTRAR PEDIDO MESA <span id="nombre_mesa"></span>
                </h5>
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>--}}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 bordered-div font-roboto-12" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
                        <form action="#" method="post" id="form">
                            @csrf
                            <input type="hidden" name="mesa_id" id="mesa_id">
                            <div id="pedido-container">
                                <div class="card-body">
                                    <div class="form-group row font-roboto-10">
                                        <div class="col-md-12">
                                            <table id="table-titulo-pedido">
                                                <tr>
                                                    <td class="unir-input-font">
                                                        <i class="fad fa-ticket-alt fa-2x"></i>
                                                        <input type="text" name="pedido_id" id="nro-pedido" value="#" class="form-control form-control-sm font-roboto-12 text-center" disabled/>
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td class="unir-input-font">
                                                        <i class="fas fa-user fa-2x"></i>
                                                        <input type="number" name="cantidad_clientes" id="cantidad_clientes" value="0" class="form-control form-control-sm font-roboto-12" min="1" step="1" onkeypress="return valideNumberSinDecimal(event);" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 font-roboto-11">
                                            <table id="table-subtitulo-pedido">
                                                <tr>
                                                    <td width="50%">
                                                        <b>IMPORTE TOTAL</b>
                                                    </td>
                                                    <td class="unir-input-font">
                                                        <i class="fas fa-hand-holding-usd fa-lg"></i>
                                                        <input type="text" id="importe-total" placeholder="0" class="form-control form-control-sm font-roboto-12 text-right" disabled/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row font-roboto-10">
                                        <div class="col-md-12">
                                            <table id="table-detalle-pedido" class="table display hover-orange" style="width: 100%;">
                                                <thead>
                                                    <tr class="font-roboto-10">
                                                        <td width="20%" class="text-left p-1">
                                                            <b>CATEGORIA</b>
                                                        </td>
                                                        <td class="text-left p-1">
                                                            <b>PRODUCTO</b>
                                                        </td>
                                                        <td width="20%" class="text-center p-1">
                                                            <b>CANT.</b>
                                                        </td>
                                                        <td width="20%" class="text-right p-1">
                                                            <b>PREC.</b>
                                                        </td>
                                                        <td width="20%" class="text-right p-1">
                                                            <b>TOTAL</b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="content-pedido">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();" id="btn-pedido-procesar">
                                        <i class="fas fa-paper-plane fa-fw"></i>&nbsp;Generar Pedido
                                    </span>
                                    <span class="btn btn-outline-warning font-roboto-12" onclick="pendiente();" id="btn-pedido-pendiente">
                                        <i class="fas fa-pause fa-fw"></i>&nbsp;Pendiente
                                    </span>
                                    <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();" id="btn-pedido-cancelar">
                                        <i class="fas fa-xmark fa-fw"></i>&nbsp;Cancelar
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 bordered-div font-roboto-12">
                        <div id="productos-container" class=" row font-roboto-12 abs-center">
                            {{-- jquery --}}
                        </div>
                    </div>
                </div>
                {{--<p>Mesa ID: <span id="modalMesaId"></span></p>
                <input type="text" class="form-control" id="mesaIdInput" readonly>--}}
            </div>
            {{--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>--}}
        </div>
    </div>
</div>

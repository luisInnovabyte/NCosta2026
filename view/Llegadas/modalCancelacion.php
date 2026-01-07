<div id="cancelacion-modal" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Cancelación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card datos-cancelacion" >
                    <div class="card-body p-4">
                        <h5 class="card-title text-center">Cancelación de la llegada <b id="datosLlegadaText"></b></h5>
                            <div class="mb-3">
                                <label for="cancelacionFecha" class="form-label">Fecha de Cancelación</label>
                                <input type="date" class="form-control form-control-sm" id="cancelacionFecha" min="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="motivoCancelacion" class="form-label">Motivo de Cancelación</label>
                                <textarea class="form-control form-control-sm" maxlength="250" id="motivoCancelacion" rows="3" required></textarea>
                            </div>

                            <div id="mostrarInsertarCancelacion" class="text-center">
                                <button onclick="agregarCancelacion()" class="btn btn-success btn-lg col-12 ">Guardar Cancelación</button>
                            </div>

                            <div id="ocultarInsertarCancelacion"  class="text-center d-none">
                                <button onclick="eliminarCancelacion()" class="btn btn-danger btn-lg col-12  mt-3"><i class="fa-regular fa-rectangle-xmark"></i> Eliminar Cancelación</button>
                            </div>

                            <small class="d-block mt-3 text-center">
                                <b class="tx-danger">*</b> La cancelación será inmediata, independientemente de la fecha de cancelación. El alumno no tendrá acceso a esta docencia.
                            </small>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>

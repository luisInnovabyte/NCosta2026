<div id="agregar-Bildungsurlaub-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Bildungsurlaub</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Agregar Bildungsurlaub</h5>
                        <form id="insertarBildungsurlaub" method="POST">
                        <input type="hidden" name="id-conocimiento" id="id-conocimiento" value="">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Nombre de Bildungsurlaub</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nombreBildungsurlaub" name="nombreBildungsurlaub" placeholder="Nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="guardarElementoBildungsurlaub()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
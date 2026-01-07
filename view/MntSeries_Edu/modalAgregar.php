<div id="insertar-serie-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Serie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nueva Serie</h5>
                        <form id="insertar-serie-form" method="POST">
                            <div class="row g-3">
                                <div class="col-12 col-lg-12">
                                    <label for="nombreTipo" class="form-label">Descripcion de la serie</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="descrSerie" name="descrSerie" placeholder="Descripcion" data-type="3" data-min="3" data-max="60" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <label for="nombreTipo" class="form-label">Nombre de la serie</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="valorSerie" name="valorSerie" placeholder="Nombre" data-type="3" data-min="3" data-max="60" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
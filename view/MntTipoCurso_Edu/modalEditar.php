<div id="editar-tipoCurso-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tipo de Alojamiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editar tipo de Alojamiento</h5>
                        <form id="editar-tipoCurso" method="POST">
                            <input type="hidden" name="id-tipocursoE" id="id-tipocursoE" value="">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Nombre</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="descripcion-TipoE" name="descripcion-TipoE" placeholder="Nombre" data-type="3" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Código</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="codigo-TipoE" name="codigo-TipoE" placeholder="Nombre" data-type="3" data-min="1" data-max="3" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Min. Alumnos</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="number" class="form-control" id="minAlum-TipoE" name="minAlum-TipoE" placeholder="Nombre" value="1" data-type="3" data-min="1" data-max="2" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nombreTipo" class="form-label">Max. Alumnos</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="number" class="form-control" id="maxAlum-TipoE" name="maxAlum-TipoE" placeholder="Nombre" value="2" data-type="3" data-min="1" data-max="2" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div> -->
                                <div class="col-12 col-lg-12">
                                    <label for="nombreTipo" class="form-label">Observación</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <textarea class="autoArea form-control" id="text-TipoE" name="text-TipoE" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="1" data-required="0"></textarea>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
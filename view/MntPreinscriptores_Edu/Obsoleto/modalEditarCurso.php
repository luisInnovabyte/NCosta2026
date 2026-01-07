<div id="editar-tipoCurso-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editar Curso</h5>
                        <form id="editarCurso" method="POST">
                            <div class="row g-3">
                                <div class="col-12 col-lg-12">
                                    
                                    <label for="nombreTipo" class="form-label">Nombre Curso</label>
                                    <div class="position-relative input-icon">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                        <input type="text" class="form-control" id="nombreCursoE" name="nombreCursoE" placeholder="Nombre" data-type="0" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElementoCurso()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
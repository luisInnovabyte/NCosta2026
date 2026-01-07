 <!-- ============================================================== -->
            <!------------------- MODAL EDITAR AULAS   --------------------------->
            <!-- ============================================================== -->
            
            <style>
                /* Estilos para checkboxes - Asegurar visibilidad */
                #editar-aula-modal .form-check-input {
                    width: 1.25em;
                    height: 1.25em;
                    margin-top: 0.125em;
                    cursor: pointer;
                    background-color: #fff !important;
                    border: 1px solid #dee2e6 !important;
                }
                #editar-aula-modal .form-check-input:checked {
                    background-color: #0d6efd !important;
                    border-color: #0d6efd !important;
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e") !important;
                }
                #editar-aula-modal .form-check-input:focus {
                    border-color: #86b7fe !important;
                    outline: 0 !important;
                    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
                }
                #editar-aula-modal .form-check-label {
                    cursor: pointer;
                    user-select: none;
                }
            </style>

            <div id="editar-aula-modal" class="modal fade" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-warning bg-gradient text-dark py-3">
                            <h5 class="modal-title d-flex align-items-center gap-2">
                                <i class="bi bi-pencil-square"></i> Editar Aula
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form id="formAulaEditar" method="POST">
                                <input type="hidden" class="form-control" name="idAulaE" id="idAulaE">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-6">
                                        <label for="descrAulaE" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-door-open me-1"></i> Nombre del Aula <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-door-open text-warning"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0" name="descrAulaE" id="descrAulaE" placeholder="Ej: Aula A1" data-type="3" data-min="2" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="localizacionE" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-geo-alt me-1"></i> Localización <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-geo-alt text-warning"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0" id="localizacionE" name="localizacionE" placeholder="Ej: Edificio B, Planta 2" data-type="13" data-min="2" data-max="100" data-new-input="1" data-descripcion="1" data-required="1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="capaAulaE" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-people me-1"></i> Capacidad <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-people text-warning"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0" id="capaAulaE" name="capaAulaE" value="1" placeholder="Número de personas" data-type="5" data-min="1" data-max="999" data-new-input="1" data-descripcion="1" data-required="1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-check2-square me-1"></i> Características
                                        </label>
                                        <div class="d-flex flex-wrap align-items-center gap-3 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="flexCheckHibridoE" name="hibridoE">
                                                <label class="form-check-label" for="flexCheckHibridoE">Híbrido</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="flexCheckKidsE" name="kidsE">
                                                <label class="form-check-label" for="flexCheckKidsE">Kids</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="flexCheckParaliticosE" name="paraliticosE">
                                                <label class="form-check-label" for="flexCheckParaliticosE">Paralíticos</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="flexCheckAgorafobiaE" name="agorafobiaE">
                                                <label class="form-check-label" for="flexCheckAgorafobiaE">Agorafobia</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="textAulaE" class="form-label fw-semibold text-secondary">
                                            <i class="bi bi-card-text me-1"></i> Descripción
                                        </label>
                                        <textarea id="textAulaE" name="textAulaE" class="form-control" rows="4" placeholder="Descripción adicional del aula..."></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light border-top-0 py-3">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" title="Cerrar">
                                <i class="bi bi-x-lg me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-warning px-4" title="Actualizar" form="formAulaEditar">
                                <i class="bi bi-check-lg me-1"></i> Actualizar
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
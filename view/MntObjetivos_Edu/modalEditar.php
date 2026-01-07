<div id="editar-objetivos-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Objetivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="col-12 col-lg-12 mg-sm-b-10">
                        <input type="hidden" id="contenidoSelected">
                            <div class="input-group custom-input-group">
                            <textarea class="autoArea form-control" id="contenido1" rows="1" placeholder="Saludar y despedirse en español..." data-type="3" data-min="0" data-max="300" data-new-input="0" data-descripcion="1" data-required = "1" style="min-inline-size: auto !important"></textarea>

                            </div>


                        </div><!-- input-group -->

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="editarObjetivoGuardar()" id="newConceptos" class="btn btn-info">Editar Objetivo</button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>

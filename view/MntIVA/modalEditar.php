<div id="editar-iva-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar IVA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        
                    <input type="hidden" id="idIvaHidden">
                    <div class="row mg-t-20 centrar_contenido">

                        <div class="form-group col-12 col-lg-12">
                            <label class="control-label">Valor</label>
                            <input type="number" class="form-control" data-type="5" data-min="1" data-max="2" id="valorIvaE" data-required="1" placeholder="" autocomplete="off">
                            <!-- Resto de los campos y mensajes de validación aquí -->
                        </div>

                        <div class="form-group col-12 col-lg-12">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control" data-type="3" data-min="2" data-max="150" autocomplete="off" data-required="1" id="descrIvaE" placeholder="">
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onclick="editarIva()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
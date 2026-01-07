<!-- ============================================================== -->
<!-- MODAL AYUDA DEL DATATABLES -->
<!-- ============================================================== -->
<div id="editar-visitas-modal" class="modal fade">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Visitante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
      </div>
      <div class="modal-body">

        <form id="editar-visitas-form" method="POST">
          <div class="row">
            <div class="form-group col-12 col-lg-6">
              <input type="hidden" id="idVis" name="idVis" value="">
              <label for="quienAlojaVis" class="control-label">Nombre:</label>
              <input type="text" class="form-control" id="quienAlojaVis" name="quienAlojaVis" minlength="2" maxlength="70" required>
              <div class="row">
                <span id="infoquienAlojaVis" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Solo letras</span>
                <span id="lonquienAlojaVis" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
              </div>
            </div>
            <div class="form-group col-12 col-lg-6">
              <label for="fechaAlojaVis" class="control-label">Fecha de visita:</label>
              <input type="date" class="form-control" id="fechaAlojaVis" name="fechaAlojaVis" required>
            </div>
          </div>
          <div class="col-md-12 mt-3">
            <label for="descrImpreAloja" class="control-label">Observaciones:</label>
            <textarea class="form-control" id="descrImpreAloja" name="descrImpreAloja"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark waves-effect" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success waves-effect waves-light" id="guardar-btn">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

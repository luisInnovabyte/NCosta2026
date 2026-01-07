<!-- Modal para añadir clase -->
<div id="modalFechaSeleccionada" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <div>
          <h5 id="modal-titlehorario" class="modal-title">Añadir Horario</h5>
          <p id="fechaSeleccionadaTexto" class="text-muted mb-0"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="eventForm">
          <h4 class="fw-bold mb-2 text-center">ESIGA21(1)202504082</h4> <!-- Título centrado y negrita -->
          <input type="hidden" class="form-control" id="codClase" name="codClase">
          <input type="hidden" class="form-control" id="fecIni" name="fecIni">
          <input type="hidden" class="form-control" id="horaIni" name="horaIni">

          <input type="hidden" id="startDate">
          <input type="hidden" id="idHorario">

          <div class="mb-3">
            <label class="form-label">Profesor</label>
            <select id="selectProfesores" class="form-select">
              <option value="">Seleccione un profesor</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Aula - 🖥️ Híbrido / 🧒 Kids /  ♿ Aula Adaptada / 🧠 Fobia</label>
            <select id="selectAulas" class="form-select">
              <option value="">Seleccione un aula</option>
            </select>          
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Hora de fin</label>
            <input type="time" class="form-control" id="horaFin" required>
          </div>

          <div id="contenedor-checkboxes" class="container mg-b-20"></div>

          <button type="submit" class="btn btn-primary noeditar">Añadir horario</button>
          <button type="button" onclick="editarHorario()" class="btn btn-warning editar d-none">Editar horario</button> 
          <button type="button" onclick="eliminarEvento()" class="btn btn-danger editar d-none">Eliminar</button>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div> <!-- cierre modal-content -->
  </div> <!-- cierre modal-dialog -->
</div> <!-- cierre modalFechaSeleccionada -->

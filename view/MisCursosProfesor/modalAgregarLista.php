<div id="gestionarLista" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Información Diaria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body p-4">
            <form id="insertar-lista-form" method="POST">
              <div class="row g-3">
               <!-- Alumno -->
                <div class="col-md-12 text-center">
                    <b id="avatar"></b>
                    <p id="nombreAlumno" class="fs-5 fw-semibold text-dark"></p>
                    <input type="hidden" id="idAlumnoSelect">
                    <input type="hidden" id="idLlegadaSelect">

                  </div>

                <!-- Fecha y hora -->
                <div class="col-md-6">
                  <label class="form-label">Fecha:</label>
                  <input type="date" class="form-control" value="<?php echo $diaInicio_horario?>" readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Horario:</label>
                  <input type="text" class="form-control" 
                  value="<?php echo date('H:i', strtotime($horaInicio_horario)) . ' - ' . date('H:i', strtotime($horaFin_horario)); ?>" 
                  readonly>

                </div>
                <input type="hidden" id="idLista">
               
                <!-- Asistencia -->
                <div class="col-md-12">
                  <label class="form-label">Asistencia:</label>
                  <div class="attendance-menu">
                    <button type="button" class="attendance-btn" data-value="0">⏳<span> Sin Registrar</span></button>
                    <button type="button" class="attendance-btn" data-value="1">✅<span> Presente</span></button>
                    <button type="button" class="attendance-btn" data-value="2">❌<span> Ausente</span></button>
                    <button type="button" class="attendance-btn" data-value="3">⏰<span> Llegó Tarde</span></button>
                    <button type="button" class="attendance-btn" data-value="4">📄<span> Justificado</span></button>
                    <input type="hidden" name="asistenciaIn" id="asistenciaIn" value="0">

                  </div>

                </div>
                <div id="horaLlegadaDiv" class="col-md-12 d-none">
                  <label class="form-label">Hora Llegada:</label>
                  <input id="horas_llegada" type="time" class="form-control" name="horas_llegada">
                </div>
                <!-- Horas asistencia -->
                <div id="horasAsistidasDiv" class="col-md-12 d-none">
                  <label class="form-label">Horas Asistencia:</label>
                  <input type="time" class="form-control" name="horas_asistencia">
                </div>
              
                <!-- Motivo -->
                <div id="motivoDiv" class="col-md-12 d-none">
                  <label class="form-label">Motivo de Ausencia:</label>
                  <textarea class="form-control" id="motivoRetraso" name="motivo" rows="2"></textarea>
                </div>

                <!-- Tareas realizadas -->
                <div id="tareasDiv" class="col-md-12 d-none">
                  <label class="form-label">Tareas Realizadas:</label>
                  <input type="number" class="form-control" id="tareas" name="tareas_realizadas">
                </div>

                <!-- Observaciones -->
                <div class="col-md-12">
                  <label class="form-label">Observacion diaria:</label>
                  <textarea class="form-control" id="obsDiaria" name="observaciones" rows="2"></textarea>
                </div>

                <!-- Tarea para hoy -->
                <!-- Tarea para hoy -->
                <div class="col-md-12">
                  <div class="border-start border-4 border-success ps-3 mb-3">
                    <label for="tareaAlumno" class="form-label fw-semibold text-success">📝 Tarea para el alumno:</label>
                    <textarea class="form-control" id="tareaAlumno" name="tareaAlumno" rows="3"></textarea>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
        <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarEditarElemento()">Aceptar</button>
      </div>
    </div>
  </div>
</div>

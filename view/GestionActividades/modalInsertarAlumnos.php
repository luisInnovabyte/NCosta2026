<style>
            /* SWITCH */
/* From Uiverse.io by cbolson */ 
.switch {
  --_switch-bg-clr: #70a9c5;
  --_switch-padding: 2px; /* antes: 4px */
  --_slider-bg-clr: rgba(12, 74, 110, 0.65);
  --_slider-bg-clr-on: rgba(12, 74, 110, 1);
  --_slider-txt-clr: #ffffff;
  --_label-padding: 0.4rem 0.8rem; /* antes: 1rem 2rem */
  --_switch-easing: cubic-bezier(0.47, 1.64, 0.41, 0.8);
  color: white;
  width: fit-content;
  display: flex;
  justify-content: center;
  border-radius: 9999px;
  cursor: pointer;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  position: relative;
  isolation: isolate;
}

.switch input[type="checkbox"] {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.switch > span {
  display: grid;
  place-content: center;
  transition: opacity 300ms ease-in-out 150ms;
  padding: var(--_label-padding);
}
.switch::before,
.switch::after {
  content: "";
  position: absolute;
  border-radius: inherit;
  transition: inset 150ms ease-in-out;
}
/* switch slider */
.switch::before {
  background-color: var(--_slider-bg-clr);
  inset: var(--_switch-padding) 50% var(--_switch-padding)
    var(--_switch-padding);
  transition:
    inset 500ms var(--_switch-easing),
    background-color 500ms ease-in-out;
  z-index: -1;
  box-shadow:
    inset 0 1px 1px rgba(0, 0, 0, 0.3),
    0 1px rgba(255, 255, 255, 0.3);
}
/* switch bg color */
.switch::after {
  background-color: var(--_switch-bg-clr);
  inset: 0;
  z-index: -2;
}
/* switch hover & focus */
.switch:focus-within::after {
  inset: -0.25rem;
}
.switch:has(input:checked):hover > span:first-of-type,
.switch:has(input:not(:checked)):hover > span:last-of-type {
  opacity: 1;
  transition-delay: 0ms;
  transition-duration: 100ms;
}
/* switch hover */
.switch:has(input:checked):hover::before {
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    45%;
}
.switch:has(input:not(:checked)):hover::before {
  inset: var(--_switch-padding) 45% var(--_switch-padding)
    var(--_switch-padding);
}
/* checked - move slider to right */
.switch:has(input:checked)::before {
  background-color: var(--_slider-bg-clr-on);
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    50%;
}
/* checked - set opacity */
.switch > span:last-of-type,
.switch > input:checked + span:first-of-type {
  opacity: 0.75;
}
.switch > input:checked ~ span:last-of-type {
  opacity: 1;
}

.alumno-inscrito {
  background-color:rgb(218, 7, 7) !important;
}

.disabled-row {
  opacity: 0.4;
}

</style>
<div id="insertar-alumno-modal" class="modal fade"> 
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir Alumno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <h5 class="mb-4">Se mostrarán los alumnos para añadir a la actividad</h5>
              <small>Solo se mostrarán aquellos alumnos registrados, que tengan una llegada activa por el departamento disponible de la actividad.</small>
              <div id="mensaje-horas-lectivas" class="mt-2 fw-bold"></div>
            </div>

              <input type="hidden" name="idAct" id="idAct" value="<?php echo $_GET['idAct'] ?>">
              <input type="hidden" name="alumnoMatriculado" id="alumnoMatriculado" value="0">

              <!-- Switch Alumno Matriculado -->
              <div class="card shadow-sm border-0 mb-4">
                <div class="card-body bg-light rounded">
                  <div class="row g-3">
                    <div class="col-md-12 d-flex flex-column align-items-center text-center mt-4">
                      <label class="form-label">Tipo de Alumno</label>
                      <div class="d-flex justify-content-center">
                        <label for="matriculadoSwitch" class="switch my-2" aria-label="Toggle Matriculado">
                          <input type="checkbox" id="matriculadoSwitch" name="matriculadoSwitch"/>
                          <span checked>Con Matricula</span>
                          <span>Sin Matricula</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del switch -->

              <!-- Tabla si SÍ está matriculado (visible inicialmente) -->
              <div id="tablaLlegadasMatriculados">
                <?php
                $nombreTabla = "tablaMatriculados";
                $nombreCampos = [
                    "Id Llegada",
                    "Usuario - Nombre Completo",
                    "Edad",
                    "Correo - Teléfono",
                    "Fecha inicio matrícula",
                    "Fecha fin matrícula",
                    "Id Usuario",  // <-- Añadido para la nueva columna
                    "Inscripción"
                    
                ];
                echo generarTabla($nombreTabla, $nombreCampos, $nombreCampos, 0, [], 0, "#3AB54A", 0, 0);
                ?>
              </div>

              <!-- Tabla si NO está matriculado (oculta inicialmente) -->
              <div id="tablaAlumnosNoMatriculados" class="d-none">
                <?php
                $nombreTabla = "tablaNoMatriculados";
                $nombreCampos = ["Id Alumno", "Nickname - Nombre", "Edad", "Correo - Teléfono", "Id Usuario", "Inscripción"];
                echo generarTabla($nombreTabla, $nombreCampos, $nombreCampos, 0, [], 0, "#0d6efd", 0, 0);
                ?>
              </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =============================================================== -->
<!-- MODAL CONFIGURAR CERTIFICADO DEL ALUMNO -->
<!-- =============================================================== -->
<!--******** ESTE MODAL ES IGUAL QUE EL DE MODAL CERTIFICADO, CON LA DIFERENCIA QUE ESTE ESTA PENSADO PARA IMPRIMIR EL CURSO SELECCIONADO *******-->
<div id="modalCertificadoAlumno" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Configurar Certificado del Alumno</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <!-- Tarjeta de información del alumno -->
        <div class="card">
          <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-primary">Información del Alumno</h6>
          </div>

          <div class="card-body">
            <form>
              <!-- Primera fila: 3 inputs -->
              <div class="row g-3">
                <div class="col-12 col-lg-4">
                  <label for="certAlumno_horasReales" class="form-label">Horas reales</label>
                  <input type="text" disabled class="form-control" id="certAlumno_horasReales" name="certAlumno_horasReales" value="00:50:00" readonly>
                </div>

                <div class="col-12 col-lg-4">
                  <label for="certAlumno_horasJustificadas" class="form-label">Horas justificadas</label>
                  <input type="text" disabled class="form-control" id="certAlumno_horasJustificadas" name="certAlumno_horasJustificadas" value="00:00:00" readonly>
                </div>

                <div class="col-12 col-lg-4">
                  <label for="certAlumno_horasRj" class="form-label">Horas reales - justificadas</label>
                  <input type="text" disabled class="form-control" id="certAlumno_horasRj" name="certAlumno_horasRj" value="00:50:00" readonly>
                </div>
              </div>

              <!-- Segunda fila: minutos certificado, jornada clase, resultado texto, resultado select, checkbox -->
              <div class="row g-3 mt-3 justify-content-center align-items-center">

                <div class="col-12 col-lg-2">
                  <label for="certAlumno_minutosCertificado" class="form-label">Minutos certificado</label>
                  <input type="text" class="form-control" id="certAlumno_minutosCertificado" name="certAlumno_minutosCertificado">
                </div>

                <div class="col-12 col-lg-2">
                  <label for="certAlumno_jornadaClase" class="form-label">Jornada Clase</label>
                  <input type="text" class="form-control" id="certAlumno_jornadaClase" name="certAlumno_jornadaClase">
                </div>

                <div class="col-12 col-lg-2">
                  <label class="form-label">Resultado (texto)</label>
                  <div id="certAlumno_resultadoTexto" class="form-control" style="background-color: #e9ecef; min-height: 38px; padding: 6px 12px;"></div>
                </div>

                <div class="col-12 col-lg-2">
                  <label for="certAlumno_resultadoEvaluacion" class="form-label">Resultado</label>
                  <select class="form-select" id="certAlumno_resultadoEvaluacion" name="certAlumno_resultadoEvaluacion">
                    <option value="" selected disabled>Seleccione un resultado</option>
                    <option value="0">Sin Evaluar</option>
                    <option value="1">Aprobado</option>
                    <option value="2">Suspendido</option>
                    <option value="3">Cancelado</option>
                  </select>
                </div>

                <div class="col-12 col-lg-2 d-flex align-items-center pt-4">
                  <label for="certAlumno_mostrarCertificado" class="form-label mb-0 me-2">Mostrar certificado</label>
                  <div class="check-online">
                    <input type="checkbox" id="certAlumno_mostrarCertificado" name="certAlumno_mostrarCertificado" class="yep">
                    <label for="certAlumno_mostrarCertificado"></label>
                  </div>
                </div>

                <input type="hidden" id="certAlumno_idCertificado" name="certAlumno_idCertificado" value="">
                <input type="hidden" id="certAlumno_codigoGrupo" name="certAlumno_codigoGrupo" value="">
              </div>

              <!-- Tercera fila: texto largo -->
              <div class="row g-3 mt-3">
                <div class="col-12">
                  <label for="certAlumno_observacionesCertificado" class="form-label">Observaciones / Texto largo</label>
                  <textarea class="form-control" id="certAlumno_observacionesCertificado" name="certAlumno_observacionesCertificado" rows="4" placeholder="Escriba aquí..."></textarea>
                </div>
              </div>

            </form>
          </div>
        </div> <!-- Fin card -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="certAlumno_btnGuardarCambios">Guardar cambios</button>
        <button type="button" class="btn btn-success" id="certAlumno_generarCertificado">Generar Certificado</button>
      </div>
    </div>
  </div>
</div>

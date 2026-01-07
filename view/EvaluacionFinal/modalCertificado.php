<!-- ============================================================== -->
<!-- MODAL CERTIFICADO DEL ALUMNO -->
<!-- ============================================================== -->
<div id="mostrarModalCertificado" class="modal fade" tabindex="-1">
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
                  <label for="horasReales" class="form-label">Horas reales</label>
                  <input type="text" disabled class="form-control" id="horasReales" name="horasReales" value="00:50:00" readonly>
                </div>

                <div class="col-12 col-lg-4">
                  <label for="horasJustificadas" class="form-label">Horas justificadas</label>
                  <input type="text" disabled class="form-control" id="horasJustificadas" name="horasJustificadas" value="00:00:00" readonly>
                </div>

                <div class="col-12 col-lg-4">
                  <label for="horasRj" class="form-label">Horas reales - justificadas</label>
                  <input type="text" disabled class="form-control" id="horasRj" name="horasRj" value="00:50:00" readonly>
                </div>
              </div>

            <!-- Segunda fila: horas totales, nuevos campos, checkbox y resultado -->
            <div class="row g-3 mt-3 justify-content-center align-items-center">

              <div class="col-12 col-lg-2">
                <label for="minutosCertificado" class="form-label">Minutos certificado</label>
                <input type="text" class="form-control" id="minutosCertificado" name="minutosCertificado">
              </div>

              <div class="col-12 col-lg-2">
                <label for="jornadaClase" class="form-label">Jornada Clase</label>
                <input type="text" class="form-control" id="jornadaClase" name="jornadaClase">
              </div>

              <div class="col-12 col-lg-2">
                <label class="form-label">Resultado (texto)</label>
                <div id="resultadoTexto" class="form-control" style="background-color: #e9ecef; min-height: 38px; padding: 6px 12px;"></div>
              </div>


              <div class="col-12 col-lg-2">
                <label for="resultadoEvaluacion" class="form-label">Resultado</label>
                <select class="form-select" id="resultadoEvaluacion" name="resultadoEvaluacion">
                  <option value="" selected disabled>Seleccione un resultado</option>
                  <option value="0">Sin Evaluar</option>
                  <option value="1">Aprobado</option>
                  <option value="2">Suspendido</option>
                  <option value="3">Cancelado</option>
                </select>
              </div>

              <div class="col-12 col-lg-2 d-flex align-items-center pt-4">
                <label for="mostrarCertificado" class="form-label mb-0 me-2">Mostrar certificado</label>
                <div class="check-online">
                  <input type="checkbox" id="mostrarCertificado" name="mostrarCertificado" class="yep">
                  <label for="mostrarCertificado"></label>
                </div>
              </div>

              <input type="hidden" id="idCertificadoG" name="idCertificado" value="">
            </div>


              <!-- Tercera fila: campo de texto largo (con contador añadido) -->
              <div class="row g-3 mt-3">
                <div class="col-12">
                  <label for="observacionesCertificado" class="form-label">Observaciones / Texto largo</label>
                  <textarea class="form-control" id="observacionesCertificado" name="observacionesCertificado" rows="4" placeholder="Escriba aquí..."></textarea>
                  <!-- Contador de caracteres añadido aquí -->
                  <div id="contador-caracteres" style="color: #666; font-size: 0.875rem; text-align: right; margin-top: 5px;">0/100</div>
                </div>
              </div>

            </form>
          </div>
        </div> <!-- Fin card -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCertificadoCompleto">Guardar cambios</button>
        <button type="button" class="btn btn-success" id="generarCertificado">Generar Certificado</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalAyudaAlertasCriticas" tabindex="-1" aria-labelledby="modalAyudaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAyudaLabel">
                    <i class="bi bi-question-circle me-2"></i>Ayuda - Listado de Transfers
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6><i class="bi bi-info-circle me-2"></i>Información General</h6>
                <p>Este módulo permite gestionar y visualizar los transfers de llegadas de alumnos programados.</p>
                
                <h6 class="mt-3"><i class="bi bi-calendar-check me-2"></i>Filtros por Fecha</h6>
                <div class="alert alert-info">
                    <p class="mb-2"><strong>Filtro Automático:</strong></p>
                    <p class="mb-2">Al cargar la página, el sistema aplica automáticamente un filtro que muestra únicamente los transfers <strong>desde hoy en adelante</strong> (hasta el 31/12/2099).</p>
                    <p class="mb-0"><strong>Personalizar el periodo:</strong></p>
                    <ul class="mb-0">
                        <li>Puede modificar las <strong>fechas "Desde"</strong> y <strong>"Hasta"</strong> en el acordeón de filtros</li>
                        <li>Haga clic en <strong>"Aplicar Filtro"</strong> para ver los transfers del periodo seleccionado</li>
                        <li>Use el botón <strong>"Limpiar"</strong> para eliminar los filtros de fecha y ver todos los registros</li>
                    </ul>
                </div>
                
                <h6 class="mt-3"><i class="bi bi-funnel me-2"></i>Clasificaciones de Urgencia</h6>
                <p>Los transfers se clasifican automáticamente según su proximidad:</p>
                <ul>
                    <li><strong>HOY:</strong> Transfers programados para hoy</li>
                    <li><strong>MAÑANA:</strong> Transfers para mañana</li>
                    <li><strong>PRÓXIMO:</strong> En los próximos 3 días</li>
                    <li><strong>ESTA SEMANA:</strong> En los próximos 7 días</li>
                    <li><strong>FUTURO:</strong> Más adelante</li>
                    <li><strong>PASADO:</strong> Transfers ya realizados</li>
                </ul>
                
                <h6 class="mt-3"><i class="bi bi-search me-2"></i>Búsqueda Avanzada</h6>
                <p>Use los campos de búsqueda al pie de cada columna para filtrar información específica de departamentos, lugares, grupos, etc.</p>
                
                <h6 class="mt-3"><i class="bi bi-eye me-2"></i>Detalles Expandibles</h6>
                <p>Haga clic en el icono <strong>+</strong> de la primera columna para ver información detallada del transfer, incluyendo datos de contacto del prescriptor, grupo, departamento y agente asignado.</p>
                
                <h6 class="mt-3"><i class="bi bi-printer me-2"></i>Generar Listado</h6>
                <p>El botón "Generar Listado" abre una página simple en formato A4 con todos los transfers en una tabla clara y legible, perfecta para impresión o distribución.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

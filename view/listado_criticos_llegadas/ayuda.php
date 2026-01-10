<!-- Modal de Ayuda - Alertas Críticas de Pago -->
<div class="modal fade" id="modalAyudaAlertasCriticas" tabindex="-1" aria-labelledby="modalAyudaAlertasCriticasLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalAyudaAlertasCriticasLabel">
                    <i class="bi bi-question-circle-fill me-2"></i>Ayuda - Alertas Críticas de Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- Propósito del Módulo -->
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Propósito del Módulo</h5>
                    <p class="mb-0">
                        Este módulo presenta un <strong>listado de llegadas con pagos pendientes</strong> clasificadas por nivel de urgencia. 
                        Su objetivo es proporcionar una vista centralizada de todas las llegadas que requieren seguimiento de pago antes del inicio del curso, 
                        permitiendo una gestión proactiva de la cobranza y evitando situaciones de impago.
                    </p>
                </div>

                <!-- Qué encontrará el usuario -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-eye me-2"></i>¿Qué encontrará en este listado?</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong><i class="bi bi-person me-2"></i>Información del Prescriptor:</strong>
                            Nombre completo, datos de contacto (email, teléfono, móvil), país y nacionalidad.
                        </li>
                        <li class="list-group-item">
                            <strong><i class="bi bi-calendar-event me-2"></i>Fechas y Plazos:</strong>
                            Fecha de inicio del curso y días restantes hasta el inicio (negativos si el curso ya comenzó).
                        </li>
                        <li class="list-group-item">
                            <strong><i class="bi bi-exclamation-triangle me-2"></i>Nivel de Alerta:</strong>
                            Clasificación automática según urgencia: VENCIDO, CRÍTICO, URGENTE, IMPORTANTE, AVISO o NORMAL.
                        </li>
                        <li class="list-group-item">
                            <strong><i class="bi bi-cash-stack me-2"></i>Información Financiera:</strong>
                            Total general, pagos realizados, monto pendiente, porcentaje pagado y desglose por conceptos (matriculaciones, alojamientos, suplidos).
                        </li>
                        <li class="list-group-item">
                            <strong><i class="bi bi-building me-2"></i>Asignación Comercial:</strong>
                            Departamento y agente comercial responsable de la llegada.
                        </li>
                    </ul>
                </section>

                <!-- Niveles de Alerta -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-flag me-2"></i>Niveles de Alerta</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nivel</th>
                                    <th>Color</th>
                                    <th>Criterio</th>
                                    <th>Acción Recomendada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge" style="background: #8B0000; color: white;">VENCIDO</span></td>
                                    <td>Rojo Oscuro</td>
                                    <td>Curso ya iniciado con pago pendiente</td>
                                    <td><strong>Acción inmediata:</strong> Contacto urgente con el prescriptor</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background: #DC143C; color: white;">CRÍTICO</span></td>
                                    <td>Rojo Brillante</td>
                                    <td>3 días o menos hasta el inicio</td>
                                    <td><strong>Alta prioridad:</strong> Seguimiento intensivo diario</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background: #FF4500; color: white;">URGENTE</span></td>
                                    <td>Naranja Rojizo</td>
                                    <td>4-7 días hasta el inicio</td>
                                    <td><strong>Prioridad:</strong> Contacto y recordatorios frecuentes</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background: #FFA500; color: white;">IMPORTANTE</span></td>
                                    <td>Naranja</td>
                                    <td>8-15 días hasta el inicio</td>
                                    <td><strong>Seguimiento:</strong> Recordatorios periódicos</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background: #FFD700; color: #333;">AVISO</span></td>
                                    <td>Amarillo</td>
                                    <td>16-30 días hasta el inicio</td>
                                    <td><strong>Monitoreo:</strong> Seguimiento regular programado</td>
                                </tr>
                                <tr>
                                    <td><span class="badge" style="background: #32CD32; color: white;">NORMAL</span></td>
                                    <td>Verde</td>
                                    <td>Más de 30 días hasta el inicio</td>
                                    <td><strong>Seguimiento estándar</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Funcionalidades del Listado -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-gear me-2"></i>Funcionalidades Disponibles</h5>
                    <div class="accordion" id="accordionFuncionalidades">
                        
                        <!-- Expandir Detalles -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDetalles">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetalles">
                                    <i class="bi bi-chevron-down me-2"></i>Ver Detalles Completos
                                </button>
                            </h2>
                            <div id="collapseDetalles" class="accordion-collapse collapse" data-bs-parent="#accordionFuncionalidades">
                                <div class="accordion-body">
                                    Haga clic en la <strong>primera columna</strong> (flecha) de cualquier fila para expandir y ver:
                                    <ul>
                                        <li>Mensaje descriptivo de la alerta</li>
                                        <li>Datos completos de contacto del prescriptor</li>
                                        <li>Desglose financiero detallado por conceptos</li>
                                        <li>Clasificación del monto pendiente</li>
                                        <li>Score de urgencia calculado</li>
                                        <li>Fechas de creación y actualización</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFiltros">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltros">
                                    <i class="bi bi-funnel me-2"></i>Sistema de Filtros
                                </button>
                            </h2>
                            <div id="collapseFiltros" class="accordion-collapse collapse" data-bs-parent="#accordionFuncionalidades">
                                <div class="accordion-body">
                                    <strong>Filtros Rápidos (Acordeón):</strong>
                                    <p>Use los botones de nivel de alerta en el acordeón superior para filtrar rápidamente por: Todos, Vencidos, Críticos, Urgentes, Importantes o Avisos.</p>
                                    
                                    <strong>Filtros por Columna (Footer):</strong>
                                    <p>Cada columna tiene su propio campo de búsqueda en el pie de la tabla:</p>
                                    <ul>
                                        <li><strong>Campos de texto:</strong> Búsqueda parcial (encuentra coincidencias en cualquier parte)</li>
                                        <li><strong>Select de Nivel:</strong> Búsqueda exacta por nivel específico</li>
                                        <li>Los filtros se pueden combinar para búsquedas más precisas</li>
                                    </ul>
                                    
                                    <strong>Limpiar Filtros:</strong>
                                    <p>Cuando hay filtros activos, aparece un botón naranja "Limpiar filtros" para resetear todas las búsquedas.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ordenamiento -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOrden">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrden">
                                    <i class="bi bi-sort-down me-2"></i>Ordenamiento
                                </button>
                            </h2>
                            <div id="collapseOrden" class="accordion-collapse collapse" data-bs-parent="#accordionFuncionalidades">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Haga clic en cualquier <strong>encabezado de columna</strong> para ordenar</li>
                                        <li>Por defecto, la tabla se ordena por <strong>"Días hasta inicio"</strong> (ascendente), mostrando primero los más urgentes</li>
                                        <li>Clic adicional invierte el orden (ascendente ↔ descendente)</li>
                                        <li>Las columnas ordenables muestran flechas indicadoras</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPaginacion">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaginacion">
                                    <i class="bi bi-files me-2"></i>Navegación y Paginación
                                </button>
                            </h2>
                            <div id="collapsePaginacion" class="accordion-collapse collapse" data-bs-parent="#accordionFuncionalidades">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Por defecto se muestran <strong>25 registros por página</strong></li>
                                        <li>Use las flechas en la parte inferior para navegar entre páginas</li>
                                        <li>El contador muestra cuántos registros se están visualizando del total</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Recomendaciones de Uso -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-lightbulb me-2"></i>Recomendaciones de Uso</h5>
                    <div class="alert alert-success">
                        <ul class="mb-0">
                            <li><strong>Revisión diaria:</strong> Consulte este listado al inicio de cada jornada laboral</li>
                            <li><strong>Priorización:</strong> Atienda primero los casos VENCIDOS y CRÍTICOS</li>
                            <li><strong>Documentación:</strong> Registre todas las gestiones de cobro realizadas</li>
                            <li><strong>Comunicación proactiva:</strong> Contacte a los prescriptores antes de que el nivel suba de urgencia</li>
                            <li><strong>Seguimiento:</strong> Use los datos de contacto proporcionados para recordatorios oportunos</li>
                            <li><strong>Coordinación:</strong> Informe a su jefe de departamento sobre casos críticos que requieran intervención</li>
                        </ul>
                    </div>
                </section>

                <!-- Clasificación de Montos -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-coin me-2"></i>Clasificación por Monto Pendiente</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Alto monto:</strong> Más de 5.000 €</li>
                        <li class="list-group-item"><strong>Monto medio:</strong> Entre 2.000 € y 5.000 €</li>
                        <li class="list-group-item"><strong>Monto bajo:</strong> Entre 500 € y 2.000 €</li>
                        <li class="list-group-item"><strong>Monto mínimo:</strong> Menos de 500 €</li>
                    </ul>
                </section>

                <!-- Alcance del Sistema -->
                <section class="mb-4">
                    <h5 class="text-primary"><i class="bi bi-bookmark-check me-2"></i>Alcance del Sistema</h5>
                    <div class="alert alert-warning">
                        <p class="mb-2"><strong>Este listado incluye automáticamente:</strong></p>
                        <ul class="mb-2">
                            <li>Llegadas con pago pendiente mayor a 0 €</li>
                            <li>Cursos que inicien en los próximos 45 días (o ya iniciados con pago pendiente)</li>
                            <li>Llegadas activas (excluye canceladas)</li>
                        </ul>
                        <p class="mb-0"><strong>No incluye:</strong> Llegadas completamente pagadas, canceladas o con inicio superior a 45 días.</p>
                    </div>
                </section>

                <!-- Nota Técnica -->
                <section class="mb-0">
                    <div class="alert alert-secondary">
                        <h6 class="alert-heading"><i class="bi bi-code-slash me-2"></i>Nota Técnica</h6>
                        <p class="mb-2">
                            <strong>Vista de Base de Datos:</strong> Este listado obtiene su información de la vista SQL 
                            <code>view_llegadas_alertas_pago</code>, que consolida datos de llegadas, matriculaciones, alojamientos, 
                            pagos y prescriptores.
                        </p>
                        <p class="mb-0">
                            <strong>Actualización:</strong> Los datos se cargan dinámicamente desde el servidor y se actualizan 
                            automáticamente al aplicar filtros u ordenamientos. Para ver cambios recientes en la base de datos, 
                            recargue la página.
                        </p>
                    </div>
                </section>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

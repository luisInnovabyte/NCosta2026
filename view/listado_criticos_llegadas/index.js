$(document).ready(function () {

    /////////////////////////////////////
    //     CONFIGURACIÓN DATATABLES    //
    ///////////////////////////////////
    
    var datatable_alertasConfig = {
        processing: true,
        layout: {
            bottomEnd: {
                paging: {
                    firstLast: true,
                    numbers: false,
                    previousNext: true
                }
            }
        },
        language: {
            paginate: {
                first: '<i class="bi bi-chevron-double-left"></i>',
                last: '<i class="bi bi-chevron-double-right"></i>',
                previous: '<i class="bi bi-chevron-compact-left"></i>',
                next: '<i class="bi bi-chevron-compact-right"></i>'
            },
            emptyTable: "No hay alertas críticas en este momento",
            info: "Mostrando _START_ a _END_ de _TOTAL_ alertas",
            infoEmpty: "Mostrando 0 a 0 de 0 alertas",
            infoFiltered: "(filtrado de _MAX_ alertas totales)",
            lengthMenu: "Mostrar _MENU_ alertas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron alertas coincidentes"
        },
        columns: [
            // Columna 0: Control para expandir detalles
            { 
                name: 'control', 
                data: null, 
                defaultContent: '', 
                className: 'details-control sorting_1 text-center' 
            },
            // Columna 1: ID Llegada
            { 
                name: 'id_llegada', 
                data: 'id_llegada', 
                className: "text-center align-middle" 
            },
            // Columna 2: Grupo
            { 
                name: 'grupo_llegadas', 
                data: 'grupo_llegadas', 
                className: "text-center align-middle" 
            },
            // Columna 3: Prescriptor
            { 
                name: 'prescriptor_nombre_completo', 
                data: 'prescriptor_nombre_completo', 
                className: "text-start align-middle" 
            },
            // Columna 4: Nivel de Alerta
            { 
                name: 'nivel_alerta', 
                data: 'nivel_alerta', 
                className: "text-center align-middle" 
            },
            // Columna 5: Días hasta inicio
            { 
                name: 'dias_hasta_inicio', 
                data: 'dias_hasta_inicio', 
                className: "text-center align-middle" 
            },
            // Columna 6: Pago Pendiente
            { 
                name: 'pago_pendiente', 
                data: 'pago_pendiente', 
                className: "text-end align-middle" 
            },
            // Columna 7: Porcentaje Pagado
            { 
                name: 'porcentaje_pago', 
                data: 'porcentaje_pago', 
                className: "text-center align-middle" 
            },
            // Columna 8: Departamento
            { 
                name: 'departamento_nombre', 
                data: 'departamento_nombre', 
                className: "text-center align-middle" 
            },
            // Columna 9: Agente
            { 
                name: 'agente_nombre', 
                data: 'agente_nombre', 
                className: "text-center align-middle" 
            }
        ],
        columnDefs: [
            // Columna 0: Control
            { 
                targets: "control:name", 
                width: '5%', 
                searchable: false, 
                orderable: false, 
                className: "text-center"
            },
            // Columna 1: ID Llegada
            { 
                targets: "id_llegada:name", 
                width: '8%', 
                searchable: true, 
                orderable: true, 
                className: "text-center" 
            },
            // Columna 2: Grupo
            { 
                targets: "grupo_llegadas:name", 
                width: '10%', 
                searchable: true, 
                orderable: true, 
                className: "text-center" 
            },
            // Columna 3: Prescriptor
            { 
                targets: "prescriptor_nombre_completo:name", 
                width: '15%', 
                searchable: true, 
                orderable: true, 
                className: "text-start" 
            },
            // Columna 4: Nivel de Alerta con badges de colores
            { 
                targets: "nivel_alerta:name", 
                width: '12%', 
                searchable: true, 
                orderable: true, 
                className: "text-center",
                render: function (data, type, row) {
                    // Para filtrado y ordenamiento, devolver el valor sin formato
                    if (type === "filter" || type === "sort") {
                        return row.nivel_alerta;
                    }
                    
                    // Para visualización, mostrar con badge
                    if (type === "display") {
                        let badgeClass = '';
                        let icon = '';
                        
                        switch(row.nivel_alerta) {
                            case 'VENCIDO':
                                badgeClass = 'badge-vencido';
                                icon = '<i class="bi bi-x-circle me-1"></i>';
                                break;
                            case 'CRÍTICO':
                                badgeClass = 'badge-critico';
                                icon = '<i class="bi bi-exclamation-triangle-fill me-1"></i>';
                                break;
                            case 'URGENTE':
                                badgeClass = 'badge-urgente';
                                icon = '<i class="bi bi-lightning-fill me-1"></i>';
                                break;
                            case 'IMPORTANTE':
                                badgeClass = 'badge-importante';
                                icon = '<i class="bi bi-bell-fill me-1"></i>';
                                break;
                            case 'AVISO':
                                badgeClass = 'badge-aviso';
                                icon = '<i class="bi bi-info-circle-fill me-1"></i>';
                                break;
                            default:
                                badgeClass = 'badge-normal';
                                icon = '<i class="bi bi-check-circle me-1"></i>';
                        }
                        
                        return `<span class="badge ${badgeClass}">${icon}${row.nivel_alerta}</span>`;
                    }
                    
                    // Para cualquier otro tipo, devolver el valor sin formato
                    return row.nivel_alerta;
                }
            },
            // Columna 5: Días hasta inicio
            { 
                targets: "dias_hasta_inicio:name", 
                width: '10%', 
                searchable: true, 
                orderable: true, 
                className: "text-center",
                render: function (data, type, row) {
                    if (type === "display") {
                        let colorClass = '';
                        let prefix = '';
                        
                        if (row.dias_hasta_inicio < 0) {
                            colorClass = 'text-danger fw-bold';
                            prefix = '⚠️ ';
                        } else if (row.dias_hasta_inicio <= 3) {
                            colorClass = 'text-danger fw-bold';
                        } else if (row.dias_hasta_inicio <= 7) {
                            colorClass = 'text-warning fw-bold';
                        }
                        
                        return `<span class="${colorClass}">${prefix}${row.dias_hasta_inicio}</span>`;
                    }
                    return row.dias_hasta_inicio;
                }
            },
            // Columna 6: Pago Pendiente
            { 
                targets: "pago_pendiente:name", 
                width: '12%', 
                searchable: true, 
                orderable: true, 
                className: "text-end",
                render: function (data, type, row) {
                    if (type === "display") {
                        return `<span class="fw-bold">${parseFloat(row.pago_pendiente).toFixed(2)} €</span>`;
                    }
                    return row.pago_pendiente;
                }
            },
            // Columna 7: Porcentaje Pagado
            { 
                targets: "porcentaje_pago:name", 
                width: '10%', 
                searchable: true, 
                orderable: true, 
                className: "text-center",
                render: function (data, type, row) {
                    if (type === "display") {
                        let percentage = parseFloat(row.porcentaje_pago);
                        let colorClass = '';
                        
                        if (percentage >= 80) {
                            colorClass = 'text-success';
                        } else if (percentage >= 50) {
                            colorClass = 'text-warning';
                        } else {
                            colorClass = 'text-danger';
                        }
                        
                        return `<span class="${colorClass} fw-bold">${percentage.toFixed(2)}%</span>`;
                    }
                    return row.porcentaje_pago;
                }
            },
            // Columna 8: Departamento
            { 
                targets: "departamento_nombre:name", 
                width: '12%', 
                searchable: true, 
                orderable: true, 
                className: "text-center" 
            },
            // Columna 9: Agente
            { 
                targets: "agente_nombre:name", 
                width: '12%', 
                searchable: true, 
                orderable: true, 
                className: "text-center" 
            }
        ],
        ajax: {
            url: '../../controller/listado_criticos_llegadas.php?op=listar',
            type: 'GET',
            dataSrc: function (json) {
                console.log("JSON recibido:", json);
                return json.data || json;
            },
            error: function(xhr, error, thrown) {
                console.error('Error al cargar datos:', error);
                console.error('Detalles:', thrown);
            }
        },
        order: [[5, 'asc']], // Ordenar por días hasta inicio (más urgente primero)
        pageLength: 25
    };

    /////////////////////////////////////
    //   DEFINICIONES DE LA TABLA      //
    ///////////////////////////////////
    
    var $table = $('#alertas_criticas_data');
    var $tableConfig = datatable_alertasConfig;
    var $tableBody = $('#alertas_criticas_data tbody');
    var $columnFilterInputs = $('#alertas_criticas_data tfoot input, #alertas_criticas_data tfoot select');

    var table_e = $table.DataTable($tableConfig);

    /////////////////////////////////////
    //   FUNCIÓN PARA MOSTRAR DETALLES //
    ///////////////////////////////////
    
    function format(d) {
        console.log(d);
        
        return `
            <div class="card border-primary mb-3" style="overflow: visible;">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-3 me-2"></i>
                        <h5 class="card-title mb-0">Detalles de la Alerta - Llegada #${d.id_llegada}</h5>
                    </div>
                </div>
                <div class="card-body p-0" style="overflow: visible;">
                    <table class="table table-borderless table-striped table-hover mb-0">
                        <tbody>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Mensaje de Alerta
                                </th>
                                <td class="pe-4">
                                    <strong>${d.mensaje_alerta || '<span class="text-muted fst-italic">Sin mensaje</span>'}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-calendar-event me-2"></i>Fecha Inicio Curso
                                </th>
                                <td class="pe-4">
                                    ${d.fecha_inicio_curso ? formatoFechaEuropeo(d.fecha_inicio_curso) : '<span class="text-muted fst-italic">Sin fecha</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-person-circle me-2"></i>Prescriptor
                                </th>
                                <td class="pe-4">
                                    ${d.prescriptor_nombre_completo || '<span class="text-muted fst-italic">Sin nombre</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-envelope me-2"></i>Email
                                </th>
                                <td class="pe-4">
                                    ${d.prescriptor_email ? `<a href="mailto:${d.prescriptor_email}">${d.prescriptor_email}</a>` : '<span class="text-muted fst-italic">Sin email</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-telephone me-2"></i>Teléfono / Móvil
                                </th>
                                <td class="pe-4">
                                    ${d.prescriptor_telefono || ''} ${d.prescriptor_movil ? ' / ' + d.prescriptor_movil : ''}
                                    ${!d.prescriptor_telefono && !d.prescriptor_movil ? '<span class="text-muted fst-italic">Sin teléfono</span>' : ''}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-globe me-2"></i>País / Nacionalidad
                                </th>
                                <td class="pe-4">
                                    ${d.prescriptor_pais || ''} ${d.prescriptor_nacionalidad ? ' / ' + d.prescriptor_nacionalidad : ''}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-cash-stack me-2"></i>Totales Financieros
                                </th>
                                <td class="pe-4">
                                    <strong>Total General:</strong> ${parseFloat(d.total_general || 0).toFixed(2)} €<br>
                                    <strong>Matriculaciones:</strong> ${parseFloat(d.total_matriculaciones || 0).toFixed(2)} €<br>
                                    <strong>Alojamientos:</strong> ${parseFloat(d.total_alojamientos || 0).toFixed(2)} €<br>
                                    <strong>Suplidos:</strong> ${parseFloat(d.total_suplidos || 0).toFixed(2)} €
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-wallet2 me-2"></i>Estado de Pagos
                                </th>
                                <td class="pe-4">
                                    <strong>Total Pagado:</strong> ${parseFloat(d.total_pagos_realizados || 0).toFixed(2)} €<br>
                                    <strong>Pendiente:</strong> <span class="text-danger fw-bold">${parseFloat(d.pago_pendiente || 0).toFixed(2)} €</span><br>
                                    <strong>% Pendiente:</strong> ${parseFloat(d.porcentaje_pendiente || 0).toFixed(2)}%
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-tag me-2"></i>Clasificación
                                </th>
                                <td class="pe-4">
                                    <span class="badge bg-info">${d.clasificacion_monto || 'Sin clasificar'}</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-speedometer2 me-2"></i>Score de Urgencia
                                </th>
                                <td class="pe-4">
                                    ${parseFloat(d.score_urgencia || 0).toFixed(2)} <small class="text-muted">(menor = más urgente)</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-end">
                    <small class="text-muted">Prioridad: ${d.prioridad || 'N/A'}</small>
                </div>
            </div>
        `;
    }

    // Click para expandir/contraer detalles
    $tableBody.on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_e.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    /////////////////////////////////////
    //   FILTROS RADIOBUTTON HEADER    //
    ///////////////////////////////////
    
    $('input[name="filterStatus"]').on('change', function () {
        var value = $(this).val();

        if (value === "all") {
            table_e.column(4).search("").draw(); // Columna de nivel_alerta
        } else {
            table_e.column(4).search(value).draw();
        }
    });

    /////////////////////////////////////
    //   FILTROS PIE DE TABLA          //
    ///////////////////////////////////
    
    $columnFilterInputs.on('keyup change', function () {
        // Obtener el índice de la columna desde el footer
        var $th = $(this).closest('th');
        var columnIndex = $th.index();
        var searchValue = $(this).val();
        
        console.log("Filtro activado - Columna:", columnIndex, "Valor:", searchValue, "Es select:", $(this).is('select'));
        
        // Para el select de nivel de alerta (columna 4), usar búsqueda exacta
        if ($(this).is('select')) {
            console.log("Es un select, aplicando búsqueda exacta en columna:", columnIndex);
            if (searchValue === "") {
                // Si está vacío, limpiar el filtro
                table_e.column(columnIndex).search("").draw();
            } else {
                // Búsqueda exacta usando regex - escapar caracteres especiales
                var escapedValue = searchValue.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                console.log("Buscando valor escapado:", escapedValue, "en columna:", columnIndex);
                table_e.column(columnIndex).search("^" + escapedValue + "$", true, false).draw();
            }
        } else {
            // Para otros campos, búsqueda normal (parcial)
            table_e.column(columnIndex).search(searchValue).draw();
        }
        
        updateFilterMessage();
    });

    // Actualizar mensaje de filtro activo
    function updateFilterMessage() {
        var activeFilters = false;

        $columnFilterInputs.each(function () {
            if ($(this).val() !== "") {
                activeFilters = true;
                return false;
            }
        });

        if (table_e.search() !== "") {
            activeFilters = true;
        }

        if (activeFilters) {
            $('#filter-alert').show();
        } else {
            $('#filter-alert').hide();
        }
    }

    table_e.on('search.dt', function () {
        updateFilterMessage();
    });

    // Botón para limpiar filtros
    $('#clear-filter').on('click', function () {
        table_e.destroy();

        $columnFilterInputs.each(function () {
            $(this).val('');
        });

        // Resetear radio buttons
        $('#filterAll').prop('checked', true);

        table_e = $table.DataTable($tableConfig);

        $('#filter-alert').hide();
    });

}); // document.ready

/////////////////////////////////////
//   FUNCIONES GLOBALES            //
///////////////////////////////////

// Función global para formatear fecha al formato europeo
function formatoFechaEuropeo(fechaString) {
    if (!fechaString) return 'Sin fecha';
    
    try {
        const fecha = new Date(fechaString);
        if (isNaN(fecha.getTime())) return 'Fecha inválida';
        
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const año = fecha.getFullYear();
        
        return `${dia}/${mes}/${año}`;
    } catch (error) {
        console.error('Error al formatear fecha:', error);
        return 'Error en fecha';
    }
}

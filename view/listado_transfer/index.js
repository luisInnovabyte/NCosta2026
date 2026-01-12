$(document).ready(function () {

    /////////////////////////////////////
    //     CONFIGURACIÓN DATATABLES    //
    ///////////////////////////////////
    
    var datatable_transferConfig = {
        processing: true,
        serverSide: false,
        ajax: {
            url: "../../controller/listado_transfer.php?op=listar",
            type: "GET",
            dataSrc: function(json) {
                if (json.data) {
                    return json.data;
                }
                return [];
            }
        },
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
            emptyTable: "No hay transfers en este momento",
            info: "Mostrando _START_ a _END_ de _TOTAL_ transfers",
            infoEmpty: "Mostrando 0 a 0 de 0 transfers",
            infoFiltered: "(filtrado de _MAX_ transfers totales)",
            lengthMenu: "Mostrar _MENU_ transfers",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron transfers coincidentes"
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
            // Columna 2: Fecha y Hora
            { 
                name: 'fechallegada_llegadas', 
                data: 'fechallegada_llegadas', 
                className: "text-center align-middle",
                render: function (data, type, row) {
                    if (type === "display" && data) {
                        // Convertir de YYYY-MM-DD HH:MM:SS a DD/MM/YYYY HH:MM
                        const fecha = new Date(data);
                        const dia = String(fecha.getDate()).padStart(2, '0');
                        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                        const anio = fecha.getFullYear();
                        const horas = String(fecha.getHours()).padStart(2, '0');
                        const minutos = String(fecha.getMinutes()).padStart(2, '0');
                        return `${dia}/${mes}/${anio} ${horas}:${minutos}`;
                    }
                    return data;
                }
            },
            // Columna 3: Lugar
            { 
                name: 'lugarllegada_llegadas', 
                data: 'lugarllegada_llegadas', 
                className: "text-start align-middle" 
            },
            // Columna 4: Quién recoge
            { 
                name: 'quienrecogealumno_llegadas', 
                data: 'quienrecogealumno_llegadas', 
                className: "text-start align-middle" 
            },
            // Columna 5: Alumno
            { 
                name: 'alumno_nombre_completo', 
                data: 'alumno_nombre_completo', 
                className: "text-start align-middle" 
            },
            // Columna 6: Clasificación
            { 
                name: 'clasificacion_transfer', 
                data: 'clasificacion_transfer', 
                className: "text-center align-middle",
                render: function (data, type, row) {
                    if (type === "filter" || type === "sort") {
                        return data;
                    }
                    
                    let badgeClass = 'bg-secondary';
                    let icon = '';
                    
                    switch(data) {
                        case 'HOY':
                            badgeClass = 'bg-danger';
                            icon = '<i class="bi bi-calendar-day me-1"></i>';
                            break;
                        case 'MAÑANA':
                            badgeClass = 'bg-warning';
                            icon = '<i class="bi bi-sun me-1"></i>';
                            break;
                        case 'PRÓXIMO':
                            badgeClass = 'bg-info';
                            icon = '<i class="bi bi-clock me-1"></i>';
                            break;
                        case 'ESTA SEMANA':
                            badgeClass = 'bg-primary';
                            icon = '<i class="bi bi-calendar-week me-1"></i>';
                            break;
                        case 'FUTURO':
                            badgeClass = 'bg-secondary';
                            icon = '<i class="bi bi-calendar-alt me-1"></i>';
                            break;
                    }
                    
                    return '<span class="badge ' + badgeClass + ' px-3 py-2">' + icon + data + '</span>';
                }
            },
            // Columna 7: Departamento
            { 
                name: 'departamento_nombre', 
                data: 'departamento_nombre', 
                className: "text-center align-middle" 
            },
            // Columna 8: Token Prescriptor (oculta)
            { 
                name: 'prescriptor_token', 
                data: 'prescriptor_token', 
                visible: false,
                searchable: false
            },
            // Columna 9: Acciones
            { 
                name: 'acciones', 
                data: null,
                className: "text-center align-middle",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const token = row.prescriptor_token || '';
                    const idLlegada = row.id_llegada || '';
                    const alumnoToken = row.alumno_token || '';
                    const urlLlegada = `../Llegadas/?tokenPreinscripcion=${token}&idLlegada=${idLlegada}`;
                    const urlPerfil = `../Perfil/?tokenUsuario=${alumnoToken}`;
                    
                    let botones = `<a href="${urlLlegada}" target="_blank" class="btn btn-sm btn-primary" title="Abrir Llegada">
                                <i class="bx bx-link-external"></i>
                            </a>`;
                    
                    if (alumnoToken) {
                        botones += ` <a href="${urlPerfil}" target="_blank" class="btn btn-sm btn-info" title="Ver Perfil Usuario">
                                <i class="bx bx-user"></i>
                            </a>`;
                    }
                    
                    return botones;
                }
            }
        ],
        order: [[2, 'asc']], // Ordenar por fecha
        pageLength: 25,
        responsive: true
    };

    // Inicializar DataTable
    var table_e = $('#alertas_criticas_data').DataTable(datatable_transferConfig);

    /////////////////////////////////////
    //     FILTROS POR FECHA          //
    ///////////////////////////////////

    // Establecer fechas por defecto al cargar la página
    function establecerFechasPorDefecto() {
        // Fecha de hoy
        const hoy = new Date();
        const diaHoy = String(hoy.getDate()).padStart(2, '0');
        const mesHoy = String(hoy.getMonth() + 1).padStart(2, '0');
        const anioHoy = hoy.getFullYear();
        const fechaHoy = `${anioHoy}-${mesHoy}-${diaHoy}`;
        
        // Fecha fin: 31/12/2099
        const fechaFin = '2099-12-31';
        
        // Establecer valores
        $('#fechaDesde').val(fechaHoy);
        $('#fechaHasta').val(fechaFin);
        
        // Aplicar filtro automáticamente
        table_e.draw();
        
        // Mostrar alerta de filtro activo
        $('#active-filters-text').text(`Filtrado desde hoy (${diaHoy}/${mesHoy}/${anioHoy}) en adelante`);
        $('#filter-alert').show();
    }
    
    // Llamar a la función después de inicializar el DataTable
    establecerFechasPorDefecto();

    // Filtro personalizado por rango de fechas
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            // Solo aplicar este filtro a nuestra tabla
            if (settings.nTable.id !== 'alertas_criticas_data') {
                return true;
            }
            
            const fechaDesde = $('#fechaDesde').val();
            const fechaHasta = $('#fechaHasta').val();
            
            // Si no hay filtros, mostrar todo
            if (!fechaDesde && !fechaHasta) {
                return true;
            }
            
            // Obtener los datos originales de la fila desde el API
            const rowData = table_e.row(dataIndex).data();
            if (!rowData || !rowData.fechallegada_llegadas) {
                return true;
            }
            
            // Parsear la fecha original (formato: YYYY-MM-DD HH:MM:SS o YYYY-MM-DD)
            const fechaRow = new Date(rowData.fechallegada_llegadas);
            if (isNaN(fechaRow.getTime())) {
                return true;
            }
            
            // Resetear horas para comparar solo fechas
            fechaRow.setHours(0, 0, 0, 0);
            
            // Comprobar rango
            let cumple = true;
            
            if (fechaDesde) {
                const desde = new Date(fechaDesde);
                desde.setHours(0, 0, 0, 0);
                cumple = cumple && (fechaRow >= desde);
            }
            
            if (fechaHasta) {
                const hasta = new Date(fechaHasta);
                hasta.setHours(23, 59, 59, 999);
                cumple = cumple && (fechaRow <= hasta);
            }
            
            return cumple;
        }
    );

    // Aplicar filtro de fechas
    $('#aplicarFiltroFechas').on('click', function() {
        table_e.draw();
        
        // Mostrar alerta de filtro activo
        const fechaDesde = $('#fechaDesde').val();
        const fechaHasta = $('#fechaHasta').val();
        
        if (fechaDesde || fechaHasta) {
            let textoFiltro = 'Filtrado por fecha: ';
            if (fechaDesde && fechaHasta) {
                textoFiltro += `desde ${fechaDesde} hasta ${fechaHasta}`;
            } else if (fechaDesde) {
                textoFiltro += `desde ${fechaDesde}`;
            } else {
                textoFiltro += `hasta ${fechaHasta}`;
            }
            
            $('#active-filters-text').text(textoFiltro);
            $('#filter-alert').show();
        }
    });

    // Limpiar filtro de fechas
    $('#limpiarFiltroFechas').on('click', function() {
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        table_e.draw();
        $('#filter-alert').hide();
    });

    // Limpiar filtros desde el botón de la alerta
    $('#clear-filter').on('click', function() {
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        table_e.draw();
        $('#filter-alert').hide();
    });

    // Búsqueda en footer
    $('#alertas_criticas_data tfoot th').each(function (i) {
        const $column = table_e.column(i);
        
        // Solo aplicar a columnas con input/select
        $('input, select', this).on('keyup change clear', function () {
            if ($column.search() !== this.value) {
                $column.search(this.value).draw();
            }
        });
    });

    /////////////////////////////////////
    //     DETALLES EXPANDIBLES        //
    ///////////////////////////////////

    function format(d) {
        console.log(d);
        
        return `
            <div class="card border-primary mb-3" style="overflow: visible;">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-3 me-2"></i>
                        <h5 class="card-title mb-0">Detalles del Transfer - Llegada #${d.id_llegada}</h5>
                    </div>
                </div>
                <div class="card-body p-0" style="overflow: visible;">
                    <table class="table table-borderless table-striped table-hover mb-0">
                        <tbody>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-calendar-event me-2"></i>Fecha y Hora Llegada
                                </th>
                                <td class="pe-4">
                                    ${d.fechallegada_llegadas ? new Date(d.fechallegada_llegadas).toLocaleString('es-ES') : '<span class="text-muted fst-italic">Sin fecha</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-geo-alt me-2"></i>Lugar de Llegada
                                </th>
                                <td class="pe-4">
                                    <strong>${d.lugarllegada_llegadas || '<span class="text-muted fst-italic">Sin lugar</span>'}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-people me-2"></i>Grupo
                                </th>
                                <td class="pe-4">
                                    ${d.grupo_nombre || '<span class="text-muted fst-italic">Sin grupo</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-envelope me-2"></i>Email Prescriptor
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
                                    <i class="bi bi-building me-2"></i>Departamento
                                </th>
                                <td class="pe-4">
                                    ${d.departamento_nombre || '<span class="text-muted fst-italic">Sin departamento</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-person-workspace me-2"></i>Agente
                                </th>
                                <td class="pe-4">
                                    ${d.agente_nombre || '<span class="text-muted fst-italic">Sin agente</span>'}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="ps-4 w-25 align-top">
                                    <i class="bi bi-tag me-2"></i>Clasificación
                                </th>
                                <td class="pe-4">
                                    <span class="badge bg-info">${d.clasificacion_transfer || 'Sin clasificar'}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-end">
                    <small class="text-muted">Estado: ${d.estado_nombre || 'N/A'}</small>
                </div>
            </div>
        `;
    }

    // Event listener para expandir/contraer detalles
    $('#alertas_criticas_data tbody').on('click', 'td.details-control', function () {
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

});

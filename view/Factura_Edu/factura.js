$(document).ready(function() {
    // Obtener los valores de los inputs hidden
    var idFactura = $('#idFactura').val();
    var tipoFactura = $('#tipoFactura').val();
    var idLlegada = $('#idLlegada').val();

    console.log('Inicializando factura.js con:', { idFactura, tipoFactura, idLlegada });

    // Inicializar DataTable de facturaTabla
    var facturaTabla = $("#facturaTabla").DataTable({
        pageLength: -1,
        dom: 't', // Solo mostrar la tabla (t=table)
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        autoWidth: false,
        language: {
            emptyTable: "No hay conceptos facturados"
        },
        columns: [
            { name: "id" },
            { name: "Codigo", className: "text-center" },
            { name: "Concepto", className: "text-center" },
            { name: "Tipo", className: "text-center d-none" },
            { name: "Descuento", className: "text-center" },
            { name: "Subtotal", className: "text-center" },
            { name: "IVA", className: "text-center" },
            { name: "Total", className: "text-center" }
        ],
        columnDefs: [
            {
                targets: [0], // Columna ID
                visible: false
            }
        ],
        ajax: {
            url: "../../controller/proforma.php?op=cargarProductoIdEnFacturaReal",
            type: "get",
            dataType: "json",
            cache: false,
            data: {
                idFactura: idFactura
            },
            beforeSend: function () {
                console.log('Cargando conceptos de factura real ID:', idFactura);
            },
            complete: function (data) {
                console.log('Datos cargados:', data);
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar conceptos:", { xhr, status, error });
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Totales
            var baseTotal = 0;
            var ivaTotal = 0;
            var totalGeneral = 0;

            // Recorrer todas las filas
            api.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                
                // Parsear valores (eliminar formato de miles y convertir coma a punto)
                var base = parseFloat(rowData[5].replace(/\./g, '').replace(',', '.')) || 0;
                var iva = parseFloat(rowData[6]) || 0;
                var total = parseFloat(rowData[7].replace(/\./g, '').replace(',', '.')) || 0;

                baseTotal += base;
                totalGeneral += total;
            });

            // Calcular IVA total (diferencia entre total y base)
            ivaTotal = totalGeneral - baseTotal;

            // Actualizar labels
            $('#baseImponible').text(baseTotal.toFixed(2).replace('.', ',') + ' €');
            $('#ivaTotal').text(ivaTotal.toFixed(2).replace('.', ',') + ' €');
            $('#totalConIva').text(totalGeneral.toFixed(2).replace('.', ',') + ' €');
            $('#totalConIvaResumen').text(totalGeneral.toFixed(2).replace('.', ',') + ' €');
        }
    });

    // Inicializar DataTable de suplidosTabla
    var suplidosTabla = $("#suplidosTabla").DataTable({
        pageLength: -1,
        dom: 't',
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        autoWidth: false,
        language: {
            emptyTable: "No hay suplidos"
        },
        columns: [
            { name: "id" },
            { name: "Descripcion", className: "text-left" },
            { name: "Importe", className: "text-right" }
        ],
        columnDefs: [
            {
                targets: [0],
                visible: false
            }
        ],
        ajax: {
            url: "../../controller/proforma.php?op=cargarProductoIdEnFacturaReal",
            type: "get",
            dataType: "json",
            cache: false,
            data: {
                idFactura: idFactura
            },
            dataSrc: function(json) {
                // Filtrar solo los suplidos (tipo 4)
                if (json.data) {
                    var suplidos = json.data.filter(function(item) {
                        // Asumiendo que la columna 3 es el tipo
                        return item[3] == 4; // 4 = Suplidos
                    });
                    
                    if (suplidos.length > 0) {
                        $('.suplidosContent').removeClass('d-none');
                    } else {
                        $('.suplidosContent').addClass('d-none');
                    }
                    
                    return suplidos;
                }
                return [];
            }
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            var totalSuplidos = 0;

            api.rows().every(function() {
                var rowData = this.data();
                var importe = parseFloat(rowData[2].replace(/\./g, '').replace(',', '.')) || 0;
                totalSuplidos += importe;
            });

            $('#totalSuplidos').text(totalSuplidos.toFixed(2).replace('.', ',') + ' €');
            
            // Calcular total general
            var totalConIva = parseFloat($('#totalConIva').text().replace(/\./g, '').replace(',', '.').replace(' €', '')) || 0;
            var totalGeneral = totalConIva + totalSuplidos;
            
            $('#totalGeneral').text(totalGeneral.toFixed(2).replace('.', ',') + ' €');
        }
    });

    // Función para imprimir
    window.imprimirFactura = function() {
        window.print();
    };
});

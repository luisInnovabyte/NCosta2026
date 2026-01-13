// Total con IVA numérico para usarlo en otros cálculos (suplidos)
var totalConIvaNumerico = 0;

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

            // Función para normalizar números con formato europeo
            var normalize = function(valor) {
                return parseFloat(
                    String(valor || "")
                        .replace(/\./g, '')   // quita puntos de miles
                        .replace(',', '.')     // convierte coma decimal en punto
                ) || 0;
            };

            var totalSinIva = 0;
            var totalIva = 0;
            var totalConIva = 0;
            var hayIvaCero = false;

            var ivaMap = {};

            // Recorrer todas las filas visibles
            api.rows({ search: 'applied' }).every(function () {
                var rowData = this.data();

                var descuento = normalize(rowData[4]);     // % Descuento
                var base = normalize(rowData[5]);          // Base imponible
                var porcentajeIva = normalize(rowData[6]); // % IVA

                // Aplicar descuento sobre la base
                var baseNeta = base * (1 - descuento / 100);

                // Calcular IVA y total de la fila sobre la base neta
                var ivaFila = baseNeta * (porcentajeIva / 100);
                var totalFila = baseNeta + ivaFila;

                // Acumular totales globales
                totalSinIva += baseNeta;
                totalIva += ivaFila;
                totalConIva += totalFila;

                if (porcentajeIva === 0) hayIvaCero = true;

                // Acumular por tipo de IVA
                if (!ivaMap[porcentajeIva]) {
                    ivaMap[porcentajeIva] = { base: 0, iva: 0, total: 0 };
                }
                ivaMap[porcentajeIva].base += baseNeta;
                ivaMap[porcentajeIva].iva += ivaFila;
                ivaMap[porcentajeIva].total += totalFila;
            });

            // Mostrar resultados totales en HTML
            $('#ivaTotal').text(totalIva.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
            $('#totalConIva').text(totalConIva.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
            $('#totalConIvaResumen').text(totalConIva.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));

            // Guardar el valor numérico en variable global
            totalConIvaNumerico = totalConIva;

            // Mostrar nota si algún IVA es 0
            $('.nota-iva').toggleClass('d-none', !hayIvaCero);

            // Limpiar filas previas de IVA
            $('.fila-iva').remove();

            // Insertar filas intermedias por tipo de IVA
            for (var iva in ivaMap) {
                if (!ivaMap.hasOwnProperty(iva)) continue;

                var fila =
                    '<tr class="fila-intermedia fila-iva">' +
                        '<td>' + ivaMap[iva].base.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) + '</td>' +
                        '<td>' + iva + '%</td>' +
                        '<td>' + ivaMap[iva].iva.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) + '</td>' +
                        '<td>' + ivaMap[iva].total.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }) + '</td>' +
                    '</tr>';

                $('#finTotales').before(fila);
            }
        }
    });

    // Inicializar DataTable de suplidosTabla usando la misma lógica que en FacturaPro_Edu
    var suplidosTabla = $("#suplidosTabla").DataTable({
        pageLength: 7,
        dom: 't',
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        autoWidth: false,
        language: {
            emptyTable: ""
        },
        columns: [
            { name: "ID", className: "d-none" },
            { name: "Descripcion", className: "text-center" },
            { name: "importe", className: "text-center" }
        ],
        columnDefs: [
            {
                targets: [0],
                visible: true
            }
        ],
        ajax: {
            url: "../../controller/proforma.php?op=recogerSuplidosXLlegada",
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            data: {
                idLlegada: idLlegada
            },
            complete: function () {
                // Mostrar u ocultar el bloque de suplidos según haya datos
                var dataCount = suplidosTabla.data().count();
                if (dataCount === 0) {
                    $('#suplidosContainer').hide();
                    $('.suplidosContent').addClass('d-none');
                } else {
                    $('#suplidosContainer').show();
                    $('.suplidosContent').removeClass('d-none');
                }
            },
            error: function (e) {
                console.error("Error en la carga de suplidos:", e);
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

            // Total de suplidos
            $('#totalSuplidosResumen').text(totalSuplidos.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));

            // Calcular total general (factura + suplidos)
            var totalConSuplidos = totalConIvaNumerico + totalSuplidos;
            $('#totalConSuplidos').text(totalConSuplidos.toLocaleString('es-ES', { style: 'currency', currency: 'EUR' }));
        }
    });

    // Función para imprimir
    window.imprimirFactura = function() {
        window.print();
    };
});

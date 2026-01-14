function actualizarPaginacion() {
  $('.pagenum').each(function(index) {
    $(this).text("Página " + (index + 1) + " de " + $('.pagenum').length);
  });
}

$(document).ready(function() {
    // Función al cargar la página
    // ID LLEGADA QUE SE VA A USAR PARA FILTRAR EN LA FACTURA
    idFactura = $('#idFactura').val();
    // TIPO DE FACTURA QUE SE VA A MOSTRAR
    tipoFactura = $('#tipoFactura').val();
      // Obtenemos el valor de si es proforma o real
    var tipoFacturaRealOProforma = $('#EsProformaOReal').val(); // "real" o "proforma"

    var ajaxUrl;

    if (tipoFacturaRealOProforma == 1) {
        ajaxUrl = "../../controller/proforma.php?op=cargarProductoIdEnFacturaRealNegativo";
    } else if (tipoFacturaRealOProforma == 0) {
        ajaxUrl = "../../controller/proforma.php?op=cargarProductoIdEnFacturaNegativo";
    }

    var hayIvaCero = false;

    var facturaTabla = $("#facturaTabla").DataTable({
        pageLength: 7,
        paging: false,         //  OCULTA LA PAGINACIÓN
        searching: false,      //  OCULTA LA BARRA DE BÚSQUEDA
        info: false,           //  OCULTA EL TEXTO DE INFORMACIÓN
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        select: false,
        buttons: [],
        language: {
            emptyTable: "Añada productos a facturar"
        },
        columns: [
            { name: "ID", className: "d-none" },
            { name: "Codigo", className: "text-center" },
            { name: "Concepto", className: "text-center" },
            { name: "Tipo", className: "text-center d-none" },
            { name: "Descuento", className: "d-none" },
            { name: "Base Imponible", className: "text-center" },
            { name: "IVA", className: "text-center" },
            { name: "Total", className: "text-center" },
        ],
        columnDefs: [
            {
                targets: [0, 3, 4],
                visible: false, // Oculta la columna ID
            }
        ],
        searchBuilder: {
            columns: [1, 2, 3], // Ajustado a las columnas existentes
        },
        ajax: {
            url: ajaxUrl,
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            data: {
                idFactura: idFactura
            },
            beforeSend: function () {
                // Aquí puedes agregar acciones antes de la solicitud
            },
            complete: function (data) {
                // Aquí puedes agregar acciones después de la solicitud
            },
            error: function (e) {
                console.error("Error en la carga de la tabla:", e);
            }
        },
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Función para normalizar números con formato europeo
            let normalize = (valor) => {
                // Convertir a string y limpiar
                let str = String(valor || "")
                    .replace(/\s+/g, '')      // eliminar todos los espacios
                    .replace(/\./g, '')       // quitar puntos de miles
                    .replace(',', '.');       // convertir coma decimal en punto
                
                return parseFloat(str) || 0;
            };

            let totalSinIva = 0;
            let totalIva = 0;
            let totalConIva = 0;
            let totalDescuento = 0;
            let hayIvaCero = false;

            let ivaMap = {};

            api.rows({ search: 'applied' }).every(function () {
                let data = this.data();

                let base = normalize(data[5]);          // Base imponible (puede venir como "- 100,50")
                let porcentajeIva = normalize(data[6]); // % IVA
                let descuento = normalize(data[4]);     // % Descuento

                // Calcular IVA y total de la fila
                let ivaFila = base * (porcentajeIva / 100);
                let totalFila = base + ivaFila;

                // Acumular totales (respetando signos negativos)
                totalSinIva += base;
                totalIva += ivaFila;
                totalConIva += totalFila;

                totalDescuento += Math.abs(base) * (descuento / 100);

                if (porcentajeIva === 0) hayIvaCero = true;

                // Map por tipo de IVA
                if (!ivaMap[porcentajeIva]) {
                    ivaMap[porcentajeIva] = { base: 0, iva: 0, total: 0 };
                }
                ivaMap[porcentajeIva].base += base;
                ivaMap[porcentajeIva].iva += ivaFila;
                ivaMap[porcentajeIva].total += totalFila;
            });

            // Mostrar resultados en HTML
            $('#ivaTotal').text(totalIva.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
            $('#baseImponible').text(totalSinIva.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
            $('#totalConIva').text(totalConIva.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
            $('#totalConIvaResumen').text(totalConIva.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));

            // $('#totalDescuento').text("-" + totalDescuento.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));

            // Mostrar nota si algún IVA es 0
            $('.nota-iva').toggleClass('d-none', !hayIvaCero);

            // Limpiar filas previas de IVA
            $(".fila-iva").remove();

            // Insertar filas por tipo de IVA
            for (let iva in ivaMap) {
                if (!ivaMap.hasOwnProperty(iva)) continue;
                
                let fila = `
                    <tr class="fila-intermedia fila-iva">
                        <td>${ivaMap[iva].base.toLocaleString("es-ES", { style: "currency", currency: "EUR" })}</td>
                        <td>${iva}%</td>
                        <td>${ivaMap[iva].iva.toLocaleString("es-ES", { style: "currency", currency: "EUR" })}</td>
                        <td>${ivaMap[iva].total.toLocaleString("es-ES", { style: "currency", currency: "EUR" })}</td>
                    </tr>
                `;
                $("#finTotales").before(fila);
            }
        },
        initComplete: function(settings, json) {
            // Esta función se ejecuta cuando la tabla ha terminado de cargar
            
            // Agregar listener antes de imprimir
            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    if (!mql.matches) {
                        // Se cerró el diálogo de impresión
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    }
                });
            }
            
            // Fallback con onafterprint
            window.onafterprint = function() {
                setTimeout(function() {
                    window.close();
                }, 500);
            };
            
            // Iniciar impresión
            window.print();
        }
    });

    // Forzar que la tabla muestre 10 filas (igual que antes)
    facturaTabla.page.len(10).draw();
    facturaTabla.column(0).visible(true);

    $("#facturaTabla").addClass("width-100"); // Mantener responsividad

   
    // Forzar que la tabla muestre 10 filas (igual que antes)
    facturaTabla.page.len(10).draw();
    facturaTabla.column(0).visible(true);

    $("#facturaTabla").addClass("width-100"); // Mantener responsividad

    



        idLlegada = $('#idLlegada').val();
       var suplidosTabla = $("#suplidosTabla").DataTable({
        pageLength: 7,
        paging: false,         //  OCULTA LA PAGINACIÓN
        searching: false,      //  OCULTA LA BARRA DE BÚSQUEDA
        info: false,           //  OCULTA EL TEXTO DE INFORMACIÓN
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        select: false,
        buttons: [],
        language: {
            emptyTable: "Añada productos a facturar"
        },
        columns: [
            { name: "ID", className: "d-none" },
            { name: "Descripcion", className: "text-center" },
            { name: "importe", className: "text-center" }
        
        ],
        columnDefs: [
            {
                targets: [0],
                visible: true, // Oculta la columna ID
            }
        ],
        searchBuilder: {
            columns: [1, 2, 3], // Ajustado a las columnas existentes
        },
        ajax: {
            url: "../../controller/proforma.php?op=recogerSuplidosXLlegada",
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            data: {
                idLlegada: idLlegada
            },
            beforeSend: function () {
                // Aquí puedes agregar acciones antes de la solicitud
            },
            complete: function (data) {
                  let dataCount = suplidosTabla.data().count();

                   if (dataCount === 0) {
                        // Ocultar todo el bloque de suplidos
                        $('#suplidosContainer').hide();

                        // Ocultar las celdas de "TOTAL SUPLIDOS" y "TOTAL A PAGAR"
                        $('.totales-horizontal tr').each(function () {
                            $(this).find('td:eq(4), td:eq(5)').hide(); // Oculta columnas 5 y 6
                        });
                    } else {
                        $('#suplidosContainer').show();

                        // Mostrar las celdas si hay suplidos
                        $('.totales-horizontal tr').each(function () {
                            $(this).find('td:eq(4), td:eq(5)').show();
                        });
                    }
            },
            error: function (e) {
                console.error("Error en la carga de la tabla:", e);
            }
        },
        footerCallback: function (row, data, start, end, display) {
            console.log('asd')
                let api = this.api();
                    // Inicializa el total
                 let totalSuplido = 0;

                api.column(2, { search: 'applied' }).data().each(function (value) {
                    let precioSuplido = parseFloat(value.toString().replace('€', ''));
                    console.log(precioSuplido);
                });
           // Recorre la columna de precios (columna 2) y suma
                api.column(2, { search: 'applied' }).data().each(function (value) {
                    // Limpia y convierte a número
                    let precioSuplido = parseFloat(value.toString().replace(/[€\s]/g, '').replace(',', '.'));
                    if (!isNaN(precioSuplido)) {
                        totalSuplido += precioSuplido;
                    }
                });
                
                // Convertir a negativo para el abono
                totalSuplido = -Math.abs(totalSuplido);
                
                $('#totalSuplidosResumen').text(totalSuplido.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
                //totalSinSuplidos = $('#totalFactura').text();
                totalSinSuplidos = $('#totalConIva').text();

                // Normalizar el valor (eliminar espacios, puntos de miles, convertir coma a punto)
                totalSinSuplidos = parseFloat(
                    totalSinSuplidos.toString()
                        .replace(/\s+/g, '')      // eliminar espacios
                        .replace(/[€]/g, '')      // eliminar símbolo €
                        .replace(/\./g, '')       // eliminar puntos de miles
                        .replace(',', '.')        // convertir coma decimal a punto
                ) || 0;

                console.log(totalSinSuplidos)
                                
                // Comprobar que el valor es numérico antes de usarlo
                if (!isNaN(totalSinSuplidos)) {
                // Sumar los valores respetando los signos negativos
                let totalConSuplidos = totalSinSuplidos + totalSuplido;

                console.log("Total sin suplidos:", totalSinSuplidos);
                console.log("Total suplido:", totalSuplido);
                console.log("Total con suplidos:", totalConSuplidos);

                // Mostrar en el HTML con formato
                $('#totalConSuplidos').text(totalConSuplidos.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
            } else {
                console.warn("No se pudo obtener un total válido desde #totalFactura");
            }

        },
        initComplete: function(settings, json) {
            // Esta función se ejecuta cuando la tabla ha terminado de cargar
            // window.print(); // No imprimir dos veces
        }
    });

    // Forzar que la tabla muestre 10 filas (igual que antes)
    suplidosTabla.page.len(10).draw();
    suplidosTabla.column(0).visible(true);

    $("#suplidosTabla").addClass("width-50"); // Mantener responsividad

   

});
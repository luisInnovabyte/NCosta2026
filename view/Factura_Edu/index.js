$(document).ready(function() {


    let idLlegada = $('#idLlegada').val();

    var facturas_table = $("#facturas_table").DataTable({
        select: false,
        serverSide: true,
        ajax: {
            url: "../../controller/proforma.php?op=listarFacturasXLlegadaReal",
            type: "get",
            dataType: "json",
            cache: false,
            data: function (d) {
                d.idLlegada = $('#idLlegada').val();
            },
            beforeSend: function () {
                // Puedes poner un loader aquí si quieres
            },
            complete: function (data) {},
            error: function (e) {
                console.error('Error al cargar facturas:', e);
            }
        },
        columns: [
            { name: "id" },
            { name: "nombre" },
            { name: "aquienFactura" },
            { name: "numeroFactura" },
            { name: "fecha" },
            { name: "botonFactura" },
            { name: "botonFacturaIVA" },
            { name: "botonFacturaREAV" },
            { name: "pagado" },
            { name: "pagoPendiente" }
        ],
        columnDefs: [
            { targets: 0, visible: false },
            { targets: [1, 2, 3, 4, 5, 6, 7], className: 'text-center' }

        ],
        orderFixed: [[1, "asc"]],
        searchBuilder: {
            columns: [1, 2, 3, 4, 5, 6]
        }
    });
    $("#facturas_table").addClass("width-100");

    
/* 

    cargarInformacionFactura();

    $('.radioQuienFactura').on('change', function() {
        cargarInformacionFactura();
    });

    function cargarInformacionFactura() {
        var valorSeleccionado = $('.radioQuienFactura:checked').val();
        console.log('Valor seleccionado:', valorSeleccionado);

        idPrescriptor = $('#idPrescriptor').val();
        idAgente = $('#idAgente').val();

        // Ejemplo de lógica según el valor
        if (valorSeleccionado === '1') {

            console.log('Se ha seleccionado Alumno');
            $.post('../../controller/prescriptor.php?op=recogerInfo', { idPrescriptor: idPrescriptor}, function(response) {
                let alumnos = JSON.parse(response);
                console.log(alumnos)
                $('#nombreFacturacion').val(alumnos[0].nomPrescripcion+' '+alumnos[0].apePrescripcion);
                $('#cifFact').val(alumnos[0].identificadorDocumento);
                $('#direcFact').val(alumnos[0].ciudadCasaPrescripcion);
                $('#movilFact').val(alumnos[0].movilCasaPrescripcion);
                $('#tefFact').val(alumnos[0].tefCasaPrescripcion);
                $('#correoFact').val(alumnos[0].emailCasaPrescripcion);
                $('#cpFact').val(alumnos[0].cpCasaPrescripcion);
                $('#paisFact').val(alumnos[0].paisCasaPrescripcion);
                $('#nombreAlumno').html("<a href='../../view/Perfil/?tokenUsuario=" + alumnos[0].tokenPrescriptores + "'>" + alumnos[0].nomPrescripcion + " " + alumnos[0].apePrescripcion + "</a>");
            });

        } else if (valorSeleccionado === '2') {
            console.log('Se ha seleccionado Agente');
              $.post('../../controller/prescriptor.php?op=recogerInfoAgente', { idAgente: idAgente}, function(response) {
                let agente = JSON.parse(response);
                console.log(agente)
                $('#nombreFacturacion').val(agente[0].nombreAgente);
                $('#cifFact').val(agente[0].identificacionFiscal);
                $('#direcFact').val(agente[0].domicilioFiscal);
                $('#movilFact').val('');
                $('#tefFact').val('');
                $('#correoFact').val(agente[0].correoAgente);
                $('#cpFact').val('');
                $('#paisFact').val('');
            });
        } else if (valorSeleccionado === '3') {
            console.log('Se ha seleccionado Grupo');
                $('#nombreFacturacion').val($('#nombreGrupoFacturacion').val());
                $('#cifFact').val('');
                $('#direcFact').val('');
                $('#movilFact').val('');
                $('#tefFact').val('');
                $('#correoFact').val('');
                $('#cpFact').val('');
                $('#paisFact').val('');
        }
    } 
    idDepartamento = $('#idDepartamento').val();
    $.post('../../controller/prescriptor.php?op=recogerUltimaFactura', { idDepartamento: idDepartamento}, function(response) {
        let datoDepartamento = JSON.parse(response);
        console.log(datoDepartamento)
        prefijoDepa = datoDepartamento[0].prefijoFactDepa;
        numeroFactura = datoDepartamento[0].numFacturaDepa;
        numeroFacturaActual = Number(datoDepartamento[0].numFacturaDepa) + 1;
        $('#numProforma').val(numeroFacturaActual);
    });
 */
    idPrescriptor = $('#idPrescriptor').val();
    $.post('../../controller/prescriptor.php?op=recogerInfo', { idPrescriptor: idPrescriptor}, function(response) {
                let alumnos = JSON.parse(response);
                console.log(alumnos)
                let email = alumnos[0].emailCasaPrescripcion.trim();
                                
                if (email) {
                    // Creamos un enlace real <a> que funciona con click normal
                    let link = $('<a>')
                        .attr('href', 'mailto:' + email)
                        .text('Enviar correo: ' + email);

                    $('#enviarCorreoAlum').empty().append(link);
                } else {
                    $('#enviarCorreoAlum').text('No hay correo disponible');
                }
                $('#nombreAlumno').html("<a href='../../view/Perfil/?tokenUsuario=" + alumnos[0].tokenPrescriptores + "' target='_blank'>" + alumnos[0].nomPrescripcion + " " + alumnos[0].apePrescripcion + "</a>");
            });
    idFacturaPro = $('#idFacturaPro').val();
    // PRODUCTOS
    var facturaTabla = $("#facturaTabla").DataTable({
        pageLength: 7, // Muestra solo 5 registros por página
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
        select: false, // No permite seleccionar filas para exportar
        buttons: [],
        language: {
            emptyTable: "Añada productos a facturar"
        },
        columns: [
            /*
            { name: "id" },
            { name: "Codigo", className: "text-center" },
            { name: "Concepto", className: "text-center" },
            { name: "Tipo", className: "text-center d-none" },
            { name: "IVA", className: "text-center" },
            { name: "Descuento", className: "text-center" },
            { name: "Subtotal", className: "text-center" },
            { name: "Total", className: "text-center" },
            */
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
                targets: [0],
                visible: true, // Oculta la columna ID
            }
        ],
        searchBuilder: {
            columns: [1, 2, 3], // Ajustado a las columnas existentes
        },
        ajax: {
            url: "../../controller/proforma.php?op=cargarProductoIdEnFactura",
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            data: {
                idFactura: idFacturaPro
               
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
        }, footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            let total = 0;
            let totalSinIva = 0;

            // === TOTAL SIN IVA ===
            api.column(5, { search: 'applied' }).data().each(function (value) {
                // Quitar puntos de miles y cambiar coma por punto
                let limpio = value.replace(/\./g, '').replace(',', '.');
                let numero = parseFloat(limpio);
                if (!isNaN(numero)) totalSinIva += numero;
            });

            $('#totalSinIva').text(
                totalSinIva.toLocaleString("es-ES", {
                    style: "currency",
                    currency: "EUR",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );

            // === TOTAL CON IVA ===
            api.column(7, { search: 'applied' }).data().each(function (value) {
                let limpio = value.replace(/\./g, '').replace(',', '.');
                let numero = parseFloat(limpio);
                if (!isNaN(numero)) total += numero;
            });

            // === YA PAGADO ===
            let yaPagadoTexto = $('#YaPagado').text(); // Ej: "1.234,56€"
            let yaPagado = parseFloat(
                yaPagadoTexto.replace(/[^\d,.-]/g, '').replace(/\./g, '').replace(',', '.')
            );

            // === TOTAL PENDIENTE ===
            let totalPendiente = total;
            if (!isNaN(yaPagado)) {
                totalPendiente = total - yaPagado;
            }

            // Mostrar Total con IVA
            $('#totalCompletoConIva').text(
                total.toLocaleString("es-ES", {
                    style: "currency",
                    currency: "EUR",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );

            // Mostrar Total Pendiente
                let suplidosText = $('#totalSuplidos').text(); // "6€"
                let suplidos = parseFloat(suplidosText.replace('€', '').replace(/\./g, '').replace(',', '.')) || 0;
                totalPendiente = parseFloat(totalPendiente) || 0; // Asegúrate que también es número

                let totalConSuplidos = totalPendiente + suplidos;

                $('#totalConIva').text(
                    totalConSuplidos.toLocaleString("es-ES", {
                        style: "currency",
                        currency: "EUR",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
            );

            // === CATEGORÍAS: Cursos, Alojamiento, Otros ===
            let totalMatriculacion = 0;
            let totalAlojamiento = 0;
            let totalOtros = 0;

            api.rows({ search: 'applied' }).every(function () {
                let data = this.data();
                let tipo = $('<div>').html(data[3]).text().trim(); // columna tipo
                let valor = parseFloat(data[7].replace(/[^\d,.-]/g, '').replace(/\./g, '').replace(',', '.')); // columna total €

                if (!isNaN(valor)) {
                    if (tipo === "Matriculación") totalMatriculacion += valor;
                    else if (tipo === "Alojamiento") totalAlojamiento += valor;
                    else totalOtros += valor;
                }
            });

            // Mostrar subtotales con formato moneda
            $('#totalCursos').text(
                totalMatriculacion.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
            );
            $('#totalAloja').text(
                totalAlojamiento.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
            );
            $('#totalAloja').text(
                totalOtros.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
            );
        }
    });
    
    // Forzar que la tabla muestre 10 filas (igual que antes)
    facturaTabla.page.len(10).draw();
    facturaTabla.column(0).visible(true);

    $("#facturaTabla").addClass("width-100"); // Mantener responsividad




    
    //=================================//
    //   APARTADO SELECCIONAR TARIFA  //
    //===============================//
    //==========================================//
    //   PRIMERO SE DEFINE EL DATATABLE VACÍO  //
    //========================================//

    // DECLARACIÓN DE DATATABLE DE FACTURAS (POR AHORA SOLO TIENE SU ESTRUCTURA),
    // (MÁS ADELANTE SE LE PONDRÁ SU INFORMACIÓN)
    var tarifaAloja_table = $("#tarifas_table").DataTable({
    select: false, // Nos permite seleccionar filas para exportar

    columns: [
        { name: "idTarifasAloja" },
        { name: "codigo" },
        { name: "nombre" },
        { name: "medidaTarifasAloja" },
        { name: "importeTarifasAloja", className: "text-center wd-30" },
        { name: "iva", className: "text-center wd-30" },
        { name: "descuento", className: "text-center wd-30" },
        { name: "tIPO", className: "text-center wd-30" },

    ],
    columnDefs: [
        { targets: [0], orderData: [0], visible: false }, // ID oculto
        { targets: [1], orderData: [1], visible: true },
        { targets: [2], orderData: [2], visible: true },
        { targets: [3], orderData: [3], visible: true },
        { targets: [4], orderData: [4], visible: true },

        { targets: [5], orderData: [5], visible: true },
        { targets: [6], orderData: false, visible: true },
        { targets: [7], orderData: [7], visible: true }

    ],

    searchBuilder: {
        columns: [1, 3],
    },

    ajax: {
        // URL inicial vacía. Se actualizará cuando el modal se abra.
        url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaFactura",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
        // Cualquier acción antes de enviar la solicitud
        },
        complete: function (data) {},

        error: function (e) {},

        orderFixed: [[1, "asc"]],
        searchBuilder: {
        columns: [1, 2, 3, 4, 5,6],
        },
    },
    });
    $('#FootIDTarifas').on('keyup', function () {
    tarifaAloja_table
            .columns(0)
            .search(this.value)
            .draw();
    });
    $('#FootCodTarifas').on('keyup', function () {
        tarifaAloja_table
            .columns(1)
            .search(this.value)
            .draw();
        });
    $('#FootNombreTarifas').on('keyup', function () {
        tarifaAloja_table
            .columns(2)
            .search(this.value)
            .draw();
        });
        $('#FootUnidadesTarifas').on('keyup', function () {
        tarifaAloja_table
                .columns(3)
                .search(this.value)
                .draw();
        });
    $('#FootDescuentoTarifas').on('keyup', function () {
        tarifaAloja_table
            .columns(4)
            .search(this.value)
            .draw();
        });
        $('#FootIVATarifas').on('keyup', function () {
        tarifaAloja_table
                .columns(5)
                .search(this.value)
                .draw();
        });
        $('#FootPrecioTarifas').on('keyup', function () {
            tarifaAloja_table
                .columns(6)
                .search(this.value)
                .draw();
        });


        //=================================//
        //   APARTADO SELECCIONAR TARIFA  //
        //===============================//

        // SE LE AÑADE AL DATATABLE EL EVENTO PARA PODER CONTROLAR LOS FILTROS

        $("#tarifas_table")
        .on("draw.dt", function () {
            controlarFiltros("tarifas_table");
        })
        .addClass("width-100"); // Para hacer el DataTable responsive

        // ACCIÓN DEL BOTÓN QUE EJECUTA EL MÉTODO PARA ABRIR EL MODAL
        // (SIN ESO NO DETECTABA EL CLICK DEL BOTÓN, AUNQUE SE LE)
        // (PUSIERA EL ONCLICK EN EL HTML LO IGNORABA)
        $("button.abrirModalTarifas").on("click", function() {
            // Aquí va la función que deseas ejecutar
            abrirModalTarifas("Docencia"); // O cualquier otra función
        });

        // MÉTODO USADO EN EL HTML PARA ABRIR EL MODAL
        function abrirModalTarifas() {
            $("#buscar-tarifaAloja-modal").modal("show");
        }

        // Función auxiliar para limpiar textos numéricos europeos y convertirlos a float
        function limpiarNumero(texto) {
        return parseFloat(
            texto
            .replace(/[€%]/g, '')   // Eliminar € y %
            .replace(/\./g, '')     // Eliminar puntos de miles
            .replace(',', '.')      // Reemplazar coma decimal por punto
            .replace(/\s/g, '')     // Eliminar espacios
            .trim()                 // Eliminar espacios al inicio/final
        );
        }

        $("#buscar-tarifaAloja-modal").on("shown.bs.modal", function () {
        

        // SE CAMBIA LA URL DEL DATATABLE CARGADO ANTERIORMENTE, Y SE OBTIENEN LOS DATOS NECESARIOS

        tarifaAloja_table.ajax.url(
            "../../controller/tarifaAloja_Edu.php?op=listarTarifasAll"
        ).load(function (json) {
            // AQUÍ SE QUITAN LOS FILTROS Y SE CARGA EL PODER CONTROLAR LOS FILTROS DE NUEVO
            $("#tarifas_table_wrapper").find(".quitarFiltros").parent().parent().trigger("click");
        }).on("draw.dt", function () {
            controlarFiltros("tarifas_table"); // Llamas a la función para controlar filtros
        });
        });
        // EVENTO PARA CAPTURAR EL CLICK EN UNA FILA (TR) DEL DATATABLE
        $("#tarifas_table tbody").on("click", "tr", function () {
        
        var data = tarifaAloja_table.row(this).data();
        console.log("data de la fila seleccionada:", data);

        // Asignación de campos normales
        $("#codigoIdFactura").val(data[0]);
        $("#codigoFacturaContenido").val(data[1]);
        $("#conceptoFacturaContenido").val(data[2] + "(" + $(data[3]).text() + ")");

        // Limpieza y asignación de valores numéricos
        var descuentoNumerico = limpiarNumero($(data[4]).text());
        var ivaNumerico = limpiarNumero($(data[5]).text());
        var totalNumerico = limpiarNumero($(data[6]).text());

        // Si totalNumerico no es un número, asignamos 0
        if (!totalNumerico || isNaN(totalNumerico)) {
            totalNumerico = 0;
        }

         var tipo =$(data[7]).text();
           console.log(tipo);
        if(tipo == 'Alojamiento'){
            $('#tipoFacturaContenido').val('2');

        }else if(tipo == 'Docencia'){
            $('#tipoFacturaContenido').val('1');
        }else if(tipo == 'Otros'){
            $('#tipoFacturaContenido').val('3');
        }else{
            $('#tipoFacturaContenido').val('4');
        }
        $("#descuentoFacturaContenido").val(descuentoNumerico);
        $("#ivaFacturaContenido").val(ivaNumerico);
        $("#importeFacturaContenido").val(totalNumerico);


        $("#ivaDocencia:visible").val($(data[5]).text());
        $("#ivaAlojamiento:visible").val($(data[5]).text());
        $("#descDocencia:visible").val($(data[4]).text());
        $("#descuentoAlojamiento:visible").val($(data[4]).text());
        // Cerramos el modal
        $("#buscar-tarifaAloja-modal").modal("hide");
        
        });

                    });
                    //=================================//
                    //   CIERRE DOCUMENT READY        //
                    //===============================//

//===================================================//
        //   MÉTODO PARA TENER EN INPUT TEXT SOLO DECIMALES //
        //=================================================//

     function soloNumerosYUnPunto(selector) {
        $(selector).on('keypress', function (event) {
            var charCode = event.which || event.keyCode;
            var charStr = String.fromCharCode(charCode);
            
            // Permitir números (0-9)
            if (charCode >= 48 && charCode <= 57) return;

            // Permitir un solo punto si aún no hay uno
            if (charStr === '.' && $(this).val().indexOf('.') === -1) return;

            // Bloquear todo lo demás
            event.preventDefault();
        });

        // También bloquear pegar texto no numérico
        $(selector).on('paste', function (event) {
            event.preventDefault();
        });
    }

    // Aplica la validación a los tres campos
    soloNumerosYUnPunto('#ivaFacturaContenido');
    soloNumerosYUnPunto('#descuentoFacturaContenido');
    soloNumerosYUnPunto('#importeFacturaContenido');


        //=================================//
        //   APARTADO GUARDAR  FACTURA    //
        //===============================//


    function guardarFactura(){
        idLlegada = $('#idLlegada').val();
        codigoFactura = $('#codigoFacturaContenido').val();
        conceptoFactura = $('#conceptoFacturaContenido').val();
        tipoFactura = $('#tipoFacturaContenido').val();
        ivaFactura = $('#ivaFacturaContenido').val();
        descuentoFactura = $('#descuentoFacturaContenido').val();
        importeFactura = $('#importeFacturaContenido').val();
        
        // Array con campos y mensajes de error
        let campos = [
            { valor: idLlegada, mensaje: "ID de llegada no puede estar vacío" },
            { valor: codigoFactura, mensaje: "Código de factura no puede estar vacío" },
            { valor: conceptoFactura, mensaje: "Concepto de factura no puede estar vacío" },
            { valor: ivaFactura, mensaje: "IVA de factura no puede estar vacío" },
            { valor: descuentoFactura, mensaje: "Descuento de factura no puede estar vacío" },
            { valor: importeFactura, mensaje: "Importe de factura no puede estar vacío" }
        ];

        // Validación
        let errores = [];
        campos.forEach(campo => {
            if (!campo.valor || campo.valor.trim() === '') {
                errores.push(campo.mensaje);
            }
        });

        if (errores.length > 0){
            toastr.error(errores.join("<br>"));
            return; // Salir sin hacer el post si hay errores
        }
     // Normalizar valores numéricos (cambiar coma por punto)
        ivaFactura = ivaFactura.replace(',', '.');
        descuentoFactura = descuentoFactura.replace(',', '.');
        importeFactura = importeFactura.replace(',', '.');



        $.post('../../controller/proforma.php?op=insertarFactura', { idLlegada:idLlegada,codigoFactura: codigoFactura, conceptoFactura:conceptoFactura,tipoFactura:tipoFactura, ivaFactura:ivaFactura, descuentoFactura:descuentoFactura, importeFactura:importeFactura}, function(response) {
           toastr.success("Tarifa Insertada");
           $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR
            $('#codigoFacturaContenido').val('');
            $('#conceptoFacturaContenido').val('');
            $('#tipoFacturaContenido').val('');
            $('#ivaFacturaContenido').val('');
            $('#descuentoFacturaContenido').val('');
            $('#importeFacturaContenido').val('');   
        });
    }

    function cargarElementoTarifa(idElemento){
        $('.editarOn').removeClass('d-none');
        $('.editarOff').addClass('d-none');

         $.post('../../controller/proforma.php?op=recogerDatosEditar', { idElemento:idElemento}, function(response) {
            let datosTarifa = JSON.parse(response);
            console.log(datosTarifa)
            codigoFacturaContenido = datosTarifa[0].codigoFacturaContenido;
            conceptoFacturaContenido = datosTarifa[0].conceptoFacturaContenido;
            descuentoFacturaContenido = datosTarifa[0].descuentoFacturaContenido;
            importeFacturaContenido = datosTarifa[0].importeFacturaContenido;
            ivaFacturaContenido = datosTarifa[0].ivaFacturaContenido;
            tipoFacturaContenido = datosTarifa[0].tipoFacturaContenido;
            idContenidoFactura = datosTarifa[0].idContenidoFactura;

            $('#codigoFacturaContenido').val(codigoFacturaContenido);
            $('#conceptoFacturaContenido').val(conceptoFacturaContenido);
            $('#tipoFacturaContenido').val(tipoFacturaContenido);
            $('#ivaFacturaContenido').val(ivaFacturaContenido);
            $('#descuentoFacturaContenido').val(descuentoFacturaContenido);
            $('#importeFacturaContenido').val(importeFacturaContenido);   
            $('#idEditando').text(idContenidoFactura);


            toastr.info("Tarifa Cargada");

        });
    }

    function cancelarEdicion(){
        $('.editarOn').addClass('d-none');
        $('.editarOff').removeClass('d-none');
        $('#idEditando').text('');
        $('#codigoFacturaContenido').val('');
        $('#conceptoFacturaContenido').val('');
        $('#tipoFacturaContenido').val('');
        $('#ivaFacturaContenido').val('');
        $('#descuentoFacturaContenido').val('');
        $('#importeFacturaContenido').val('');   
    }

    
    function guardarEdicion(){
        idEditando = $('#idEditando').text();
        codigoFactura = $('#codigoFacturaContenido').val();
        conceptoFactura = $('#conceptoFacturaContenido').val();
        tipoFactura = $('#tipoFacturaContenido').val();
        ivaFactura = $('#ivaFacturaContenido').val();
        descuentoFactura = $('#descuentoFacturaContenido').val();
        importeFactura = $('#importeFacturaContenido').val();
        
        // Array con campos y mensajes de error
        let campos = [
            { valor: idEditando, mensaje: "ID no puede estar vacío" },
            { valor: codigoFactura, mensaje: "Código de factura no puede estar vacío" },
            { valor: conceptoFactura, mensaje: "Concepto de factura no puede estar vacío" },
            { valor: tipoFactura, mensaje: "Tipo de factura no puede estar vacío" },
            { valor: ivaFactura, mensaje: "IVA de factura no puede estar vacío" },
            { valor: descuentoFactura, mensaje: "Descuento de factura no puede estar vacío" },
            { valor: importeFactura, mensaje: "Importe de factura no puede estar vacío" }
        ];

        // Validación
        let errores = [];
        campos.forEach(campo => {
            if (!campo.valor || campo.valor.trim() === '') {
                errores.push(campo.mensaje);
            }
        });

        if (errores.length > 0){
            toastr.error(errores.join("<br>"));
            return; // Salir sin hacer el post si hay errores
        }

        $.post('../../controller/proforma.php?op=editarTarifa', { idEditando:idEditando,codigoFactura: codigoFactura, conceptoFactura:conceptoFactura,tipoFactura:tipoFactura, ivaFactura:ivaFactura, descuentoFactura:descuentoFactura, importeFactura:importeFactura}, function(response) {
           toastr.success("Tarifa Editada");
           $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR
              $('.editarOn').addClass('d-none');
            $('.editarOff').removeClass('d-none');
            $('#idEditando').text('');
            $('#codigoFacturaContenido').val('');
            $('#conceptoFacturaContenido').val('');
            $('#tipoFacturaContenido').val('');
            $('#ivaFacturaContenido').val('');
            $('#descuentoFacturaContenido').val('');
            $('#importeFacturaContenido').val('');   
        });
    }

    function eliminarTarifa(idTarifa){
         $.post('../../controller/proforma.php?op=eliminarTarifa', { idTarifa:idTarifa}, function(response) {
           $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR
           toastr.success("Tarifa Eliminada");

        });
    }




     $("button.abrirModalLlegadas").on("click", function() {
        // Aquí va la función que deseas ejecutar
        abrirModalLlegadas("Docencia"); // O cualquier otra función
    });
    function abrirModalLlegadas() {
        $("#buscar-Llegadas-modal").modal("show");
        idLlegada = $('#idLlegada').val();
        
    }

  
 

    idLlegada = $('#idLlegada').val();
    idFacturaPro = $('#idFacturaPro').val();

    /*
    var matriculacionTable = $("#matriculacionTableNew").DataTable({
        select: false, // Nos permite seleccionar filas para exportar
        buttons:[],
        columns: [
            { name: "Tipo", className: 'secundariaDef' },          // Corresponde a "Tarifa"
            { name: "Tarifa", className: 'secundariaDef' },          // Corresponde a "Tarifa"
            { name: "Descripcion", className: 'secundariaDef' },    // Corresponde a "Descripción"
            { name: "Observacion", className: 'secundariaDef' },    // Corresponde a "Observación"
            { name: "Importe", className: 'text-center' },          // Corresponde a "Importe"
            { name: "IVA", className: 'text-center' },              // Corresponde a "IVA"
            { name: "Descuento", className: 'text-center' },        // Corresponde a "Descuento"
            { name: "FechaInicio", className: 'text-center' },      // Corresponde a "Fecha Inicio"
            { name: "FechaFin", className: 'text-center' },         // Corresponde a "Fecha Fin"
            { name: "tipoId", className: 'text-center' },         // Corresponde a "Fecha Fin"

        ],
        
        columnDefs: [
            { targets: [0], orderable: true, visible: true }, // Tarifa
            { targets: [1], orderable: true, visible: true }, // Descripción
            { targets: [2], orderable: true, visible: true }, // Observación
            { targets: [3], orderable: true, visible: true }, // Importe
            { targets: [4], orderable: true, visible: true }, // IVA
            { targets: [5], orderable: true, visible: true }, // Descuento
            { targets: [6], orderable: true, visible: true }, // Fecha Inicio
            { targets: [7], orderable: true, visible: true }, // Fecha Fin
            { targets: [8], orderable: true, visible: true }, // Fecha Fin
            { targets: [9], orderable: true, visible: false }, // Fecha Fin

        ],

        searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
            columns: [0, 1, 2, 3, 4, 5, 6, 7]
        },

        ajax: {
            //`../../controller/proforma.php?op=listarMatriculacionesFacturaReal&idFacturaPro=${idFacturaPro}` QUIERO IMAGINAR QUE LA MATRICULACIÓN USA EL MISMO MÉTODO PARA
            // OBTENER LOS DATOS QUE EN FACTURAPRO_EDU
            url: `../../controller/proforma.php?op=listarFacturaContenido&idFacturaPro=${idFacturaPro}`, // Añadimos el parámetro
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: false,
            processData: true,
            beforeSend: function () {
                // Código opcional antes de enviar
            },
            complete: function (data) {
                
                        console.log("Datos recibidos:", data);

                // Código opcional al completar
            },
            error: function (e) {
                console.error("Error en la carga de datos:", e);
            }
        },

        
        createdRow: function (row, data, dataIndex) {
            // Personaliza las filas si es necesario
        }
    });
    matriculacionTable.column(9).visible(false); // Oculta la columna con índice 3


    $("#matriculacionTableNew").addClass("width-100");

   
     $("#matriculacionTableNew tbody").on("click", "tr", function () {
        
       var table = $("#matriculacionTableNew").DataTable(); // <-- Aquí recuperas el DataTable
        var data = table.row(this).data(); // <-- Ahora puedes usar .row() correctamente
        // Asignación de campos normales
       
        $("#codigoFacturaContenido").val(data[1]);

        $("#conceptoFacturaContenido").val(data[2]);

        var descuentoNumerico = data[6].replace('%', '').trim();
        $('#descuentoFacturaContenido').val(descuentoNumerico);

        var ivaNumerico = data[5].replace('%', '').trim();
        $('#ivaFacturaContenido').val(ivaNumerico);

        var importeNumerico = data[4].replace('€', '').trim();
        $('#importeFacturaContenido').val(importeNumerico);

        $("#tipoFacturaContenido").val(data[9]);


      
        $("#buscar-Llegadas-modal").modal("hide");
        
    });
    */
   
    //===========================//
    // APARTADO INSERTAR FACTURA //
    //==========================//


        
    $("#guardarFacturaBoton").on("click", function() {
         var table = $("#facturaTabla").DataTable(); // <-- Aquí recuperas el DataTable
        if (table.rows().count() === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No hay productos',
                text: 'Debes añadir al menos un producto antes de generar la factura.',
                confirmButtonText: 'Entendido'
            });
        } else {
            // EN CASO DE QUE SI HAYAN REGISTROS, SE PREGUNTA SI QUIERE PONER A TODOS COMO PRESENTES
            Swal.fire({
                title: '<strong style="color:#2e7d32;">¿Quieres generar una factura?</strong>',
                html: '<p style="font-size:1.1rem; color:#555;">Esta acción generará una factura. <b>Se utilizarán los datos de facturación</b> y solo podrá anularse abonando dicha factura.</p>',
                iconHtml: '<i class="fa-solid fa-check-circle" style="color:#2e7d32; font-size:4rem;"></i>',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-check" style="margin-right:8px;"></i> Sí, generar factura',
                cancelButtonText: '<i class="fa-solid fa-times" style="margin-right:8px;"></i> Cancelar',
                confirmButtonColor: '#2e7d32',
                cancelButtonColor: '#c62828',
                background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
                customClass: {
                    popup: 'shadow-lg rounded-3',
                    title: 'mb-3',
                    htmlContainer: 'mb-4',
                    confirmButton: 'btn btn-success px-4 py-2',
                    cancelButton: 'btn btn-danger px-4 py-2 ms-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                let today = new Date();

                    // Formateo tipo YYYY-MM-DD
                    let fechaActual = today.getFullYear() + '-' +
                        String(today.getMonth() + 1).padStart(2, '0') + '-' +
                        String(today.getDate()).padStart(2, '0');

                    var datosFormulario = {
                                // CABECERA //
                                nombreCabecera : $('#nombreFacturacion').val(),
                                cifCabecera : $('#cifFact').val(),
                                direcCabecera : $('#direcFact').val(),
                                movilCabecera : $('#movilFact').val(),
                                telefonoCabecera : $('#tefFact').val(),
                                cpCabecera : $('#cpFact').val(),
                                correoCabecera : $('#correoFact').val(),
                                paisCabecera : $('#paisFact').val(),

                                // PIE
                                idLlegada : $('#idLlegada').val(),
                                numFactura : $('#numProforma').val(),
                                numProforma : $('#idFacturaPro').val(),
                                serieProforma : 'Serie',
                                fechaProforma : fechaActual,
                                idAgente : $('#idAgente').val(),
                                grupoAmigos : 'NoNecesario',
                                grupoFacturacion : 'NoNecesario',
                                quienFactura : 'NoNecesario',
                                aQuienFactura : $('.radioQuienFactura:checked').val(),
                                conceptoExtra : $('#conceptoExtra').val(),

                                // ID DEPARTAMENTO PARA NUMpROFORMA
                                idDepartamento : $('#idDepartamento').val()
                            };
                            // Crear un objeto FormData
                            var formData = new FormData();

                            // Agregar los datos al objeto FormData
                            for (var key in datosFormulario) {
                                formData.append(key, datosFormulario[key]);
                            }

                            
                            $.ajax({
                                url: '../../controller/proforma.php?op=guardarFacturaReal',
                                type: 'POST',
                                data: formData,
                                processData: false, // Importante para evitar que jQuery procese los datos
                                contentType: false, // Importante para que el navegador determine el tipo de contenido
                                success: (response) => {
                                    let data = JSON.parse(response); // ← aquí simplemente lo parseas
                                    let numFactura = data.numFactura;
                                    let idLlegada = data.idLlegada;

                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Listo!',
                                        text: 'Factura Generada',
                                        timer: 2500,
                                        showConfirmButton: true,
                                        confirmButtonText: 'Cerrar',
                                        background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
                                        customClass: { popup: 'shadow-lg rounded-3' }
                                }).then(() => {
                                        // Recargar la página cuando se cierre el Swal
                                        /*location.reload();*/
                                        imprimirFacturaDatatable(numFactura, 1, idLlegada);

                                        window.location.href = '../MntFacturacion/';

                                    });
                                },
                                error: () => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo guardar la factura',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Cerrar'
                                    });
                                }
                            });
                        }
                    });
            }
    });


        function abrirModalFacturas() {
            $("#buscar-facturas-modal").modal("show");
        }

        function imprimirFactura(idFactura, tipoFactura) {
            if (!idFactura) {
                console.warn("idFactura no encontrado en la URL");
                return;
            }

            const nuevaVentana = window.open(
                `factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}`,
                "_blank",
                "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
            );
        }
        function imprimirFacturaDatatablePro(idFactura, tipoFactura, idLlegada) {
                        
                        console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

                        if (!idFactura) {
                            console.warn("idFactura no encontrado en la URL");
                            return;
                        }

                        const nuevaVentana = window.open(
                        `../FacturaPro_Edu/factura.php?idFactura=${encodeURIComponent(idFactura.toString().trim())}&tipoFactura=${encodeURIComponent(tipoFactura.toString().trim())}&idLlegada=${encodeURIComponent(idLlegada.toString().trim())}`,
                        "_blank",
                        "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
                        );

                          // Esperamos a que la ventana se cargue completamente
                    nuevaVentana.onload = function() {
                        // Llamamos a print

                        // Cerramos la ventana después de imprimir
                        nuevaVentana.onafterprint = function() {
                            nuevaVentana.close();
                        }; 
                    };

        }
        function imprimirFacturaDatatableMismaPagina(idFactura, tipoFactura, idLlegada) {
            console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

            if (!idFactura) {
                console.warn("idFactura no encontrado en la URL");
                return;
            }

            // Redirige en la misma pestaña
            window.location.href = `factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}`;
            
        }


    idDepartamento = $('#idDepartamento').val();
    
    $.post('../../controller/prescriptor.php?op=recogerUltimaFacturaPro', { idDepartamento: idDepartamento}, function(response) {
        let datoDepartamento = JSON.parse(response);
        console.log(datoDepartamento)
        prefijoDepa = datoDepartamento[0].prefijoFactDepa;
        numeroFactura = datoDepartamento[0].numFacturaDepa;
        numeroFacturaActual = Number(datoDepartamento[0].numFacturaDepa) + 1;
        $('#numProforma').val(numeroFacturaActual);
    });

    idLlegada = $('#idLlegada').val();
     $("#llegadaNum").val(
        "NUM" + idLlegada.toString().padStart(4, "0")
    );

    //FUNCIÓN PARA GUARDAR LA FACTURA EN EL BOTÓN DE FACTURA PAGADA
    
    function pagarFactura(idPie) {
    Swal.fire({
        title: '<strong style="color:#2e7d32;">¿Quieres pagar la factura?</strong>',
        html: '<p style="font-size:1.1rem; color:#555;">Esta acción pagará la factura.',
        iconHtml: '<i class="fa-solid fa-check-circle" style="color:#2e7d32; font-size:4rem;"></i>',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check" style="margin-right:8px;"></i> Sí, pagar factura',
        cancelButtonText: '<i class="fa-solid fa-times" style="margin-right:8px;"></i> No pagar',
        confirmButtonColor: '#2e7d32',
        cancelButtonColor: '#c62828',
        background: 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)',
        customClass: {
            popup: 'shadow-lg rounded-3',
            title: 'mb-3',
            htmlContainer: 'mb-4',
            confirmButton: 'btn btn-success px-4 py-2',
            cancelButton: 'btn btn-danger px-4 py-2 ms-3'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            
            // Usuario aceptó: Pagar factura
            $.post("../../controller/proforma.php?op=activarFactura", { idPie: idPie }, function (data) {
                $('#facturas_table').DataTable().ajax.reload();

                Swal.fire(
                    'Factura Pagada',
                    'Cambios actualizados correctamente.',
                    'success'
                  ).then(() => {
                    // Espera 2 segundos y recarga la página
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                });
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Usuario canceló: No pagar factura
            $('#facturas_table').DataTable().ajax.reload();
            
            $.post("../../controller/proforma.php?op=desactivarFactura", { idPie: idPie }, function (data) {
                Swal.fire(
                    'No pagada',
                    'No se realizo el pago.',
                    'info'
                 ).then(() => {
                                // Espera 2 segundos y recarga la página
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    });;
            });
        }
        
    });
}

     function imprimirFacturaDatatable(idFactura, tipoFactura, idLlegada) {
            
        console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

        if (!idFactura) {
            console.warn("idFactura no encontrado en la URL");
            return;
        }

        const nuevaVentana = window.open(
            `factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}`,
            "_blank",
            "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
        );

    }


     function realizarAbono(idPie, numFactura) {
            // Cerrar el modal de Bootstrap si está abierto
            $('#buscar-facturas-modal').modal('hide'); // 👈 Asegúrate de que el ID es correcto
            idDepartamento = $('#idDepartamento').val();
            // Esperamos un poco para que se cierre correctamente antes de abrir el Swal
            setTimeout(() => {
                swal.fire({
                    title: 'Abonar',
                    html: `
                        <p>¿Desea abonar la factura con Nº ${numFactura}?</p>
                        <textarea id="motivoAbono" class="swal2-textarea" placeholder="Motivo del abono"></textarea>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Abonar',
                    cancelButtonText: 'No',
                    reverseButtons: true,
                    focusConfirm: false,
                    didOpen: () => {
                        $('#motivoAbono').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const motivoAbono = $('#motivoAbono').val().trim();
                        if (!motivoAbono) {
                                swal.fire('Error', 'Debe ingresar un motivo para el abono', 'error');
                                return;
                        }
                        $.post("../../controller/proforma.php?op=abonarFacturaReal", {
                            idPie: idPie,
                            motivo: motivoAbono,
                            idDepartamento: idDepartamento
                        }, function (data) {
                            $('#facturas_table').DataTable().ajax.reload();

                             Swal.fire(
                                'Abonada',
                                'La factura ha sido abonada',
                                'success'
                            ).then(() => {
                                // Espera 2 segundos y recarga la página
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            });
                        });
                    }/* else{
                        $('#buscar-facturas-modal').modal('show'); // 👈 Asegúrate de que el ID es correcto
                    } */
                });
            }, 300); // Pequeño retraso para asegurar que el modal se cerró
        }
   
        function realizarAbonoProformaIndex(idPie, numFactura) {
            // Cerrar el modal de Bootstrap si está abierto
            $('#buscar-facturas-modal').modal('hide'); // 👈 Asegúrate de que el ID es correcto
            idDepartamento = $('#idDepartamento').val();
            // Esperamos un poco para que se cierre correctamente antes de abrir el Swal
            setTimeout(() => {
                swal.fire({
                    title: 'Abonar',
                    html: `
                        <p>¿Desea abonar la Proforma?</p>
                        <textarea id="motivoAbono" class="swal2-textarea" placeholder="Motivo del abono"></textarea>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Abonar',
                    cancelButtonText: 'No',
                    reverseButtons: true,
                    focusConfirm: false,
                    didOpen: () => {
                        $('#motivoAbono').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const motivoAbono = $('#motivoAbono').val().trim();

                        // 🔹 Validar que el motivo no esté vacío
                        if (!motivoAbono) {
                            swal.fire('Error', 'Debe ingresar un motivo para el abono', 'error');
                            return;
                        }

                        $.post("../../controller/proforma.php?op=abonarFacturaPro", {
                            idPie: idPie,
                            motivo: motivoAbono,
                            idDepartamento: idDepartamento
                        }, function (data) {
                            $('#facturas_table').DataTable().ajax.reload();

                            Swal.fire(
                                'Abonada',
                                'La factura ha sido abonada',
                                'success'
                            ).then(() => {
                                // Espera 2 segundos y recarga la página
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            });
                        });
                    } else {
                      
                    }
                });
            }, 300); // Pequeño retraso para asegurar que el modal se cerró
        }

       
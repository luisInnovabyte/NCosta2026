$(document).ready(function() {

       var existeProforma = $("#existeProforma").val();
   
   function comprobarProformaExistente() {

        // Lista de IDs de inputs a deshabilitar
        var inputs = [
            "#nombreFacturacion",
            "#cifFact",
            "#movilFact",
            "#tefFact",
            "#correoFact",
            "#direcFact",
            "#cpFact",
            "#paisFact",
            "#codigoFacturaContenido",
            "#conceptoFacturaContenido",
            "#tipoFacturaContenido", // Select incluido
            "#ivaFacturaContenido",
            "#descuentoFacturaContenido",
            "#importeFacturaContenido"
        ];

        if (existeProforma === "1") {
            // Deshabilitar inputs
            inputs.forEach(function (id) {
                $(id).prop("disabled", true);
            });

            // Deshabilitar radios con clase radioQuienFactura
            $(".radioQuienFactura").prop("disabled", true);

            // Deshabilitar botones dentro de .editarOff
            $(".editarOff button").prop("disabled", true);
        } else {
            // Habilitar inputs
            inputs.forEach(function (id) {
                $(id).prop("disabled", false);
            });

            // Habilitar radios con clase radioQuienFactura
            $(".radioQuienFactura").prop("disabled", false);

            // Habilitar botones dentro de .editarOff
            $(".editarOff button").prop("disabled", false);
        }
    }

    comprobarProformaExistente();

    // Función para validar campos requeridos y habilitar/deshabilitar botón de generar proforma
    function validarCamposFacturacion() {
        var direccion = $("#direcFact").val().trim();
        var cpPoblacion = $("#cpFact").val().trim();
        var boton = $("#guardarFacturaBoton");
        var mensaje = $("#mensajeValidacionFactura");

        // Solo validar si no existe proforma (existeProforma == "0")
        if (existeProforma === "0") {
            if (direccion !== "" && cpPoblacion !== "") {
                boton.prop("disabled", false);
                boton.removeClass("btn-secondary").addClass("btn-success");
                mensaje.hide(); // Ocultar mensaje cuando los campos están completos
            } else {
                boton.prop("disabled", true);
                boton.removeClass("btn-success").addClass("btn-secondary");
                mensaje.show(); // Mostrar mensaje cuando faltan campos
            }
        }
    }

    // Event listeners para validar en tiempo real
    $("#direcFact, #cpFact").on("input", function() {
        validarCamposFacturacion();
    });

    // Validación inicial al cargar la página
    validarCamposFacturacion();


    let idLlegada = $('#idLlegada').val();

    var facturas_table = $("#facturas_table").DataTable({
        select: false,
        serverSide: true,
        ajax: {
            url: "../../controller/proforma.php?op=listarFacturasXLlegada",
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
            { name: "verProforma" },
            { name: "botonFactura" },
            { name: "botonFacturaIVA" },
            /*{ name: "botonFacturaREAV", class: 'd-none' }*/
            { name: "pagoPendiente" },
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

    


    // Función al cargar la página
    cargarInformacionFactura();

    // Función al cambiar de opción
    $('.radioQuienFactura').on('change', function() {
        cargarInformacionFactura();
        tipoGrupo = $('.radioQuienFactura:checked').val();
        mostrarBotonFacturaGrupo(tipoGrupo)
    });
    function mostrarBotonFacturaGrupo(tipoGrupo){
        if(tipoGrupo == 3){
            $('.abrirModalGrupo').removeClass('d-none');
            $('.abrirModalLlegadas').addClass('d-none');


        }else{
            $('.abrirModalGrupo').addClass('d-none');
            $('.abrirModalLlegadas').removeClass('d-none');
        }
    }
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
                $('#nombreAlumno').html("<a href='../../view/Perfil/?tokenUsuario=" + alumnos[0].tokenPrescriptores + "'  target='_blank'>" + alumnos[0].nomPrescripcion + " " + alumnos[0].apePrescripcion + "</a>");
                // Validar campos después de cargar
                validarCamposFacturacion();
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
                // Validar campos después de cargar
                validarCamposFacturacion();
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
                // Validar campos después de cargar
                validarCamposFacturacion();
        }
    }
    idDepartamento = $('#idDepartamento').val();
    $.post('../../controller/prescriptor.php?op=recogerUltimaFacturaPro', { idDepartamento: idDepartamento}, function(response) {
        let datoDepartamento = JSON.parse(response);
        console.log(datoDepartamento)
        prefijoDepa = datoDepartamento[0].prefijoFacturaProEdu;
        numeroFactura = datoDepartamento[0].numFacturaProDepa;
        numeroFacturaActual = Number(datoDepartamento[0].numFacturaProDepa) + 1;
        $('#numProforma').val(numeroFacturaActual);
    });

    idLlegada = $('#idLlegada').val();
     $("#llegadaNum").val(
        "NUM" + idLlegada.toString().padStart(4, "0")
    );
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
                { name: "Gestionar", className: "text-center" }
            */

            { name: "id" },
            { name: "Codigo", className: "text-center" },
            { name: "Concepto", className: "text-center" },
            { name: "Tipo", className: "text-center d-none" },
            { name: "Descuento", className: "text-center" },
            { name: "Subtotal", className: "text-center" },
            { name: "IVA", className: "text-center" },
            { name: "Total", className: "text-center" },
            { name: "Gestionar", className: "text-center" }
            
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
            url: "../../controller/proforma.php?op=cargarProductoId",
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            data: {
                idLlegada: idLlegada,
                existeProforma: $('#existeProforma').val()
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
        },footerCallback: function (row, data, start, end, display) {
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
    processing: true,
    language: {
        processing: "Cargando tarifas...",
        emptyTable: "No hay tarifas disponibles"
    },
    columns: [
        { name: "idTarifasAloja", data: 0 },
        { name: "codigo", data: 1 },
        { name: "nombre", data: 2 },
        { name: "medidaTarifasAloja", data: 3 },
        { name: "descuento", data: 4, className: "text-center wd-30" },
        { name: "iva", data: 5, className: "text-center wd-30" },
        { name: "importeTarifasAloja", data: 6, className: "text-center wd-30" },
        { name: "tipo", data: 7, className: "text-center wd-30" }
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
    order: [[1, "asc"]],
    searchBuilder: {
        columns: [1, 2, 3, 4, 5, 6],
    },
    ajax: {
        url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAll",
        type: "GET",
        dataType: "json",
        dataSrc: "aaData",
        cache: false,
        beforeSend: function () {
            console.log("Cargando tarifas...");
        },
        complete: function (data) {
            console.log("Respuesta recibida:", data);
        },
        error: function (xhr, error, thrown) {
            console.error("Error al cargar tarifas:");
            console.error("XHR:", xhr);
            console.error("Error:", error);
            console.error("Thrown:", thrown);
            console.error("Response Text:", xhr.responseText);
        }
    }
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
            console.log("Modal abierto - Recargando tarifas...");
            
            // SE CAMBIA LA URL DEL DATATABLE CARGADO ANTERIORMENTE, Y SE OBTIENEN LOS DATOS NECESARIOS
            tarifaAloja_table.ajax.reload(function (json) {
                console.log("Datos recargados:", json);
                // AQUÍ SE QUITAN LOS FILTROS Y SE CARGA EL PODER CONTROLAR LOS FILTROS DE NUEVO
                $("#tarifas_table_wrapper").find(".quitarFiltros").parent().parent().trigger("click");
                controlarFiltros("tarifas_table");
            }, false);
        });
        
        // EVENTO PARA CAPTURAR EL CLICK EN UNA FILA (TR) DEL DATATABLE
        $("#tarifas_table tbody").on("click", "tr", function () {
        
        var data = tarifaAloja_table.row(this).data();
        console.log("data de la fila seleccionada:", data);
        console.log("data[4] Descuento:", data[4]);
        console.log("data[5] IVA:", data[5]);
        console.log("data[6] Precio:", data[6]);
        console.log("data[7] Tipo:", data[7]);

        // Asignación de campos normales
        $("#codigoIdFactura").val(data[0]);
        $("#codigoFacturaContenido").val(data[1]);
        $("#conceptoFacturaContenido").val(data[2] + "(" + $(data[3]).text() + ")");

        // Limpieza y asignación de valores numéricos
        var descuentoNumerico = limpiarNumero($(data[4]).text());
        var ivaNumerico = limpiarNumero($(data[5]).text());
        var totalNumerico = limpiarNumero($(data[6]).text());

        console.log("descuentoNumerico:", descuentoNumerico);
        console.log("ivaNumerico:", ivaNumerico);
        console.log("totalNumerico:", totalNumerico);

        // Si totalNumerico no es un número, asignamos 0
        if (!totalNumerico || isNaN(totalNumerico)) {
            totalNumerico = 0;
        }

         var tipo =$(data[7]).text();
           console.log("tipo:", tipo);
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
function soloNumerosYComa(selector) {
    $(selector).on('keypress', function (event) {
        var charCode = event.which || event.keyCode;
        var charStr = String.fromCharCode(charCode);

        // Permitir números (0-9)
        if (charCode >= 48 && charCode <= 57) return;

        // Permitir una sola coma si aún no hay una
        if (charStr === ',' && $(this).val().indexOf(',') === -1) return;

        // Bloquear todo lo demás
        event.preventDefault();
    });

    // Bloquear pegar texto con caracteres no válidos
    $(selector).on('paste', function (event) {
        event.preventDefault();
        var pastedData = (event.originalEvent || event).clipboardData.getData('text');

        // Reemplazar punto por coma si el usuario lo pega
        pastedData = pastedData.replace(/\./g, ',');

        // Validar que solo queden números y como mucho una coma
        if (/^\d+(,\d{0,2})?$/.test(pastedData)) {
            $(this).val(pastedData);
        }
    });
}

    soloNumerosYComa('#ivaFacturaContenido');
    soloNumerosYComa('#descuentoFacturaContenido');
    soloNumerosYComa('#importeFacturaContenido');


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
            importeFacturaContenido = importeFacturaContenido.replace('.', ','); 
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
        $.post('../../controller/proforma.php?op=editarTarifa', { idEditando:idEditando,codigoFactura: codigoFactura, conceptoFactura:conceptoFactura,tipoFactura:tipoFactura, ivaFactura:ivaFactura, descuentoFactura:descuentoFactura, importeFactura:importeFactura}, function(response) {
           toastr.success("Tarifa Editada");
           $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR
              $('.editarOn').addClass('d-none');
            $('.editarOff').removeClass('d-none');
            $('#idEditando').text('');
            $('#codigoFacturaContenido').val('');
            $('#conceptoFacturaContenido').val('');
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

     $("button.abrirModalGrupo").on("click", function() {
        nombreGrupos = $('#grupoFact').text();
        $('#textoGrupo').text(nombreGrupos)
        if(nombreGrupos != ''){
            $("#buscar-LlegadasGrupos-modal").modal("show");
        }else{
            toastr.error("No hay grupos asignados a esta factura");
        }
    });
  
 

    idLlegada = $('#idLlegada').val();

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
            url: `../../controller/proforma.php?op=listarMatriculaciones&idLlegada=${idLlegada}`, // Añadimos el parámetro
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
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
    //===========================//
    //   APARTADO GUARDAR FACTURA  //
    //==========================//
   
    nombreGrupos = $('#grupoFact').text();
    if(nombreGrupos != ''){
      
        var matriculacionTableGrupo = $("#matriculacionTableNewGrupos").DataTable({
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
                { name: "nombreAlumno", className: 'text-center' },         // Corresponde a "Fecha Fin"

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
                { targets: [10], orderable: true, visible: true }, // Fecha Fin

            ],

            searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            },

            ajax: {
                url: `../../controller/proforma.php?op=listarMatriculacionesGrupos&nombreGrupos=${nombreGrupos}`, // Añadimos el parámetro
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
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
        matriculacionTableGrupo.column(9).visible(false); // Oculta la columna con índice 3
        matriculacionTableGrupo.column(10).visible(true); 


        $("#matriculacionTableNewGrupos").addClass("width-100");

    
        $("#matriculacionTableNewGrupos tbody").on("click", "tr", function () {
            
        var table = $("#matriculacionTableNewGrupos").DataTable(); // <-- Aquí recuperas el DataTable
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


        
            $("#buscar-LlegadasGrupos-modal").modal("hide");
            
        });



        // TRANSFER LLEGADA //
         var transferLlegadaGrupo = $("#transferLlegadaGrupo").DataTable({
            select: false, // Nos permite seleccionar filas para exportar
            buttons:[],
            columns: [
                 { name: "CÓDIGO", className: 'secundariaDef' },      
                { name: "CONCEPTO", className: 'secundariaDef' },       
                { name: "IVA", className: 'secundariaDef' },    
                { name: "TOTAL", className: 'secundariaDef' },   
              
            ],
            
            columnDefs: [
                { targets: [0], orderable: true, visible: true }, // Tarifa
                { targets: [1], orderable: true, visible: true }, // Descripción
                { targets: [2], orderable: true, visible: true }, // Observación
                { targets: [3], orderable: true, visible: true }
              

            ],

            searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
                columns: [0, 1, 2, 3]
            },

            ajax: {
                url: `../../controller/proforma.php?op=transferGruposLlegada&nombreGrupos=${nombreGrupos}`, // Añadimos el parámetro
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
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
    

        $("#transferLlegadaGrupo").addClass("width-50");

    
        $("#transferLlegadaGrupo tbody").on("click", "tr", function () {
            
        var table = $("#transferLlegadaGrupo").DataTable(); // <-- Aquí recuperas el DataTable
            var data = table.row(this).data(); // <-- Ahora puedes usar .row() correctamente
            // Asignación de campos normales
        
            $("#codigoFacturaContenido").val(data[0]);

            $("#conceptoFacturaContenido").val(data[1]);

            $('#descuentoFacturaContenido').val(0);

            var ivaNumerico = data[2].replace('%', '').trim();
            $('#ivaFacturaContenido').val(ivaNumerico);

            var importeNumerico = data[3].replace('€', '').trim();
            $('#importeFacturaContenido').val(importeNumerico);



        
            $("#buscar-LlegadasGrupos-modal").modal("hide");
            
        });



        
        // TRANSFER LLEGADA //
         var transferRegresoGrupo = $("#transferRegresoGrupo").DataTable({
            select: false, // Nos permite seleccionar filas para exportar
            buttons:[],
            columns: [
                 { name: "CÓDIGO", className: 'secundariaDef' },      
                { name: "CONCEPTO", className: 'secundariaDef' },       
                { name: "IVA", className: 'secundariaDef' },    
                { name: "TOTAL", className: 'secundariaDef' },   
              
            ],
            
            columnDefs: [
                { targets: [0], orderable: true, visible: true }, // Tarifa
                { targets: [1], orderable: true, visible: true }, // Descripción
                { targets: [2], orderable: true, visible: true }, // Observación
                { targets: [3], orderable: true, visible: true }
              

            ],

            searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
                columns: [0, 1, 2, 3]
            },

            ajax: {
                url: `../../controller/proforma.php?op=transferGruposRegreso&nombreGrupos=${nombreGrupos}`, // Añadimos el parámetro
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
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
    

        $("#transferRegresoGrupo").addClass("width-50");

    
        $("#transferRegresoGrupo tbody").on("click", "tr", function () {
            
        var table = $("#transferRegresoGrupo").DataTable(); // <-- Aquí recuperas el DataTable
            var data = table.row(this).data(); // <-- Ahora puedes usar .row() correctamente
            // Asignación de campos normales
        
            $("#codigoFacturaContenido").val(data[0]);

            $("#conceptoFacturaContenido").val(data[1]);

            $('#descuentoFacturaContenido').val(0);

            var ivaNumerico = data[2].replace('%', '').trim();
            $('#ivaFacturaContenido').val(ivaNumerico);

            var importeNumerico = data[3].replace('€', '').trim();
            $('#importeFacturaContenido').val(importeNumerico);



        
            $("#buscar-LlegadasGrupos-modal").modal("hide");
            
        });
    }
    
    //===========================//
    //   CIERRE DOCUMENT READY    //
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
                title: '<div style="color:#0066cc; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">📋 Generar Factura Proforma</div>',
                html: `
                    <div style="background:#ffffff; border:2px solid #0066cc; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(0,102,204,0.1);">
                        <div style="background:#e3f2fd; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #0066cc;">
                            <p style="font-size:1.05rem; color:#1565c0; margin:0; font-weight:600; line-height:1.6;">
                                <i class="fa-solid fa-file-invoice" style="margin-right:8px; font-size:1.2rem;"></i>
                                Esta acción generará una <strong>Factura Proforma Oficial</strong>
                            </p>
                        </div>
                        <div style="padding:0.75rem 0;">
                            <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                                ✓ Se utilizarán los datos de facturación actuales
                            </p>
                            <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                                ⚠️ Solo podrá anularse mediante proceso de abono
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#ff9800',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-check-circle" style="margin-right:10px;"></i>Sí, Generar Factura',
                cancelButtonText: '<i class="fa-solid fa-times-circle" style="margin-right:8px;"></i>Cancelar',
                confirmButtonColor: '#0066cc',
                cancelButtonColor: '#757575',
                background: 'linear-gradient(to bottom, #0066cc 60px, #ffffff 60px)',
                width: '650px',
                padding: '0 0 2rem 0',
                customClass: {
                    popup: 'shadow-lg',
                    title: 'pt-3 pb-2',
                    htmlContainer: 'px-4 pb-4',
                    confirmButton: 'btn btn-primary px-5 py-2 fw-bold',
                    cancelButton: 'btn btn-secondary px-4 py-2 ms-3',
                    actions: 'pb-3'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                backdrop: 'rgba(0,0,0,0.4)'
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
                                numProforma : $('#numProforma').val(),
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
                                url: '../../controller/proforma.php?op=guardarFacturaPro',
                                type: 'POST',
                                data: formData,
                                processData: false, // Importante para evitar que jQuery procese los datos
                                contentType: false, // Importante para que el navegador determine el tipo de contenido
                                 success: (response) => {
                                    let data = JSON.parse(response); // ← aquí simplemente lo parseas
                                    let numProforma = data.numProforma;
                                    let idLlegada = data.idLlegada;

                                    Swal.fire({
                                        title: '<div style="color:#28a745; font-size:1.9rem; font-weight:700; text-shadow:0 2px 4px rgba(0,0,0,0.05);">✅ ¡Factura Generada!</div>',
                                        html: `
                                            <div style="background:#ffffff; border:2px solid #28a745; padding:1.5rem; margin:1.5rem 0; border-radius:8px; box-shadow:0 2px 8px rgba(40,167,69,0.1);">
                                                <div style="background:#d4edda; padding:1rem; border-radius:6px; margin-bottom:1rem; border-left:5px solid #28a745;">
                                                    <p style="font-size:1.05rem; color:#155724; margin:0; font-weight:600; line-height:1.6;">
                                                        <i class="fa-solid fa-check-circle" style="margin-right:8px; font-size:1.2rem;"></i>
                                                        La <strong>Factura Proforma</strong> ha sido generada correctamente
                                                    </p>
                                                </div>
                                                <div style="padding:0.75rem 0;">
                                                    <p style="font-size:0.95rem; color:#424242; margin:0 0 0.5rem 0; line-height:1.6;">
                                                        📄 Número: <strong>${numProforma}</strong>
                                                    </p>
                                                    <p style="font-size:0.95rem; color:#424242; margin:0; line-height:1.6;">
                                                        🔄 Redirigiendo a la vista de factura...
                                                    </p>
                                                </div>
                                            </div>
                                        `,
                                        icon: 'success',
                                        iconColor: '#28a745',
                                        showConfirmButton: true,
                                        confirmButtonText: '<i class="fa-solid fa-arrow-right" style="margin-right:8px;"></i>Continuar',
                                        confirmButtonColor: '#28a745',
                                        background: 'linear-gradient(to bottom, #28a745 60px, #ffffff 60px)',
                                        width: '650px',
                                        padding: '0 0 2rem 0',
                                        timer: 3000,
                                        timerProgressBar: true,
                                        customClass: {
                                            popup: 'shadow-lg',
                                            title: 'pt-3 pb-2',
                                            htmlContainer: 'px-4 pb-4',
                                            confirmButton: 'btn btn-success px-5 py-2 fw-bold',
                                            actions: 'pb-3'
                                        },
                                        buttonsStyling: false,
                                        showClass: {
                                            popup: 'animate__animated animate__zoomIn animate__faster'
                                        },
                                        backdrop: 'rgba(0,0,0,0.4)'
                                }).then(() => {
                                        //imprimirFacturaDatatableMismaPagina(numProforma, 1, idLlegada);
                                        /* imprimirFacturaDatatable(numProforma, 1, idLlegada); */
                                         let url = '../Factura_Edu/index.php?idLlegada='+idLlegada+'&idFacturaPro='+numProforma+'&tipoFactura=1';
                                         window.location.href = url;
                                        // Recargar la página cuando se cierre el Swal
                                       
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

        function imprimirFacturaDatatableMismaPagina(idFactura, tipoFactura, idLlegada) {
            console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

            if (!idFactura) {
                console.warn("idFactura no encontrado en la URL");
                return;
            }

            // Redirige en la misma pestaña
            window.location.href = `factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}`;
        }



        // AGREGAR TODAS LAS TARIFAS
        function agregarTodosTarifaGrupo(){


            $('#matriculacionTableNewGrupos tbody tr').each(function() {
                const fila = $(this);
                idLlegada = $('#idLlegada').val();
                const datos = {
                    idLlegada: idLlegada,
                    codigoFactura: fila.find('td').eq(1).text().trim(),
                    conceptoFactura: fila.find('td').eq(2).text().trim(),
                    tipoFactura: fila.find('td').eq(9).text().trim(),
                    ivaFactura: fila.find('td').eq(5).text().trim().replace('%', '').replace(',', '.'),
                    descuentoFactura: fila.find('td').eq(6).text().trim().replace('%', '').replace(',', '.'),
                    importeFactura: fila.find('td').eq(4).text().trim().replace('€', '').replace(/\./g, '').replace(',', '.'),
                    fecha_inicio: fila.find('td').eq(7).text().trim(),
                    fecha_fin: fila.find('td').eq(8).text().trim()
                };

                // Enviar cada fila por AJAX
                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',  // Cambia esto a tu endpoint real
                    type: 'POST',
                    data: datos,
                    success: function(response) {
                        console.log('Insertado correctamente:', response);
                        $("#buscar-LlegadasGrupos-modal").modal("hide");

                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar:', error);
                    }
                });
                

            });
            
            $('#transferLlegadaGrupo tbody tr').each(function() {
                const fila = $(this);
                idLlegada = $('#idLlegada').val();
                const datos = {
                        idLlegada: idLlegada,
                        codigoFactura: fila.find('td').eq(0).text().trim(),
                        conceptoFactura: fila.find('td').eq(1).text().trim(),
                        tipoFactura: "TRANSFER_LLEGADA",
                        ivaFactura: fila.find('td').eq(3).text().trim().replace('%', '').replace(',', '.'),
                        descuentoFactura: '0',
                        importeFactura: fila.find('td').eq(4).text().trim().replace('€', '').replace(/\./g, '').replace(',', '.'),
                        fecha_inicio: '',
                        fecha_fin: ''
                    };
                    console.log(datos);
                // Enviar cada fila por AJAX
                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',  // Cambia esto a tu endpoint real
                    type: 'POST',
                    data: datos,
                    success: function(response) {
                        $("#buscar-Llegadas-modal").modal("hide");

                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar:', error);
                    }
                });
            
        
            });

             
            $('#transferRegresoGrupo tbody tr').each(function() {
                const fila = $(this);
                idLlegada = $('#idLlegada').val();
                const datos = {
                        idLlegada: idLlegada,
                        codigoFactura: fila.find('td').eq(0).text().trim(),
                        conceptoFactura: fila.find('td').eq(1).text().trim(),
                        tipoFactura: "TRANSFER_REGRESO",
                        ivaFactura: fila.find('td').eq(3).text().trim().replace('%', '').replace(',', '.'),
                        descuentoFactura: '0',
                        importeFactura: fila.find('td').eq(4).text().trim().replace('€', '').replace(/\./g, '').replace(',', '.'),
                        fecha_inicio: '',
                        fecha_fin: ''
                    };
                    
                // Enviar cada fila por AJAX
                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',  // Cambia esto a tu endpoint real
                    type: 'POST',
                    data: datos,
                    success: function(response) {
                        console.log('Insertado correctamente:', response);
                        $("#buscar-Llegadas-modal").modal("hide");

                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar:', error);
                    }
                });
            
        
            });
            toastr.success("Tarifas Añadidas");

            $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR

        }
        function agregarTodosTarifa(){


            $('#matriculacionTableNew tbody tr').each(function() {
                const fila = $(this);
                idLlegada = $('#idLlegada').val();
                const datos = {
                    idLlegada: idLlegada,
                    codigoFactura: fila.find('td').eq(1).text().trim(),
                    conceptoFactura: fila.find('td').eq(2).text().trim(),
                    tipoFactura: fila.find('td').eq(9).text().trim(),
                    ivaFactura: fila.find('td').eq(5).text().trim().replace('%', '').replace(',', '.'),
                    descuentoFactura: fila.find('td').eq(6).text().trim().replace('%', '').replace(',', '.'),
                    importeFactura: fila.find('td').eq(4).text().trim().replace('€', '').replace(/\./g, '').replace(',', '.'),
                    fecha_inicio: fila.find('td').eq(7).text().trim(),
                    fecha_fin: fila.find('td').eq(8).text().trim()
                };

                // Enviar cada fila por AJAX
                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',  // Cambia esto a tu endpoint real
                    type: 'POST',
                    data: datos,
                    success: function(response) {
                        console.log('Insertado correctamente:', response);
                        $("#buscar-Llegadas-modal").modal("hide");

                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar:', error);
                    }
                });
                
        
            });

            // ===============================
            // 2. INSERTAR TRANSFER DE LLEGADA
            // ===============================
            const codigoLlegada = $("#codigotariotallegadaTransfer_llegadas").val().trim();
            const importeLlegada = $("#importetariotallegadaTransfer_llegadas").val().trim();
            
            if (codigoLlegada && importeLlegada && importeLlegada !== '0') {

                const datosTransferLlegada = {
                    idLlegada: idLlegada,
                    codigoFactura: codigoLlegada,
                    conceptoFactura: $("#textotariotallegadaTransfer_llegadas").val().trim(),
                    tipoFactura: "TRANSFER_LLEGADA",
                    ivaFactura: $("#ivatariotallegadaTransfer_llegadas").val().trim().replace('%', '').replace(',', '.'),
                    descuentoFactura: 0,
                    importeFactura: importeLlegada.replace('€', '').replace(/\./g, '').replace(',', '.'),
                    fecha_inicio: '',
                    fecha_fin: ''
                };

                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',
                    type: 'POST',
                    data: datosTransferLlegada,
                    success: function(response) {
                        console.log('Transfer llegada insertado:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar transfer llegada:', error);
                    }
                });
            }


            // ===============================
            // 3. INSERTAR TRANSFER DE REGRESO
            // ===============================
            const codigoRegreso = $("#codigotariotalregresoTransfer_llegadas").val().trim();
            const importeRegreso = $("#importetariotalregresoTransfer_llegadas").val().trim();
            
            if (codigoRegreso && importeRegreso && importeRegreso !== '0') {

                const datosTransferRegreso = {
                    idLlegada: idLlegada,
                    codigoFactura: codigoRegreso,
                    conceptoFactura: $("#textotariotalregresoTransfer_llegadas").val().trim(),
                    tipoFactura: "TRANSFER_REGRESO",
                    ivaFactura: $("#ivatariotalregresoTransfer_llegadas").val().trim().replace('%', '').replace(',', '.'),
                    descuentoFactura: 0,
                    importeFactura: importeRegreso.replace('€', '').replace(/\./g, '').replace(',', '.'),
                    fecha_inicio: '',
                    fecha_fin: ''
                };

                $.ajax({
                    url: '../../controller/proforma.php?op=guardarTarifasTodas',
                    type: 'POST',
                    data: datosTransferRegreso,
                    success: function(response) {
                        console.log('Transfer regreso insertado:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar transfer regreso:', error);
                    }
                });
            }

            toastr.success("Tarifas Añadidas");

            $("#facturaTabla").DataTable().ajax.reload(null, false); //! NO TOCAR

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
                        $('#buscar-facturas-modal').modal('show'); // 👈 Asegúrate de que el ID es correcto
                    }
                });
            }, 300); // Pequeño retraso para asegurar que el modal se cerró
        }



        function cargarTransferLlegada(){
            $('#codigoFacturaContenido').val($('#codigotariotallegadaTransfer_llegadas').val());
            $('#conceptoFacturaContenido').val($('#textotariotallegadaTransfer_llegadas').val());
            let importe = $('#importetariotallegadaTransfer_llegadas').val();
            // Eliminar todo lo que no sea número o coma/punto
            importe = importe.replace(/[^0-9,\.]/g, '');
            $('#importeFacturaContenido').val(importe);
            let iva = $('#ivatariotallegadaTransfer_llegadas').val();
            // quitar todo lo que no sea número, coma o punto
            iva = iva.replace(/[^0-9,\.]/g, '');
            $('#ivaFacturaContenido').val(iva);
            $('#descuentoFacturaContenido').val('0')
                        $('#tipoFacturaContenido').val(4); 
        $("#buscar-Llegadas-modal").modal("hide");

        }
        function cargarTransferRegreso(){
            $('#codigoFacturaContenido').val($('#codigotariotalregresoTransfer_llegadas').val());
            $('#conceptoFacturaContenido').val($('#textotariotalregresoTransfer_llegadas').val());
            let importe = $('#importetariotalregresoTransfer_llegadas').val();
            // Eliminar todo lo que no sea número o coma/punto
            importe = importe.replace(/[^0-9,\.]/g, '');
            $('#importeFacturaContenido').val(importe);
            let iva = $('#ivatariotalregresoTransfer_llegadas').val();
            // quitar todo lo que no sea número, coma o punto
            iva = iva.replace(/[^0-9,\.]/g, '');
            $('#ivaFacturaContenido').val(iva);
            $('#descuentoFacturaContenido').val('0')
            $('#tipoFacturaContenido').val(4); 

                    $("#buscar-Llegadas-modal").modal("hide");

        }
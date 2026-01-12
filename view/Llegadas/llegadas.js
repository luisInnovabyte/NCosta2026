


$("#btnSearchTarifaDocencia").attr("disabled", false);

// Variables globales para almacenar cada total
var totalMatriculacion = 0;
var totalMatriculacionIva = 0;
var totalAlojamiento = 0;
var totalAlojamientoIva = 0;
var totalTransferLlegada = 0;
var totalTransferLlegadaIva = 0;
var totalTransferRegreso = 0;
var totalTransferRegresoIva = 0;
var totalGeneral = 0;
var totalGeneralIva = 0;

// Función para actualizar todos los totales
function actualizarTotalFacturado() {
    // Obtener valores de transfer
    let importeLlegada = convertirEurANumero($('#importeTarifasLlegada').val());
    let ivaLlegada = parseFloat(String($('#ivaTarifasLlegada').val()).replace(/\s|%/g, '').replace(',', '.')) || 0;
    let importeRegreso = convertirEurANumero($('#importeTarifasRegreso').val());
    let ivaRegreso = parseFloat(String($('#ivaTarifasRegreso').val()).replace(/\s|%/g, '').replace(',', '.')) || 0;
    
    // Calcular totales de transfer
    totalTransferLlegada = importeLlegada;
    totalTransferLlegadaIva = importeLlegada + (importeLlegada * ivaLlegada / 100);
    totalTransferRegreso = importeRegreso;
    totalTransferRegresoIva = importeRegreso + (importeRegreso * ivaRegreso / 100);
    
    // Calcular totales generales
    totalGeneral = totalMatriculacion + totalAlojamiento + totalTransferLlegada + totalTransferRegreso;
    totalGeneralIva = totalMatriculacionIva + totalAlojamientoIva + totalTransferLlegadaIva + totalTransferRegresoIva;
    
    // Actualizar todos los campos del display
    $('#totalMatriculacionSinIva').text(totalMatriculacion.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    $('#totalMatriculacionConIva').text(totalMatriculacionIva.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    
    $('#totalAlojamientoSinIva').text(totalAlojamiento.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    $('#totalAlojamientoConIva').text(totalAlojamientoIva.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    
    $('#totalTransferLlegadaSinIva').text(totalTransferLlegada.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    $('#totalTransferLlegadaConIva').text(totalTransferLlegadaIva.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    
    $('#totalTransferRegresoSinIva').text(totalTransferRegreso.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    $('#totalTransferRegresoConIva').text(totalTransferRegresoIva.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    
    $('#totalGeneralSinIva').text(totalGeneral.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    $('#totalGeneralConIva').text(totalGeneralIva.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
    
    // Actualizar pendiente usando total con IVA
    actualizarPendiente();
}
//==================================================//
//            TABLA MATRICULACIONES                 //
//==================================================//
function listarMatriculacionesTabla(idLlegada){
 
     // Comprueba si el DataTable ya está inicializado
     if ($.fn.DataTable.isDataTable("#matriculacionTableNew")) {
        // Destruye el DataTable
        $("#matriculacionTableNew").DataTable().clear().destroy();
    }

    comprobarFacturasActivas(idLlegada);

var matriculacionTable = $("#matriculacionTableNew").DataTable({
    select: false, // Nos permite seleccionar filas para exportar

    columns: [
        { name: "Tarifa", className: 'secundariaDef' },          // Corresponde a "Tarifa"
        { name: "Descripcion", className: 'secundariaDef' },    // Corresponde a "Descripción"
        { name: "Observacion", className: 'secundariaDef' },    // Corresponde a "Observación"
        { name: "Importe", className: 'text-center' },          // Corresponde a "Importe"
        { name: "IVA", className: 'text-center' },              // Corresponde a "IVA"
        { name: "Descuento", className: 'text-center' },        // Corresponde a "Descuento"
        { name: "FechaInicio", className: 'text-center' },      // Corresponde a "Fecha Inicio"
        { name: "FechaFin", className: 'text-center' },         // Corresponde a "Fecha Fin"
        { name: "Estado", className: 'text-center' },         // Corresponde a "Fecha Fin"
        { name: "Accion", className: 'text-center', width: "9%" } // Corresponde a "Acción"
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
        { targets: [8], orderable: false, visible: true }, // Acción
        { targets: [9], orderable: false, visible: true } // Acción

    ],

    searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
    },

    ajax: {
        url: `../../controller/llegadas.php?op=listarMatriculaciones`,
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        data: function(d) {
            d.idLlegada = $('#idLlegadaReal').val() || idLlegada;
            return d;
        },
        error: function (e) {
            console.error("Error en la carga de datos:", e);
        }
    },

    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
        let total = 0;
        let totalConIva = 0;
    
        // Obtener los datos completos de cada fila
        api.rows({ search: 'applied' }).every(function () {
            let rowData = this.data();
            
            // Columna 3: Importe
            let importe = parseFloat(
                String(rowData[3])
                    .replace(/\s|€/g, '')   // quitar espacios y símbolo €
                    .replace(/\./g, '')     // quitar separadores de miles
                    .replace(',', '.')      // cambiar coma decimal por punto
            );
            
            // Columna 4: IVA
            let iva = parseFloat(
                String(rowData[4])
                    .replace(/\s|%/g, '')   // quitar espacios y símbolo %
                    .replace(',', '.')      // cambiar coma decimal por punto
            );
            
            if (!isNaN(importe)) {
                total += importe;
                
                // Calcular importe con IVA: importe + (importe * iva / 100)
                if (!isNaN(iva)) {
                    totalConIva += importe + (importe * iva / 100);
                } else {
                    totalConIva += importe;
                }
            }
        });
    
        $(api.column(3).footer()).html(total.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
        
        // Asignar los totales a las variables globales
        totalMatriculacion = total;
        totalMatriculacionIva = totalConIva;
        
        // Actualizar el total facturado (suma de matriculaciones + alojamientos)
        actualizarTotalFacturado();

    },

    createdRow: function (row, data, dataIndex) {
        // Personaliza las filas si es necesario
    }
});
}

$("#matriculacionTableNew").addClass("width-100");

//==================================================//
//==================================================//
//==================================================//


//---------------------------------------//
// CREACION/EDICION DE UNA NUEVA LLEGADA //
//---------------------------------------//

$(document).ready(function () {
   
    $("#guardarBtn").on("click", function () {
     
      // Acepta d/m/aaaa, dd/mm/aaaa, d/mm/aaaa, dd/m/aaaa
    const fechaRegex = /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[0-2])\/\d{4}$/;

    const dia = $('#diaInscripcion').val().trim();


        if (dia === '') {
            toastr.error(
                'El campo Día Inscripción de Llegada está vacío.',
                'Error de Validación'
            );
            return;
        }

        // Validación del formato
        if (!fechaRegex.test(dia)) {
            toastr.error(
                'El campo Día Inscripción de Llegada debe tener el formato (dd/mm/aaaa).',
                'Error de Validación'
            );
            return;
        }
      
      if ($('#fechaLlegada').val().trim() === '') {
        toastr.error(`El campo Fecha de Llegada está vacío.`, 'Error de Validación');
        
        return; // Salir de la función si hay un campo vacío
      }
        // Recoger inputs de texto, textarea y selects
        var datosFormulario = {
            idLlegada: $("#idLlegada").val(),
            diaInscripcion: formatearFechaSinHora($("#diaInscripcion").val()),
            idPrescriptorDatos: $("#idPrescriptorDatos").val(),
            departamentoSelect: $("#departamentoSelect").val(),
            nombreApellidos: $("#nombreApellidos").val(),
            sexo: $("#sexo").val(),
            pais: $("#pais").val(),
            //idAgente: $("#idAgente").val().split("-")[0].trim(),
            idAgente: $("#idAgente").val().trim(),
            idGrupo: $("#idGrupo").val(),
            idGrupoAmigo: $("#idGrupoAmigo").val(),
            fechaLlegada: formatearFechaConHora($("#fechaLlegada").val()),
            lugarLlegada: $("#lugarLlegada").val(),
            recogeAlumno: $("#recogeAlumno").val(),
        
        };
        // Crear un objeto FormData
        var formData = new FormData();

        // Agregar los datos al objeto FormData
        for (var key in datosFormulario) {
            formData.append(key, datosFormulario[key]);
        }
      
      // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
          $.ajax({
              url: "../../controller/llegadas.php?op=agregarLlegada",
              type: 'POST',
                data: formData,
                processData: false, // Importante para evitar que jQuery procese los datos
                contentType: false, // Importante para que el navegador determine el tipo de contenido
              success: function(idLlegada) {
                    // TENGO QUE OBTENER LOS VALORES GUARDADOS DE PROFORMA Y FACTURA REAL DE ESTA LLEGADA
                    
                    // IMPORTANTE: Establecer idLlegadaReal ANTES de inicializar las tablas
                    $('#idLlegadaReal').val(idLlegada);

                    listarMatriculacionesTabla(idLlegada);
                    listarPagoAnticipadoTabla(idLlegada);
                    listarSuplidosTabla(idLlegada);
                    estadoLlegada();
                    // forzarEstadosMatricula se llamará automáticamente después de inicializar la tabla
                    forzarEstadosMatricula();
                    listarAlojamientosTabla(idLlegada);
                    // Eliminado ajax.reload() redundante - la tabla ya se inicializa con datos

                  // Manejar la respuesta del servidor
                  toastr.success("Llegada agregada");
                  toastr.warning("Mostrando Servicios");
                  $("#llegadasTable").DataTable().ajax.reload(null, false); //! NO TOCAR
                  $(".colorBoton4").parent().removeClass("d-none");

                  $("#guardarTxt").addClass("d-none");
                  $(".serviciosDiv").removeClass("d-none");
                  $("#editarBtn").removeClass("d-none");

                  //=====================//
                  // APARTADO DE EDICION //
                  //=====================//
                    $('.serviciosDiv').removeClass('d-none'); // MOSTRAR SERVICIOS
                    
                    // Obtén el objeto de datos de la fila actual
                    
                    $("#irProforma").parent().removeClass("d-none")
                    $("#irProforma").attr("href","../FacturaPro_Edu/index.php?idLlegada="+idLlegada)
                    // $("#buscar-llegadas-modal").modal("hide");
                    let idLlegadas = idLlegada;
                    
                    // Asignar el valor de soloFecha al campo #inicioDocencia
                    $("#codDocencia").attr("disabled", false);
                    $("#btnSearchTarifaDocencia").attr("disabled", false);

                    let fechaTexto = $('#fechaLlegada').val();

                    // 1️⃣ Extraer la fecha con regex
                    let fecha = fechaTexto.match(/\d{2}\/\d{2}\/\d{4}/)[0];

                    // 2️⃣ Convertir a formato YYYY-MM-DD
                    let partes = fecha.split("/");
                    let fechaFinal = `${partes[2]}-${partes[1]}-${partes[0]}`;

                    // 3️⃣ Asignar al input
                    $("#diaLlegada").val(fechaFinal);


                },
              error: function(err) {
                  // Manejar errores
              }
          });
    });

//---------------------------------------//
//--------------- EDICION ---------------//
//---------------------------------------//
    $("#editarBtn").on("click", function () {

     // Acepta d/m/aaaa, dd/mm/aaaa, d/mm/aaaa, dd/m/aaaa
        const fechaRegex = /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[0-2])\/\d{4}$/;

        const dia = $('#diaInscripcion').val().trim();


            if (dia === '') {
                toastr.error(
                    'El campo Día Inscripción de Llegada está vacío.',
                    'Error de Validación'
                );
                return;
            }

            // Validación del formato
            if (!fechaRegex.test(dia)) {
                toastr.error(
                    'El campo Día Inscripción de Llegada debe tener el formato (dd/mm/aaaa).',
                    'Error de Validación'
                );
                return;
            }
        
        if ($('#fechaLlegada').val().trim() === '') {
            toastr.error(`El campo Fecha de Llegada está vacío.`, 'Error de Validación');
            
            return; // Salir de la función si hay un campo vacío
        }
        // Recoger inputs de texto, textarea y selects
        var datosFormulario = {
            idLlegada: $("#idLlegadaReal").val(),
            diaInscripcion: formatearFechaSinHora($("#diaInscripcion").val()),
            idPrescriptorDatos: $("#idPrescriptorDatos").val(),
            departamentoSelect: $("#departamentoSelect").val(),
            nombreApellidos: $("#nombreApellidos").val(),
            sexo: $("#sexo").val(),
            pais: $("#pais").val(),
            //idAgente: $("#idAgente").val().split("-")[0].trim(),
            idAgente: $("#idAgente").val(),
            idGrupo: $("#idGrupo").val(),
            idGrupoAmigo: $("#idGrupoAmigo").val(),
            fechaLlegada: formatearFechaConHora($("#fechaLlegada").val()),
            lugarLlegada: $("#lugarLlegada").val(),
            recogeAlumno: $("#recogeAlumno").val(),
        
          
          // Agrega más campos según tus necesidades
        };
    
        // Crear un objeto FormData
        var formData = new FormData();

        // Agregar los datos al objeto FormData
        for (var key in datosFormulario) {
            formData.append(key, datosFormulario[key]);
        }

        // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
            $.ajax({
                url: "../../controller/llegadas.php?op=editarLlegada",
                type: 'POST',
                data: formData,
                processData: false, // Importante para evitar que jQuery procese los datos
                contentType: false, // Importante para que el navegador determine el tipo de contenido
                success: function(response) {
                    // Manejar la respuesta del servidor
                    toastr.success("Llegada Editada");
                    
                   
        
                  },
                error: function(err) {
                    // Manejar errores
                }
            });
      });

      /* GUARDAR EDICION */
$("#guardarMatricula").on("click", function () {

  $("#inicioDocencia").addClass('blink');
  $("#finalDocencia").removeClass('blink');
  //===================================================//
  //===================================================//
  //===================================================//
  // Lista de campos a validar
  const campos = [
      { id: '#codDocencia', nombre: 'Código de Docencia' },
      { id: '#ivaDocencia', nombre: 'IVA Docencia' },
      { id: '#inicioDocencia', nombre: 'Fecha de Inicio' },
      { id: '#finalDocencia', nombre: 'Fecha de Finalización' }
  ];

  // Validar si los campos están vacíos
  for (const campo of campos) {
      if ($(campo.id).val().trim() === '') {
          toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
          return; // Salir de la función si hay un campo vacío
      }
  }

  // Validar fechas
  const inicio = formatearFechaSinHora($('#inicioDocencia').val());
  const final = formatearFechaSinHora($('#finalDocencia').val());

  if (final < inicio) {
      toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
      return; // Salir de la función si las fechas no son lógicas
  }
  //===================================================//
  //===================================================//
  //===================================================//

  var datosFormulario = {
      idMatriculaEditando : $("#idMatriculaEditando").val(),
      idLlegada : $("#idLlegadaReal").val(),
      inicioDocencia : inicio,
      finalDocencia : final,
      codDocencia : $("#codDocencia").val(),
      descripcion : $("#descripcionTarifa").val(),
      importeDocencia : $("#importeDocencia").val(),
      ivaDocencia : $("#ivaDocencia").val(),
      descDocencia : $("#descDocencia").val(),
      observacionesDocencias : $("#observacionesDocencias").val()
  };

  console.log("datos para salvar matricula:", datosFormulario);

  var formData = new FormData();

  // Agregar los datos al objeto FormData
  for (var key in datosFormulario) {
      formData.append(key, datosFormulario[key]);
  }

  // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
  $.ajax({
      url: "../../controller/llegadas.php?op=editarMatricula",
      type: 'POST',
      data: formData,
      processData: false, // Importante para evitar que jQuery procese los datos
      contentType: false, // Importante para que el navegador determine el tipo de contenido
      success: function(response) {
          // Manejar la respuesta del servidor
          toastr.success("Matricula Editada");
          $("#matriculacionTableNew").DataTable().ajax.reload(null, false);

          $("#agregarMatriculaNew").removeClass("d-none");
          $("#guardarMatricula").addClass("d-none");
          $("#cancelarMatricula").addClass("d-none");

          $("#codDocencia").val("");
          $("#importeDocencia").val("");
          $("#ivaDocencia").val("");
          $("#descDocencia").val("");
          $("#finalDocencia").val("");
          $("#observacionesDocencias").val("");

          forzarEstadosMatricula();

          // Deshabilitar el campo de fecha de finalización después de guardar
          //$("#finalDocencia").prop("disabled", true);
      },
      error: function(err) {
          // Manejar errores
      }
  });
});

      
      /** APARTADO MATRICULACION  */

      /* AÑADIR MATRICULA */

       
    $("#agregarMatriculaNew").on("click", function () {

       
        //===================================================//
        //===================================================//
        //===================================================//
        // Lista de campos a validar
        const campos = [      
            { id: '#codDocencia', nombre: 'Código de Docencia' },
            { id: '#ivaDocencia', nombre: 'IVA Docencia' },
            { id: '#inicioDocencia', nombre: 'Fecha de Inicio' },
            { id: '#finalDocencia', nombre: 'Fecha de Finalización' }
        ];
      
        // Validar si los campos están vacíos
        for (const campo of campos) {
            if ($(campo.id).val().trim() === '') {
                toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
                return; // Salir de la función si hay un campo vacío
            }
        }
      
        // Validar fechas
        const inicio = formatearFechaSinHora($('#inicioDocencia').val());
        const final = formatearFechaSinHora($('#finalDocencia').val());
      
        if (final < inicio) {
            toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
            return; // Salir de la función si las fechas no son lógicas
        }
        //===================================================//
        //===================================================//
        //===================================================//
      
        var datosFormulario = {
            idLlegada : $("#idLlegadaReal").val(),
            inicioDocencia : inicio,
            finalDocencia : final,
            codDocencia : $("#codDocencia").val(),
            textEditar : $("#descripcionTarifa").val(),  // Descripción de la tarifa
            importeDocencia : $("#importeDocencia").val(),
            ivaDocencia : $("#ivaDocencia").val(),
            descDocencia : $("#descDocencia").val(),
            observacionesDocencias : $("#observacionesDocencias").val()  // Observaciones
        };

        console.log("datos a insertar de matricula:", datosFormulario);
        var formData = new FormData();

        // Agregar los datos al objeto FormData
        for (var key in datosFormulario) {
            formData.append(key, datosFormulario[key]);
        }
        // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
            $.ajax({
                url: "../../controller/llegadas.php?op=insertarMatricula",
                type: 'POST',
                data: formData,
                processData: false, // Importante para evitar que jQuery procese los datos
                contentType: false, // Importante para que el navegador determine el tipo de contenido
                success: function(response) {
                    toastr.success("Matricula Añadida");

                    $("#agregarMatriculaNew").removeClass("d-none");
                    $("#guardarMatricula").addClass("d-none");
                    $("#cancelarMatricula").addClass("d-none");

                    forzarEstadosMatricula();
                    
                    $("#codDocencia").val("");
                    $("#importeDocencia").val("");
                    $("#ivaDocencia").val("");
                    $("#descDocencia").val("");
                    $("#finalDocencia").val("");
                    $("#observacionesDocencias").val("");

                  },
                error: function(err) {
                    // Manejar errores
                }
            });
     
   
     });
});



//******************************************/
//********** EDITAR MATRICULA  *************/
//******************************************/


function editarMatriculaNew(idMatricula){
    $.ajax({
        url: "../../controller/llegadas.php?op=recogerMatriculaxId",
        type: 'POST',
        data: { idMatricula: idMatricula },  // Aquí pasas la idMatricula
      
        success: function(response) {
            var data = JSON.parse(response);
            console.log("datos al editar:", data);
            
            // Manejar la respuesta del servidor
            // Si la respuesta es un array de objetos, puedes acceder a la primera posición y luego al campo:
            var idMatriculacion = data[0]['idMatriculacionLlegada'];

            var codTarifa_matriculacion = data[0]['codTarifa_matriculacion'];
            var nombreTarifa_matriculacion = data[0]['nombreTarifa_matriculacion'];
            var descuento_tarifa = data[0]['descuento_tarifa'];

            var precioTarifa_matriculacion = data[0]['precioTarifa_matriculacion'];
            var idIvaTarifa_matriculacion = data[0]['idIvaTarifa_matriculacion'];

            // Extrae solo la fecha (YYYY-MM-DD) de la cadena completa (YYYY-MM-DD HH:mm:ss)
            var fechaInicioMatriculacion = data[0]['fechaInicioMatriculacion'];
            fechaInicioMatriculacion = new Date(fechaInicioMatriculacion);
            let fechaFormateadaMatriculaIni = fechaInicioMatriculacion.toLocaleDateString('es-ES'); // => "20/10/1999"

            var fechaFinMatriculacion = data[0]['fechaFinMatriculacion'];
            fechaFinMatriculacion = new Date(fechaFinMatriculacion);
            let fechaFormateadaMatriculaFin = fechaFinMatriculacion.toLocaleDateString('es-ES'); // => "20/10/1999"

            var fechaFinMatriculacion = data[0]['fechaFinMatriculacion'];
            var fechaFinal = fechaFinMatriculacion.split(' ')[0];  // Divide en el espacio y toma
            var obsMatriculacion = data[0]['obsMatriculacion'];

            $("#textEditar").text(" - Editando la linea: Tarifa: "+ codTarifa_matriculacion+ " - Descripción: " + nombreTarifa_matriculacion);
            $("#descripcionTarifa").val(nombreTarifa_matriculacion);

            $("#idMatriculaEditando").val(idMatriculacion);

            $("#codDocencia").val(codTarifa_matriculacion);
            $("#importeDocencia").val(precioTarifa_matriculacion);
            $("#ivaDocencia").val(idIvaTarifa_matriculacion);
            $("#descDocencia").val(descuento_tarifa);

            $("#inicioDocencia").val(fechaFormateadaMatriculaIni);
            $("#finalDocencia").val(fechaFormateadaMatriculaFin);
            $("#observacionesDocencias").val(obsMatriculacion);

            $(".btnEditView").addClass("d-none");
            $("#agregarMatriculaNew").addClass("d-none");
            $("#guardarMatricula").removeClass("d-none");
            $("#cancelarMatricula").removeClass("d-none");

            // Habilita el campo de fecha de finalización (por si estaba deshabilitado)
            $("#finalDocencia").prop("disabled", false);
        },
        error: function(err) {
            // Manejar errores
        }
    });
}



//******************************************/
//********** eliminar MATRICULA  *************/
//******************************************/



function eliminarMatriculaNew(idMatricula){
    $.ajax({
        url: "../../controller/llegadas.php?op=eliminarMatricula",
        type: 'POST',
        data: { idMatricula: idMatricula },  // Aquí pasas la idMatricula
      
        success: function(response) {

            $("#matriculacionTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR

            toastr.success("Matricula Eliminada");
            forzarEstadosMatricula();
          },
        error: function(err) {
            // Manejar errores
        }
    });

}


//******************************************/
//************ AGREGAR  NIVEL  *************/
//******************************************/
$("#rutaSelect").val(null).trigger('change');

$("#rutaSelect").select2({
    theme: "bootstrap-5",
    width: "100%",
    placeholder: $(this).data('placeholder'),
    closeOnSelect: true,
    language: {
        inputTooShort: function (args) {
            var remainingChars = args.minimum - args.input.length;
            return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
        },
        maximumSelected: function (e) {
            return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
        },
        noResults: function () {
            return 'No se encontraron resultados';
        },
        searching: function () {
            return 'Buscando...';
        }
    }
});

function agregarNivel(){
    
    idLlegada = $('#idLlegadaReal').val();
    nivelDocencia = $('#nivelDocencia').val();
    observacionesNivel = $('#observacionesNivel').val();
    nivelDocenciaAsignado = $('#rutaSeleccionada').val();
    semanaDocenciaAsignado = '0';

    $.ajax({
        url: "../../controller/llegadas.php?op=agregarNivel",
        type: 'POST',
        data: { idLlegada: idLlegada, nivelDocencia: nivelDocencia, observacionesNivel: observacionesNivel, nivelDocenciaAsignado: nivelDocenciaAsignado, semanaDocenciaAsignado: semanaDocenciaAsignado   },  // Aquí pasas la idMatricula
      
        success: function(response) {

            toastr.success("Nivel Añadido");

          },
        error: function(err) {
            // Manejar errores
        }
    });

}
function abrirModalRutas() {
    $("#buscar-rutas-modal").modal("show");
}
rutasTable = $("#rutas_table").DataTable({
    select: false,
    order: [[6, "desc"]], // Ordenar por la columna "Orden" en orden ascendente
    columns: [
        { name: "id" },
        { name: "Idioma" },
        { name: "Curso" },
        { name: "Nivel" },
        { name: "Alumnos" },
        { name: "Periodicidad" },
        { name: "Código" }
    ],
    columnDefs: [
        { targets: 0, visible: false, width: "50px" },
        { targets: 1, width: "100px", className: "small" },
        { targets: 2, width: "200px", className: "small" },
        { targets: 3, width: "100px", className: "texto-peque" },
        { targets: 4, width: "60px" },
        { targets: 5, width: "30px" },
       
        { targets: 6, width: "30px" }

    ],
    searchBuilder: { columns: [1, 2, 3, 4, 5, 6] },

    ajax: {
        url: "../../controller/rutas.php?op=listarRutasTodas",
        type: "POST",
       
        cache: false,
        serverSide: true,
        error: function (e) {
            console.log("Error en AJAX:", e.responseText);
        }
    }
});
$("#rutas_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
$('#FootIdioma').on('keyup', function () {
    rutasTable
        .columns(1)
        .search(this.value)
        .draw();
  });
  $('#FootTipo').on('keyup', function () {
    rutasTable
        .columns(2)
        .search(this.value)
        .draw();
  });
  $('#FootNivel').on('keyup', function () {
    rutasTable
        .columns(3)
        .search(this.value)
        .draw();
  });
  $('#FootAlumnos').on('keyup', function () {
    rutasTable
        .columns(4)
        .search(this.value)
        .draw();
  });
  $('#FootPeriodicidad').on('keyup', function () {
    rutasTable
        .columns(5)
        .search(this.value)
        .draw();
  });
  $('#FootCodigo').on('keyup', function () {
    rutasTable
        .columns(6)
        .search(this.value)
        .draw();
  });

$("#rutas_table tbody").on("click", "tr", function () {
    //! === Función para recoger los valores de la fila de un DataTable al hacer clic ===

    var tabla = $("#rutas_table").DataTable();
    var data = tabla.row(this).data();

    // Verificar que data no sea undefined
    if (!data) {
        console.error("No se pudo obtener la información de la fila seleccionada.");
        return;
    }

    $("#rutaSeleccionada").val(data[0]);

    $.ajax({
        url: "../../controller/rutas.php?op=obtenerRutaxIdView", // `op` va en GET
        type: "POST", // `idRuta` se envía por POST
        data: { idRuta: data[0] },
        dataType: "json",
        success: function (respuesta) {
          
            $('#botonAsignar').text(respuesta[0].id_ruta+': '+respuesta[0].descrIdioma+' - '+ respuesta[0].descrTipo+' ('+respuesta[0].codNivel+') - '+respuesta[0].minAlum_ruta+'/'+respuesta[0].maxAlum_ruta+' - '+respuesta[0].codIdioma+respuesta[0].codTipo+respuesta[0].codNivel)
            $('#botonAsignar').addClass('btn-success');
            $('#botonAsignar').removeClass('btn-danger');
            $("#buscar-rutas-modal").modal("hide");
            $('#rutaSeleccionada').val(respuesta[0].id_ruta);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
        }
    });

});

  
//******************************************/
//********** AGREGAR TRANSFER  *************/
//******************************************/


// Sistema de detección de cambios sin guardar en Transfer
var transferHasCambios = false;

// Función para marcar que hay cambios sin guardar
function marcarTransferCambios() {
    if (!transferHasCambios) {
        transferHasCambios = true;
        $('#transferWarningBanner').slideDown();
        $('#btnAgregarTransfer').removeClass('btn-primary').addClass('btn-warning');
        $('#btnAgregarTransfer').html('<i class="fa-solid fa-save"></i> Guardar Cambios');
    }
}

// Función para resetear el estado de cambios
function resetearTransferCambios() {
    transferHasCambios = false;
    $('#transferWarningBanner').slideUp();
    $('#btnAgregarTransfer').removeClass('btn-warning').addClass('btn-primary');
    $('#btnAgregarTransfer').html('Agregar Transfer');
}

// Detectar cambios en todos los campos de Transfer
$(document).ready(function() {
    // Campos de Transfer Llegada
    $('#codigoTarifasLlegada, #textoTarifasLlegada, #importeTarifasLlegada, #ivaTarifasLlegada').on('input change', function() {
        marcarTransferCambios();
        actualizarTotalFacturado();
    });
    $('#diaLlegada, #horaLlegada').on('change', marcarTransferCambios);
    $('#lugarRecogidaLlegada, #lugarEntregaLlegada, #quienRecogeLlegada').on('input change', marcarTransferCambios);
    
    // Campos de Transfer Regreso
    $('#codigoTarifasRegreso, #textoTarifasRegreso, #importeTarifasRegreso, #ivaTarifasRegreso').on('input change', function() {
        marcarTransferCambios();
        actualizarTotalFacturado();
    });
    $('#diaRegreso, #horaRegreso').on('change', marcarTransferCambios);
    $('#lugarRecogidaRegreso, #lugarEntregaRegreso, #quienRecogeRegreso').on('input change', marcarTransferCambios);
    
    // Observaciones
    $('#observaciones').on('input change', marcarTransferCambios);
});

function agregarTransfer(){
    
    idLlegada = $('#idLlegadaReal').val();
    codigoTarifasLlegada = $('#codigoTarifasLlegada').val();
    textoTarifasLlegada = $('#textoTarifasLlegada').val();
    importeTarifasLlegada = $('#importeTarifasLlegada').val();
    ivaTarifasLlegada = $('#ivaTarifasLlegada').val();
    diaLlegada = $('#diaLlegada').val();
    horaLlegada = $('#horaLlegada').val();
    lugarRecogidaLlegada = $('#lugarRecogidaLlegada').val();
    lugarEntregaLlegada = $('#lugarEntregaLlegada').val();
    quienRecogeLlegada = $('#quienRecogeLlegada').val();
    codigoTarifasRegreso = $('#codigoTarifasRegreso').val();
    textoTarifasRegreso = $('#textoTarifasRegreso').val();
    importeTarifasRegreso = $('#importeTarifasRegreso').val();
    ivaTarifasRegreso = $('#ivaTarifasRegreso').val();
    
    // DEBUG: Verificar valores de IVA
    console.log('🔍 DEBUG Transfer - IVA Llegada:', ivaTarifasLlegada);
    console.log('🔍 DEBUG Transfer - IVA Regreso:', ivaTarifasRegreso);
    
    diaRegreso = $('#diaRegreso').val();
    horaRegreso = $('#horaRegreso').val();
    lugarRecogidaRegreso = $('#lugarRecogidaRegreso').val();
    lugarEntregaRegreso = $('#lugarEntregaRegreso').val();
    quienRecogeRegreso = $('#quienRecogeRegreso').val();
    observaciones = $('#observaciones').val();


    $.ajax({
        url: "../../controller/llegadas.php?op=agregarTransfer",
        type: 'POST',
        data: {
            idLlegada: idLlegada, 
            codigoTarifasLlegada: codigoTarifasLlegada, 
            textoTarifasLlegada: textoTarifasLlegada, 
            importeTarifasLlegada: importeTarifasLlegada, 
            ivaTarifasLlegada: ivaTarifasLlegada, 
            diaLlegada: diaLlegada, 
            horaLlegada: horaLlegada,
            lugarRecogidaLlegada: lugarRecogidaLlegada, 
            lugarEntregaLlegada: lugarEntregaLlegada, 
            quienRecogeLlegada: quienRecogeLlegada,
            codigoTarifasRegreso: codigoTarifasRegreso, 
            textoTarifasRegreso: textoTarifasRegreso, 
            importeTarifasRegreso: importeTarifasRegreso, 
            ivaTarifasRegreso: ivaTarifasRegreso, 
            diaRegreso: diaRegreso, 
            horaRegreso: horaRegreso,
            lugarRecogidaRegreso: lugarRecogidaRegreso, 
            lugarEntregaRegreso: lugarEntregaRegreso, 
            quienRecogeRegreso: quienRecogeRegreso,
            observaciones: observaciones
        },  // Aquí pasas la idMatricula
      
        success: function(response) {

            

            toastr.success("Transfer Añadido");
            
            // Resetear el estado de cambios sin guardar
            resetearTransferCambios();
            
            // Actualizar totales
            actualizarTotalFacturado();

          },
        error: function(err) {
            // Manejar errores
        }
    });

}




//==================//
// PAGO ANTICIPADO  //


function listarPagoAnticipadoTabla(idLlegada){
 
     
var pagoAnticipadoTable = $("#pagoAnticipadoTableNew").DataTable({
    select: false, // Nos permite seleccionar filas para exportar

    columns: [
        { name: "importePagoAnticipado", className: 'secundariaDef' },          // Corresponde a "Tarifa"
        { name: "fechaPagoAnticipado", className: 'secundariaDef' },    // Corresponde a "Descripción"
        { name: "medioPagoAnticipado", className: 'text-center' },        // Corresponde a "Descuento"
        { name: "observacionPagoAnticipado", className: 'text-center' },      // Corresponde a "Fecha Inicio"
        { name: "Accion", className: 'text-center', width: "9%" } // Corresponde a "Acción"
    ],

    columnDefs: [
        { targets: [0], orderable: true, visible: true }, // Tarifa
        { targets: [1], orderable: true, visible: true }, // Descripción
        { targets: [2], orderable: true, visible: true }, // Importe
        { targets: [3], orderable: true, visible: true }, // IVA
        { targets: [4], orderable: true, visible: true }, // Descuento
     
    ],

    searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
        columns: [0, 1, 2, 3, 4]
    },

    ajax: {
        url: `../../controller/llegadas.php?op=listarPagoAnticipado&idLlegada=${idLlegada}`, // Añadimos el parámetro
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            // Código opcional antes de enviar
        },
        complete: function (data) {

        },
        error: function (e) {
            console.error("Error en la carga de datos:", e);
        }
    },

    footerCallback: function (row, data, start, end, display) {

        // HABILITAR VISADO //
        var api = this.api();
        var totalRegistros = api.data().length; // Total de registros
        console.log('Totalregistro'+ totalRegistros);
        // Comprobar si hay datos
        if (totalRegistros > 0) {
            // La tabla tiene contenido
            $("#visados-tabNew").attr("disabled", false);
            $("#visados-tabNew").removeClass("disabled");
            $("#visadosContentNew").removeClass("d-none");
        } else {
            // La tabla está vacía
            $("#visados-tabNew").attr("disabled", true);
            $("#visados-tabNew").removeClass("true");
            $("#visadosContentNew").addClass("d-none");
        }
        //====================//

        let totalPagoAnticipado = 0;

        api.column(0, { search: 'applied' }).data().each(function (value) {
            let numero = parseFloat(value.replace(/[€.]/g, '').replace(',', '.'));
            if (!isNaN(numero)) {
                totalPagoAnticipado += numero;
            }
        });
    
        $(api.column(0).footer()).html(totalPagoAnticipado.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
        $('#finalPagado').text(totalPagoAnticipado.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
        actualizarPendiente();


    },

    createdRow: function (row, data, dataIndex) {
        // Personaliza las filas si es necesario
    }

    });

    $("#pagoAnticipadoTableNew").addClass("width-100");

}

function actualizarPendiente() {
    // Obtener el total pagado limpiando el formato
    let pagadoTexto = $('#finalPagado').text().replace(/[€\s.]/g, '').replace(',', '.');
    let pagado = parseFloat(pagadoTexto) || 0;
    
    // Calcular pendiente usando el total general con IVA
    let pendiente = totalGeneralIva - pagado;
    
    // Actualizar el campo de pendiente
    $('#finalPendiente').text(pendiente.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
}

// AÑADIR PAGO ANTICIPADO
   
$("#agregarPagoAnticipadoNew").on("click", function () {

    
    let importePago = $("#importeAnticipadoOtros").val().trim();

    // Elimina separadores de miles (puntos) y cambia la coma decimal por un punto
    importePago = importePago.replace(/\./g, "").replace(",", ".");

    // Convierte a número después de la limpieza
    importePago = parseFloat(importePago) || 0;

    if (isNaN(importePago)) {
        toastr.warning("Por favor, introduce un número válido.");
        return;
    }
    let fechaPago = $("#fechaPagoOtros").val();

    if (!fechaPago) {
        toastr.warning("Por favor, introduce una fecha.");
        return;
    } else if (isNaN(Date.parse(fechaPago))) {
        toastr.warning("La fecha de pago no es válida.");
        return;
    } 
    
    let medioPago = $("#medioPagoOtros").val();

    if (!medioPago || medioPago.trim() === "") {
        toastr.warning("Por favor, selecciona un medio de pago.");
        return;

    } 
    comentarioPago = $("#comentarioPagoOtros").val();

    // NO PERMITIMOS SUPERAR PAGO PENDIENTE
    let finalPagadoTexto = $('#finalPagado').text().replace(/[€\s.]/g, '').replace(',', '.');
    let finalPagado = parseFloat(finalPagadoTexto) || 0;
    
    let totalExtra = finalPagado + importePago;
    console.log(importePago);
    console.log(finalPagado);
    console.log(totalGeneralIva);
    console.log(totalExtra);
    
    if (totalExtra > totalGeneralIva) {
        toastr.warning('El importe supera el pago pendiente.');
    }
    
    //===================================================//
    //===================================================//
    //===================================================//
  
    var datosFormulario = {
        idLlegadas : $("#idLlegadaReal").val(),
        importePago : $("#importeAnticipadoOtros").val(),
        fechaPago : $("#fechaPagoOtros").val(),
        medioPago : $("#medioPagoOtros").val(),
        comentarioPago : $("#comentarioPagoOtros").val()
    };

    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }
    // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
        $.ajax({
            url: "../../controller/llegadas.php?op=insertarPagoAnticipado",
            type: 'POST',
            data: formData,
            processData: false, // Importante para evitar que jQuery procese los datos
            contentType: false, // Importante para que el navegador determine el tipo de contenido
            success: function(response) {
                // Manejar la respuesta del servidor
                toastr.success("Pago Añadido");
                $("#pagoAnticipadoTableNew").DataTable().ajax.reload(null, false);
                
                $("#idPagoEditando").text("");
                $("#importeAnticipadoOtros").val("");
                $("#fechaPagoOtros").val("");
                $("#medioPagoOtros").val("").trigger('change');
                $("#comentarioPagoOtros").val("");
              },
            error: function(err) {
                // Manejar errores
            }
        });
 

 });

 // GUARDAR EDITAR PAGO //
$("#guardarPagoAnticipadoNew").on("click", function () {

    
    let idPagoEditando = $("#idPagoEditando").val();
    if(idPagoEditando == ''){
        toastr.error("Error en la edición. Cargue de nuevo.");
        return;
    }
    let importePago = $("#importeAnticipadoOtros").val().trim();

    // Elimina separadores de miles (puntos) y cambia la coma decimal por un punto
    importePago = importePago.replace(/\./g, "").replace(",", ".");

    
    if (!/^-?\d+(\.\d{1,2})?$/.test(importePago)) {
        toastr.warning("Por favor, introduce un número válido.");
        return;
    } else {
    }
    let fechaPago = $("#fechaPagoOtros").val();

    if (!fechaPago) {
        toastr.warning("Por favor, introduce una fecha.");
        return;
    } else if (isNaN(Date.parse(fechaPago))) {
        toastr.warning("La fecha de pago no es válida.");
        return;
    } 
    
    let medioPago = $("#medioPagoOtros").val();

    if (!medioPago || medioPago.trim() === "") {
        toastr.warning("Por favor, selecciona un medio de pago.");
        return;

    } 
    comentarioPago = $("#comentarioPagoOtros").val();

    
    //===================================================//
    //===================================================//
    //===================================================//
  
    var datosFormulario = {
        
        idPagoEditando : $("#idPagoEditando").val(),
        importePago : $("#importeAnticipadoOtros").val(),
        fechaPago : $("#fechaPagoOtros").val(),
        medioPago : $("#medioPagoOtros").val(),
        comentarioPago : $("#comentarioPagoOtros").val()
    };

    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }
    // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
        $.ajax({
            url: "../../controller/llegadas.php?op=guardarEdicionPago",
            type: 'POST',
            data: formData,
            processData: false, // Importante para evitar que jQuery procese los datos
            contentType: false, // Importante para que el navegador determine el tipo de contenido
            success: function(response) {
                // Manejar la respuesta del servidor
                toastr.success("Pago Editado");
                $("#pagoAnticipadoTableNew").DataTable().ajax.reload(null, false);
               
                 $("#idPagoEditando").text("");
                 $("#importeAnticipadoOtros").val("");
                 $("#fechaPagoOtros").val("");
                 $("#medioPagoOtros").val("").trigger('change');
                 $("#comentarioPagoOtros").val("");
  
                 $("#agregarPagoAnticipadoNew").removeClass("d-none");
                 $("#guardarPagoAnticipadoNew").addClass("d-none");
                 $("#cancelarPagoAnticipado").addClass("d-none");
    
              },
            error: function(err) {
                // Manejar errores
            }
        });
 

 });


//******************************************/
//********** eliminar PAGO  *************/
//******************************************/



function eliminarPagoAnticipado(idPago){
    $.ajax({
        url: "../../controller/llegadas.php?op=eliminarPagoAnticipado",
        type: 'POST',
        data: { idPago: idPago },  // Aquí pasas la idMatricula
      
        success: function(response) {

            $("#pagoAnticipadoTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR

            toastr.success("Pago Eliminado");

          },
        error: function(err) {
            // Manejar errores
        }
    });

}


//******************************************/
//********** EDITAR MEDIO PAGO  *************/
//******************************************/


function editarPagoAnticipado(idPago){
    $.ajax({
        url: "../../controller/llegadas.php?op=pagoAnticipadoxId",
        type: 'POST',
        data: { idPago: idPago },  // Aquí pasas la idMatricula
      
        success: function(response) {
            var data = JSON.parse(response);

            // Manejar la respuesta del servidor
            // Si la respuesta es un array de objetos, puedes acceder a la primera posición y luego al campo:
            
            var idPagoEditando = data[0]['idPagoAnticipado'];
            var importeAnticipadoOtros = data[0]['importePagoAnticipado'];
            var fechaPagoOtros = data[0]['fechaPagoAnticipado'];
            var medioPagoOtros = data[0]['medioPagoAnticipado'];
            var comentarioPagoOtros = data[0]['observacionPagoAnticipado'];

            
            $("#idPagoEditando").val(idPagoEditando);

            $("#importeAnticipadoOtros").val(importeAnticipadoOtros);

            $("#fechaPagoOtros").val(fechaPagoOtros);
            $("#medioPagoOtros").val(medioPagoOtros).trigger('change');
            $("#comentarioPagoOtros").val(comentarioPagoOtros);
          
            $(".btnEditViewPago").addClass("d-none");
          
            $("#agregarPagoAnticipadoNew").addClass("d-none");

            $("#guardarPagoAnticipadoNew").removeClass("d-none");
            $("#cancelarPagoAnticipado").removeClass("d-none");

            
          },
        error: function(err) {
            // Manejar errores
        }
    });

}

//==================//
// CANCELAR EDICION //
//==================//

$("#cancelarPagoAnticipado").click(function(){

    $("#idPagoEditando").text("");
    $("#importeAnticipadoOtros").val("");
    $("#fechaPagoOtros").val("");
    $("#medioPagoOtros").val("").trigger('change');
    $("#comentarioPagoOtros").val("");
  
   
    
    $("#agregarPagoAnticipadoNew").removeClass("d-none");
    $("#guardarPagoAnticipadoNew").addClass("d-none");
    $("#cancelarPagoAnticipado").addClass("d-none");
  });

  //=========================//
  //     AÑADIR VISADO       //
  //=========================//

  

function agregarVisado(){
    // Obtener 1 si el checkbox está marcado, 0 si no lo está
    var visadoCheck = $('#visadoCheck').prop('checked') ? 1 : 0;
    idLlegada = $('#idLlegadaReal').val();

  
    var fechaAdmision = new Date($("#fechaAdmision").val());
    var denegacionFecha = new Date($("#denegacionFecha").val());
    
    if (denegacionFecha < fechaAdmision) {
        toastr.warning("La fecha de denegación no puede ser anterior a la fecha de admisión.");
        return;
    } else {
        var datosFormulario = {
            idLlegada : $('#idLlegadaReal').val(),
            visadoCheck : visadoCheck,
            fechaAdmision : $("#fechaAdmision").val(),
            denegacionFecha : $("#denegacionFecha").val(),
            denegacionMotivo : $("#denegacionMotivo").val()
        };
    }

    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }
    $.ajax({
        url: "../../controller/llegadas.php?op=actualizarVisado",
        type: 'POST',
        data: formData,
        processData: false, // Importante para evitar que jQuery procese los datos
        contentType: false, // Importante para que el navegador determine el tipo de contenido
      
        success: function(response) {

            forzarEstadosMatricula();
            forzarEstadosAlojamiento();
            toastr.success("Visado Actualizado");

          },
        error: function(err) {
            // Manejar errores
        }
    });

}

  //=========================//
  //     cargar SUPLIDOS     //
  //=========================//

  
function listarSuplidosTabla(idLlegada){
 
     
    var suplidosTableNew = $("#suplidosTableNew").DataTable({
        select: false, // Nos permite seleccionar filas para exportar
    
        columns: [
            { name: "importeSuplidos", className: 'secundariaDef' },          // Corresponde a "Tarifa"
            { name: "descripcionSuplidos", className: 'secundariaDef' },    // Corresponde a "Descripción"
         
            { name: "Accion", className: 'text-center', width: "9%" } // Corresponde a "Acción"
        ],
    
        columnDefs: [
            { targets: [0], orderable: true, visible: true }, // Tarifa
            { targets: [1], orderable: true, visible: true }, // Descripción
            { targets: [2], orderable: true, visible: true }, // Importe
          
         
        ],
    
        searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
            columns: [0, 1, 2]
        },
    
        ajax: {
            url: `../../controller/llegadas.php?op=listarSuplidos&idLlegada=${idLlegada}`, // Añadimos el parámetro
            type: "get",
            dataType: "json",
            cache: false,
            serverSide: true,
            processData: true,
            beforeSend: function () {
                // Código opcional antes de enviar
            },
            complete: function (data) {
    
            },
            error: function (e) {
                console.error("Error en la carga de datos:", e);
            }
        },
    
        footerCallback: function (row, data, start, end, display) {
    
            // HABILITAR VISADO //
            var api = this.api();
            var total = api.data().length; // Total de registros
    
            // Comprobar si hay datos
            if (total > 0) {
                // La tabla tiene contenido
                $("#visados-tab").attr("disabled", false);
                $("#visados-tab").removeClass("disabled");
                $("#visadosContent").removeClass("d-none");
            } else {
                // La tabla está vacía
                $("#visados-tab").attr("disabled", true);
                $("#visados-tab").removeClass("true");
                $("#visadosContent").addClass("d-none");
            }
          
            //====================//
    
           /*  let api = this.api();
            let total = 0;
    
            api.column(1, { search: 'applied' }).data().each(function (value) {
                let numero = parseFloat(value.replace(/[€.]/g, '').replace(',', '.'));
                console.log(numero)
                if (!isNaN(numero)) {
                    total += numero;
                    console.log(total);
                }
            });
    
            $(api.column(1).footer()).html(total.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
    
            precioMatricula = $('#finalFacturadoNew').val();
            precioFacturar = calcularPrecio(precioMatricula,total);
            
            $('#finalFacturadoNew').val(precioFacturar.toFixed(2));  */
    
    
        },
    
        createdRow: function (row, data, dataIndex) {
            // Personaliza las filas si es necesario
        }
    
        });
    
        $("#suplidosTableNew").addClass("width-100");
    
    }


    function agregarSuplidos(){
    
        idLlegada = $('#idLlegadaReal').val();
     
        var importeSuplido = $('#importeSuplido').val().trim();
        var descrSuplido = $('#descrSuplido').val().trim();
        
        if (importeSuplido === "" || descrSuplido === "") {
            toastr.warning("Los campos Importe Suplido y Descripción Suplido no pueden estar vacíos.");
            return;
        } 
        
    
        $.ajax({
            url: "../../controller/llegadas.php?op=agregarSuplido",
            type: 'POST',
            data: { idLlegada: idLlegada, importeSuplido: importeSuplido, descrSuplido: descrSuplido },  // Aquí pasas la idMatricula
          
            success: function(response) {
    
                
                $("#suplidosTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR

                toastr.success("Suplido Añadido");
    
              },
            error: function(err) {
                // Manejar errores
            }
        });
    
    }
    
//******************************************/
//**********  eliminar Suplido  *************/
//******************************************/



function eliminarSuplido(idSuplido){
    $.ajax({
        url: "../../controller/llegadas.php?op=eliminarSuplido",
        type: 'POST',
        data: { idSuplido: idSuplido },  // Aquí pasas la idMatricula
      
        success: function(response) {

            $("#suplidosTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR

            toastr.success("Suplido Eliminado");

          },
        error: function(err) {
            // Manejar errores
        }
    });

}

    
    


//============================================//
//               CANCELACIÓN                  //
//============================================//

$(document).ready(function () {
   
    $("#cancelacionLlegadas").on("click", function () {

        $('#datosLlegadaText').text($('#idLlegada').val());
        $("#cancelacion-modal").modal("show");

    });

});
function agregarCancelacion(){
    idLlegada = $('#idLlegadaReal').val();
    fechaCancelacion = $('#cancelacionFecha').val();
    motivoCancelacion = $('#motivoCancelacion').val();

    // Validar que los campos no estén vacíos
    if (fechaCancelacion === "" || motivoCancelacion === "") {
        // Si algún campo está vacío, mostrar un mensaje de error
        toastr.error(`El campo Fecha de Cancelación o Motivo está vacío.`, 'Error de Validación');

    } else {
        $.ajax({
            url: "../../controller/llegadas.php?op=insertarCancelacion",
            type: 'POST',
            data: {idLlegada:idLlegada, fechaCancelacion: fechaCancelacion, motivoCancelacion: motivoCancelacion  },  // Aquí pasas la idMatricula
          
            success: function(response) {
                forzarEstadosMatricula();
                forzarEstadosAlojamiento();
                $('.llegadaActivaLabel').addClass('d-none');
                $('.llegadaInactivaLabel').removeClass('d-none');

                toastr.success("Cancelación Insertada");
                toastr.warning("El alumno no tendrá acceso a esta docencia.");
                $('#ocultarInsertarCancelacion').removeClass('d-none'); // Ocultar si al menos un campo tiene contenido
                $('#mostrarInsertarCancelacion').addClass('d-none'); // Ocultar si al menos un campo tiene contenido    
              },
            error: function(err) {
                // Manejar errores
            }
        });
    }
    
}


function estadoLlegada(){
    idLlegadas = $('#idLlegadaReal').val();

  $.post("../../controller/llegadas.php?op=recogerLledagasXIdLlegada",{idLlegadas:idLlegadas},function (data) {
  
    data = JSON.parse(data);
    console.log(data);
    let estLlegadas = data[0]["estLlegada"];
    console.log(estLlegadas);
    
    // Badge de estado
    let estadoBadge = '';
    if (estLlegadas == '0' ) {
        estadoBadge = "<label class='badge bg-danger estLlegadasLabel tx-14-force'>Cancelado</label>";
    } else if (estLlegadas == '1') {
        estadoBadge = "<label class='badge bg-success estLlegadasLabel tx-14-force'>En Proceso</label>";
    } else if (estLlegadas == '2') {
        estadoBadge = "<label class='badge bg-warning estLlegadasLabel tx-14-force'>En Espera</label>";
    } else if (estLlegadas == '3') {
        estadoBadge = "<label class='badge bg-info estLlegadasLabel tx-14-force'>Finalizada</label>";
    } else if (estLlegadas == '4') {
        estadoBadge = "<label class='badge bg-secondary estLlegadasLabel tx-14-force'>Sin Matriculación</label>";
    } else {
        estadoBadge = "<label class='badge bg-secondary estLlegadasLabel tx-14-force'>Sin Resolver</label>";
    }
    
    // Badge de alerta de pago
    let alertaBadge = '';
    if (data[0]["nivel_alerta"] && data[0]["color_alerta"]) {
        let nivel = data[0]["nivel_alerta"];
        let color = data[0]["color_alerta"];
        let mensaje = data[0]["mensaje_alerta"] || nivel;
        alertaBadge = " <span class='badge' style='background-color: " + color + "; color: white; font-size: 14px; padding: 6px 12px;' title='" + mensaje + "'>" + nivel + "</span>";
    } else {
        alertaBadge = " <span class='badge bg-light text-dark' style='font-size: 14px; padding: 6px 12px;'>Sin Alerta</span>";
    }
    
    // Mostrar ambos badges
    $('#estadoLlegada').html(estadoBadge + alertaBadge);
  })

}
function eliminarCancelacion(){
        idLlegada = $('#idLlegadaReal').val();
 

   
        $.ajax({
            url: "../../controller/llegadas.php?op=eliminarCancelacion",
            type: 'POST',
            data: {idLlegada:idLlegada},  // Aquí pasas la idMatricula
          
            success: function(response) {
    
                
                $('.llegadaActivaLabel').removeClass('d-none');
                $('.llegadaInactivaLabel').addClass('d-none');

                $('#cancelacionFecha').val('');
                $('#motivoCancelacion').val('');

                toastr.success("Cancelación eliminada");
                toastr.warning("El alumno tendrá acceso a esta docencia dentro de las fechas de matriculación.");

                $('#ocultarInsertarCancelacion').addClass('d-none'); // Ocultar si al menos un campo tiene contenido
                $('#mostrarInsertarCancelacion').removeClass('d-none'); // Ocultar si al menos un campo tiene contenido    
                forzarEstadosMatricula();
                forzarEstadosAlojamiento();
              },
            error: function(err) {
                // Manejar errores
            }
        });

}




//============================================//
//         FORZAR ESTADOS DE MATRICULA        //
//============================================//

function forzarEstadosMatricula(){
    idLlegada = $('#idLlegadaReal').val();
    $.post("../../controller/llegadas.php?op=actualizarMatriculacion", { idLlegada: idLlegada}).always(function() {
        $("#matriculacionTableNew").DataTable().ajax.reload(null, false);
        estadoLlegada();
    });
}



//============================================//
//         FORZAR ESTADOS DE ALOJAMIENTO        //
//============================================//

function forzarEstadosAlojamiento(){
    idLlegada = $('#idLlegadaReal').val();
    $.post("../../controller/llegadas.php?op=actualizarAlojamiento", { idLlegada: idLlegada}).always(function() {
        $("#alojamientoTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR
        estadoLlegada();
    });

}


//=====================================================//
//                    ALOJAMIENTO                      //
//=====================================================//


//==================================================//
//              TABLA ALOJAMIENTOS                  //
//==================================================//

// AÑADIDOS LOS PARÁMETROS DE FACTURA PROFORMA Y FACTURA REAL, YA QUE SUS ACCIONES
// SE QUIEREN ANULAR EN CASO DE QUE EXISTA ALGUNA PROFORMA

function listarAlojamientosTabla(idLlegada){
 
    // Comprueba si el DataTable ya está inicializado
    if ($.fn.DataTable.isDataTable("#alojamientoTableNew")) {
       // Destruye el DataTable
       $("#alojamientoTableNew").DataTable().clear().destroy();
   }

   comprobarFacturasActivas(idLlegada);
var alojamientoTable = $("#alojamientoTableNew").DataTable({
   select: false, // Nos permite seleccionar filas para exportar

   columns: [
       { name: "Tarifa", className: 'secundariaDef' },          // Corresponde a "Tarifa"
       { name: "Descripcion", className: 'secundariaDef' },    // Corresponde a "Descripción"
       { name: "Importe", className: 'text-center' },          // Corresponde a "Importe"
       { name: "IVA", className: 'text-center' },              // Corresponde a "IVA"
       { name: "Descuento", className: 'text-center' },        // Corresponde a "Descuento"
       { name: "FechaInicio", className: 'text-center' },      // Corresponde a "Fecha Inicio"
       { name: "FechaFin", className: 'text-center' },         // Corresponde a "Fecha Fin"
       { name: "Estado", className: 'text-center d-none' },         // Corresponde a "Fecha Fin"
       { name: "Accion", className: 'text-center', width: "9%" } // Corresponde a "Acción"
   ],
   
   columnDefs: [
       { targets: [0], orderable: true, visible: true }, // Tarifa
       { targets: [1], orderable: true, visible: true }, // Descripción
       { targets: [2], orderable: true, visible: true }, // Importe
       { targets: [3], orderable: true, visible: true }, // IVA
       { targets: [4], orderable: true, visible: true }, // Descuento
       { targets: [5], orderable: true, visible: true }, // Fecha Inicio
       { targets: [6], orderable: true, visible: true }, // Fecha Fin
       { targets: [7], orderable: false, visible: true }, // Acción
       { targets: [8], orderable: false, visible: true } // Acción

   ],

   searchBuilder: {  // Las columnas que aparecerán en el desplegable para ser buscadas
       columns: [0, 1, 2, 3, 4, 5, 6, 7,8]
   },

   ajax: {
       url: `../../controller/llegadas.php?op=listarAlojamientos&idLlegada=${idLlegada}`, // Añadimos el parámetro
       type: "get",
       dataType: "json",
       cache: false,
       serverSide: true,
       processData: true,
       data: function(d) {
        d.facturaProforma = $('#inputFacturaProforma').val();
        d.facturaReal = $('#inputFacturaReal').val();
       },
       beforeSend: function () {
           // Código opcional antes de enviar
       },
       complete: function (data) {
           // Código opcional al completar
       },
       error: function (e) {
           console.error("Error en la carga de datos:", e);
       }
   },

   footerCallback: function (row, data, start, end, display) {
    let api = this.api();
    let total = 0;
    let totalConIva = 0;

    // Obtener los datos completos de cada fila
    api.rows({ search: 'applied' }).every(function () {
        let rowData = this.data();
        
        // Columna 2: Importe
        let importe = parseFloat(
            String(rowData[2])
                .replace(/[€.\s]/g, '')   // quitar espacios, símbolo € y puntos de miles
                .replace(',', '.')      // cambiar coma decimal por punto
        );
        
        // Columna 3: IVA
        let iva = parseFloat(
            String(rowData[3])
                .replace(/\s|%/g, '')   // quitar espacios y símbolo %
                .replace(',', '.')      // cambiar coma decimal por punto
        );
        
        if (!isNaN(importe)) {
            total += importe;
            
            // Calcular importe con IVA: importe + (importe * iva / 100)
            if (!isNaN(iva)) {
                totalConIva += importe + (importe * iva / 100);
            } else {
                totalConIva += importe;
            }
        }
    });

    $(api.column(2).footer()).html(total.toLocaleString("es-ES", { style: "currency", currency: "EUR" }));
    
    // Asignar los totales a las variables globales
    totalAlojamiento = total;
    totalAlojamientoIva = totalConIva;
    
    // Actualizar el total facturado (suma de matriculaciones + alojamientos)
    actualizarTotalFacturado();

   },

   createdRow: function (row, data, dataIndex) {
       // Personaliza las filas si es necesario
   }
});
}

$("#alojamientoTableNew").addClass("width-100");

//==================================================//
//==================================================//
//==================================================//

//==================================================//
//              AGREGAR ALOJAMIENTOS                //
//==================================================//
      
$("#agregarAlojamientosNew").on("click", function () {

    //===================================================//
    //===================================================//
    //===================================================//
    // Lista de campos a validar
    const campos = [      
        { id: '#codAlojamiento', nombre: 'Tarifa de Alojamiento' },
        { id: '#ivaAlojamiento', nombre: 'IVA Alojamiento' },
        { id: '#entradaAlojamiento', nombre: 'Fecha de Inicio' },
        { id: '#salidaAlojamiento', nombre: 'Fecha de Finalización' }
    ];
  
    // Validar si los campos están vacíos
    for (const campo of campos) {
        if ($(campo.id).val().trim() === '') {
            toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
            return; // Salir de la función si hay un campo vacío
        }
    }
  
    // Validar fechas
    const inicio = formatearFechaSinHora($('#entradaAlojamiento').val());
    const final = formatearFechaSinHora($('#salidaAlojamiento').val());
  
    if (final < inicio) {
        toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
        return; // Salir de la función si las fechas no son lógicas
    }
    //===================================================//
    //===================================================//
    //===================================================//
  
    var datosFormulario = {
         idLlegada : $("#idLlegadaReal").val(),
         entradaAlojamiento : inicio,
         salidaAlojamiento : final,
         codAlojamiento : $("#codAlojamiento").val(),
         textEditar : $("#descripcionTarifaAloja").val(),
         importeAlojamiento : $("#importeAlojamiento").val(),
         ivaAlojamiento : $("#ivaAlojamiento").val(),
         descuentoAlojamiento : $("#descuentoAlojamiento").val(),
         observacionesAlojamiento : $("#observacionesAlojamiento").val()

    };
    console.log(datosFormulario)
    var formData = new FormData();

    // Agregar los datos al objeto FormData
    for (var key in datosFormulario) {
        formData.append(key, datosFormulario[key]);
    }
    // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
        $.ajax({
            url: "../../controller/llegadas.php?op=insertarAlojamiento",
            type: 'POST',
            data: formData,
            processData: false, // Importante para evitar que jQuery procese los datos
            contentType: false, // Importante para que el navegador determine el tipo de contenido
            success: function(response) {
                // Manejar la respuesta del servidor
                toastr.success("Alojamiento Añadido");
                $("#alojamientoTableNew").DataTable().ajax.reload(null, false);
                forzarEstadosAlojamiento();
                
                // Limpiar campos del formulario (excepto fecha de entrada)
                $("#codAlojamiento").val('');
                $("#importeAlojamiento").val('');
                $("#ivaAlojamiento").val('');
                $("#descuentoAlojamiento").val('');
                $("#salidaAlojamiento").val('');
                $("#horaAlojamiento").val('11:00');
                $("#observacionesAlojamiento").val('');
                $("#descripcionTarifaAloja").val('');
    
              },
            error: function(err) {
                // Manejar errores
            }
        });
 

 });


//******************************************/
//********** EDITAR ALOJAMIENTO  ***********/
//******************************************/


function editarAlojamientoNew(idAlojamiento){
    $.ajax({
        url: "../../controller/llegadas.php?op=recogerAlojamientoxId",
        type: 'POST',
        data: { idAlojamiento: idAlojamiento },  // Aquí pasas la idMatricula
      
        success: function(response) {
            var data = JSON.parse(response);
            // Manejar la respuesta del servidor
            // Si la respuesta es un array de objetos, puedes acceder a la primera posición y luego al campo:
            var idAlojamientoLlegada = data[0]['idAlojamientoLlegada'];

            var codTarifa_alojamientos = data[0]['codTarifa_alojamientos'];
            var nombreTarifa_alojamientos = data[0]['nombreTarifa_alojamientos'];
            var descuento_Alojamientos = data[0]['descuento_Alojamientos'];

            var precioTarifa_alojamientos = data[0]['precioTarifa_alojamientos'];
            var idIvaTarifa_alojamientos = data[0]['idIvaTarifa_alojamientos'];
              // Extrae solo la fecha (YYYY-MM-DD) de la cadena completa (YYYY-MM-DD HH:mm:ss)

            var fechaInicioAlojamientos = data[0]['fechaInicioAlojamientos'];

            fechaInicioAlojamientos = new Date(fechaInicioAlojamientos);
            let fechaInicio = fechaInicioAlojamientos.toLocaleDateString('es-ES'); // => "20/10/1999"


            
            var fechaFinAlojamientos = data[0]['fechaFinAlojamientos'];

            fechaFinAlojamientos = new Date(fechaFinAlojamientos);
            let fechaFinal = fechaFinAlojamientos.toLocaleDateString('es-ES'); // => "20/10/1999"


            var obsAlojamientos = data[0]['obsAlojamientos'];

            
            
            
        
        
            $("#textEditar").text(" - Editando la linea: Tarifa: "+ codTarifa_alojamientos+ " - Descripción: " + nombreTarifa_alojamientos);
            
            $("#descripcionTarifaAloja").val(nombreTarifa_alojamientos);

            $("#idAlojamientoEditando").val(idAlojamientoLlegada);

            $("#codAlojamiento").val(codTarifa_alojamientos);
            $("#importeAlojamiento").val(precioTarifa_alojamientos);
            $("#ivaAlojamiento").val(idIvaTarifa_alojamientos);
            $("#descuentoAlojamiento").val(descuento_Alojamientos);
          
            $("#entradaAlojamiento").val(fechaInicio);
            $("#salidaAlojamiento").val(fechaFinal);
            $("#observacionesAlojamiento").val(obsAlojamientos);


          
            $("#agregarAlojamientosNew").addClass("d-none");

            $("#guardarAlojamientoNew").removeClass("d-none");
            $("#cancelarAlojamiento").removeClass("d-none");
          },
        error: function(err) {
            // Manejar errores
        }
    });

}



      /* GUARDAR EDICION */
      $("#guardarAlojamientoNew").on("click", function () {
        console.log('fff');
        const campos = [      
            { id: '#codAlojamiento', nombre: 'Tarifa de Alojamiento' },
            { id: '#ivaAlojamiento', nombre: 'IVA Alojamiento' },
            { id: '#entradaAlojamiento', nombre: 'Fecha de Inicio' },
            { id: '#salidaAlojamiento', nombre: 'Fecha de Finalización' }
        ];
      
        // Validar si los campos están vacíos
        for (const campo of campos) {
            if ($(campo.id).val().trim() === '') {
                toastr.error(`El campo "${campo.nombre}" está vacío.`, 'Error de Validación');
                return; // Salir de la función si hay un campo vacío
            }
        }
              console.log('fff');

        // Validar fechas
        const inicio = formatearFechaSinHora($('#entradaAlojamiento').val());
        const final = formatearFechaSinHora($('#salidaAlojamiento').val());
              console.log('fff');

        if (final < inicio) {
            toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
            return; // Salir de la función si las fechas no son lógicas
        }
        //===================================================//
        //===================================================//
        //===================================================//
              console.log('fff');

        var datosFormulario = {
            idAlojamientoEditando : $("#idAlojamientoEditando").val(),
             idLlegada : $("#idLlegadaReal").val(),
             entradaAlojamiento : inicio,
             salidaAlojamiento : final,
             codAlojamiento : $("#codAlojamiento").val(),
             textEditar : $("#descripcionTarifaAloja").val(),
             importeAlojamiento : $("#importeAlojamiento").val(),
             ivaAlojamiento : $("#ivaAlojamiento").val(),
             descuentoAlojamiento : $("#descuentoAlojamiento").val(),
             observacionesAlojamiento : $("#observacionesAlojamiento").val()
    
        };
        var formData = new FormData();
        console.log(datosFormulario);
        // Agregar los datos al objeto FormData
        for (var key in datosFormulario) {
            formData.append(key, datosFormulario[key]);
        }
        // Aquí puedes hacer la llamada AJAX para enviar el JSON al servidor
            $.ajax({
                url: "../../controller/llegadas.php?op=editarAlojamiento",
                type: 'POST',
                data: formData,
                processData: false, // Importante para evitar que jQuery procese los datos
                contentType: false, // Importante para que el navegador determine el tipo de contenido
                success: function(response) {
                    // Manejar la respuesta del servidor
                    toastr.success("Alojamiento Editado");
                    $("#alojamientoTableNew").DataTable().ajax.reload(null, false);
                   
                    forzarEstadosAlojamiento();
                  },
                error: function(err) {
                    // Manejar errores
                }
            });
     
   
     });

    //******************************************/
    //********** eliminar MATRICULA  *************/
    //******************************************/



    function eliminarAlojamientoNew(idAlojamiento){
        $.ajax({
            url: "../../controller/llegadas.php?op=eliminarAlojamiento",
            type: 'POST',
            data: { idAlojamiento: idAlojamiento },  // Aquí pasas la idMatricula
        
            success: function(response) {

                $("#alojamientoTableNew").DataTable().ajax.reload(null, false); //! NO TOCAR

                toastr.success("Alojamiento Eliminado");
                forzarEstadosAlojamiento();
            },
            error: function(err) {
                // Manejar errores
            }
        });

    }

    // SUMAR TIEMPO A UNA FECHA - Función para agregar semanas a una fecha //
    function sumarTiempo(fecha, cantidad, medida) {
      // Normalizar la medida a minúsculas y quitar espacios
      const medidaNormalizada = medida ? medida.toLowerCase().trim() : '';
      console.log('📊 sumarTiempo - Medida normalizada:', medidaNormalizada);
      
      // Verificar si es semanas (tolerante a diferentes formatos)
      if (medidaNormalizada.includes('semana') || medidaNormalizada.includes('week')) {
        fecha.setDate(fecha.getDate() + cantidad * 7); // Sumar semanas
        console.log('✅ Sumadas', cantidad, 'semanas');
      } else if (medidaNormalizada.includes('dia') || medidaNormalizada.includes('day')) {
        fecha.setDate(fecha.getDate() + cantidad); // Sumar días
        console.log('✅ Sumados', cantidad, 'días');
      } else if (medidaNormalizada.includes('mes') || medidaNormalizada.includes('month')) {
        fecha.setMonth(fecha.getMonth() + cantidad); // Sumar meses
        console.log('✅ Sumados', cantidad, 'meses');
      } else {
        console.error('❌ Medida no reconocida:', medida);
        toastr.warning('Fin de fecha automático solo funciona con semanas, días o meses.');
        return null; // Retornar null si no se reconoce la unidad
      }

      // Obtener solo el día, mes y año
      let dia = fecha.getDate(); // Obtener el día
      let mes = fecha.getMonth() + 1; // Obtener el mes (se suma 1 porque los meses son indexados desde 0)
      let año = fecha.getFullYear(); // Obtener el año

      // Añadir un 0 a los días y meses menores a 10 para que el formato sea DD/MM/YYYY (español)
      let diaFormateado = dia < 10 ? `0${dia}` : dia;
      let mesFormateado = mes < 10 ? `0${mes}` : mes;

      // Devolver la fecha en formato DD/MM/YYYY (español)
      let fechaFormateada = `${diaFormateado}/${mesFormateado}/${año}`;

      return fechaFormateada; // Retornar la fecha en formato español
    }
     
      


    // AJUSTE DE FECHAS POR DOCENCIA //

   

    function ajustarAViernesAnterior(fechaStr) {
       if (typeof fechaStr !== "string") return null;

        // Parsear DD/MM/YYYY
        const [d, m, y] = fechaStr.split("/");
        const fecha = new Date(`${y}-${m}-${d}`);
        if (isNaN(fecha)) return null;

        const diaSemana = fecha.getDay(); // 0=domingo ... 5=viernes

        // Calcular cuántos días restar para llegar al viernes anterior
        const diasARestar = (diaSemana - 5 + 7) % 7;
        fecha.setDate(fecha.getDate() - diasARestar);

        // Formatear DD-MM-YYYY
        const dd = String(fecha.getDate()).padStart(2, "0");
        const mm = String(fecha.getMonth() + 1).padStart(2, "0");
        const yyyy = fecha.getFullYear();

        return `${dd}/${mm}/${yyyy}`;
    }
    
    // AJUSTE DE FECHAS POR ALOJAMIENTO //
    function ajustarASabadoAnterior(fechaStr) {
        if (typeof fechaStr !== "string") return null;

        // Parsear DD/MM/YYYY
        const [d, m, y] = fechaStr.split("/");
        const fecha = new Date(`${y}-${m}-${d}`);
        if (isNaN(fecha)) return null;

        const diaSemana = fecha.getDay(); // 0=domingo ... 5=viernes

        // Calcular cuántos días restar para llegar al viernes anterior
        const diasARestar = (diaSemana - 6 + 7) % 7;
        fecha.setDate(fecha.getDate() - diasARestar);

        // Formatear DD-MM-YYYY
        const dd = String(fecha.getDate()).padStart(2, "0");
        const mm = String(fecha.getMonth() + 1).padStart(2, "0");
        const yyyy = fecha.getFullYear();

        return `${dd}/${mm}/${yyyy}`;
    }
    //
    // SUMAR TIEMPO QUE ESTA EN index.js
    //


    // CALCULO AUTOMATICO DE FECHAS
    $("#tarifas_table tbody").on("click", "tr", function () {


        console.log('Macadamia');
        var data = tarifaAloja_table.row(this).data();
        
        // Obtener el IVA directamente de la fila de la tabla (columna 5)
        var ivaFromTable = $(data[5]).text();
        console.log('📊 IVA obtenido de la tabla:', ivaFromTable);
        
        // Limpiar el valor del IVA (eliminar % y espacios) para campos type="number"
        var ivaValue = ivaFromTable.replace(/[^0-9.,]/g, '').trim();
        console.log('✨ IVA limpio:', ivaValue);

            
        $.post(
        "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
        { codigo: data[1] },function (data) {
            data = JSON.parse(data);
         
            var cantidad = data[0]["unidades_tarifa"]; //1,2,3,4,5....
            console.log(cantidad);
            var medida = data[0]["unidad_tarifa"]; //dias,semanas....
            console.log(medida);


            tipoTarifaCarga = $(".tab-pane.active").find(".buscarTarifa").val();

            if(tipoTarifaCarga == 'Docencia'){
                console.log('Docencia RRR');

                                // Obtener valor DD/MM/YYYY
                let inicioStr = $("#inicioDocencia").val(); // ejemplo: "29/09/2025"

                // Parsear correctamente a Date
                const [d, m, y] = inicioStr.split("/");
                var fechaInicio = new Date(`${y}-${m}-${d}`);
                console.log("Fecha inicio parseada:", fechaInicio);

                var fechaFinal = sumarTiempo(fechaInicio, cantidad, medida);
                console.log("Fecha final calculada:", fechaFinal);
                
                if (fechaFinal) {
                    fechaFinal = ajustarAViernesAnterior(fechaFinal);
                    console.log('Fecha ajustada a viernes anterior:', fechaFinal);
                    $('#finalDocencia').val(fechaFinal);
                } else {
                    console.warn('⚠️ No se pudo calcular la fecha final');
                }

                
            }else if(tipoTarifaCarga == 'Otro'){
                console.log('🚕 Transfer detectado en llegadas.js');
                
                // Si existe lastClickedButton (viene de index.js), usarlo para determinar el contexto
                if (typeof lastClickedButton !== 'undefined' && lastClickedButton) {
                    console.log('✅ Usando lastClickedButton para detectar contexto');
                    var parent = $(lastClickedButton).parent().parent();
                    var isTransferLlegada = parent.closest('.transfer-llegada').length > 0;
                    var isTransferRegreso = parent.closest('.transfer-regreso').length > 0;
                    
                    if (isTransferLlegada) {
                        console.log('📍 Contexto: Transfer Llegada');
                        $('#ivaTarifasLlegada').val(ivaValue);
                        console.log('📊 IVA Llegada asignado:', ivaValue);
                    } else if (isTransferRegreso) {
                        console.log('📍 Contexto: Transfer Regreso');
                        $('#ivaTarifasRegreso').val(ivaValue);
                        console.log('📊 IVA Regreso asignado:', ivaValue);
                    }
                } else {
                    // Fallback: intentar detectar por el campo de código que coincide
                    console.log('⚠️ lastClickedButton no disponible, usando fallback');
                    if ($('#codigoTarifasLlegada').val() === data[1]) {
                        console.log('📍 Detectado por código: Transfer Llegada');
                        $('#ivaTarifasLlegada').val(ivaValue);
                        console.log('📊 IVA Llegada asignado:', ivaValue);
                    } else if ($('#codigoTarifasRegreso').val() === data[1]) {
                        console.log('📍 Detectado por código: Transfer Regreso');
                        $('#ivaTarifasRegreso').val(ivaValue);
                        console.log('📊 IVA Regreso asignado:', ivaValue);
                    }
                }
                
                // Marcar cambios sin guardar
                if ($('#transfer').hasClass('active')) {
                    marcarTransferCambios();
                }
                
            }else if(tipoTarifaCarga == 'Alojamiento'){
                console.log('Alojamiento TTTT');

                let finStr = $("#entradaAlojamiento").val(); // ejemplo: "29/09/2025"

                // Parsear correctamente a Date
                const [d, m, y] = finStr.split("/");
                var fechaFin = new Date(`${y}-${m}-${d}`);
                console.log("Fecha FIN parseada:", fechaFin);
                 

                var fechaFinal = sumarTiempo(fechaFin, cantidad, medida);
                console.log("Fecha salida calculada:", fechaFinal);
                
                if (fechaFinal) {
                    fechaFinal = ajustarASabadoAnterior(fechaFinal);
                    console.log('Fecha ajustada a sábado anterior:', fechaFinal);
                    $('#salidaAlojamiento').val(fechaFinal);
                } else {
                    console.warn('⚠️ No se pudo calcular la fecha de salida');
                }


            }
            
        
        })

    });



    // SABER SI UN GRUPO YA ESTA FACTURADO, YA QUE DEBEMOS BLOQUEAR //
    
    function grupoFacturado(){

        nombreGrupo = $('#idGrupo').val();

         $.ajax({
            url: "../../controller/llegadas.php?op=grupoFacturado",
            type: 'POST',
            data: { nombreGrupo: nombreGrupo },  // Aquí pasas la idMatricula
        
            success: function(response) {

                console.log("Respuesta cruda:", response);

                // Convertimos la respuesta a JSON
                let data;
                try {
                    data = JSON.parse(response);
                } catch (e) {
                    console.error("Error al parsear JSON:", e);
                    return;
                }
                let idLlegada = $("#idLlegadaReal").val(); // viene como string
                console.log("idLlegada (string):", idLlegada);

                let idLlegadaPie = data[0].idLlegada_Pie; // viene como número
                console.log("idLlegada_Pie (número):", idLlegadaPie);

               
                                
                // Verificamos si está vacío
                 // Convertimos ambos a número para comparar correctamente
               
                if (Array.isArray(data) && data.length === 0) {
                    console.log("El resultado está vacío");
                    // Aquí podés poner lo que quieras hacer si no hay resultados
                    $("#trans-tab").attr("disabled", false);
                    $("#trans-tab").removeClass("disabled");
                    $("#trans-tab").removeClass("d-none");

                    $("#otros-tab").attr("disabled", false);
                    $("#otros-tab").removeClass("disabled");
                    $("#otros-tab").removeClass("d-none");
                    
                    $("#suplidos-tab").attr("disabled", false);
                    $("#suplidos-tab").removeClass("disabled");
                    $("#suplidos-tab").removeClass("d-none");

                    $("#visados-tabNew").attr("disabled", false);
                    $("#visados-tabNew").removeClass("disabled");
                    $("#visados-tabNew").removeClass("d-none");
                      // Mostramos formularios
                    $('#zonaFormMatricula').show();
                    $('#zonaFormAlojamiento').show();
                    $('.botonFlotante5-1').removeClass("d-none");
                    
                    // Ocultamos mensajes
                    $('.mensajeGrupo').hide();
                } else {

                    if (Number(idLlegada) === Number(idLlegadaPie)) {
                        console.log('Iguales');
                    } else {
                         console.log("Resultado con datos:", data);
                        // Aquí procesás los datos
                        $("#trans-tab").attr("disabled", true);
                        $("#trans-tab").removeClass("true");
                        $("#trans-tab").addClass("d-none");

                        $("#suplidos-tab").attr("disabled", true);
                        $("#suplidos-tab").removeClass("true");
                        $("#suplidos-tab").addClass("d-none");

                        $("#otros-tab").attr("disabled", true);
                        $("#otros-tab").removeClass("true");
                        $("#otros-tab").addClass("d-none");

                        $("#visados-tabNew").attr("disabled", true);
                        $("#visados-tabNew").removeClass("true");
                        $("#visados-tabNew").addClass("d-none");

                        // Ocultamos formularios
                        $('#zonaFormMatricula').hide();
                        $('#zonaFormAlojamiento').hide();

                        // Mostramos mensajes en cada contenedor mensajeFacturas
                        $('.botonFlotante5-1').addClass("d-none");

                    
                        mensaje = 'Existe una factura a nivel de Grupo. Se bloquean todas las opciones individuales.';
                
                        $('.mensajeGrupo').html('<h4 style="color: #b09c68ff;">' + mensaje + '</h4><a target="_blank" href="../FacturaPro_Edu/index.php?idLlegada=' + idLlegadaPie + '">Ver Factura</a>').show();
                    }

                   
                

                }
            },
            error: function(err) {
                console.error("Error en la petición AJAX:", err);
            }
        });

    }

    function vaciarTransfer(tipo){
        toastr.warning('Por favor, presione Agregar Transfer para actualizar datos.')
        if(tipo == 'llegada'){
                
            // Código Tarifas (Llegada)
            $('#codigoTarifasLlegada').val('');

            // Texto Tarifas (Llegada)
            $('#textoTarifasLlegada').val('');

            // Importe Tarifas (Llegada)
            $('#importeTarifasLlegada').val('');

            // % IVA Tarifas (Llegada)
            $('#ivaTarifasLlegada').val('');

            // Día Llegada
            $('#diaLlegada').val('');

            // Hora Llegada
            $('#horaLlegada').val('');

            // Lugar Recogida (Llegada)
            $('#lugarRecogidaLlegada').val('');

            // Lugar Entrega (Llegada)
            $('#lugarEntregaLlegada').val('');

            // Quién Recoge (Llegada)
            $('#quienRecogeLlegada').val('');

        }else if(tipo == 'regreso'){
              // Código Tarifas (Regreso)
            $('#codigoTarifasRegreso').val('');

            // Texto Tarifas (Regreso)
            $('#textoTarifasRegreso').val('');

            // Importe Tarifas (Regreso)
            $('#importeTarifasRegreso').val('');

            // % IVA Tarifas (Regreso)
            $('#ivaTarifasRegreso').val('');

            // Día Regreso
            $('#diaRegreso').val('');

            // Hora Regreso
            $('#horaRegreso').val('');

            // Lugar de Recogida (Regreso)
            $('#lugarRecogidaRegreso').val('');

            // Lugar de Entrega (Regreso)
            $('#lugarEntregaRegreso').val('');

            // Quién recoge (Regreso)
            $('#quienRecogeRegreso').val('');

            // Observaciones
            $('#observaciones').val('');
        }
    }


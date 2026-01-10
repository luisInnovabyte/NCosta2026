
$(document).ready(function () {
  
  let idPrescriptor = $("#tokkenPrescripcion").val();
  $.post(
    "../../controller/llegadas.php?op=recogerLlegadaspost",
    { idPrescriptor: idPrescriptor },
    function (data) {
      data = JSON.parse(data);
      idLlegada = data.length;
      $.post(
        "../../controller/prescriptor.php?op=recogerInfo",
        { idPrescriptor: idPrescriptor },
        function (data) {
          //data[0][]
          data = JSON.parse(data);
          $("#llegadasDe").text(
            data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]
          );
        }
      );
    }
  );

  $("#buttonContainer").removeClass("d-none");
  // Detecta cuando cambia la pestaña
  $('button[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
    var target = $(e.target).attr("data-bs-target");

    $("#obsMatricula, #obsAloja, #obsPago").addClass("d-none");

    if (target === "#docencia") {
      $("#obsMatricula").removeClass("d-none");
    } else if (target === "#alojamiento") {
      $("#obsAloja").removeClass("d-none");
    } else if (target === "#otros") {
      $("#obsPago").removeClass("d-none");
    }
  });
 /*  $("input:not([disabled])").each(function () {
    $(this).attr("disabled", true);
    $(this).addClass("disabled");
  }); */
 /*  $("textarea:not([disabled])").each(function () {
    $(this).attr("disabled", true);
    $(this).addClass("disabled");
  }); */
});

// AÑADIR NUEVA LLEGADA

$("#nuevaLlegada").on("click", function () {

  $('.serviciosDiv').addClass('d-none');

  /* $("input:not(:disabled)").val(""); */
  $("#finalFacturado").val("0,00€");
  $("#finalPagado").text("0,00 €");
  $("#finalPendiente").text("0,00 €");
  $("#divNuevaLlegada tbody tr").remove();
  $("#buscarLlegada").addClass("d-none");
  $("#nuevaLlegada").parent().addClass("d-none");
  $("#listarLlegadas").parent().removeClass("d-none");
  $("#guardarTxt").removeClass("d-none");
  let idPrescriptor = $("#tokkenPrescripcion").val();
  var idLlegada = 0;
  $.post(
    "../../controller/llegadas.php?op=recogerLlegadaspost",
    { idPrescriptor: idPrescriptor },
    function (data) {
      data = JSON.parse(data);
      idLlegada = data.length;
      $.post(
        "../../controller/prescriptor.php?op=recogerInfo",
        { idPrescriptor: idPrescriptor },
        function (data) {
          //data[0][]
          data = JSON.parse(data);
          $("#idLlegada").val(
            "NUM" + (idLlegada + 1).toString().padStart(4, "0")
          );
          
            let fecha = data[0]["fecPrescripcion"];
            if (!fecha || isNaN(new Date(fecha).getTime())) {
                console.error("Fecha no válida:", fecha);
            } else {
              fecha = new Date(fecha);
              let fechaFormateada = fecha.toLocaleDateString('es-ES'); // => "20/10/1999"
              $("#diaInscripcion").val(fechaFormateada);
            }


          $("#nombreApellidos").val(
            data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]
          );
          $("#sexo").val(data[0]["sexoPrescripcion"]);
          $("#pais").val(data[0]["paisCasaPrescripcion"]);
          $("#idPrescriptorDatos").val(data[0]["idPrescripcion"]);
          $("#departamentoSelect")
            .val(data[0]["idDepartamentoEdu_prescriptores"])
            .trigger("change");
          cargarLobibox(); 
        }
      );
    }
  );

  $(".disabled").each(function () {
    $(this).attr("disabled", false);
    $(".cardLlegadas").removeClass("d-none");
    
    /* $("#visados-tab").addClass("disabled");
    $("#visados-tab").attr("disabled",true) */
  });
  
  $("#guardarBtn").removeClass("d-none");
  $("#editarBtn").addClass("d-none");
  $("#irProforma").parent().addClass("d-none");
  
});
$("#buscarLlegada").on("click", function () {
  // $("#buscar-llegadas-modal").modal("show");
});

$(document).ready(function () {

  let idPrescriptor = $("#tokkenPrescripcion").val();
  $.post(
    "../../controller/llegadas.php?op=recogerLlegadas&idPrescriptor="+idPrescriptor,
    {},
    function (data) {
      data = JSON.parse(data);
      if (data.length > 0) {
        $("#buscarLlegada").removeClass("d-none");
      } else {
        $("#nuevaLlegada").trigger("click");
      }
    }
  );
});

$("#agregarMatricula").on("click", function () {
  $("#inicioDocencia").addClass('blink');
  $("#finalDocencia").removeClass('blink');
  //===================================================//
  //===================================================//
  //===================================================//
  // Lista de campos a validar
  const campos = [
      { id: '#descDocencia', nombre: 'Tarifa Docencia' },

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
  const inicio = $('#inicioDocencia').val();
  const final = $('#finalDocencia').val();

  if (final < inicio) {
      toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
      return; // Salir de la función si las fechas no son lógicas
  }
  //===================================================//
  //===================================================//
  //===================================================//



  var tabla = $("#matriculacionTable").DataTable({
    language: {
        emptyTable: "",
        zeroRecords: "", // Este mensaje también aparece cuando no hay datos visibles tras una búsqueda
        infoEmpty: "",   // Elimina mensajes adicionales cuando no hay datos
        info: ""
    }
});

  // Las fechas ya están en formato DD/MM/YYYY, no necesitan conversión
  var cantidadFilasTotales = tabla.rows().count();
  var siguienteFila = cantidadFilasTotales + 1;
  var nuevaFila = [
    $("#codDocencia").val(), // Tarifa
    $("#textEditar").text().replace("- Tipo:",""),
    formatearEur(convertirEurANumero($("#importeDocencia").val())) + "€",
    $("#ivaDocencia").val(),
    $("#descDocencia").val(),
    $("#inicioDocencia").val(), // Fecha Inicio (ya en formato DD/MM/YYYY)
    $("#finalDocencia").val(), // Fecha Fin (ya en formato DD/MM/YYYY)
    "<button class='btn btn-info btnEditView' onClick='editarMatricula("+siguienteFila+")'><i class='fa-solid fa-edit'></i></button><button class='btn btn-danger mg-l-5 eliminarMatricula'><i class='fa-solid fa-trash' ></i></button>", // Edad
  ];

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  let importeDocencia = convertirEurANumero($("#importeDocencia").val());

  importeTotal += importeDocencia;


  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  
  recalcularPrecios();

  $("#codDocencia").val("");
  $("#importeDocencia").val("");
  $("#ivaDocencia").val("");
  $("#descDocencia").val("");
  //$("#inicioDocencia").val("");
  //$("#finalDocencia").val("");
  $("#matriculacionTable").addClass("width-100");
  // Agregar la nueva fila a la tabla
  tabla.row.add(nuevaFila).draw();
});
$("#agregarAlojamiento").on("click", function () {
  // Las fechas ya están en formato DD/MM/YYYY, no necesitan conversión
  var tabla = $("#alojamientoTable").DataTable();
  var cantidadFilasTotales = tabla.rows().count();
  var siguienteFila = cantidadFilasTotales + 1;
  var nuevaFila = [
    $("#codAlojamiento").val(), // Tarifa
    $("#textAlojamiento").text().replace("- Tipo:",""),
    formatearEur(convertirEurANumero($("#importeAlojamiento").val())) + "€",
    $("#ivaAlojamiento").val(),
    $("#descuentoAlojamiento").val(),
    $("#entradaAlojamiento").val(), // Fecha Entrada (ya en formato DD/MM/YYYY)
    $("#salidaAlojamiento").val(), // Fecha Salida (ya en formato DD/MM/YYYY)
    $("#horaAlojamiento").val(),
    "<button class='btn btn-info'  onClick='editarAlojamiento("+siguienteFila+")'><i class='fa-solid fa-edit'></i></button><button class='btn btn-danger mg-l-5 eliminarAlojamiento'><i class='fa-solid fa-trash' ></i></button>", // Edad
  ];

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  let importeDocencia = convertirEurANumero($("#importeAlojamiento").val());
  importeTotal += importeDocencia;
  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  recalcularPrecios();

  $("#codAlojamiento").val("");
  $("#importeAlojamiento").val("");
  $("#ivaAlojamiento").val("");
  $("#descuentoAlojamiento").val("");
  //$("#entradaAlojamiento").val("");
  //$("#salidaAlojamiento").val("");
  $("#horaAlojamiento").val("11:00");
  $("#alojamientoTable").addClass("width-100");
  // Agregar la nueva fila a la tabla
  tabla.row.add(nuevaFila).draw();
});
$("#agregarOtro").on("click", function () {
  var tabla = $("#otrosTable").DataTable();
  var fechaPagoOtros = $("#fechaPagoOtros").val().split("-");

  var nuevaFila = [
    formatearEur(convertirEurANumero($("#importeAnticipadoOtros").val())) + "€", // Tarifa
    fechaPagoOtros[2] + "/" + fechaPagoOtros[1] + "/" + fechaPagoOtros[0], // Fecha Pago
    $("#medioPagoOtros").val(),
    $("#comentarioPagoOtros").val(),
    "<button class='btn btn-danger mg-l-5 eliminarOtro'><i class='fa-solid fa-trash' ></i></button>", // Edad
  ];

  let importeTotal = convertirEurANumero($("#finalPagado").text());
  let importeOtro = convertirEurANumero($("#importeAnticipadoOtros").val());
  importeTotal += importeOtro;
  $("#finalPagado").text(importeTotal.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
  recalcularPrecios();

  $("#importeAnticipadoOtros").val("");
  $("#fechaPagoOtros").val("");
  $("#medioPagoOtros").val("");
  $("#comentarioPagoOtros").val("");
  // Agregar la nueva fila a la tabla
  $("#otrosTable").addClass("width-100");
  tabla.row.add(nuevaFila).draw();
  /* $("#visados-tab").attr("disabled", false);
  $("#visados-tab").removeClass("disabled"); */
});
// Evento delegado para eliminar la fila cuando se hace clic en el botón .eliminarMatricula
$("#matriculacionTable").on("click", ".eliminarMatricula", function () {

  //=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================




//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================
//=======================================




  var tabla = $("#matriculacionTable").DataTable();

  // Encuentra la fila padre (tr)
  var fila = $(this).parents("tr");

  // Obtén los datos de la fila
  var datosFila = tabla.row(fila).data();

  // Accede a la segunda columna (índice 1, ya que los índices comienzan en 0)
  var valorSegundaColumna = datosFila[2];

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  let importeDocencia = convertirEurANumero(valorSegundaColumna);

  importeTotal -= importeDocencia;
  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  recalcularPrecios();

  // Elimina la fila
  tabla.row(fila).remove().draw();

  tabla.find("tbody").empty(); // Vacía el tbody manualmente
  tabla.clear().draw(); // Limpia el DataTable completamente y evita que genere filas automáticas
});

$("#alojamientoTable").on("click", ".eliminarAlojamiento", function () {
  var tabla = $("#alojamientoTable").DataTable();

  // Encuentra la fila padre (tr)
  var fila = $(this).parents("tr");

  // Obtén los datos de la fila
  var datosFila = tabla.row(fila).data();

  // Accede a la segunda columna (índice 1, ya que los índices comienzan en 0)
  var valorSegundaColumna = datosFila[2];

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  let importeAlojamiento = convertirEurANumero(valorSegundaColumna);

  importeTotal -= importeAlojamiento;
  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  recalcularPrecios();

  // Encuentra la fila padre (tr) y elimínala
  tabla.row($(this).parents("tr")).remove().draw();
});
$("#otrosTable").on("click", ".eliminarOtro", function () {
  var tabla = $("#otrosTable").DataTable();
  // Encuentra la fila padre (tr) y elimínala

  // Encuentra la fila padre (tr)
  var fila = $(this).parents("tr");

  // Obtén los datos de la fila
  var datosFila = tabla.row(fila).data();

  // Accede a la segunda columna (índice 1, ya que los índices comienzan en 0)
  var valorSegundaColumna = datosFila[0];

  let importeTotal = convertirEurANumero($("#finalPagado").text());
  let importeDocencia = convertirEurANumero(valorSegundaColumna);

  importeTotal -= importeDocencia;
  $("#finalPagado").text(importeTotal.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
  recalcularPrecios();

  tabla.row($(this).parents("tr")).remove().draw();
  var totalFilas = tabla.rows().count();
  if (totalFilas == 0) {
    /* $("#visados-tab").attr("disabled", true);
    $("#visados-tab").addClass("disabled"); */
  }
});

  //* SUGERENCIAS *//
 $(document).on("input focus", "#codDocencia", function () {
    var objetoInput = $("#codDocencia");
    var query = objetoInput.val();
    var dataType = "Docencia";

    // Habilitar/deshabilitar botón según input
    if (query !== '') {
        $('#btnSearchTarifaDocencia').prop('disabled', true).addClass('btn-danger').removeClass('bd-secondary btn-outline-secondary');
    } else {
        $('#btnSearchTarifaDocencia').prop('disabled', false).removeClass('btn-danger').addClass('bd-secondary btn-outline-secondary');
    }

    if (query.length === 0) {
        objetoInput.next().hide();
        return;
    }

    $.ajax({
        url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaInput",
        method: "POST",
        data: { search: query, dataType: dataType },
        success: function (data) {
            data = JSON.parse(data);

            var suggestionsHTML = "";
            var suggestionsArray = [];

            data.forEach(function(item) {
                suggestionsHTML += '<p class="suggestion-item">' + item.cod_tarifa + " - " + item.nombre_tarifa.trim() + " (" + item.unidades_tarifa + " " + item.unidad_tarifa + ")</p>";
                suggestionsArray.push(item.cod_tarifa);
            });

            if (suggestionsHTML !== "") {
                objetoInput.next().html(suggestionsHTML).show();
            } else {
                objetoInput.next().hide();
            }

            // Click en sugerencia
            $(document).off("click", ".suggestion-item");
            $(document).on("click", ".suggestion-item", function () {
                var selectedText = $(this).text();
                var selectedValue = selectedText.split(" - ")[0];

                objetoInput.val(selectedValue);
                if ($("#textEditar").text() == "") {
                    $("#textEditar").text(" - Tipo:" + selectedText.split(" - ")[1].split(",")[0]);
                }
                $("#tiempoDocencia").text(" " + selectedText.split(" - ")[1].split(",")[1]);

                $.post(
                    "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
                    { codigo: selectedValue },
                    function(data) {
                        data = JSON.parse(data);

                        $("#codDocencia").val(data[0]["cod_tarifa"]);
                        $("#importeDocencia").val(formatearEur(data[0]["precio_tarifa"]) + "€");
                        $("#ivaDocencia").val(data[0]["iva_tarifa"] + " %");
                        $("#descDocencia").val(data[0]["descuento_tarifa"] + " %");

                        var cantidad = data[0]["unidades_tarifa"];
                        var medida = data[0]["unidad_tarifa"];

                        console.log("📅 Calculando fecha final de Docencia");
                        console.log("Cantidad:", cantidad, "Medida:", medida);

                        // ---- Lógica de fechas igual al modal ----
                        let inicioStr = $("#inicioDocencia").val(); // DD/MM/YYYY
                        console.log("Fecha inicio (string):", inicioStr);
                        
                        if (inicioStr && inicioStr.includes("/")) {
                            const [d, m, y] = inicioStr.split("/");
                            var fechaInicio = new Date(`${y}-${m}-${d}`);
                            console.log("Fecha inicio (Date):", fechaInicio);

                            var fechaFinal = sumarTiempo(fechaInicio, cantidad, medida);
                            console.log("Fecha final calculada:", fechaFinal);
                            
                            fechaFinal = ajustarAViernesAnterior(fechaFinal);
                            console.log("Fecha final ajustada a viernes:", fechaFinal);

                            $('#finalDocencia').val(fechaFinal);
                        } else {
                            console.warn("⚠️ No hay fecha de inicio válida");
                        }
                        // ----------------------------------------

                        $("#agregarMatricula").attr("disabled", false);
                        $("#guardarBtn").attr("disabled", false);
                        objetoInput.next().hide();
                    }
                );
            });
        }
    });
});



$(document).on("input focus", "#codAlojamiento", function () {
    var objetoInput = $("#codAlojamiento");
    var query = objetoInput.val();
    var dataType = "Alojamiento";

    if (query.length === 0) {
        objetoInput.next().hide();
        return;
    }
     // Habilitar/deshabilitar botón según input
    if (query !== '') {
        $('#btnSearchTarifaAlojamiento').prop('disabled', true).addClass('btn-danger').removeClass('bd-secondary btn-outline-secondary');
    } else {
        $('#btnSearchTarifaAlojamiento').prop('disabled', false).removeClass('btn-danger').addClass('bd-secondary btn-outline-secondary');
    }


    $.ajax({
        url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaInput",
        method: "POST",
        data: { search: query, dataType: dataType },
        success: function (data) {
            data = JSON.parse(data);

            var suggestionsHTML = "";
            var suggestionsArray = [];

            data.forEach(function(item) {
                suggestionsHTML += '<p class="suggestion-item">' + item.cod_tarifa + " - " + item.nombre_tarifa.trim() + " (" + item.unidades_tarifa + " " + item.unidad_tarifa + ")</p>";
                suggestionsArray.push(item.cod_tarifa);
            });

            if (suggestionsHTML !== "") {
                objetoInput.next().html(suggestionsHTML).show();
            } else {
                objetoInput.next().hide();
            }

            // Click en sugerencia
            $(document).off("click", ".suggestion-item");
            $(document).on("click", ".suggestion-item", function () {
                var selectedText = $(this).text();
                var selectedValue = selectedText.split(" - ")[0];

                objetoInput.val(selectedValue);
                if ($("#textAlojamiento").text() == "") {
                    $("#textAlojamiento").text(" - Tipo:" + selectedText.split(" - ")[1].split(",")[0].split("()")[0]);
                }
                $("#tiempoAloja").text(" " + selectedText.split(" - ")[1].split(",")[1]);

                $.post(
                    "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
                    { codigo: selectedValue },
                    function(data) {
                        data = JSON.parse(data);

                        $("#codAlojamiento").val(data[0]["cod_tarifa"]);
                        $("#importeAlojamiento").val(formatearEur(data[0]["precio_tarifa"]) + "€");
                        $("#ivaAlojamiento").val(data[0]["iva_tarifa"] + " %");
                        $("#descuentoAlojamiento").val(data[0]["descuento_tarifa"] + " %");

                        var cantidad = data[0]["unidades_tarifa"];
                        var medida = data[0]["unidad_tarifa"];

                        // ---- Lógica de fechas igual al modal ----
                        let inicioStr = $("#entradaAlojamiento").val(); // DD/MM/YYYY
                        const [d, m, y] = inicioStr.split("/");
                        var fechaInicio = new Date(`${y}-${m}-${d}`);

                        var fechaFinal = sumarTiempo(fechaInicio, cantidad, medida);
                        fechaFinal = ajustarASabadoAnterior(fechaFinal);

                        $('#salidaAlojamiento').val(fechaFinal);
                        // ----------------------------------------

                        $("#agregarAlojamiento").attr("disabled", false);
                        $("#guardarBtn").attr("disabled", false);
                        objetoInput.next().hide();
                    }
                );
            });
        }
    });
});



$(document).on("input focus", "#codigoTarifasLlegada", function () {
  var query = $("#codigoTarifasLlegada").val(); // Captura el valor del input
  var dataType = "Otro";
  var objetoInput = $("#codigoTarifasLlegada");
  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia
    $.ajax({
      url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaInput", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query, dataType: dataType }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido

        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.cod_tarifa +
            " - " +
            item.nombre_tarifa.trim() +
            " (" +
            item.unidades_tarifa +
            " " +
            item.unidad_tarifa +
            ")</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.cod_tarifa); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }
        
        var oninputVal = objetoInput.val(); // Valor actual del input
        if (suggestionsArray.indexOf(oninputVal) === -1) {
          // Si el valor no coincide con ninguna sugerencia
          $(".cardLlegadas")
            .find(".nav-link")
            .each(function () {
              // Si el ID no es "visados-tab", deshabilitar el botón
            /*   if ($(this).attr("id") !== "visados-tab" || !$(this).hasClass("disabled")) {
                $(this).attr("disabled", true);
              } */
            });
          $("#guardarBtn").attr("disabled", true);
        }

        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText.split(" - ")[0]; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el input
          $.post(
            "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
            { codigo: selectedValue },
            function (data) {
              data = JSON.parse(data);
              $("#codigoTarifasLlegada").val(data[0]["cod_tarifa"]);
              $("#textoTarifasLlegada").val(data[0]["nombre_tarifa"]);
              $("#ivaTarifasLlegada").val(data[0]["iva_tarifa"]);
              if (data[0]["precio_tarifa"] != "") {
                $("#importeTarifasLlegada").val(
                  formatearEur(data[0]["precio_tarifa"])
                );
              } else {
                $("#importeTarifasLlegada").val("0,00€");
              }

              // Asignar el valor numérico sin formato al atributo data-value para facilitar cálculos
              if (
                $("#importeTarifasLlegada").attr("data-value") === undefined
              ) {
                // Si no existe, establecer el valor "0.00€"
                $("#importeTarifasLlegada").attr("data-value", "0.00€");
              }

              let importeTotal = convertirEurANumero(
                $("#finalFacturado").val()
              );
              let importeOtro = convertirEurANumero(
                $("#importeTarifasLlegada").val()
              );

              let importeStr = convertirEurANumero(
                $("#importeTarifasLlegada").attr("data-value")
              );

              importeTotal -= importeStr;
              importeTotal += importeOtro;
              $("#importeTarifasLlegada").attr(
                "data-value",
                formatearEur(importeOtro) + "€"
              );
              $("#finalFacturado").val(formatearEur(importeTotal) + "€");
              recalcularPrecios();
            }
          );
          $(".cardLlegadas")
            .find(".nav-link")
            .each(function () {
              // Si el ID no es "visados-tab", deshabilitar el botón
             /*  if ($(this).attr("id") !== "visados-tab" || !$(this).hasClass("disabled")) {
                $(this).attr("disabled", false);
              } */
            });
          $("#guardarBtn").attr("disabled", false);
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });
        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        $(document).on("click", function (event) {
          if (
            !$(event.target).closest("#codigoTarifasLlegada").length &&
            !$(event.target).closest(".suggestion-item").length &&
            objetoInput.next().is(":visible")
          ) {
            // Verificar si el clic fue fuera del input o de las sugerencias
            var inputVal = objetoInput.val(); // Obtener el valor actual del input

            // Validamos si lo escrito coincide con alguna sugerencia
            if (suggestionsArray.indexOf(inputVal) !== -1) {
              // Si coincide, cargamos esa sugerencia en el input
              objetoInput.val(inputVal); // Cargar el valor en el input (es el mismo que ya estaba)

              $.post(
                "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
                { codigo: inputVal },
                function (data) {
                  data = JSON.parse(data);
                  $("#codigoTarifasLlegada").val(data[0]["cod_tarifa"]);
                  $("#textoTarifasLlegada").val(data[0]["nombre_tarifa"]);
                  $("#ivaTarifasLlegada").val(data[0]["iva_tarifa"]);
                  if (data[0]["precio_tarifa"] != "") {
                    $("#importeTarifasLlegada").val(
                      formatearEur(data[0]["precio_tarifa"])
                    );
                  } else {
                    $("#importeTarifasLlegada").val("0,00€");
                  }

                  // Asignar el valor numérico sin formato al atributo data-value para facilitar cálculos
                  if (
                    $("#importeTarifasLlegada").attr("data-value") === undefined
                  ) {
                    // Si no existe, establecer el valor "0.00€"
                    $("#importeTarifasLlegada").attr("data-value", "0.00€");
                  }

                  let importeTotal = convertirEurANumero(
                    $("#finalFacturado").val()
                  );
                  let importeOtro = convertirEurANumero(
                    $("#importeTarifasLlegada").val()
                  );

                  let importeStr = convertirEurANumero(
                    $("#importeTarifasLlegada").attr("data-value")
                  );

                  importeTotal -= importeStr;
                  importeTotal += importeOtro;
                  $("#importeTarifasLlegada").attr(
                    "data-value",
                    formatearEur(importeOtro) + "€"
                  );
                  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
                  recalcularPrecios();
                }
              );
              $(".cardLlegadas")
                .find(".nav-link")
                .each(function () {
                  // Si el ID no es "visados-tab", deshabilitar el botón
                  /* if ($(this).attr("id") !== "visados-tab" || !$(this).hasClass("disabled")) {
                    $(this).attr("disabled", false);
                  } */
                });
              $("#guardarBtn").attr("disabled", false);
              objetoInput.next().hide(); // Ocultar el menú de sugerencias
            }
          }
        });
        objetoInput.off("blur").on("blur", function () {
          setTimeout(function () {
            var inputVal = objetoInput.val(); // Valor actual del input
            if (suggestionsArray.indexOf(inputVal) === -1 && inputVal != "") {
              // Si el valor no coincide con ninguna sugerencia
              toastr.error("Seleccione o escriba una tarifa correcta");
              objetoInput.focus(); // Devuelve el foco al input
              $(".cardLlegadas")
                .find(".nav-link")
                .each(function () {
                  $(this).attr("disabled", true);
                });
            } else {
              isSuggestionClick = false; // Reiniciar la variable para futuros clics
              if (inputVal == "") {
                $("#textoTarifasLlegada").val("");
                $("#importeTarifasLlegada").val("");
                $("#ivaTarifasLlegada").val("");
              }
            }
          }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
        });
        
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});
$(document).on("input focus", "#codigoTarifasRegreso", function () {
  var query = $("#codigoTarifasRegreso").val(); // Captura el valor del input
  var dataType = "Otro";
  var objetoInput = $("#codigoTarifasRegreso");
  if (query.length > 0) {
    $.ajax({
      url: "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaInput", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query, dataType: dataType }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido

        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.cod_tarifa +
            " - " +
            item.nombre_tarifa.trim() +
            " (" +
            item.unidades_tarifa +
            " " +
            item.unidad_tarifa +
            ")</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.cod_tarifa); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }

        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText.split(" - ")[0]; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el input
          $.post(
            "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
            { codigo: selectedValue },
            function (data) {
              data = JSON.parse(data);
              $("#codigoTarifasRegreso").val(data[0]["cod_tarifa"]);
              $("#textoTarifasRegreso").val(data[0]["nombre_tarifa"]);

              if (data[0]["precio_tarifa"] != "") {
                $("#importeTarifasRegreso").val(
                  formatearEur(data[0]["precio_tarifa"])
                );
              } else {
                $("#importeTarifasRegreso").val("0,00€");
              }

              // Asignar el valor numérico sin formato al atributo data-value para facilitar cálculos
              if (
                $("#importeTarifasRegreso").attr("data-value") === undefined
              ) {
                // Si no existe, establecer el valor "0.00€"
                $("#importeTarifasRegreso").attr("data-value", "0.00€");
              }

              let importeTotal = convertirEurANumero(
                $("#finalFacturado").val()
              );
              let importeOtro = convertirEurANumero(
                $("#importeTarifasRegreso").val()
              );

              let importeStr = convertirEurANumero(
                $("#importeTarifasRegreso").attr("data-value")
              );

              importeTotal -= importeStr;
              importeTotal += importeOtro;
              $("#importeTarifasRegreso").attr(
                "data-value",
                formatearEur(importeOtro) + "€"
              );
              $("#finalFacturado").val(formatearEur(importeTotal) + "€");
              recalcularPrecios();
              $("#ivaTarifasRegreso").val(data[0]["iva_tarifa"]);
              $("#importeTarifasRegreso").val(data[0]["precio_tarifa"]);
            }
          );
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        $(document).on("click", function (event) {
          if (
            !$(event.target).closest("#codigoTarifasRegreso").length &&
            !$(event.target).closest(".suggestion-item").length &&
            objetoInput.next().is(":visible")
          ) {
            // Verificar si el clic fue fuera del input o de las sugerencias
            var inputVal = objetoInput.val(); // Obtener el valor actual del input

            // Validamos si lo escrito coincide con alguna sugerencia
            if (suggestionsArray.indexOf(inputVal) !== -1) {
              // Si coincide, cargamos esa sugerencia en el input
              objetoInput.val(inputVal); // Cargar el valor en el input (es el mismo que ya estaba)
              $.post(
                "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
                { codigo: inputVal },
                function (data) {
                  data = JSON.parse(data);
                  $("#codigoTarifasRegreso").val(data[0]["cod_tarifa"]);
                  $("#textoTarifasRegreso").val(data[0]["nombre_tarifa"]);

                  if (data[0]["precio_tarifa"] != "") {
                    $("#importeTarifasRegreso").val(
                      formatearEur(data[0]["precio_tarifa"])
                    );
                  } else {
                    $("#importeTarifasRegreso").val("0,00€");
                  }

                  // Asignar el valor numérico sin formato al atributo data-value para facilitar cálculos
                  if (
                    $("#importeTarifasRegreso").attr("data-value") === undefined
                  ) {
                    // Si no existe, establecer el valor "0.00€"
                    $("#importeTarifasRegreso").attr("data-value", "0.00€");
                  }

                  let importeTotal = convertirEurANumero(
                    $("#finalFacturado").val()
                  );
                  let importeOtro = convertirEurANumero(
                    $("#importeTarifasRegreso").val()
                  );

                  let importeStr = convertirEurANumero(
                    $("#importeTarifasRegreso").attr("data-value")
                  );

                  importeTotal -= importeStr;
                  importeTotal += importeOtro;
                  $("#importeTarifasRegreso").attr(
                    "data-value",
                    formatearEur(importeOtro) + "€"
                  );
                  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
                  recalcularPrecios();
                  $("#ivaTarifasRegreso").val(data[0]["iva_tarifa"]);
                  $("#importeTarifasRegreso").val(data[0]["precio_tarifa"]);
                }
              );
              
              $(".cardLlegadas")
                .find(".nav-link")
                .each(function () {
                  // Si el ID no es "visados-tab", deshabilitar el botón
                  /* if ($(this).attr("id") !== "visados-tab" || !$(this).hasClass("disabled")) {
                    $(this).attr("disabled", false);
                  } */
                });
              $("#agregarAlojamiento").attr("disabled", false);
              $("#guardarBtn").attr("disabled", false);
              objetoInput.next().hide(); // Ocultar el menú de sugerencias
            }
          }
          objetoInput.off("blur").on("blur", function () {
            setTimeout(function () {
              var inputVal = objetoInput.val(); // Valor actual del input
              if (suggestionsArray.indexOf(inputVal) === -1 && inputVal != "") {
                // Si el valor no coincide con ninguna sugerencia
                toastr.error("Seleccione o escriba una tarifa correcta");
                objetoInput.focus(); // Devuelve el foco al input
                $(".cardLlegadas")
                  .find(".nav-link")
                  .each(function () {
                    $(this).attr("disabled", true);
                  });
              } else {
                isSuggestionClick = false; // Reiniciar la variable para futuros clics
                if (inputVal == "") {
                  $("#textoTarifasRegreso").val("");
                  $("#importeTarifasRegreso").val("");
                  $("#ivaTarifasRegreso").val("");
                }
              }
            }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
          });
        });
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});
$(document).on("input focus", "#idGrupo", function () {
  var query = $("#idGrupo").val(); // Captura el valor del input
  var objetoInput = $("#idGrupo");

  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia

    $.ajax({
      url: "../../controller/grupos_Edu.php?op=recogerGruposBuscador", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido
        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.grupo_llegadas +
            "</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.grupo_llegadas); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }
        var oninputVal = objetoInput.val(); // Valor actual del input
        
        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el inputç
          isSuggestionClick = true;
          
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });
        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });
        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        
        
       objetoInput.off("blur").on("blur", function () {
        setTimeout(function () {
          
          if (suggestionsArray.length > 0 && isSuggestionClick == false) {
            // Si hay sugerencias, cargamos la primera en el input
            // objetoInput.val(suggestionsArray[0]); // Cargar la primera sugerencia
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          }
        }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
      });
        
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});
$(document).on("input focus", "#idGrupoAmigo", function () {
  var query = $("#idGrupoAmigo").val(); // Captura el valor del input
  var objetoInput = $("#idGrupoAmigo");

  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia

    $.ajax({
      url: "../../controller/grupos_Edu.php?op=recogerGruposAmigosBuscador", // Archivo PHP donde harás la consulta
      method: "POST",
      data: { search: query }, // Envía el texto al servidor
      success: function (data) {
        data = JSON.parse(data); // Parseamos el JSON recibido
        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item">' +
            item.grupoAmigos +
            "</p>"; // Generamos el HTML de cada sugerencia
          suggestionsArray.push(item.grupoAmigos); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }
        var oninputVal = objetoInput.val(); // Valor actual del input
        
        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros
        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedValue = selectedText; // Extraer solo el código antes del " - "
          objetoInput.val(selectedValue); // Cargar solo el código en el inputç
          isSuggestionClick = true;
          
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });
        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });
        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        
        
       objetoInput.off("blur").on("blur", function () {
        setTimeout(function () {
          
          if (suggestionsArray.length > 0 && isSuggestionClick == false) {
            // Si hay sugerencias, cargamos la primera en el input
            // objetoInput.val(suggestionsArray[0]); // Cargar la primera sugerencia
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          }
        }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
      });
        
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});
$(document).on("input focus", "#nombreAgente", function () {
  var query = $("#nombreAgente").val(); // Captura el valor del input
  var objetoInput = $("#nombreAgente");

  if (query.length > 0) {
    var isSuggestionClick = false; // Variable para controlar si se hizo clic en una sugerencia

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=obtenerAgentesBuscador", // Archivo PHP donde harás la consulta 
      method: "POST",
      data: { search: query }, // Envía el texto al servidor
      success: function (data) {

        data = JSON.parse(data); // Parseamos el JSON recibido
        var suggestionsHTML = ""; // Contenedor para las sugerencias
        var suggestionsArray = []; // Arreglo para guardar las sugerencias

        // Recorremos el arreglo de datos
        data.forEach(function (item) {
          suggestionsHTML +=
            '<p class="suggestion-item" data-id="' + item.idAgente + '">' +
            item.idAgente + " " +
            item.nombreAgente.trim() +
            " (" +
            item.domicilioFiscal.trim() +
            " " +
            item.correoAgente +
            ")</p>"; // Generamos el HTML de cada sugerencia

          suggestionsArray.push(item.nombreAgente + " - " + item.domicilioFiscal.trim() + " - " + item.correoAgente + ""); // Guardamos las sugerencias en el array
        });

        // Si hay sugerencias, las mostramos
        if (suggestionsHTML !== "") {
          objetoInput.next().html(suggestionsHTML).show(); // Mostramos el menú de sugerencias
        } else {
          objetoInput.next().hide(); // Si no hay sugerencias, escondemos el contenedor
        }

        var oninputVal = objetoInput.val(); // Valor actual del input

        // Usar delegación de eventos para los elementos creados dinámicamente
        $(document).off("click", ".suggestion-item"); // Limpiar eventos previos para evitar múltiples registros

        $(document).on("click", ".suggestion-item", function () {
          var selectedText = $(this).text(); // Obtener el texto completo de la sugerencia
          var selectedId = $(this).data("id"); // Obtener el id del agente desde el atributo data-id

          $("#idAgente").val(selectedId); // Asignar el idAgente al input oculto
          objetoInput.val(selectedText); // Mostrar el nombre completo del agente en el input visible

          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        $(document).on("mousedown", ".suggestion-item", function () {
          isSuggestionClick = true; // Indica que se hizo clic en una sugerencia
        });

        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros

        objetoInput.off("blur").on("blur", function () {
          setTimeout(function () {

            if (suggestionsArray.length > 0) {
              if (isSuggestionClick == false) {
                // Si hay sugerencias, cargamos la primera en el input
                objetoInput.val(suggestionsArray[0]); // Cargar la primera sugerencia
                
                // NUEVO: Asignar también el id del primer elemento visible al input oculto
                var firstId = objetoInput.next().find(".suggestion-item").first().data("id");
                $("#idAgente").val(firstId);

                objetoInput.next().hide(); // Ocultar el menú de sugerencias
              }
            } else {
              toastr.error("Seleccione o escriba un agente correcto");
              objetoInput.focus(); // Devuelve el foco al input
              $("#guardarBtn").attr("disabled", true);
            }
          }, 200); // Timeout para dar tiempo a procesar el clic en la sugerencia antes del blur
        });

      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
    $("#idAgente").val('');    // Limpiar input oculto del idAgente
  }
});



$("#importeTarifasLlegada").on("input", function () {
  // Asignar el valor numérico sin formato al atributo data-value para facilitar cálculos
  if ($("#importeTarifasLlegada").attr("data-value") === undefined) {
    // Si no existe, establecer el valor "0.00€"
    $("#importeTarifasLlegada").attr("data-value", "0.00€");
  }

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  let importeOtro = convertirEurANumero($("#importeTarifasLlegada").val());

  if (isNaN(importeOtro)) {
    importeOtro = 0;
  }
  let importeStr = convertirEurANumero(
    $("#importeTarifasLlegada").attr("data-value")
  );

  importeTotal -= importeStr;
  importeTotal += importeOtro;
  $("#importeTarifasLlegada").attr(
    "data-value",
    formatearEur(importeOtro) + "€"
  );
  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  recalcularPrecios();
});
$("#importeTarifasRegreso").on("input", function () {
  if ($("#importeTarifasRegreso").attr("data-value") === undefined) {
    // Si no existe, establecer el valor "0.00€"
    $("#importeTarifasRegreso").attr("data-value", "0.00€");
  }

  let importeTotal = convertirEurANumero($("#finalFacturado").val());
  var importeOtro = convertirEurANumero($("#importeTarifasRegreso").val());
  if (isNaN(importeOtro)) {
    importeOtro = 0;
  }
  let importeStr = convertirEurANumero(
    $("#importeTarifasRegreso").attr("data-value")
  );

  importeTotal -= importeStr;
  importeTotal += importeOtro;
  $("#importeTarifasRegreso").attr(
    "data-value",
    formatearEur(importeOtro) + "€"
  );
  $("#finalFacturado").val(formatearEur(importeTotal) + "€");
  recalcularPrecios();
});
$("#departamentoSelect")
  .select2({
    theme: "bootstrap-5",
    placeholder: $(this).data("placeholder"),
    closeOnSelect: true,
    language: {
      inputTooShort: function (args) {
        var remainingChars = args.minimum - args.input.length;
        return "Por favor, ingresa " + remainingChars + " o más caracteres";
      },
      maximumSelected: function (e) {
        return "Solo puedes seleccionar " + e.maximum + " elemento";
      },
      noResults: function () {
        return "No se encontraron resultados";
      },
      searching: function () {
        return "Buscando...";
      },
    },
  })
  .val(null)
  .trigger("change");
$.post(
  "../../controller/mntPreinscripciones.php?op=recogerDepartamentos",
  {},
  function (data) {
    data = JSON.parse(data);
    $("#departamentoSelect").append(
      "<option value=''>SELECCIONA DEPARTAMENTO</option>"
    );

    $.each(data, function (indice, valor) {
      $("#departamentoSelect").append(
        "<option value='" +
          data[indice]["idDepartamentoEdu"] +
          "'>" +
          data[indice]["nombreDepartamento"] +
          "</option>"
      );
    });
  }
);

$("#medioPagoOtros")
  .select2({
    theme: "bootstrap-5",
    placeholder: $(this).data("placeholder"),
    closeOnSelect: true,
    language: {
      inputTooShort: function (args) {
        var remainingChars = args.minimum - args.input.length;
        return "Por favor, ingresa " + remainingChars + " o más caracteres";
      },
      maximumSelected: function (e) {
        return "Solo puedes seleccionar " + e.maximum + " elemento";
      },
      noResults: function () {
        return "No se encontraron resultados";
      },
      searching: function () {
        return "Buscando...";
      },
    },
  })
  .val(null)
  .trigger("change");
$.post(
  "../../controller/pagos_Edu.php?op=recogerMediosPago",
  {},
  function (data) {
    data = JSON.parse(data);
    $("#medioPagoOtros").append(
      "<option value=''>SELECCIONA MEDIO DE PAGO</option>"
    );

    $.each(data, function (indice, valor) {
      $("#medioPagoOtros").append(
        "<option value='" +
          data[indice]["idMedioPago"] +
          "'>" +
          data[indice]["nomMedioPago"] +
          "</option>"
      );
    });
  }
);
$("#fechaLlegada").on("input", function () {
  $('#fechaLlegada').removeClass('is-invalid');
  
  let valor = $(this).val().trim(); // ejemplo: "jueves, 16/10/2025 09:00"

  // Quitar el día de la semana si lo hay
  if (valor.includes(",")) {
    valor = valor.split(",")[1].trim(); // "16/10/2025 09:00"
  }

  // Separar día y hora
  const [diaStr, horaStr = "00:00"] = valor.split(" ");
  $("#diaLlegada").val(diaStr);
  $("#horaLlegada").val(horaStr);

  // Parsear la fecha (formato europeo d/m/Y)
  const [d, m, y] = diaStr.split("/");
  const diaActual = new Date(`${y}-${m}-${d}`); // formato ISO para que lo entienda bien

  if (isNaN(diaActual)) return; // evitar errores si el parseo falla

  const diaSemana = diaActual.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado

  // Si NO es lunes, calcular el siguiente lunes
  if (diaSemana !== 1) {
    const diasHastaLunes = (8 - diaSemana) % 7;
    diaActual.setDate(diaActual.getDate() + diasHastaLunes);
  }

  // Convertir a formato YYYY-MM-DD
  const dd = String(diaActual.getDate()).padStart(2, '0');
  const mm = String(diaActual.getMonth() + 1).padStart(2, '0');
  const yyyy = diaActual.getFullYear();

  const diaSiguiente = `${dd}/${mm}/${yyyy}`;


  $("#inicioDocencia").val(diaSiguiente);
  $("#entradaAlojamiento").val(diaSiguiente);

  $("#codDocencia").attr("disabled", false);
  $("#btnSearchTarifaDocencia").attr("disabled", false);
});
function calcularLunesSiguiente() {
  console.log('calculadno dia siguente');
    let valor = $("#fechaLlegada").val().trim(); 
    if (!valor) return;

    // Quitar día de la semana si viene así: "viernes, 14/11/2025 12:00"
    if (valor.includes(",")) {
        valor = valor.split(",")[1].trim();
    }

    // Tomar solo la fecha (d/m/Y)
    const diaStr = valor.split(" ")[0];
    const [d, m, y] = diaStr.split("/");

    const fecha = new Date(`${y}-${m}-${d}`);
    if (isNaN(fecha)) return;

    const diaSemana = fecha.getDay(); // 1 = lunes

    // Calcular lunes siguiente
    if (diaSemana !== 1) {
        const diasHastaLunes = (8 - diaSemana) % 7;
        fecha.setDate(fecha.getDate() + diasHastaLunes);
    }

    // Convertir a DD/MM/YYYY
    const dd = String(fecha.getDate()).padStart(2, '0');
    const mm = String(fecha.getMonth() + 1).padStart(2, '0');
    const yyyy = fecha.getFullYear();

    const lunesStr = `${dd}/${mm}/${yyyy}`;

    // Asignar
    $("#inicioDocencia").val(lunesStr);
      $("#entradaAlojamiento").val(lunesStr);

      console.log(lunesStr);

}


$("#inicioDocencia").addClass('blink');
$("#inicioDocencia").on("input", function () {
  $("#inicioDocencia").removeClass('blink');
  if($('#codDocencia').val() == ''){
    $("#codDocencia").addClass('blink');
  }

  
  $("#codDocencia").attr("disabled", false);
  $("#btnSearchTarifaDocencia").attr("disabled", false);
});
$("#finalDocencia").on("input", function () {
  let dia = $(this).val();
  var diaActual = new Date(dia);
  $("#finalDocencia").removeClass('blink');

  // Sumamos un día
  diaActual.setDate(diaActual.getDate() + 1);

  // Convertimos de nuevo el objeto Date a cadena en el formato YYYY-MM-DD
  var diaSiguiente = diaActual.toISOString().split("T")[0];
  $("#salidaAlojamiento").val(diaSiguiente);
  $("#diaRegreso").val(diaSiguiente);
  $("#horaRegreso").val(diaSiguiente);
});
$("#salidaAlojamiento").on("input", function () {
  let dia = $(this).val();
  $("#diaRegreso").val(dia);
  $("#horaRegreso").val($("#horaAlojamiento").val());
});
$("#recogeAlumno").on("input", function () {
  let persona = $(this).val();
  $("#quienRecogeLlegada").val(persona);
  $("#quienRecogeRegreso").val(persona);
});

function formatearEur(importe) {
  // Si el importe no es un número, asegurarse de que lo sea
  if (typeof importe === "number") {
    // Convertir el número a string formateado
    importe = importe.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  }

  // Comprobar si el importe contiene un separador decimal
  if (!importe.includes(",")) {
    // Si no lo tiene, agregamos ",00"
    importe += ",00";
  }

  // Reemplazar los miles para el formato europeo
  importe = importe.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  return importe;
}
function convertirEurANumero(importe) {
  // Validar que importe no sea undefined, null o vacío
  if (!importe || importe === undefined || importe === null) {
    return 0;
  }
  
  // Convertir a string por si acaso
  importe = String(importe);
  
  // Eliminar los puntos que separan los miles
  importe = importe.replace(/\./g, "");

  // Reemplazar la coma por un punto para que sea reconocida como decimal
  importe = importe.replace(",", ".");

  // Convertir el string a un número flotante
  return parseFloat(importe) || 0;
}
function recalcularPrecios() {
  let facturado = convertirEurANumero($("#finalFacturado").val());
  let pagado = convertirEurANumero($("#finalPagado").text());

  $("#finalPendiente").text((facturado - pagado).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €');
  var valor = $("#finalFacturado").val(); // Obtienes el valor del input
  var esNaN = isNaN(parseFloat(valor));  // Verificas si no es un número (convertido a float)

  if (esNaN) {
      console.log("El valor no es un número válido.");
  }
  
}

$("#finalFacturado").val(formatearEur(0) + "€");
$("#finalPagado").text("0,00 €");
$("#finalPendiente").text("0,00 €");

$("#lugarLlegada").on("input", function () {
  let lugar = $(this).val();
  $("#lugarRecogidaLlegada").val(lugar);
  $("#lugarEntregaRegreso").val(lugar);
});

var prescriptor_table = $("#prescriptor_table").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idCliente" },
    { name: "nombreCliente", className: "text-center" },
    { name: "email", className: "text-center" },
    { name: "tefCliente", className: "text-center" },
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },

    { targets: [2], orderData: false, visible: true },

    { targets: [3], orderData: false, visible: true },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/prescriptor.php?op=mostrarElementos",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // $('.submitBtn').attr("disabled","disabled");
      //$('#usuario_data').css("opacity","");
    },
    complete: function (data) {
      $("#prescriptor_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
      $("#prescriptor_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
    },
    error: function (e) {},
  },
}); // del DATATABLE

$("#prescriptor_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros("prescriptor_table");
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });
$("#prescriptor_table tbody").on("click", "tr", function () {
  //! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
  // Obtén la instancia de la tabla DataTables
  var tabla = $("#prescriptor_table").DataTable();

  // Obtén el objeto de datos de la fila actual
  var data = tabla.row(this).data();
  cargarDatosXIdPrescriptor(data[0]);
  $("#seleccionar-prescriptor-modal").modal("hide");
});

function cargarDatosXIdPrescriptor(idPrescriptor) {
  $.post(
    "../../controller/prescriptor.php?op=recogerInfo",
    { idPrescriptor: idPrescriptor },
    function (data) {
      data = JSON.parse(data);
      $("#idPrescriptorDatos").val(data[0]["idPrescripcion"]);
      $("#diaInscripcion").val(data[0]["fecPrescripcion"]);
      $("#departamentoSelect").val(data[0]["idDepartamentoEdu_prescriptores"]);
      $("#nombreApellidos").val(
        data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]
      );
      $("#sexo").val(data[0]["sexoPrescripcion"]);

      cargarLobibox();
    }
  );
}
var Lobibox = Lobibox || {};

function cargarLobibox() {
  var nombreApe = $("#nombreApellidos").val();
  var prescriptorNum = $("#idPrescriptorDatos").val();
  var fechaFormateada = $("#diaInscripcion").val();
 

  Lobibox.notify.closeAll();

  // Cerrar notificaciones activas de Lobibox antes de crear una nueva
  Lobibox.notify("info", {
    pauseDelayOnHover: true, // Pausar el temporizador al pasar el mouse
    continueDelayOnInactiveTab: false, // No continuar el retraso si la pestaña está inactiva
    position: "top center", // Posición en la parte superior central
    icon: "fa-solid fa-user", // Icono FontAwesome
    delay: false, // Duración infinita
    title: "Datos del Prescriptor", // Título personalizado
    msg: `<strong>Nombre: ${nombreApe} <br> ID: ${prescriptorNum} <br> Fecha inscripción: ${fechaFormateada}</strong>`, // HTML en el mensaje
    closeOnClick: false,
    closable: false // Eliminar el botón de cierre

  });

  // Cerrar todas las notificaciones de Lobibox si ya existe alguna
}
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
  ],
  columnDefs: [
    { targets: [0], orderData: [0], visible: false }, // ID oculto
    { targets: [1], orderData: [1], visible: true },
    { targets: [2], orderData: [2], visible: true },
    { targets: [3], orderData: [3], visible: true },
    { targets: [4], orderData: [4], visible: true },

    { targets: [5], orderData: [5], visible: true },
    { targets: [6], orderData: false, visible: true },
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
      columns: [1, 2, 3, 4, 5],
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
// Añadimos eventos adicionales al DataTable después de la inicialización
$("#tarifas_table")
  .on("draw.dt", function () {
    controlarFiltros("tarifas_table");
  })
  .addClass("width-100"); // Para hacer el DataTable responsive
function abrirModalTarifas(tipo) {
  $("#buscar-tarifaAloja-modal").modal("show");
  $(".tab-pane.active").find(".buscarTarifa").val(tipo);
}

let lastClickedButton = null;

function abrirModalTarifasOtros(tipo, button) {
  lastClickedButton = button;  // Almacenamos el botón que fue clickeado
  $("#buscar-tarifaAloja-modal").modal("show");
  $(".tab-pane.active").find(".buscarTarifa").val(tipo);
}
// Capturamos el data-type al abrir el modal y recargamos los datos del DataTable
$("#buscar-tarifaAloja-modal").on("shown.bs.modal", function () {
  // Accedemos al atributo data-type del botón
  var dataType = $(".tab-pane.active").find(".buscarTarifa").val();

  // Cambiamos la URL del DataTable y recargamos los datos

  tarifaAloja_table.ajax.url(
    "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaFactura&datatype=" + dataType
  ).load(function (json) {
    // Aquí puedes manejar el objeto json si lo necesitas
    $("#tarifas_table_wrapper").find(".quitarFiltros").parent().parent().trigger("click");
  }).on("draw.dt", function () {
    controlarFiltros("tarifas_table"); // Llamas a la función para controlar filtros
  });
});
// Evento para capturar el clic en una fila del DataTable
  $("#tarifas_table tbody").on("click", "tr", function () {

      // Datos de la fila seleccionada
      var data = tarifaAloja_table.row(this).data();

      // Cargar código en inputs visibles
      $("#codDocencia:visible").val(data[1]);
      $("#codAlojamiento:visible").val(data[1]);

      // Si existe botón previamente pulsado
      if (lastClickedButton) {
          $(lastClickedButton).prev().prev().val(data[1]);
      }

      // Cargar textos si están vacíos
      if ($("#textEditar:visible").text() == "") {
          $("#textEditar:visible").text(" - Tipo:" + data[2]);
      }
      if ($("#textAlojamiento:visible").text() == "") {
          $("#textAlojamiento:visible").text(" - Tipo:" + data[2]);
      }

      // Tiempo docencia / alojamiento
      $("#tiempoDocencia:visible").text(" (" + $(data[3]).text() + ")");
      $("#tiempoAloja:visible").text(" (" + $(data[3]).text() + ")");

      // Descripciones
      $('#descripcionTarifa').val(data[2]);
      $('#descripcionTarifaAloja').val(data[2]);

      // Importes e IVA
      $("#importeDocencia:visible").val(
          formatearEur(convertirEurANumero($(data[6]).text())) + "€"
      );
      $("#importeAlojamiento:visible").val(
          formatearEur(convertirEurANumero($(data[6]).text())) + "€"
      );

      $("#ivaDocencia:visible").val($(data[5]).text());
      $("#ivaAlojamiento:visible").val($(data[5]).text());

      $("#descDocencia:visible").val($(data[4]).text());
      $("#descuentoAlojamiento:visible").val($(data[4]).text());

      // Cerrar modal
      $("#buscar-tarifaAloja-modal").modal("hide");

      // Petición AJAX
      $.post(
          "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
          { codigo: data[1] },
          function (data) {

              data = JSON.parse(data);

              // Si viene de un botón pulsado previamente
              if (lastClickedButton) {

                  var parent = $(lastClickedButton).parent().parent();

                  // Nombre tarifa
                  parent.next().find("input").val(data[0]["nombre_tarifa"]);

                  // Precio tarifa
                  if (data[0]["precio_tarifa"] != "") {
                      parent.next().next().find("input").val(
                          formatearEur(data[0]["precio_tarifa"]) + "€"
                      );
                  } else {
                      parent.next().next().find("input").val("0,00€");
                  }

                  // Si no tiene data-value, asignarlo
                  if (parent.next().next().find("input").attr("data-value") === undefined) {
                      parent.next().next().find("input").attr("data-value", "0,00€");
                  }

                  // IVA tarifa
                  parent.next().next().next().find("input").val(data[0]["iva_tarifa"]);

                  // Recalcular importe total
                  let importeTotal = convertirEurANumero($("#finalFacturado").val());
                  let importeOtro = convertirEurANumero(parent.next().next().find("input").val());
                  let importeStr = convertirEurANumero(parent.next().next().find("input").attr("data-value"));

                  importeTotal -= importeStr;
                  importeTotal += importeOtro;

                  $("#importeTarifasLlegada").attr("data-value", formatearEur(importeOtro) + "€");
                  $("#finalFacturado").val(formatearEur(importeTotal) + "€");

                  parent.next().next().find("input").attr(
                      "data-value",
                      parent.next().next().find("input").val()
                  );

                  recalcularPrecios();
                  
                  // Marcar cambios sin guardar en Transfer si estamos en esa pestaña
                  if ($('#transfer').hasClass('active')) {
                      marcarTransferCambios();
                  }
              }

              // Si NO viene de lastClickedButton (selección desde Docencia o Alojamiento)
              else {

                  var cantidad   = data[0]["unidades_tarifa"];
                  var medida     = data[0]["unidad_tarifa"];
                  
                  console.log("📋 Tarifa seleccionada desde modal");
                  console.log("Cantidad:", cantidad, "Medida:", medida);
                  
                  // Verificar si estamos en la pestaña de Docencia
                  if ($("#codDocencia:visible").length > 0) {
                      console.log("✅ Estamos en pestaña Docencia");
                      
                      // Estamos en Docencia, calcular fecha final
                      let inicioStr = $("#inicioDocencia").val(); // DD/MM/YYYY
                      console.log("Fecha inicio:", inicioStr);
                      
                      if (inicioStr && inicioStr.includes("/")) {
                          // Parsear fecha DD/MM/YYYY
                          const [d, m, y] = inicioStr.split("/");
                          var fechaInicio = new Date(`${y}-${m}-${d}`);
                          console.log("Fecha inicio parseada:", fechaInicio);
                          
                          // Calcular fecha final sumando tiempo
                          var fechaFinal = sumarTiempo(fechaInicio, cantidad, medida);
                          console.log("Fecha final calculada:", fechaFinal);
                          
                          if (fechaFinal) {
                              // Ajustar al viernes anterior
                              fechaFinal = ajustarAViernesAnterior(fechaFinal);
                              console.log("Fecha final ajustada:", fechaFinal);
                              
                              // Asignar fecha final
                              $('#finalDocencia').val(fechaFinal);
                              console.log("✅ Fecha final asignada al input");
                          } else {
                              console.warn("⚠️ No se pudo calcular la fecha final");
                          }
                      } else {
                          console.warn("⚠️ No hay fecha de inicio válida");
                      }
                  }
                  
                  // Verificar si estamos en la pestaña de Alojamiento
                  if ($("#codAlojamiento:visible").length > 0) {
                      console.log("✅ Estamos en pestaña Alojamiento");
                      
                      // Estamos en Alojamiento, calcular fecha de salida
                      let entradaStr = $("#entradaAlojamiento").val(); // DD/MM/YYYY
                      console.log("Fecha entrada:", entradaStr);
                      
                      if (entradaStr && entradaStr.includes("/")) {
                          // Parsear fecha DD/MM/YYYY
                          const [d, m, y] = entradaStr.split("/");
                          var fechaEntrada = new Date(`${y}-${m}-${d}`);
                          console.log("Fecha entrada parseada:", fechaEntrada);
                          
                          // Calcular fecha de salida sumando tiempo
                          var fechaSalida = sumarTiempo(fechaEntrada, cantidad, medida);
                          console.log("Fecha salida calculada:", fechaSalida);
                          
                          if (fechaSalida) {
                              // Ajustar al sábado anterior
                              fechaSalida = ajustarASabadoAnterior(fechaSalida);
                              console.log("Fecha salida ajustada:", fechaSalida);
                              
                              // Asignar fecha de salida
                              $('#salidaAlojamiento').val(fechaSalida);
                              console.log("✅ Fecha salida asignada al input");
                          } else {
                              console.warn("⚠️ No se pudo calcular la fecha de salida");
                          }
                      } else {
                          console.warn("⚠️ No hay fecha de entrada válida");
                      }
                  }

                  $("#agregarMatricula").attr("disabled", false);

                  // Solo recalcular si hay importes válidos
                  if ($("#importeDocencia").val() || $("#importeAlojamiento").val()) {
                      recalcularPrecios();
                  }
              }

          }
      );
  });




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

// AJUSTE DE FECHAS POR DOCENCIA - Ajusta a viernes anterior //
function ajustarAViernesAnterior(fechaStr) {
   console.log("🔧 ajustarAViernesAnterior - Input:", fechaStr);
   
   if (typeof fechaStr !== "string") {
       console.error("❌ fechaStr no es string:", typeof fechaStr);
       return null;
   }

    // Parsear DD/MM/YYYY
    const [d, m, y] = fechaStr.split("/");
    console.log("Parseado - Día:", d, "Mes:", m, "Año:", y);
    
    const fecha = new Date(`${y}-${m}-${d}`);
    console.log("Fecha creada:", fecha);
    
    if (isNaN(fecha)) {
        console.error("❌ Fecha inválida");
        return null;
    }

    const diaSemana = fecha.getDay(); // 0=domingo ... 5=viernes
    const nombresDias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    console.log("Día de la semana:", nombresDias[diaSemana], `(${diaSemana})`);

    // Calcular cuántos días restar para llegar al viernes anterior
    const diasARestar = (diaSemana - 5 + 7) % 7;
    console.log("Días a restar:", diasARestar);
    
    fecha.setDate(fecha.getDate() - diasARestar);
    console.log("Fecha ajustada:", fecha);

    // Formatear DD/MM/YYYY
    const dd = String(fecha.getDate()).padStart(2, "0");
    const mm = String(fecha.getMonth() + 1).padStart(2, "0");
    const yyyy = fecha.getFullYear();
    
    const resultado = `${dd}/${mm}/${yyyy}`;
    console.log("✅ Resultado final:", resultado);

    return resultado;
}

// AJUSTE DE FECHAS POR ALOJAMIENTO - Ajusta a sábado anterior //
function ajustarASabadoAnterior(fechaStr) {
    if (typeof fechaStr !== "string") return null;

    // Parsear DD/MM/YYYY
    const [d, m, y] = fechaStr.split("/");
    const fecha = new Date(`${y}-${m}-${d}`);
    if (isNaN(fecha)) return null;

    const diaSemana = fecha.getDay(); // 0=domingo ... 6=sábado

    // Calcular cuántos días restar para llegar al sábado anterior
    const diasARestar = (diaSemana - 6 + 7) % 7;
    fecha.setDate(fecha.getDate() - diasARestar);

    // Formatear DD/MM/YYYY
    const dd = String(fecha.getDate()).padStart(2, "0");
    const mm = String(fecha.getMonth() + 1).padStart(2, "0");
    const yyyy = fecha.getFullYear();

    return `${dd}/${mm}/${yyyy}`;
}

$("#botonContenedorVisado").click(function () {
  if ($("#visados-tab").hasClass("disabled")) {
    toastr.error("Visado deshabilitado, es necesario un pago anticipado");
  }
});
/* $('#visadoCheck').on('change', function() {
  if ($(this).is(':checked')) {
    $("#visadosContent").removeClass("d-none");
  } else {
    $("#visadosContent").addClass("d-none");
  }
}); */

$("#btnSearchAgente").click(function(){
  $("#buscar-agente-modal").modal("show");
});
var agentes_table = $("#agentes_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idAgente" },
    { name: "nombreAgente", className: "text-center"},
    { name: "identificacionAgente", className: "text-center" },
    { name: "domicilioAgente", className: "text-center" },
    { name: "correoAgente", className: "text-center" },
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },


    { targets: [2], orderData: false, visible: true },
    { targets: [3], orderData: false, visible: true },
    { targets: [4], orderData: false, visible: true },

  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarAgentesPreinscripciones",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // $('.submitBtn').attr("disabled","disabled");
      //$('#usuario_data').css("opacity","");
    },
    complete: function (data) {},
    error: function (e) {},
  },
}); // del DATATABLE

//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

$("#agentes_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros("agentes_table");
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#agentes_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE


$("#agentes_table tbody").on("click", "tr", function () {
  //! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
  // Obtén la instancia de la tabla DataTables
  var tabla = $("#agentes_table").DataTable();

  // Obtén el objeto de datos de la fila actual
  var data = tabla.row(this).data();
  //console.log("data:"+ JSON.stringify(data));
  //alert("data: " + JSON.stringify(data));

  
  $("#idAgente").val(data[0]);
  $("#nombreAgente").val(data[1]);
  $("#seleccionar-prescriptor-modal").modal("hide");
  $("#buscar-agente-modal").modal("hide");
});

function convertirFecha(formatoOriginal) {
  var partes = formatoOriginal.split('/');
  return partes[2] + '-' + partes[1] + '-' + partes[0]; // yyyy-mm-dd
}
function editarMatricula(filaMatricula){
 
  var filaTabla = filaMatricula - 1;
  var datosFila = $("#matriculacionTable").DataTable().row(filaTabla).data();
  $("#textEditar").text(" - Editando la linea: "+filaMatricula+ " - Tarifa: "+datosFila[0] + " - Descripción: " + datosFila[1] );
  
   let aFacturar = convertirEurANumero($("#finalFacturado").val());
   let importDocencia = convertirEurANumero(datosFila[2]);
   let nuevoTotal = aFacturar - importDocencia;
   $("#finalFacturado").val(formatearEur(nuevoTotal) + "€");
  $("#codDocencia").val(datosFila[0]);
  $("#importeDocencia").val(datosFila[2]);
  $("#ivaDocencia").val(datosFila[3]);
  $("#descDocencia").val(datosFila[4]);
  var fechaInicio = convertirFecha(datosFila[5]); // Convierte la fecha
  var fechaFin = convertirFecha(datosFila[6]); // Convierte la fecha
  $("#inicioDocencia").val(fechaInicio);
  $("#finalDocencia").val(fechaFin);
  $(".btnEditView").addClass("d-none");

  $("#agregarMatricula").addClass("d-none");
  $("#guardarMatricula").removeClass("d-none");
  $("#cancelarMatricula").removeClass("d-none");
  

}

$("#cancelarMatricula").click(function(){

  $("#textEditar").text("");
  $("#codDocencia").val("");
  $("#importeDocencia").val("");
  $("#ivaDocencia").val("");
  $("#descDocencia").val("");

  $("#inicioDocencia").val("");
  $("#finalDocencia").val("");
  $("#idMatriculaEditando").val("");
  $("#observacionesDocencias").val("");

  $("#agregarMatriculaNew").removeClass("d-none");
  $("#guardarMatricula").addClass("d-none");
  $("#cancelarMatricula").addClass("d-none");
  $(".btnEditView").removeClass("d-none");

  // Vuelve a deshabilitar el campo de fecha de finalización
  //$("#finalDocencia").prop("disabled", true);
});

$("#guardarMatriculaNo").click(function(){
      $(".btnEditView").removeClass("d-none");
      //===================================================//
      //===================================================//
      //===================================================//
      // Lista de campos a validar
      const campos = [
        { id: '#descDocencia', nombre: 'Tarifa Docencia' },

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
    const inicio = $('#inicioDocencia').val();
    const final = $('#finalDocencia').val();

    if (final < inicio) {
        toastr.error('La fecha de finalización no puede ser anterior a la fecha de inicio.', 'Error de Fechas');
        return; // Salir de la función si las fechas no son lógicas
    }
    //===================================================//
    //===================================================//
    //===================================================//
  var filaTabla = $("#textEditar").text().split("-")[1].split(":")[1].trim();
  var filaDescripcion = $("#textEditar").text().split("-")[3].split(":")[1].trim();
  
  var lineaTablaOriginal = filaTabla - 1;

  var inicioDocencia = $("#inicioDocencia").val().split("-");
  var finalDocencia = $("#finalDocencia").val().split("-");

/*   let aFacturar = convertirEurANumero($("#finalFacturado").val());
  console.log("🚀 ~ $ ~ aFacturar:", aFacturar)

  let importDocencia = convertirEurANumero($("#importeDocencia").val())
  console.log("🚀 ~ $ ~ importDocencia:", importDocencia)

  let nuevoTotal = aFacturar + importDocencia;
  console.log("🚀 ~ $ ~ nuevoTotal:", nuevoTotal)

  $("#finalFacturado").val(formatearEur(nuevoTotal) + "€");
  console.log($("#finalFacturado").val()); */
  
  var nuevosDatos = [
    $("#codDocencia").val(), // Tarifa
    filaDescripcion,
    formatearEur(convertirEurANumero($("#importeDocencia").val())) + "€",
    $("#ivaDocencia").val(),
    $("#descDocencia").val(),
    inicioDocencia[2] + "/" + inicioDocencia[1] + "/" + inicioDocencia[0], // Fecha Inicio
    finalDocencia[2] + "/" + finalDocencia[1] + "/" + finalDocencia[0], // Fecha Fin
    "<button class='btn btn-info btnEditView' onClick='editarMatricula("+filaTabla+")'><i class='fa-solid fa-edit'></i></button><button class='btn btn-danger mg-l-5 eliminarMatricula'><i class='fa-solid fa-trash' ></i></button>", // Botones de acción
  ];

  // Verificar si la fila existe antes de actualizar
  if ($("#matriculacionTable").DataTable().row(lineaTablaOriginal).data()) {
    $("#matriculacionTable").DataTable().row(lineaTablaOriginal).data(nuevosDatos).draw(); // Actualizar la fila si existe
    $("#cancelarMatricula").trigger("click");
  } else {
    console.error("La fila no existe o el índice es incorrecto.");
  }
});

function editarAlojamiento(filaAlojamiento){
  var filaTabla = filaAlojamiento - 1;
  var datosFila = $("#alojamientoTable").DataTable().row(filaTabla).data();

  $("#textAlojamiento").text(" - Editando la linea: "+filaAlojamiento+ " - Tarifa: "+datosFila[0] + " - Descripción: " + datosFila[1] );
  
  let aFacturar = convertirEurANumero($("#finalFacturado").val());
  let importeAlojamiento = convertirEurANumero(datosFila[2]);
  let nuevoTotal = aFacturar - importeAlojamiento;
  $("#finalFacturado").val(formatearEur(nuevoTotal) + "€");

  $("#codAlojamiento").val(datosFila[0]);
  $("#importeAlojamiento").val(datosFila[2]);
  $("#ivaAlojamiento").val(datosFila[3]);
  $("#descuentoAlojamiento").val(datosFila[4]);
  var fechaInicio = convertirFecha(datosFila[5]); // Convierte la fecha
  var fechaFin = convertirFecha(datosFila[6]); // Convierte la fecha
  $("#entradaAlojamiento").val(fechaInicio);
  $("#salidaAlojamiento").val(fechaFin);
  $("#horaAlojamiento").val(datosFila[7]);

  $("#agregarAlojamientosNew").addClass("d-none");
  $("#guardarAlojamiento").removeClass("d-none");
  $("#cancelarAlojamiento").removeClass("d-none");
  

}
$("#cancelarAlojamiento").click(function(){
 

  $("#textAlojamiento").text("");
  $("#codAlojamiento").val("");
  $("#importeAlojamiento").val("");
  $("#ivaAlojamiento").val("");
  $("#descuentoAlojamiento").val("");

  $("#entradaAlojamiento").val("");
  $("#salidaAlojamiento").val("");
  $("#horaAlojamiento").val("11:00");

  $("#agregarAlojamiento").removeClass("d-none");
  $("#guardarAlojamiento").addClass("d-none");
  $("#cancelarAlojamiento").addClass("d-none");
});
$("#guardarAlojamiento").click(function(){
  var filaTabla = $("#textAlojamiento").text().split("-")[1].split(":")[1].trim();
  var filaDescripcion = $("#textAlojamiento").text().split("-")[3].split(":")[1].trim();
  var lineaTablaOriginal = filaTabla - 1;

  var entradaAlojamiento = $("#entradaAlojamiento").val().split("-");
  var salidaAlojamiento = $("#salidaAlojamiento").val().split("-");

  let aFacturar = convertirEurANumero($("#finalFacturado").val());
  let importDocencia = convertirEurANumero($("#importeAlojamiento").val())
  let nuevoTotal = aFacturar + importDocencia;
  $("#finalFacturado").val(formatearEur(nuevoTotal) + "€");
  var nuevosDatos = [
    $("#codAlojamiento").val(), // Tarifa
    filaDescripcion,
    formatearEur(convertirEurANumero($("#importeAlojamiento").val())) + "€",
    $("#ivaAlojamiento").val(),
    $("#descuentoAlojamiento").val(),
    entradaAlojamiento[2] +
      "/" +
      entradaAlojamiento[1] +
      "/" +
      entradaAlojamiento[0], // Fecha Inicio
    salidaAlojamiento[2] +
      "/" +
      salidaAlojamiento[1] +
      "/" +
      salidaAlojamiento[0], // Fecha Fin
    $("#horaAlojamiento").val(),
    "<button class='btn btn-info'  onClick='editarAlojamiento("+filaTabla+")'><i class='fa-solid fa-edit'></i></button><button class='btn btn-danger mg-l-5 eliminarAlojamiento'><i class='fa-solid fa-trash' ></i></button>", // Edad
  ];

  // Verificar si la fila existe antes de actualizar
  if ($("#alojamientoTable").DataTable().row(lineaTablaOriginal).data()) {
    $("#alojamientoTable").DataTable().row(lineaTablaOriginal).data(nuevosDatos).draw(); // Actualizar la fila si existe
    $("#cancelarAlojamiento").trigger("click");
  } else {
    console.error("La fila no existe o el índice es incorrecto.");
  }
});
var idPrescriptores = $("#tokkenPrescripcion").val();
var llegadasTable = $("#llegadasTable").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idCliente" },
    { name: "Nº Llegada", className: "text-center" },
    { name: "DiaInscripcion", className: "text-center" },
    { name: "Fecha Llegada", className: "text-center" },
    { name: "Departamento", className: "text-center" },
    { name: "Matriculas", className: "text-center" },
    { name: "Estado", className: "text-center" },
    { name: "Alerta Pago", className: "text-center" }
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },

    { targets: [2], orderData: false, visible: true },
    { targets: [3], orderData: false, visible: true },
    { targets: [4], orderData: false, visible: true },
    { targets: [5], orderData: false, visible: true },
    { targets: [6], orderData: false, visible: true },
    { targets: [7], orderData: false, visible: true }
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 2,3,4,5,7],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/llegadas.php?op=recogerLlegadasDT&idPrescriptor="+idPrescriptores,
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      // $('.submitBtn').attr("disabled","disabled");
      //$('#usuario_data').css("opacity","");
    },
    complete: function (data) {
      $("#llegadasTable").addClass("width-100"); // AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
    },
    error: function (e) {
      console.error("Error en la solicitud:", e); // Muestra el error en la consola
    }
    ,
  },
}); // del DATATABLE
$('#FootNumero').on('keyup', function () {
  llegadasTable
      .columns(1)
      .search(this.value)
      .draw();
});
$('#FootDia').on('keyup', function () {
  llegadasTable
      .columns(2)
      .search(this.value)
      .draw();
});
$('#FootFecha').on('keyup', function () {
  llegadasTable
      .columns(3)
      .search(this.value)
      .draw();
});
$('#FootDepartamento').on('keyup', function () {
  llegadasTable
      .columns(4)
      .search(this.value)
      .draw();
});
$('#FootMatriculacion').on('keyup', function () {
  llegadasTable
      .columns(5)
      .search(this.value)
      .draw();
});
$('#FootEstado').on('keyup', function () {
  llegadasTable
      .columns(6)
      .search(this.value)
      .draw();
});
$('#FootAlerta').on('keyup', function () {
  llegadasTable
      .columns(7)
      .search(this.value)
      .draw();
});

$("#listarLlegadas").on("click",function(){
  window.location.reload(true);
 /*  $("#buscarLlegada").removeClass("d-none");
  $("#nuevaLlegada").parent().removeClass("d-none");
  $("#listarLlegadas").parent().addClass("d-none");
  $(".cardLlegadas").addClass("d-none"); */
});


  //=========================//
  //      CARGAR EDITAR      //
  //=========================//


$("#llegadasTable tbody").on("click", "tr", function () {
  
  var hoy = new Date();
  var dia = ('0' + hoy.getDate()).slice(-2);  // Día con dos dígitos
  var mes = ('0' + (hoy.getMonth() + 1)).slice(-2);  // Mes con dos dígitos (los meses empiezan en 0)
  var anio = hoy.getFullYear();

  var fechaHoy = anio + '-' + mes + '-' + dia;  // Formato YYYY-MM-DD

  $('#diaInscripcion').val(fechaHoy);  // Asignar la fecha de hoy al input

  $('.serviciosDiv').removeClass('d-none');
  
  
  $('#matriculacionTableDiv').removeClass('d-none');
  $("#guardarTxt").addClass("d-none");

  $("#listarLlegadas").parent().removeClass("d-none");
  $("#buscarLlegada").addClass("d-none");
  $("#nuevaLlegada").parent().addClass("d-none");
  //! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
  // Obtén la instancia de la tabla DataTables
  var tabla = $("#llegadasTable").DataTable();

  // Obtén el objeto de datos de la fila actual
  var data = tabla.row(this).data();
  $(".colorBoton4").parent().removeClass("d-none");

  $("#irProforma").parent().removeClass("d-none")
  $("#irProforma").attr("href","../FacturaPro_Edu/index.php?idLlegada="+data[0])
  // $("#buscar-llegadas-modal").modal("hide");
  let idLlegadas = data[0];

  $('.matriculacionTableNew').removeClass('d-none');
  
  $('#idLlegadaReal').val(idLlegadas);

  $.post("../../controller/llegadas.php?op=recogerLledagasXIdLlegada",{idLlegadas:idLlegadas},function (data) {
    data = JSON.parse(data);
    let idPrescriptor = data[0]["idprescriptor_llegadas"];
    var idLlegada = data[0]["id_llegada"];
    //alert("id llegada:"+idLlegada);

    if ( data[0]["estLlegada"] == 1 ) {
                 
        $('.llegadaActivaLabel').removeClass('d-none');
        $('.llegadaInactivaLabel').addClass('d-none');
       
    } else {
        $('.llegadaActivaLabel').addClass('d-none');
        $('.llegadaInactivaLabel').removeClass('d-none');
    }


    $("#departamentoSelect")
    .val(data[0]["iddepartamento_llegadas"])
    .trigger("change");
    $.post(
      "../../controller/prescriptor.php?op=recogerInfo",
      { idPrescriptor: idPrescriptor },
      function (data) {
        //data[0][]
        data = JSON.parse(data);
        $("#idLlegada").val(
          "NUM" + idLlegada.toString().padStart(4, "0")
        );
        $("#idLlegada").attr("data-value",idLlegada);
        //$("#diaInscripcion").val(data[0]["fecPrescripcion"]);
        $("#nombreApellidos").val(
          data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]
        );
        $("#sexo").val(data[0]["sexoPrescripcion"]);
        $("#pais").val(data[0]["paisCasaPrescripcion"]);
        $("#idPrescriptorDatos").val(data[0]["idPrescripcion"]);
       
        cargarLobibox();
      }
    );
    $(".disabled").each(function () {
      $(this).attr("disabled", false);
      $(".cardLlegadas").removeClass("d-none");
      
      /* $("#visados-tab").addClass("disabled");
      $("#visados-tab").attr("disabledff",true) */
    });
    $("#guardarBtn").addClass("d-none");

    $("#editarBtn").removeClass("d-none");
    //! ↓↓↓↓↓↓ AGENTE / GRUPO ↓↓↓↓↓↓ !//

    
    let fecha = data[0]["diainscripcion_llegadas"];
    if (!fecha || isNaN(new Date(fecha).getTime())) {
        console.error("Fecha no válida:", fecha);
    } else {
      fecha = new Date(fecha);
      let fechaFormateada = fecha.toLocaleDateString('es-ES'); // => "20/10/1999"
      $("#diaInscripcion").val(fechaFormateada);
    }
    $("#idAgente").val(data[0]["agente_llegadas"]);
    $("#nombreAgente").val(data[0]["nombreAgente"]);
    $("#idGrupo").val(data[0]["grupo_llegadas"]);
    $("#idGrupoAmigo").val(data[0]["grupoAmigos"]);
    //! ↑↑↑↑↑↑ AGENTE / GRUPO ↑↑↑↑↑↑ !//
    //! ↓↓↓↓↓↓ LLEGADA ↓↓↓↓↓↓ !//
    if (data[0]["fechallegada_llegadas"]) {
      const fechaMySQL = data[0]["fechallegada_llegadas"]; // "2025-08-20 11:00"
      const fp = $("#fechaLlegada")[0]._flatpickr;

      // Convertir la cadena MySQL a Date
      const fechaObj = new Date(fechaMySQL.replace(" ", "T"));

      // Asignar la fecha correctamente al Flatpickr
      fp.setDate(fechaObj, true);

      // Añadir el día de la semana al valor visible
      const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
      const diaSemana = dias[fechaObj.getDay()];
      const fechaFormateada = fp.formatDate(fechaObj, "d/m/Y H:i");

      fp.input.value = `${diaSemana}, ${fechaFormateada}`;
    }
    let fechallegada = data[0]["fechallegada_llegadas"]; // "2024-10-26 17:35:00"

    /*   let soloFecha = fechallegada.split(' ')[0]; 
    $("#inicioDocencia").val(soloFecha); */
    $("#lugarLlegada").val(data[0]["lugarllegada_llegadas"]);
    $("#recogeAlumno").val(data[0]["quienrecogealumno_llegadas"]);
    //! ↑↑↑↑↑↑ LLEGADA ↑↑↑↑↑↑ !//
    //! ↓↓↓↓↓↓ CANCELACION ↓↓↓↓↓↓ !//
    $("#cancelacionFecha").val(data[0]["fechacancelacion_llegadas"]);
    $("#motivoCancelacion").val(data[0]["motivocancelacion_llegadas"]);
    if (
      data[0]["fechacancelacion_llegadas"] !== "" && data[0]["fechacancelacion_llegadas"] != null &&
      data[0]["motivocancelacion_llegadas"] !== "" && data[0]["motivocancelacion_llegadas"] != null
    ) {
        $('#mostrarInsertarCancelacion').addClass('d-none'); // Ocultar si al menos un campo tiene contenido
        $('#ocultarInsertarCancelacion').removeClass('d-none'); // Mostrar si al menos un campo tiene contenido
    } else {
        $('#ocultarInsertarCancelacion').addClass('d-none'); // Ocultar si está vacío o null
        $('#mostrarInsertarCancelacion').removeClass('d-none'); // Mostrar si está vacío o null
    }
    //! ↑↑↑↑↑↑ CANCELACION ↑↑↑↑↑↑ !//
    var aFacturar = 0;
    var pagado = 0;
    //! ↓↓↓↓↓↓ NIVEL ↓↓↓↓↓↓ !//
    $("#nivelDocencia").val(data[0]["niveldice_llegadas"]);
    $("#observacionesNivel").val(data[0]["nivelobservaciones_llegadas"]);
    rutaSeleccionada = data[0]["nivelasignado_llegadas"];
    $.ajax({
        url: "../../controller/rutas.php?op=obtenerRutaxIdView", // `op` va en GET
        type: "POST", // `idRuta` se envía por POST
        data: { idRuta: rutaSeleccionada },
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
    $("#semanaDocenciaAsignado").val(data[0]["semanaasignada_llegadas"]);
    //! ↑↑↑↑↑↑ NIVEL ↑↑↑↑↑↑ !//
    //! ↓↓↓↓↓↓ TRANSFER ↓↓↓↓↓↓ !//
    $("#codigoTarifasLlegada").val(data[0]["codigotariotallegadaTransfer_llegadas"]);
    $("#textoTarifasLlegada").val(data[0]["textotariotallegadaTransfer_llegadas"]);
    $("#importeTarifasLlegada").val(data[0]["importetariotallegadaTransfer_llegadas"]);
    $("#ivaTarifasLlegada").val(data[0]["ivatariotallegadaTransfer_llegadas"]); 
    
    if (!data[0]["diallegadaTransferTransfer_llegadas"] || !data[0]["horallegadaTransferTransfer_llegadas"]) {
      let valor = $('#fechaLlegada').val(); 
      // Ejemplo: "miércoles, 29/10/2025 11:15"

      // Extraer la parte "29/10/2025"
      let match = valor.match(/\d{2}\/\d{2}\/\d{4}/);

      if (match) {
          let dmy = match[0];        // "29/10/2025"
          let partes = dmy.split("/");

          let dia = partes[0];
          let mes = partes[1];
          let anio = partes[2];

          // Convertir a formato compatible con <input type="date">
          let fechaISO = `${anio}-${mes}-${dia}`; // "2025-10-29"

          $("#diaLlegada").val(fechaISO);
      }

      // Extraer solo la hora si la necesitas "11:15"
      let matchHora = valor.match(/\d{2}:\d{2}/);

      if (matchHora) {
          $("#horaLlegada").val(matchHora[0]);
      }

  } else {
      $("#diaLlegada").val(data[0]["diallegadaTransferTransfer_llegadas"]);
      $("#horaLlegada").val(data[0]["horallegadaTransferTransfer_llegadas"]);
  }

    if (!data[0]["lugarllegadallegadaTransfer_llegadas"]) {
        $("#lugarRecogidaLlegada").val($('#lugarLlegada').val());
    } else {
        $("#lugarRecogidaLlegada").val(data[0]["lugarllegadallegadaTransfer_llegadas"]);
    }
    $("#lugarEntregaLlegada").val(data[0]["lugarentregallegadaTransfer_llegadas"]);
    if (!data[0]["quienrecogealumnollegadaTransfer_llegadas"]) {
      $("#quienRecogeLlegada").val($('#quienRecogeRegreso').val());
    } else {
        $("#quienRecogeLlegada").val(data[0]["quienrecogealumnollegadaTransfer_llegadas"]);
    }
    //!-------------------------!//
    $("#codigoTarifasRegreso").val(data[0]["codigotariotalregresoTransfer_llegadas"]);
    $("#textoTarifasRegreso").val(data[0]["textotariotalregresoTransfer_llegadas"]);
    $("#importeTarifasRegreso").val(data[0]["importetariotalregresoTransfer_llegadas"]);
    $("#ivaTarifasRegreso").val(data[0]["ivatariotalregresoTransfer_llegadas"]);

    $("#diaRegreso").val(data[0]["diaregresoTransfer_llegadas"]);
    $("#horaRegreso").val(data[0]["horaregresoTransfer_llegadas"]);
    $("#lugarRecogidaRegreso").val(data[0]["lugarrecogidaregresaTransfer_llegadas"]);

    $("#lugarEntregaRegreso").val(data[0]["lugarentregaregresaTransfer_llegadas"]);
    $("#quienRecogeRegreso").val(data[0]["quienrecogealumnoregresaTransfer_llegadas"]);
    $("#observaciones").val(data[0]["campoobservacionesgeneralTransfer_llegadas"]);
    
    // Actualizar totales después de cargar los datos de transfer
    if (typeof actualizarTotalFacturado === 'function') {
        actualizarTotalFacturado();
    }
    //! ↑↑↑↑↑↑ TRANFER ↑↑↑↑↑↑ !//
    //! ↓↓↓↓↓↓ VISADO ↓↓↓↓↓↓ !//
    $("#visadoCheck").prop("checked", data[0]["tieneVisado"] == 1);
    $("#fechaAdmision").val(data[0]["fechCartaAdmision"]);
    $("#denegacionFecha").val(data[0]["denegacionFecha"]);
    $("#denegacionMotivo").val(data[0]["denegacionMotivo"]);
    //! ↑↑↑↑↑↑ VISADO ↑↑↑↑↑↑ !//
  
    calcularLunesSiguiente();
    //! ↑↑↑↑↑↑ TOTALES + COMENTARIOS ↑↑↑↑↑↑ !// UTILIZAR RECALCULAR
    grupoFacturado();
  })
  // Asignar el valor de soloFecha al campo #inicioDocencia
  $("#codDocencia").attr("disabled", false);
  $("#btnSearchTarifaDocencia").attr("disabled", false);

  comprobarFacturasActivas(idLlegadas);

  listarMatriculacionesTabla(idLlegadas);
  listarPagoAnticipadoTabla(idLlegadas);
  listarSuplidosTabla(idLlegadas);
  estadoLlegada();
  forzarEstadosMatricula();
  listarAlojamientosTabla(idLlegadas);
  
});
estadoLlegada();
$("#groupTarifaDocenciaInputs").on("click",function(){
  if ($("#codDocencia").prop("disabled")) { 
    toastr.error("Selecciona una fecha de inicio primero");
  }
});

    function comprobarFacturasActivas(idLlegada) {
    // OBTENGO SI ESA PERSONA TIENE O NO ALGUNA FACTURA PROFORMA O REAL ACTIVA
    // EN ESE CASO, SE "BLOQUEAN" CIERTAS ACCIONES DE MODIFICACIÓN DE SERVICIOS
    // DE MATRICULACIÓN Y MANTENIMIENTO

    $.ajax({
        url: "../../controller/proforma.php?op=comprobarFacturasActivas",
        type: "POST",
        data: { idLlegada: idLlegada },
        async: false, // 👈 Esto lo hace sincrónico
        success: function (respuesta) {
            let datos = JSON.parse(respuesta);

            // Asignar el valor recibido a los inputs hidden
            $('#inputFacturaProforma').val(datos.factura_proforma);
            $('#inputFacturaReal').val(datos.factura_real);

            comprobarFacturas(datos);
        }
    });
}



    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    //  NUEVO MÉTODO PARA COMPROBAR SEGÚN SI HAY FACTURAS ACTIVAS  //
    //  O NO SI SE QUIEREN DESACTIVAR CIERTOS APARTADOS            //
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////


    function comprobarFacturas(datos) {
      // Ocultamos ambos mensajes inicialmente
      $('.mensajeFacturas').hide();

      if (datos.factura_proforma === 1 || datos.factura_real === 1) {
        // Ocultamos formularios
        $('#zonaFormMatricula').hide();
        $('#zonaFormAlojamiento').hide();

        // Mostramos mensajes en cada contenedor mensajeFacturas
        $('.mensajeFacturas').each(function() {
          let mensaje = '';
          if (datos.factura_proforma === 1) {
            mensaje = 'Ya existe una factura proforma, debe abonarla para poder editar los servicios.';
          }
          if (datos.factura_real === 1) {
            // Si ya había mensaje, añadimos salto de línea para el otro mensaje
            mensaje += mensaje ? '<br>' : '';
            mensaje += 'Ya hay una factura real, debe abonarla para poder editar los servicios..';
          }
          $(this).html('<h4 style="color: #b08968;">' + mensaje + '</h4>').show();
        });
      } else {
        // Mostramos formularios
        $('#zonaFormMatricula').show();
        $('#zonaFormAlojamiento').show();

        // Ocultamos mensajes
        $('.mensajeFacturas').hide();
      }
    }


    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    //  FIN MÉTODO PARA COMPROBAR SEGÚN SI HAY FACTURAS ACTIVAS    //
    //  O NO SI SE QUIEREN DESACTIVAR CIERTOS APARTADOS            //
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////

// PA MODAL CANCELACION

$("#listClient").on("click",function(){
  $("#seleccionar-cliente-modal").modal("show")
});

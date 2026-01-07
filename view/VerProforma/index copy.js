/* $("#agregarAlojamiento").on("click", function () {
  $("#tablaAlojamientos").append(`<tr>
                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>
                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>



                                            </tr>`);
});
$("#agregarMatriculacion").on("click", function () {
  $("#tablaCursos").append(`
                                            <tr>
                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>

                                                <td class="tx-center">
                                                    <input type="text" class="tx-center" value="--" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
                                                </td>



                                            </tr>`);
}); */

/* $("#addCurso").on("click", function () {
  let cantidadSaltos = $("#rowCursos").find(".rowSpanTD").attr("rowspan");

  cantidadSaltos = parseInt(cantidadSaltos);
  $("#rowCursos")
    .find(".rowSpanTD")
    .attr("rowspan", cantidadSaltos + 1);
  cantidadSaltos -= 1;
  let ultimoTR;
  if (cantidadSaltos > 0) {
    // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
    ultimoTR = $("#rowCursos")
      .nextAll("tr")
      .eq(cantidadSaltos - 1);
  } else {
    // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
    ultimoTR = $("#rowCursos");
  }
  let nuevoTR = `
  <tr>
    <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="docenciaInput inputTextFill tx-left-force" value="" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
                                                    </div>
                                                    <button data-type="Docencia" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
    <td><input type="text" class="tx-left-force" value="" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td><input type="text" class="tx-center-force ivaInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force descInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td class="tx-center"><input type="text" class="importeDocencia inputImporte tx-center-force" value="0,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
  </tr>
  `;
  ultimoTR.after(nuevoTR);
  $(".docenciaInput").last().focus();
});
$("#addAlojamiento").on("click", function () {
  let cantidadSaltos = $("#rowAloja").find(".rowSpanTD").attr("rowspan");

  cantidadSaltos = parseInt(cantidadSaltos);

  $("#rowAloja")
    .find(".rowSpanTD")
    .attr("rowspan", cantidadSaltos + 1);
  cantidadSaltos -= 1;
  let ultimoTR;
  if (cantidadSaltos > 0) {
    // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
    ultimoTR = $("#rowAloja")
      .nextAll("tr")
      .eq(cantidadSaltos - 1);
  } else {
    // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
    ultimoTR = $("#rowAloja");
  }
  let nuevoTR = `
  <tr>
    <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="alojamientoInput inputTextFill tx-left-force" value="" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
                                                    </div>
                                                    <button data-type="Alojamiento" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
    <td><input type="text" class="tx-left-force" value="" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td><input type="text" class="tx-center-force ivaInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force descInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td class="tx-center"><input type="text" class="inporteAloja inputImporte tx-center-force" value="0,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
  </tr>
  `;
  ultimoTR.after(nuevoTR);

  $(".alojamientoInput").last().focus();
}); */
/* $("#addOtro").on("click", function () {
  let cantidadSaltos = $("#rowOtros").find(".rowSpanTD").attr("rowspan");

  cantidadSaltos = parseInt(cantidadSaltos);
  $("#rowOtros")
    .find(".rowSpanTD")
    .attr("rowspan", cantidadSaltos + 1);
  cantidadSaltos -= 1;
  let ultimoTR;
  if (cantidadSaltos > 0) {
    // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
    ultimoTR = $("#rowOtros")
      .nextAll("tr")
      .eq(cantidadSaltos - 1);
  } else {
    // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
    ultimoTR = $("#rowOtros");
  }
  let nuevoTR = `
  <tr>
    <td><div style="position: relative; display: inline-block; width: 55%;">
                                                        <input type="text" class="otroInput inputTextFill tx-left-force" value="" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
                                                        <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
                                                    </div>
                                                    <button data-type="Otro" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
    <td><input type="text" class="tx-left-force" value="" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td><input type="text" class="tx-center-force ivaInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force descInput" value="0 %" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

    <td class="tx-center"><input type="text" class="inporteOtro inputImporte tx-center-force" value="0,00€" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
  </tr>
  `;
  ultimoTR.after(nuevoTR);

  $(".otroInput").last().focus();
}); */
var simboloEuro = "€";
$(document).on("focusout", ".inputImporte", function () {
  var valor = $(this).val();

  // Permitir solo un signo negativo al principio
  // Si el primer carácter es '-', lo mantenemos, pero eliminamos cualquier otro que esté en cualquier otra parte del string
  var partes = valor.replace(/(?!^-)[^0-9,]/g, "").split(",");

  // Limitar a dos decimales si hay una coma
  if (partes.length === 2 && partes[1].length > 2) {
    partes[1] = partes[1].substring(0, 2); // Limitar a dos dígitos decimales
  }

  // Volvemos a ensamblar el valor con máximo dos decimales
  valor = partes.join(",");

  // Si tiene un `-` al principio, lo mantenemos, pero eliminamos cualquier otro `-`

  if (valor.charAt(0) === "-") {
    valor = "-" + valor.replace(/-/g, ""); // Solo permite el `-` al principio
  }

  // Mantenemos solo números, comas y el símbolo de euro
  if (!valor.includes(simboloEuro)) {
    $(this).val(valor + simboloEuro);
  }

  recalcularImportes();
});

$(document).on("input", "#YaPagado", function () {
  // Obtener el valor actual del campo
  var valor = $(this).val();
  valor = valor.replace("-", ""); // Eliminar cualquier '-' 

  // Eliminar cualquier carácter que no sea número, coma, punto o el signo negativo al principio
  valor = valor.replace(/[^0-9\.,-]/g, "");

  // Limitar a dos decimales si el valor tiene una coma (decimal)
  var partes = valor.split(",");
  if (partes.length > 1) {
    partes[1] = partes[1].substring(0, 2); // Limitar a dos dígitos decimales
    valor = partes[0] + "," + partes[1]; // Volver a juntar las partes
  }

  // Convertir el valor a número flotante, reemplazando coma por punto
  var valorNumerico = parseFloat(valor.replace(",", "."));

  // Obtener el valor de totalConIva, reemplazando puntos y comas
  let totalConIva = parseFloat(
    $("#totalConIva").text().replace("€", "").replace(".", "").replace(",", ".")
  );

  // Comparar el valor con totalConIva
  if (!isNaN(valorNumerico) && valorNumerico > totalConIva) {
    valorNumerico = totalConIva;
    valor = totalConIva.toString().replace(".", ","); // Asegurar el formato con coma
  }

  // Si el valor empieza con '-', mantenerlo
  if (valor.charAt(0) === "-") {
    valor = "-" + valor.replace(/-/g, ""); // Solo permite el `-` al principio
  }

  // Agregar el símbolo del euro si no está presente
  if (!valor.includes("€")) {
    valor += "€";
  }

  // Establecer el valor modificado en el campo
  $(this).val(valor);
});

$(document).on("focusout", ".inputImporte", function () {
  var valor = $(this).val();
  
  // Si al perder el foco el campo no tiene el símbolo, lo añadimos de nuevo
  if (!valor.includes(simboloEuro)) {
    $(this).val(valor + simboloEuro);
  }
});
$(document).on("focusout", "#YaPagado", function () {
  var valor = $(this).val();
  
  // Verificamos si el valor tiene el símbolo de euro; si no, lo añadimos
  if (!valor.includes(simboloEuro)) {
    valor += simboloEuro;
  }
  
  // Si el valor no tiene decimales, añadimos ",00"
  if (!valor.includes(',')) {
    valor = valor.replace(simboloEuro, ',00' + simboloEuro);
  } else {
    // Si el valor tiene decimales y solo hay un decimal, completamos con un "0"
    var partes = valor.split(',');
    if (partes[1].length === 1) {
      valor = partes[0] + ',' + partes[1] + '0' + simboloEuro;
    } else if (partes[1].length === 0) {
      // En caso de que el separador esté sin decimales, añadimos "00"
      valor = partes[0] + ',00' + simboloEuro;
    }
  }

  // Actualizamos el valor en el campo
  $(this).val(valor);
});


// Detectar cuando cualquier elemento dentro de la fila (tr) obtiene el foco
/* $(document).on("focus", "#tablaCentral tbody tr *", function () {
  // Guardar la fila actual en una variable
  let focusedRow = $(this).closest("tr");

  // Eliminar cualquier otro manejador de 'keydown' anterior para evitar duplicados
  focusedRow.off("keydown");

  // Detectar cuando se presiona una tecla dentro de la fila enfocada
  focusedRow.on("keydown", function (event) {
    // Verificar si la tecla Supr (Delete) ha sido presionada y si el tr no tiene un id
    if (event.key === "Delete" && !focusedRow.attr("id")) {
      // Eliminar la fila actual que tiene el foco solo si no tiene atributo 'id'
      focusedRow.remove();
      actualizarColspan();
      recalcularImportes();
    }
  });
}); */

function actualizarColspan() {
  let filasHastaRowAloja = $("#rowCursos").nextUntil("#rowAloja").length;
  let filasHastaRowOtros = $("#rowAloja").nextUntil("#rowOtros").length;
  let filasHastaFinal = $("#rowOtros").nextAll().length;
  $("#rowCursos")
    .find(".rowSpanTD")
    .attr("rowspan", filasHastaRowAloja + 1);
  $("#rowAloja")
    .find(".rowSpanTD")
    .attr("rowspan", filasHastaRowOtros + 1);
  $("#rowOtros")
    .find(".rowSpanTD")
    .attr("rowspan", filasHastaFinal + 1);
}
function recalcularImportes() {
  var descuentoAcumulado = 0;
  var deferreds = []; // Array para almacenar las promesas de las peticiones AJAX

  // Recorremos cada input para realizar la llamada AJAX
  $(".inputTextFill").each(function () {
    let codigo = $(this).val();

    // Obtenemos el valor del descuento ingresado
    var descuentoLinea = $(this)
      .parent()
      .parent()
      .next()
      .next()
      .next()
      .find("input")
      .val()
      .replace(" %", "");
    descuentoLinea = parseInt(descuentoLinea, 10); // Convertimos a número

    // Limitar el descuento a un máximo de 100
    if (descuentoLinea > 100) {
        descuentoLinea = 100;
        // Actualizamos el campo de descuento a 100% si el usuario introduce un valor mayor
        $(this).parent().parent().next().next().next().find("input").val("100 %");
    }
    // Obtenemos el valor original (data-original) del input, es decir, el importe original
    
    var importeOriginal = $(this)
    .parent().parent().next().next().next().next()
    .find("input").val();   // Eliminar símbolo de euros
    
    // Si no existe el valor en 'data-original', lo almacenamos la primera vez.
    if (isNaN(importeOriginal)) {
      var importeInicial = parseFloat(importeOriginal);

      $(this).parent().parent().next().next().next().next().find("input").attr("data-original", importeInicial.toLocaleString("es-ES", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }));
    }

    importeOriginal = parseFloat(importeOriginal);
    // Calculamos el descuento en función del porcentaje ingresado
    var desctTotalLinea = importeOriginal * (descuentoLinea / 100);
    
    // Calculamos el nuevo importe con el descuento aplicado
    var importeConDescuento = importeOriginal - desctTotalLinea;

    // Formateamos el valor a formato de moneda
    importeConDescuento = importeConDescuento.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });


    importeConDescuento = importeConDescuento.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    // Actualizamos el input con el importe final
    $(this).parent().parent().next().next().next().next().find("input").val(importeConDescuento + "€");

    // Realizamos la llamada Ajax
    var deferred = $.post(
      "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
      { codigo: codigo },
      function (data) {
        try {
          data = JSON.parse(data);
          let descuentoCodigo = data[0]["descuento_tarifa"];
          descuentoAcumulado += parseInt(descuentoCodigo, 10);
        } catch (e) {
        }
      }
    );

    deferreds.push(deferred); // Añadimos la promesa al array
});



  // Esperamos a que todas las peticiones AJAX se completen
  $.when.apply($, deferreds).done(function () {
    // Después de que todas las peticiones AJAX terminen, calculamos los importes
    var importeTotal = 0;
    $(".inputImporte").each(function () {
      importeTotal += parseFloat(
        $(this).val().replace("€", "").replace(".", "").replace(",", ".")
      );
    });

    if (descuentoAcumulado > 100) {
      descuentoAcumulado = 100;
    }
    $("#descuentoTotal").text(descuentoAcumulado);
    
    var importeDocencia = 0
    var importeAloja = 0
    var importeOtro = 0

    //INICIO TOTAL CURSOS

    $(".importeDocencia").each(function(){
      let importe = parseFloat(
        $(this).val().replace("€", "").replace(".", "").replace(",", ".")
      );
      importeDocencia += importe;
    });
    importeDocenciaParseado = importeDocencia.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeDocenciaParseado = importeDocenciaParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalCursos").text(importeDocenciaParseado + "€");

    //FIN TOTAL CURSOS
    //INICIO TOTAL ALOJA

    $(".inporteAloja").each(function(){
      let importe = parseFloat(
        $(this).val().replace("€", "").replace(".", "").replace(",", ".")
      );
      importeAloja += importe;
    });
    importeAlojaParseado = importeAloja.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeAlojaParseado = importeAlojaParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalAloja").text(importeAlojaParseado + "€");

    //FIN TOTAL ALOJA
    //INICIO TOTAL OTROS

    $(".inporteOtro").each(function(){
      let importe = parseFloat(
        $(this).val().replace("€", "").replace(".", "").replace(",", ".")
      );
      importeOtro += importe;
    });
    importeOtroParseado = importeOtro.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeOtroParseado = importeOtroParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalOtros").text(importeOtroParseado + "€");

    //FIN TOTAL OTROS
    //TOTAL DESCUENTO CURSOS
    $("#descuentoTotalCurso").text($("#descGrupoCurso").val());
    var descuentoCurso = parseInt($("#descGrupoCurso").val(),10);
    var importeDocenciaDesc = importeDocencia * (descuentoCurso / 100);
    importeDocencia = importeDocencia - importeDocenciaDesc;
    importeDocenciaParseado = importeDocencia.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeDocenciaParseado = importeDocenciaParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalCursosDto").text(importeDocenciaParseado+"€");


    //FIN TOTAL DESCUENTO CURSOS
    //TOTAL DESCUENTO ALOJA
    $("#descuentoTotalAloja").text($("#descGrupoAloja").val());
    var descuentoAloja = parseInt($("#descGrupoAloja").val(),10);
    var importeAlojaDesc = importeAloja * (descuentoAloja / 100);
    importeAloja = importeAloja - importeAlojaDesc;
    importeAlojaParseado = importeAloja.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeAlojaParseado = importeAlojaParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalAlojaDto").text(importeAlojaParseado+"€");
    

    //FIN TOTAL DESCUENTO ALOJA
    //TOTAL DESCUENTO otros
    $("#descuentoTotalOtro").text($("#descGrupoOtro").val());
    var descuentoOtro = parseInt($("#descGrupoOtro").val(),10);
    var importeOtroDesc = importeOtro * (descuentoOtro / 100);
    importeOtro = importeOtro - importeOtroDesc;
    importeOtroParseado = importeOtro.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    importeOtroParseado = importeOtroParseado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalOtrosDto").text(importeOtroParseado+"€");
    

    //FIN TOTAL DESCUENTO otros
    importeTotal = importeOtro + importeDocencia + importeAloja
    var resultadoFormateado = importeTotal.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    resultadoFormateado = resultadoFormateado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );
    $("#totalSinIva").text(resultadoFormateado + "€");
    
    var descuentoTotal =
      importeTotal - importeTotal * (descuentoAcumulado / 100);



    var descuentoFormateado = descuentoTotal.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    descuentoFormateado = descuentoFormateado.replace(
      /\B(?=(\d{3})+(?!\d))/g,
      "."
    );

    $("#totalConDescuento").text(descuentoFormateado + "€");


    $("#groupIVA").html("");
    // Crear un objeto para acumular los precios por cada tipo de IVA
    var ivaTotales = {};

    $(".ivaInput").each(function () {
      // Obtenemos el valor del input del IVA, que se espera que sea algo como '16 %'
      var ivaValue = $(this).val();

      // Eliminamos cualquier carácter no numérico (en este caso, el símbolo de porcentaje)
      var ivaNumber = ivaValue.replace(/\D/g, ""); // Esto dejará solo los números

      // Obtenemos el precio relacionado que está en el siguiente input
      var precio =
        parseFloat(
          $(this)
            .parent()
            .next()
            .next()
            .find("input")
            .val()
            .replace(/\./g, "")
            .replace(",", ".")
        ) || 0; // Convertir el precio de cadena a número

      // Si no existe una entrada en el objeto para este IVA, la creamos con el precio inicial
      if (!ivaTotales[ivaNumber]) {
        ivaTotales[ivaNumber] = 0;
      }

      // Sumamos el precio actual al total acumulado para este IVA
      ivaTotales[ivaNumber] += precio;
    });
    var totalIVA;
    // Ahora recorremos el objeto ivaTotales para agregar los valores al HTML
    $.each(ivaTotales, function (ivaNumber, totalPrecios) {
      // Calculamos el IVA sobre el total de los precios acumulados
      totalIVA = (totalPrecios * ivaNumber) / 100;

      // Chequeamos si ya existe un bloque para ese IVA en el div #groupIVA
      var ivaLabel = $("#groupIVA").find("label[data-iva='" + ivaNumber + "']");

      totalIVA = totalIVA.toLocaleString("es-ES", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
      totalIVA = totalIVA.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

      if (ivaLabel.length === 0) {
        // Si no existe, lo agregamos con el total de IVA calculado

        var htmlToAdd =
          '<p>Tipo IVA <label class="ivaTipo" data-iva="' +
          ivaNumber +
          '">' +
          ivaNumber +
          "</label>%: <label class='totalIVA'>" +
          totalIVA +
          "€</label></p>";

        // Añadimos el nuevo bloque al div #groupIVA
        $("#groupIVA").append(htmlToAdd);
      } else {
        // Si ya existe, simplemente actualizamos el valor del IVA total
        ivaLabel
          .parent()
          .find(".totalIVA")
          .text(totalIVA + "€");
      }
    });
    var totalConIva = 0;
    $(".totalIVA").each(function () {
      // Sumar el valor de cada elemento .totalIVA
      totalConIva += parseFloat(
        $(this).text().replace("€", "").replace(".", "").replace(",", ".")
      );
    });

    // Sumar el descuento total al total acumulado
    totalConIva += descuentoTotal;

    // Formatear el total acumulado una vez que se haya calculado completamente
    totalConIva = totalConIva.toLocaleString("es-ES", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    totalConIva = totalConIva.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    // Actualizar el valor en el elemento con el resultado formateado

    $("#totalConIva").text(totalConIva + "€");
  });
}


// Inicializamos el DataTable sin URL dinámica (la URL se actualizará luego)
/* var tarifaAloja_table = $("#tarifas_table").DataTable({
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
    url: "",
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
}); */

// Añadimos eventos adicionales al DataTable después de la inicialización
/* $("#tarifas_table")
  .on("draw.dt", function () {
    controlarFiltros("tarifas_table");
  })
  .addClass("width-100"); // Para hacer el DataTable responsive
 */
// Capturamos el clic en cualquier botón con la clase .searchTarifa
/* $(document).on("click", ".searchTarifa", function (event) {
  // Capturamos el botón que ha sido clicado
  var triggerElement = $(this);

  // Guardamos el triggerElement para poder acceder a él en el evento del modal
  $("#buscar-tarifaAloja-modal").data("triggerElement", triggerElement);

  // Mostramos el modal
  $("#buscar-tarifaAloja-modal").modal("show");
}); */

// Capturamos el data-type al abrir el modal y recargamos los datos del DataTable
/* $("#buscar-tarifaAloja-modal").on("show.bs.modal", function () {
  // Recuperamos el triggerElement almacenado
  var triggerElement = $(this).data("triggerElement");

  // Accedemos al atributo data-type del botón
  var dataType = triggerElement.attr("data-type");

  // Cambiamos la URL del DataTable y recargamos los datos
  tarifaAloja_table.ajax
    .url(
      "../../controller/tarifaAloja_Edu.php?op=listarTarifasAlojaFactura&datatype=" +
        dataType
    )
    .load();
});
 */
// Evento para capturar el clic en una fila del DataTable
/* $("#tarifas_table tbody").on("click", "tr", function () {
  // Capturamos los datos de la fila seleccionada
  var data = tarifaAloja_table.row(this).data();
  // Suponemos que el ID de la fila está en la primera columna (data[0])
  var selectedId = data[0];

  // Recuperamos el triggerElement almacenado
  var triggerElement = $("#buscar-tarifaAloja-modal").data("triggerElement");

  // Buscamos el input que está justo antes del triggerElement
  triggerElement.prev().find("input").val(data[1]);
  triggerElement
    .parent()
    .next()
    .find("input")
    .val(data[2] + "(" + $(data[3]).text() + ")");
  var valor = $(data[6]).text().replace(" ", "").replace("€", "");

  // Verifica si el valor ya tiene decimales
  if (valor.indexOf(",") === -1) {
    // Si no tiene decimales, agrega ",00"
    valor = valor + ",00";
  }
  if (valor == ",00") {
    valor = "0,00";
  }
  triggerElement
    .parent()
    .next()
    .next()
    .next()
    .find("input")
    .val("0 %");
  triggerElement
    .parent()
    .next()
    .next()
    .next()
    .next()
    .find("input")
    .val(valor + "€");
    triggerElement
      .parent()
      .next()
      .next()
      .next()
      .next()
      .find("input")
      .attr("data-original",valor + "€");
  triggerElement.parent().next().next().find("input").val($(data[5]).text());

  // Cerramos el modal
  $("#buscar-tarifaAloja-modal").modal("hide");
  recalcularImportes();
  // Mostramos en consola los datos seleccionados (opcional)
  
}); */

/* $(document).on("input focus", ".docenciaInput", function () {
  var query = $(this).val(); // Captura el valor del input
  var dataType = "Docencia";
  var objetoInput = $(this);

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
          cargarDatosPorCodigo(objetoInput, selectedValue);
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        $(document).on("focusout",".inputTextFill ", function (event) {
          // Verificar si el clic fue fuera del input o de las sugerencias
          var inputVal = objetoInput.val(); // Obtener el valor actual del input

          // Validamos si lo escrito coincide con alguna sugerencia
          if (suggestionsArray.indexOf(inputVal) !== -1) {
            // Si coincide, cargamos esa sugerencia en el input
            objetoInput.val(inputVal); // Cargar el valor en el input (es el mismo que ya estaba)
            cargarDatosPorCodigo(objetoInput, inputVal);
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          } else {
            /* // Si no coincide con ninguna sugerencia
            objetoInput.val(""); // Limpiamos el campo de texto
            objetoInput.parent().parent().next().find("input").val(""); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .find("input")
              .val("0 %"); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .next()
              .next()
              .find("input")
              .val("0,00€"); // Limpiamos el campo de texto
            objetoInput.focus(); // Regresamos el foco al input
            objetoInput.next().hide(); // Ocultamos las sugerencias
            toastr.error(
              "Debe completar el campo con una de las sugerencias."
            ); // Mostramos el error
          }
        });
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});

$(document).on("input", ".alojamientoInput", function () {
  var query = $(this).val(); // Captura el valor del input
  var dataType = "Alojamiento";
  var objetoInput = $(this);

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
          cargarDatosPorCodigo(objetoInput, selectedValue);
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
       
        $(document).on("focusout",".inputTextFill ", function (event) {
          // Verificar si el clic fue fuera del input o de las sugerencias
          var inputVal = objetoInput.val(); // Obtener el valor actual del input

          // Validamos si lo escrito coincide con alguna sugerencia
          if (suggestionsArray.indexOf(inputVal) !== -1) {
            // Si coincide, cargamos esa sugerencia en el input
            objetoInput.val(inputVal); // Cargar el valor en el input (es el mismo que ya estaba)
            cargarDatosPorCodigo(objetoInput, inputVal);
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          } else {
            /* // Si no coincide con ninguna sugerencia
            objetoInput.val(""); // Limpiamos el campo de texto
            objetoInput.parent().parent().next().find("input").val(""); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .find("input")
              .val("0 %"); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .next()
              .next()
              .find("input")
              .val("0,00€"); // Limpiamos el campo de texto
            objetoInput.focus(); // Regresamos el foco al input
            objetoInput.next().hide(); // Ocultamos las sugerencias
            toastr.error(
              "Debe completar el campo con una de las sugerencias."
            ); // Mostramos el error
          }
        });
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
});
$(document).on("input", ".otroInput", function () {
  var query = $(this).val(); // Captura el valor del input
  var dataType = "Otro";
  var objetoInput = $(this);

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
          cargarDatosPorCodigo(objetoInput, selectedValue);
          objetoInput.next().hide(); // Ocultar el menú de sugerencias
        });

        // Evento para manejar el clic fuera del input o de las sugerencias
        $(document).off("click.outside"); // Elimina eventos previos para evitar múltiples registros
        
        $(document).on("focusout",".inputTextFill ", function (event) {
          // Verificar si el clic fue fuera del input o de las sugerencias
          var inputVal = objetoInput.val(); // Obtener el valor actual del input

          // Validamos si lo escrito coincide con alguna sugerencia
          if (suggestionsArray.indexOf(inputVal) !== -1) {
            // Si coincide, cargamos esa sugerencia en el input
            objetoInput.val(inputVal); // Cargar el valor en el input (es el mismo que ya estaba)
            cargarDatosPorCodigo(objetoInput, inputVal);
            objetoInput.next().hide(); // Ocultar el menú de sugerencias
          } else {
            /* // Si no coincide con ninguna sugerencia
            objetoInput.val(""); // Limpiamos el campo de texto
            objetoInput.parent().parent().next().find("input").val(""); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .find("input")
              .val("0 %"); // Limpiamos el campo de texto
            objetoInput
              .parent()
              .parent()
              .next()
              .next()
              .next()
              .next()
              .find("input")
              .val("0,00€"); // Limpiamos el campo de texto
            objetoInput.focus(); // Regresamos el foco al input
            objetoInput.next().hide(); // Ocultamos las sugerencias
            toastr.error(
              "Debe completar el campo con una de las sugerencias."
            ); // Mostramos el error
          }
        });
      },
    });
  } else {
    objetoInput.next().hide(); // Si no hay texto, ocultamos el menú
  }
}); */

/* function cargarDatosPorCodigo(objeto, codigo) {
  $.post(
    "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
    { codigo: codigo },
    function (data) {
      data = JSON.parse(data);
      objeto
        .parent()
        .parent()
        .next()
        .find("input")
        .val(
          data[0]["nombre_tarifa"].trim() +
            " (" +
            data[0]["unidades_tarifa"] +
            " " +
            data[0]["unidad_tarifa"] +
            ")"
        );
      var valor = data[0]["precio_tarifa"].replace(" ", "").replace("€", "");

      // Verifica si el valor ya tiene decimales
      if (valor.indexOf(",") === -1) {
        // Si no tiene decimales, agrega ",00"
        valor = valor + ",00";
      }
      if (valor == ",00") {
        valor = "0,00";
      }
      objeto
        .parent()
        .parent()
        .next()
        .next()
        .next()
        .next()
        .find("input")
        .val(valor + "€");
        
      objeto
      .parent()
      .parent()
      .next()
      .next()
      .next()
      .next()
      .find("input")
      .attr("data-original",valor + "€");

      objeto
        .parent()
        .parent()
        .next()
        .next()
        .find("input")
        .val(data[0]["valorIva"] + " %"); // Limpiamos el campo de texto
      recalcularImportes();
    }
  );
} */
/* function cargarDatosPorCodigoConInfo(objeto, codigo, nombre, cif) {
  $.post(
    "../../controller/tarifaAloja_Edu.php?op=recogerDatosPorCodigo",
    { codigo: codigo },
    function (data) {
      data = JSON.parse(data);
      objeto
        .parent()
        .parent()
        .next()
        .find("input")
        .val(
          data[0]["nombre_tarifa"].trim() +
            " (" +
            data[0]["unidades_tarifa"] +
            " " +
            data[0]["unidad_tarifa"] +
            ") - " + cif
        );
      var valor = data[0]["precio_tarifa"].replace(" ", "").replace("€", "");

      // Verifica si el valor ya tiene decimales
      if (valor.indexOf(",") === -1) {
        // Si no tiene decimales, agrega ",00"
        valor = valor + ",00";
      }
      if (valor == ",00") {
        valor = "0,00";
      }
      objeto
        .parent()
        .parent()
        .next()
        .next()
        .next()
        .next()
        .find("input")
        .val(valor + "€");
        
      objeto
      .parent()
      .parent()
      .next()
      .next()
      .next()
      .next()
      .find("input")
      .attr("data-original",valor + "€");

      objeto
        .parent()
        .parent()
        .next()
        .next()
        .find("input")
        .val(data[0]["valorIva"] + " %"); // Limpiamos el campo de texto
      recalcularImportes();
    }
  );
} */

$(document).ready(function () {
  $("#imprimirBtn").click(function () {
    // Obtener datos de la empresa por POST
    $.post("../../controller/empresa.php?op=listarEmpresa", function (dataEmpresa) {
      dataEmpresa = JSON.parse(dataEmpresa);
  
      // Preparar datos de la factura
      var datosFactura = {
        cliente: $("#nombreAlumno").val(),
        docencia: [],
        alojamiento: [],
        otros: [],
        totalSinIva: $("#totalSinIva").text(),
        totalDescuento: $("#descuentoTotal").text(),
        totalConDescuento: $("#totalConDescuento").text(),
        iva: [],
        totalFactura: $("#totalConIva").text(),
        yaPagado: $("#YaPagado").val(),
        paisFact: $("#paisFact").val(),
        ciudadFact: $("#ciudadFact").val(),
        cpFact: $("#cpFact").val(),
        direcFact: $("#direcFact").val(),
        tefFact: $("#tefFact").val(),
        movilFact: $("#movilFact").val(),
        correoFact: $("#correoFact").val(),
        descrEmpresa: dataEmpresa[0]["descrEmpresa"],
        dirEmpresa: dataEmpresa[0]["dirEmpresa"],
        cpEmpresa: dataEmpresa[0]["cpEmpresa"],
        emailEmpresa: dataEmpresa[0]["emailEmpresa"],
        nifEmpresa: dataEmpresa[0]["nifEmpresa"],
        paisEmpresa: dataEmpresa[0]["paisEmpresa"],
        poblaEmpresa: dataEmpresa[0]["poblaEmpresa"],
        provEmpresa: dataEmpresa[0]["provEmpresa"],
        regEmpresa: dataEmpresa[0]["regEmpresa"],
        tlfEmpresa: dataEmpresa[0]["tlfEmpresa"],
        numProforma: $("#numProforma").val(),
        departamento: $("#numProforma").attr("data-depart"),
      };
  
      // Recopilar datos de docencia
      $(".docenciaInput").each(function () {
        datosFactura.docencia.push({
          codigo: $(this).val(),
          descripcion: $(this).parent().parent().next().find("input").val(),
          iva: $(this).parent().parent().next().next().find("input").val(),
          importe: $(this)
            .parent()
            .parent()
            .next()
            .next()
            .next()
            .next()
            .find("input")
            .val(),
        });
      });
  
      // Recopilar datos de alojamiento
      $(".alojamientoInput").each(function () {
        datosFactura.alojamiento.push({
          codigo: $(this).val(),
          descripcion: $(this).parent().parent().next().find("input").val(),
          iva: $(this).parent().parent().next().next().find("input").val(),
          importe: $(this)
            .parent()
            .parent()
            .next()
            .next()
            .next()
            .next()
            .find("input")
            .val(),
        });
      });
  
      // Recopilar datos de otros servicios
      $(".otroInput").each(function () {
        datosFactura.otros.push({
          codigo: $(this).val(),
          descripcion: $(this).parent().parent().next().find("input").val(),
          iva: $(this).parent().parent().next().next().find("input").val(),
          importe: $(this)
            .parent()
            .parent()
            .next()
            .next()
            .next()
            .next()
            .find("input")
            .val(),
        });
      });
  
      // Recopilar IVA
      $(".totalIVA").each(function () {
        datosFactura.iva.push({
          importe: convertirEurANumero($(this).text()),
        });
      });
  
      // Crear iframe visible para depuración
      var $iframe = $("<iframe>", {
        id: "facturaIframe",
        name: "facturaIframe",
        style: "width: 100%; height: 500px; border: none;", // Tamaño visible
      }).appendTo("body");
  
      // Enviar datos a facturaHabitual.php por AJAX
      $.ajax({
        url: "../../public/mailTemplate/facturaHabitual.php",
        method: "POST",
        data: {
          factura: JSON.stringify(datosFactura),
        },
        success: function (response) {
          // Validar que la respuesta no esté vacía
          if (!response || response.trim() === "") {
            alert("La respuesta del servidor está vacía. Revisa facturaHabitual.php.");
            $iframe.remove();
            return;
          }
  
          // Cargar la respuesta en el iframe
          var iframeDocument =
            $iframe[0].contentDocument || $iframe[0].contentWindow.document;
          iframeDocument.open();
          iframeDocument.write(response);
          iframeDocument.close();
  
          // Esperar a que el iframe cargue antes de imprimir
          $iframe[0].onload = function () {
            $iframe[0].contentWindow.focus();
            $iframe[0].contentWindow.print();
  
            // Eliminar iframe después de un tiempo
            setTimeout(function () {
              $iframe.remove();
            }, 10000);
          };
        },
        error: function (xhr, status, error) {
          alert("Error en la solicitud: " + status + " - " + error);
          console.log(xhr.responseText); // Mostrar detalles del error
        },
      });
    });
  });
  
  $("#imprimirBtnSinDescuento").click(function () {
    // Datos que deseas enviar por POST
    
    
    $.post("../../controller/empresa.php?op=listarEmpresa", function (dataEmpresa) {

      dataEmpresa = JSON.parse(dataEmpresa);
      var datosFactura = {
        cliente: $("#nombreAlumno").val(),
        docencia: [],
        alojamiento: [],
        otros: [],
        totalSinIva: $("#totalSinIva").text(),
        totalDescuento: $("#descuentoTotal").text(),
        totalConDescuento: $("#totalConDescuento").text(),
        iva: [],  // aquí se almacenarán los valores del IVA calculado
        totalFactura: 0, // Inicializamos y luego calculamos el total
        yaPagado: $("#YaPagado").val(),
        paisFact : $("#paisFact").val(),
        ciudadFact : $("#ciudadFact").val(),
        cpFact : $("#cpFact").val(),
        direcFact : $("#direcFact").val(),
        tefFact : $("#tefFact").val(),
        movilFact : $("#movilFact").val(),
        correoFact : $("#correoFact").val(),
        descrEmpresa : dataEmpresa[0]["descrEmpresa"],
        dirEmpresa : dataEmpresa[0]["dirEmpresa"],
        cpEmpresa : dataEmpresa[0]["cpEmpresa"],
        emailEmpresa : dataEmpresa[0]["emailEmpresa"],
        nifEmpresa : dataEmpresa[0]["nifEmpresa"],
        paisEmpresa : dataEmpresa[0]["paisEmpresa"],
        poblaEmpresa : dataEmpresa[0]["poblaEmpresa"],
        provEmpresa : dataEmpresa[0]["provEmpresa"],
        regEmpresa : dataEmpresa[0]["regEmpresa"],
        tlfEmpresa : dataEmpresa[0]["tlfEmpresa"],
        numProforma : $("#numProforma").val(),
        departamento : $("#numProforma").attr("data-depart")
      };
    
      var ivaAmount = 0;
      // Recolección de datos para docencia, alojamiento y otros servicios
      $(".docenciaInput").each(function () {
        var codigo = $(this).val();
        var descripcion = $(this).parent().parent().next().find("input").val();
        var iva = $(this).parent().parent().next().next().find("input").val();
        var importe = $(this)
          .parent()
          .parent()
          .next()
          .next()
          .next()
          .next()
          .find("input")
          .val();
          ivaAmount += (convertirEurANumero(importe) * (iva.replace("%","")/100));
        datosFactura.docencia.push({
          codigo: codigo,
          descripcion: descripcion,
          iva: iva,
          importe: importe,
        });
      });
    
      $(".alojamientoInput").each(function () {
        var codigo = $(this).val();
        var descripcion = $(this).parent().parent().next().find("input").val();
        var iva = $(this).parent().parent().next().next().find("input").val();
        var importe = $(this)
          .parent()
          .parent()
          .next()
          .next()
          .next()
          .next()
          .find("input")
          .val();
          ivaAmount += (convertirEurANumero(importe) * (iva.replace("%","")/100));
    
        datosFactura.alojamiento.push({
          codigo: codigo,
          descripcion: descripcion,
          iva: iva,
          importe: importe,
        });
      });
    
      $(".otroInput").each(function () {
        var codigo = $(this).val();
        var descripcion = $(this).parent().parent().next().find("input").val();
        var iva = $(this).parent().parent().next().next().find("input").val();
        var importe = $(this)
          .parent()
          .parent()
          .next()
          .next()
          .next()
          .next()
          .find("input")
          .val();
          ivaAmount += (convertirEurANumero(importe) * (iva.replace("%","")/100));
    
        datosFactura.otros.push({
          codigo: codigo,
          descripcion: descripcion,
          iva: iva,
          importe: importe,
        });
      });
    
      // Cálculo del IVA basado en totalSinIva, sin considerar el descuento
      var totalSinIva = parseFloat($("#totalSinIva").text().replace(",", "."));
      var ivaRate = 0.21; //! TODO: Suponiendo un IVA del 21%, ajustar según sea necesario
      console.log(ivaAmount);
    
      datosFactura.iva.push({ importe: ivaAmount.toFixed(2) });  // Convertimos a dos decimales
    
      // Calcular totalFactura como totalSinIva + ivaAmount
      datosFactura.totalFactura = formatearEur(convertirEurANumero((totalSinIva + ivaAmount).toFixed(2).replace(".",",") + "€"))+"€"; // Convertimos a dos decimales
    
      // Crear el iframe para cargar la página de factura
      var $iframe = $("<iframe>", {
        id: "facturaIframe",
        name: "facturaIframe",
        style: "width: 100%; height: 500px; border: none;", // Visible para visualizar el contenido
      }).appendTo("body"); // Agregar el iframe al body
    
      // Envío AJAX por POST
      $.ajax({
        url: "../../public/mailTemplate/facturaSinDescuento.php",
        method: "POST",
        data: {
          factura: JSON.stringify(datosFactura), // Enviar el JSON correctamente
        },
        success: function (response) {
          // Cargar la respuesta en el iframe
          var iframeDocument = $iframe[0].contentDocument || $iframe[0].contentWindow.document;
          iframeDocument.open();
          iframeDocument.write(response);
          iframeDocument.close();
    
          // Opción: Mostrar el iframe
          $iframe.show();
    
          // Imprimir automáticamente
          $iframe[0].contentWindow.focus();
          $iframe[0].contentWindow.print();
    
          // Opción: Eliminar el iframe después de un tiempo
          setTimeout(function () {
            $iframe.remove();
          }, 10000); // Elimina el iframe después de 10 segundos
        },
        error: function (xhr, status, error) {
          console.error("Error al cargar la factura:", error);
        },
      });
    });
    
    
    
    
  });
});

$(document).ready(function () {
  let idProforma = $("#idProforma").val(); //!cambiar por idllegada//!cambiar por idllegada//!cambiar por idllegada
  $.post("../../controller/proforma.php?op=recogerProforma",{idProforma:idProforma},function (data) {
    data = JSON.parse(data);
    console.log(data);
    $("#agenteProforma").text(data[0]["agentePie"]);
    $("#grupoFact").text(data[0]["grupoFactPie"]);
    $("#grupoAmigos").text(data[0]["grupoAmigPie"]);
    $("#facturaA").text(data[0]["quienFacturaPie"]);
    let valor = data[0]["yaPagado"];
    if (!valor.includes(',')) {
      valor = valor.replace(simboloEuro, ',00' + simboloEuro);
    } else {
      // Si el valor tiene decimales y solo hay un decimal, completamos con un "0"
      var partes = valor.split(',');
      if (partes[1].length === 1) {
        valor = partes[0] + ',' + partes[1] + '0' + simboloEuro;
      } else if (partes[1].length === 0) {
        // En caso de que el separador esté sin decimales, añadimos "00"
        valor = partes[0] + ',00' + simboloEuro;
      }
    }


    $("#YaPagado").val(valor);
    $("#idCabecera").val(data[0]["idCabecera"]);
    $("#idPie").val(data[0]["idPie"]);
    $("#llegadaNum").val("NUM" + (data[0]["idLlegada_Pie"]).toString().padStart(4, "0"));

    $("#paisFact").val(data[0]["paisCabecera"]);
    $("#provFact").val(data[0]["provCabecera"]);
    $("#ciudadFact").val(data[0]["ciudadCabecera"]);
    $("#cpFact").val(data[0]["cpCabecera"]);
    $("#direcFact").val(data[0]["direcCabecera"]);
    $("#tefFact").val(data[0]["tefCabecera"]);
    $("#movilFact").val(data[0]["movilCabecera"]);
    $("#correoFact").val(data[0]["correoCabecera"]);
    $("#cifFact").val(data[0]["cifCabecera"]);
    $("#nombreFacturacion").text(data[0]["nombreCabecera"])
    let idPrescriptor = data[0]["idprescriptor_llegadas"];
    /* $.post("../../controller/prescriptor.php?op=recogerInfo",{ idPrescriptor:  idPrescriptor},function (data) {
        //data[0][]
        data = JSON.parse(data);
        
        $("#nombreAlumno").val(
          data[0]["nomPrescripcion"] + " " + data[0]["apePrescripcion"]
        );
        
        switch (data[0]["sexoPrescripcion"]) {
          case "F":
            $("#sexoAlumno").val("Femenino");
            break;
          case "M":
            $("#sexoAlumno").val("Masculino");
            break;
          case "O":
            $("#sexoAlumno").val("Otro");
            break;
          case "N":
            $("#sexoAlumno").val("No binario");
            break;
        }

      }
    ); */
    console.log("JSON Matriculacion");
    console.log(JSON.parse(data[0]["matriculacionPie"]));
    let idLlegada = data[0]["idLlegada_Pie"];
    
    $.post("../../controller/llegadas.php?op=recogerLlegadaXID",{idLlegada:idLlegada},function (datosLlegada) {
      datosLlegada = JSON.parse(datosLlegada);
      console.log("Datos llegada");
      console.log(datosLlegada);
      
      let iddepartamento_llegadas = datosLlegada[0]["iddepartamento_llegadas"];
      $.post("../../controller/mntPreinscripciones.php?op=obtenerDepartamentoPorId",{idDepartamento:iddepartamento_llegadas},function (datosDepart) {
        datosDepart = JSON.parse(datosDepart);
        console.log(datosDepart);
        $("#numProforma").val(data[0]["numProformaPie"]);
        $("#serie").val(datosDepart[0]["prefijoFactDepa"]);
        toastr.info("PREFIJO PROFORMA EN EFACTURA");
      
      })
      
      let idPrescriptor = datosLlegada[0]["idprescriptor_llegadas"];
      $.post("../../controller/prescriptor.php?op=recogerInfo",{ idPrescriptor:  idPrescriptor},function (datosAlumno) {
        datosAlumno = JSON.parse(datosAlumno);
        $("#nombreAlumno").val(
          datosAlumno[0]["nomPrescripcion"] + " " + datosAlumno[0]["apePrescripcion"]
        );
        
        switch (datosAlumno[0]["sexoPrescripcion"]) {
          case "F":
            $("#sexoAlumno").val("Femenino");
            break;
          case "M":
            $("#sexoAlumno").val("Masculino");
            break;
          case "O":
            $("#sexoAlumno").val("Otro");
            break;
          case "N":
            $("#sexoAlumno").val("No binario");
            break;
        }
      });
      // Suponiendo que la fecha original está en datosLlegada[0]["diallegadaTransferTransfer_llegadas"]
      let fechaOriginal = datosLlegada[0]["diallegadaTransferTransfer_llegadas"];

      // Convertimos el string en un objeto Date
      let fecha = new Date(fechaOriginal);

      // Formateamos la fecha en DD/MM/YYYY
      let diaLlegada = String(fecha.getDate()).padStart(2, '0'); // Añade un cero si es necesario
      let mesLlegada = String(fecha.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11, por eso sumamos 1
      let anio = fecha.getFullYear();

      // Concatenamos el formato deseado
      let fechaFormateada = `${diaLlegada}/${mesLlegada}/${anio}`;

      $("#llegadaDia").val(fechaFormateada);
      let numeroSemana = obtenerNumeroSemana(fecha);
      $("#llegadaSemana").val(numeroSemana);
      $.each(JSON.parse(datosLlegada[0]["matriculacionesArray"]), function(index, value) {
        
        
        $("#tablaCursos").append(`
          <tr>
              <td class="tx-center">
                  <input disabled type="text" class="tx-center" value="${value[0]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
              </td>

              <td class="tx-center">
                  <input disabled type="text" class="tx-center" value="${value[4]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
              </td>

              <td class="tx-center">
                  <input disabled type="text" class="tx-center" value="${value[5]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
              </td>



          </tr>`);
      });
      $.each(JSON.parse(datosLlegada[0]["alojamientosArray"]), function(index, value) {
        
        
        $("#tablaAlojamientos").append(`<tr>
          <td class="tx-center">
              <input disabled type="text" class="tx-center" value="${value[0]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
          </td>

          <td class="tx-center">
              <input disabled type="text" class="tx-center" value="${value[4]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
          </td>

          <td class="tx-center">
              <input disabled type="text" class="tx-center" value="${value[5]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
          </td>
          <td class="tx-center">
              <input disabled type="text" class="tx-center" value="${value[6]}" style="border: none; background: none; text-align: center; width: 100%; box-sizing: border-box;">
          </td>



      </tr>`);
      });

    
    $("#idTransferLlegada").val(datosLlegada[0]["codigotariotallegadaTransfer_llegadas"]);

    //? LLEGADAS ?//
    let fechaParseadaLlegada = new Date(datosLlegada[0]["diallegadaTransferTransfer_llegadas"]);
    // Obtener el día, mes y año
    var dia = fechaParseadaLlegada.getDate();       // Día del mes (1-31)
    var mes = fechaParseadaLlegada.getMonth() + 1;  // Mes (0-11), se le suma 1 para obtener el formato correcto (1-12)
    var año = fechaParseadaLlegada.getFullYear();   // Año (yyyy)
    // Asegurarse de que el día y el mes siempre tengan 2 dígitos
    if (dia < 10) dia = '0' + dia;
    if (mes < 10) mes = '0' + mes;
    // Formatear la fecha en dd/mm/yyyy
    var fechaFormateadaLlegada = dia + '/' + mes + '/' + año;
    //? LLEGADAS ?//
    //? Regreso ?//
    let fechaParseadaRegreso = new Date(datosLlegada[0]["diaregresoTransfer_llegadas"]);
    // Obtener el día, mes y año
    var dia = fechaParseadaRegreso.getDate();       // Día del mes (1-31)
    var mes = fechaParseadaRegreso.getMonth() + 1;  // Mes (0-11), se le suma 1 para obtener el formato correcto (1-12)
    var año = fechaParseadaRegreso.getFullYear();   // Año (yyyy)
    // Asegurarse de que el día y el mes siempre tengan 2 dígitos
    if (dia < 10) dia = '0' + dia;
    if (mes < 10) mes = '0' + mes;
    // Formatear la fecha en dd/mm/yyyy
    var fechaFormateadaRegreso = dia + '/' + mes + '/' + año;
    //? Regreso ?//


    $("#idTransferLlegadaDia").val(fechaFormateadaLlegada);
    $("#idTransferLlegadaLugar").val(datosLlegada[0]["lugarllegadallegadaTransfer_llegadas"]);
    $("#idTransferLlegadaLugarEntrega").val(datosLlegada[0]["lugarentregallegadaTransfer_llegadas"]);

    $("#idTransferRecogida").val(datosLlegada[0]["codigotariotalregresoTransfer_llegadas"]);
    $("#idTransferRecogidaDia").val(fechaFormateadaRegreso);
    $("#idTransferRecogidaLugar").val(datosLlegada[0]["lugarrecogidaregresaTransfer_llegadas"]);
    $("#idTransferRecogidaLugarEntrega").val(datosLlegada[0]["lugarentregaregresaTransfer_llegadas"]);

    });

    $.each(JSON.parse(data[0]["matriculacionPie"]), function(index, value) {
      console.log(value);
      let cantidadSaltos = $("#rowCursos").find(".rowSpanTD").attr("rowspan");
      cantidadSaltos = parseInt(cantidadSaltos);
      $("#rowCursos").find(".rowSpanTD").attr("rowspan", cantidadSaltos + 1);
      cantidadSaltos -= 1;
      let ultimoTR;
      if (cantidadSaltos > 0) {
        // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
        ultimoTR = $("#rowCursos")
          .nextAll("tr")
          .eq(cantidadSaltos - 1);
      } else {
        // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
        ultimoTR = $("#rowCursos");
      }
      let nuevoTR =
        `
      <tr>
        <td>
          <div style="position: relative; display: inline-block; width: 55%;">
            <input type="text" class="docenciaInput inputTextFill tx-left-force" value="${value["codigo"]}" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
            <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
          </div>
          <button data-type="Docencia" class="tx-10 btn btn-info tx-10 searchTarifa">
              <i class="fa-solid fa-search"></i>
          </button>
        </td>
        <td><input type="text" class="tx-left-force" value="${value["concepto"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force ivaInput" value="${value["iva"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force descInput" value="${value["descuento"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

        <td class="tx-center"><input type="text" class="importeDocencia inputImporte tx-center-force" data-original="${value["importe"].replace("u20ac", "€")}" value="${value["importe"].replace("u20ac", "€")}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
      </tr>
      `;
      // Insertar el nuevo <tr> después del último
      ultimoTR.after(nuevoTR);

      // Capturar el último .docenciaInput añadido
      let nuevoInputDocencia = $(".docenciaInput").last();

      // Llamar a la función cargarDatosPorCodigo pasando el nuevo input como 'objeto'
      recalcularImportes();      
      
    });
    $.each(JSON.parse(data[0]["alojamientoPie"]), function(index, value) { //alojamientoInput      otroInput
      console.log(value);
      let cantidadSaltos = $("#rowAloja").find(".rowSpanTD").attr("rowspan");
      cantidadSaltos = parseInt(cantidadSaltos);
      $("#rowAloja").find(".rowSpanTD").attr("rowspan", cantidadSaltos + 1);
      cantidadSaltos -= 1;
      let ultimoTR;
      if (cantidadSaltos > 0) {
        // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
        ultimoTR = $("#rowAloja")
          .nextAll("tr")
          .eq(cantidadSaltos - 1);
      } else {
        // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
        ultimoTR = $("#rowAloja");
      }
      let nuevoTR =
        `
      <tr>
        <td>
          <div style="position: relative; display: inline-block; width: 55%;">
            <input type="text" class="alojamientoInput inputTextFill tx-left-force" value="${value["codigo"]}" style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
            <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
          </div>
          <button data-type="Alojamiento" class="tx-10 btn btn-info tx-10 searchTarifa">
              <i class="fa-solid fa-search"></i>
          </button>
        </td>
        <td><input type="text" class="tx-left-force" value="${value["concepto"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force ivaInput" value="${value["iva"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
        <td><input type="text" class="tx-center-force descInput" value="${value["descuento"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

        <td class="tx-center"><input type="text" class="inporteAloja inputImporte tx-center-force" data-original="${value["importe"].replace("u20ac", "€")}" value="${value["importe"].replace("u20ac", "€")}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
      </tr>
      `;
      // Insertar el nuevo <tr> después del último
      ultimoTR.after(nuevoTR);

      // Capturar el último .alojamientoInput añadido
      let nuevoInputAlojamiento = $(".alojamientoInput").last();

      // Llamar a la función cargarDatosPorCodigo pasando el nuevo input como 'objeto'
      recalcularImportes();
      
    });
    $.each(JSON.parse(data[0]["otrosPie"]), function(index, value) { //alojamientoInput      otroInput
      let cantidadSaltos = $("#rowOtros").find(".rowSpanTD").attr("rowspan");
      cantidadSaltos = parseInt(cantidadSaltos);
      $("#rowOtros").find(".rowSpanTD").attr("rowspan", cantidadSaltos + 1);
      cantidadSaltos -= 1;
      let ultimoTR;
      if (cantidadSaltos > 0) {
        // Si cantidadSaltos es mayor que 0, buscar el último tr cubierto por el rowspan
        ultimoTR = $("#rowOtros")
          .nextAll("tr")
          .eq(cantidadSaltos - 1);
      } else {
        // Si no hay filas adicionales, usar el siguiente tr después de #rowCursos
        ultimoTR = $("#rowOtros");
      }
      let nuevoTR =
        `
      <tr>
        <td>
          <div style="position: relative; display: inline-block; width: 55%;">
            <input type="text" class="otroInput inputTextFill tx-left-force" value="${value["codigo"]}"  style="width:100% !important; border: none; background: none; text-align: left; box-sizing: border-box;">
            <div class="suggestions-list"></div> <!-- Contenedor de sugerencias -->
          </div>
          <button data-type="Otro" class="tx-10 btn btn-info tx-10 searchTarifa">
                                                        <i class="fa-solid fa-search"></i>
                                                    </button></td>
        <td><input type="text" class="tx-left-force" value="${value["concepto"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

        <td><input type="text" class="tx-center-force ivaInput" value="${value["iva"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
            <td><input type="text" class="tx-center-force descInput" value="${value["descuento"]}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>

        <td class="tx-center"><input type="text" class="inporteOtro inputImporte tx-center-force" data-original="${value["importe"].replace("u20ac", "€")}" value="${value["importe"].replace("u20ac", "€")}" style="border: none; background: none; text-align: center; box-sizing: border-box;"></td>
      </tr>
      `;
      // Insertar el nuevo <tr> después del último
      ultimoTR.after(nuevoTR);

      // Capturar el último .alojamientoInput añadido
      let nuevoInputOtro = $(".otroInput").last();

      // Llamar a la función cargarDatosPorCodigo pasando el nuevo input como 'objeto'
      recalcularImportes();
      
    });
    $("#transferObs").val(data[0]["campoobservacionesgeneralTransfer_llegadas"]);
    $("#transferObs").text(data[0]["campoobservacionesgeneralTransfer_llegadas"]);
    let yaPagado = JSON.parse(data[0]["otrosArray"])[0][0].replace("u20ac","").replace(".", "").replace(",", ".");
    $("#YaPagado").val(formatearEur(convertirEurANumero(yaPagado.replace(".",","))) + "€");
    $("#agenteProforma").text(data[0]["agente_llegadas"]);
    $("#llegadaDia").val(fechaFormateadaLlegada);
    $("#llegadaSemana").val(obtenerSemanaDelAño(fechaParseadaLlegada));
    $("#grupoFact").text(data[0]["grupo_llegadas"]);
    $("#grupoAmigos").text(data[0]["grupoAmigos"]);
  })
  
});


$(document).on("input", ".descInput", function () {
  recalcularImportes();
});
$(document).on("input", "#descGrupoCurso", function () {
  recalcularImportes();
});
$(document).on("input", ".inporteAloja", function () {
  recalcularImportes();
});
$(document).on("input", "#descGrupoAloja", function () {
  recalcularImportes();
});
$(document).on("input", ".inporteOtro", function () {
  recalcularImportes();
});
$(document).on("input", "#descGrupoOtro", function () {
  recalcularImportes();
});
$(document).on("focusout",".inputImporte",function() {
    $(this).attr('data-original',$(this).val());
});
$(document).on("input",".ivaInput",function(){
  recalcularImportes();

})
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
  // Eliminar los puntos que separan los miles
  importe = importe.replace(/\./g, "");

  // Reemplazar la coma por un punto para que sea reconocida como decimal
  importe = importe.replace(",", ".");

  // Convertir el string a un número flotante
  return parseFloat(importe);
}
function obtenerSemanaDelAño(fecha) {
  // Copiar la fecha para no modificar el objeto original
  var fechaCopiada = new Date(fecha.getTime());

  // Establecer el primer día del año
  var primerDiaDelAño = new Date(fecha.getFullYear(), 0, 1);

  // Calcular el número de días entre la fecha actual y el primer día del año
  var diferenciaEnDias = Math.floor((fechaCopiada - primerDiaDelAño) / (24 * 60 * 60 * 1000));

  // Obtener el día de la semana del primer día del año (0 = domingo, 1 = lunes, etc.)
  var diaSemanaPrimerDia = primerDiaDelAño.getDay() || 7; // Ajuste para que 0 sea domingo y 1 sea lunes

  // Calcular el número de la semana
  var semanaNumero = Math.ceil((diferenciaEnDias + diaSemanaPrimerDia) / 7);

  return semanaNumero;
}

$("#guardarProformaBtn").on("click",function(){
  let paisFact = $("#paisFact").val();
  let provFact = $("#provFact").val();
  let ciudadFact = $("#ciudadFact").val();
  let cpFact = $("#cpFact").val();
  let direcFact = $("#direcFact").val();
  let tefFact = $("#tefFact").val();
  let movilFact = $("#movilFact").val();
  let correoFact = $("#correoFact").val();
  let cifFact = $("#cifFact").val();
  let nombreFacturacion = $("#nombreFacturacion").text();
  let llegadaNum = $("#llegadaNum").val();
  let nombreAlumno = $("#nombreAlumno").val();
  let sexoAlumno = $("#sexoAlumno").val();
  let idCabecera = $("#idCabecera").val();
  let idPie = $("#idPie").val();
  let jsonMatricula = {}
  $(".docenciaInput").each(function(index){
    let objeto = $(this).parent().parent().parent();
    let codigo = objeto.find(".docenciaInput").val();
    let concepto = objeto.children().eq(1).children().val();
    let iva = objeto.find(".ivaInput").val();
    let descuento = objeto.find(".descInput").val();
    let importe = objeto.find(".inputImporte").val();

    // Añadir los datos al jsonMatricula usando el codigo como clave o el index como clave única
    jsonMatricula[index] = {
      codigo: codigo,
      concepto: concepto,
      iva: iva,
      descuento: descuento,
      importe: importe
    };
  });
  //alojamineto
  let jsonAloja = {}
  $(".alojamientoInput").each(function(index){
    let objeto = $(this).parent().parent().parent();
    let codigo = objeto.find(".alojamientoInput").val();
    let concepto = objeto.children().eq(1).children().val();
    let iva = objeto.find(".ivaInput").val();
    let descuento = objeto.find(".descInput").val();
    let importe = objeto.find(".inputImporte").val();

    // Añadir los datos al jsonMatricula usando el codigo como clave o el index como clave única
    jsonAloja[index] = {
      codigo: codigo,
      concepto: concepto,
      iva: iva,
      descuento: descuento,
      importe: importe
    };
  });
  //otros
  let jsonOtros = {}
  $(".otroInput").each(function(index){
    let objeto = $(this).parent().parent().parent();
    let codigo = objeto.find(".otroInput").val();
    let concepto = objeto.children().eq(1).children().val();
    let iva = objeto.find(".ivaInput").val();
    let descuento = objeto.find(".descInput").val();
    let importe = objeto.find(".inputImporte").val();

    // Añadir los datos al jsonMatricula usando el codigo como clave o el index como clave única
    jsonOtros[index] = {
      codigo: codigo,
      concepto: concepto,
      iva: iva,
      descuento: descuento,
      importe: importe
    };
  });
  let idTransferLlegada = $("#idTransferLlegada").val();
  let idTransferLlegadaDia = $("#idTransferLlegadaDia").val();
  let idTransferLlegadaLugar = $("#idTransferLlegadaLugar").val();
  let idTransferLlegadaLugarEntrega = $("#idTransferLlegadaLugarEntrega").val();
  let idTransferRecogida = $("#idTransferRecogida").val();
  let idTransferRecogidaDia = $("#idTransferRecogidaDia").val();
  let idTransferRecogidaLugar = $("#idTransferRecogidaLugar").val();
  let idTransferRecogidaLugarEntrega = $("#idTransferRecogidaLugarEntrega").val();
  let llegadaDia = $("#llegadaDia").val();
  let llegadaSemana = $("#llegadaSemana").val();
  //tabla
  //totales //! mirar si se puede calcular en vez de recoger
  
  /* $("#totalCursos").val();
  $("#totalAloja").val();
  $("#totalOtros").val();
  $("#descuentoTotalCurso").val();
  $("#totalCursosDto").val();
  $("#descuentoTotalAloja").val();
  $("#totalAlojaDto").val();
  $("#descuentoTotalOtro").val();
  $("#totalOtrosDto").val();
  $("#totalSinIva").val();
  $("#totalConIva").val();
  $("#YaPagado").val(); */
  

  
  let fechaHoyFactura = $("#fechaHoyFactura").val();
  let numProforma = $("#numProforma").val();

  
  let agenteProforma = $("#agenteProforma").text();
  let grupoFact = $("#grupoFact").text();
  let grupoAmigos = $("#grupoAmigos").text();
  
  //A quien facturar 
  let aQuienFacturar = $('.radioQuienFactura:checked').next().find("span").text();

  let idLlegada = $("#idLlegada").val();
  let YaPagado = $("#YaPagado").val();

  let dataFactura = {
    idLlegada:idLlegada,
    paisFact: paisFact,
    ciudadFact: ciudadFact,
    provFact:provFact,
    cpFact: cpFact,
    direcFact: direcFact,
    tefFact: tefFact,
    movilFact: movilFact,
    correoFact: correoFact,
    cifFact: cifFact,
    nombreFacturacion: nombreFacturacion,
    llegadaNum: llegadaNum,
    nombreAlumno: nombreAlumno,
    sexoAlumno: sexoAlumno,
    matriculacion: jsonMatricula,
    alojamiento: jsonAloja,
    otros: jsonOtros,
    idTransferLlegada: idTransferLlegada,
    idTransferLlegadaDia: idTransferLlegadaDia,
    idTransferLlegadaLugar: idTransferLlegadaLugar,
    idTransferLlegadaLugarEntrega: idTransferLlegadaLugarEntrega,
    idTransferRecogida: idTransferRecogida,
    idTransferRecogidaDia: idTransferRecogidaDia,
    idTransferRecogidaLugar: idTransferRecogidaLugar,
    idTransferRecogidaLugarEntrega: idTransferRecogidaLugarEntrega,
    llegadaDia: llegadaDia,
    llegadaSemana: llegadaSemana,
    fechaHoyFactura: fechaHoyFactura,
    numProforma: numProforma,
    serie:serie,
    agenteProforma: agenteProforma,
    grupoFact: grupoFact,
    grupoAmigos: grupoAmigos,
    aQuienFacturar: aQuienFacturar,
    YaPagado: YaPagado
  };
  $.post("../../controller/llegadas.php?op=actualizarProforma",{dataFactura:dataFactura},function (data) {
    toastr.success("Proforma Editada");
  })
  console.log(dataFactura);
  
});
function obtenerNumeroSemana(fecha) {
  // Clonamos la fecha para no modificar el original
  let fechaClone = new Date(Date.UTC(fecha.getFullYear(), fecha.getMonth(), fecha.getDate()));

  // Establecemos el día en jueves (4) según el estándar ISO 8601
  fechaClone.setUTCDate(fechaClone.getUTCDate() + 4 - (fechaClone.getUTCDay() || 7));

  // Calculamos el inicio del año en la primera semana del mismo estándar
  let inicioAño = new Date(Date.UTC(fechaClone.getUTCFullYear(), 0, 1));

  // Calculo del número de semana
  let numeroSemana = Math.ceil(((fechaClone - inicioAño) / 86400000 + 1) / 7);

  return numeroSemana;
}


 // Función principal que genera el archivo XML cuando el documento está listo.
  // Definir el namespace que usaremos para Facturae
  var namespaceURI = "http://www.facturae.es/Facturae/2014/v3.2.1/Facturae";
 /*    // Namespace Facturae
    const namespaceURI = "http://www.facturae.es/Facturae/2014/v3.2.1/Facturae";
    const dsNamespace = "http://www.w3.org/2000/09/xmldsig#";

    // Crear el documento XML con el nodo raíz 'Facturae' y asignar los namespaces
    const root = xmlDoc.documentElement;
    root.setAttribute("xmlns:fe", namespaceURI);
    root.setAttribute("xmlns:ds", dsNamespace); // Namespace para firmas digitales */


    function generarFacturaE() {
        
      $.ajax({
      url: `https://restcountries.com/v3.1/name/España`,
      method: 'GET',
      success: function (data) {

          let provFact = $("#provFact").val();
          let paisFact = $("#paisFact").val();
          let ciudadFact = $("#ciudadFact").val();
          let cpFact = $("#cpFact").val();
          let direcFact = $("#direcFact").val();
          let tefFact = $("#tefFact").val();
          let movilFact = $("#movilFact").val();
          let correoFact = $("#correoFact").val();
          let cifFact = $("#cifFact").val();
          let nombreFacturacion = $("#nombreFacturacion").text();
          let llegadaNum = $("#llegadaNum").val();
          let nombreAlumno = $("#nombreAlumno").val();
          let sexoAlumno = $("#sexoAlumno").val();
          let idCabecera = $("#idCabecera").val();
          let idPie = $("#idPie").val();
          $(".docenciaInput").each(function(index){
            let objeto = $(this).parent().parent().parent();
            let codigo = objeto.find(".docenciaInput").val();
            let concepto = objeto.children().eq(1).children().val();
            let iva = objeto.find(".ivaInput").val();
            let descuento = objeto.find(".descInput").val();
            let importe = objeto.find(".inputImporte").val();
          });

          $(".alojamientoInput").each(function(index){
            let objeto = $(this).parent().parent().parent();
            let codigo = objeto.find(".alojamientoInput").val();
            let concepto = objeto.children().eq(1).children().val();
            let iva = objeto.find(".ivaInput").val();
            let descuento = objeto.find(".descInput").val();
            let importe = objeto.find(".inputImporte").val();
          });

          $(".otroInput").each(function(index){
            let objeto = $(this).parent().parent().parent();
            let codigo = objeto.find(".otroInput").val();
            let concepto = objeto.children().eq(1).children().val();
            let iva = objeto.find(".ivaInput").val();
            let descuento = objeto.find(".descInput").val();
            let importe = objeto.find(".inputImporte").val();
          });
          let idTransferLlegada = $("#idTransferLlegada").val();
          let idTransferLlegadaDia = $("#idTransferLlegadaDia").val();
          let idTransferLlegadaLugar = $("#idTransferLlegadaLugar").val();
          let idTransferLlegadaLugarEntrega = $("#idTransferLlegadaLugarEntrega").val();
          let idTransferRecogida = $("#idTransferRecogida").val();
          let idTransferRecogidaDia = $("#idTransferRecogidaDia").val();
          let idTransferRecogidaLugar = $("#idTransferRecogidaLugar").val();
          let idTransferRecogidaLugarEntrega = $("#idTransferRecogidaLugarEntrega").val();
          let llegadaDia = $("#llegadaDia").val();
          let llegadaSemana = $("#llegadaSemana").val();
          let fechaHoyFactura = $("#fechaHoyFactura").val();
          let numProforma = $("#numProforma").val(); 
          let agenteProforma = $("#agenteProforma").text();
          let grupoFact = $("#grupoFact").text();
          let grupoAmigos = $("#grupoAmigos").text();
          let aQuienFacturar = $('.radioQuienFactura:checked').next().find("span").text();
          let idLlegada = $("#idLlegada").val();
          let totalSinIva = parseFloat($("#totalSinIva").text().replace("€","")).toFixed(8);
          let totalConIva = parseFloat($("#totalConIva").text().replace("€","")).toFixed(8);
          console.log("🚀 ~ generarFacturaE ~ totalConIva:", totalConIva)
          let YaPagado = parseFloat($("#YaPagado").val().replace("€","")).toFixed(8);
          // Crear un nuevo XMLDocument con el namespace URI y nodo raíz "fe:Facturae"
          const xmlDoc = document.implementation.createDocument(namespaceURI, "fe:Facturae", null);
        
          // Obtener el nodo raíz del documento (fe:Facturae)
          const root = xmlDoc.documentElement;
        
          // Añadir el atributo de namespace "fe" al nodo raíz
          root.setAttribute("xmlns:fe", "http://www.facturae.es/Facturae/2014/v3.2.1/Facturae");
        
          // Añadir el atributo de namespace "ds" al nodo raíz
          root.setAttribute("xmlns:ds", "http://www.w3.org/2000/09/xmldsig#");
        
          // Creación del elemento FileHeader
          const fileHeader = xmlDoc.createElement("FileHeader");
        
          // Añadir el nodo SchemaVersion a FileHeader con el valor "3.2.1" (versión de la factura)
          fileHeader.appendChild(createTextElement(xmlDoc, "SchemaVersion", "3.2.1"));
        
          // Añadir el nodo Modality a FileHeader con el valor "I" (modalidad de la factura)
          fileHeader.appendChild(createTextElement(xmlDoc, "Modality", "I"));
        
          // Añadir el nodo InvoiceIssuerType a FileHeader con el valor "EM" (tipo de emisor)
          fileHeader.appendChild(createTextElement(xmlDoc, "InvoiceIssuerType", "EM"));
        
          // Creación del nodo Batch dentro de FileHeader
          const batch = xmlDoc.createElement("Batch");
        
          // Añadir el identificador del lote BatchIdentifier con el valor específico de la factura
          batch.appendChild(createTextElement(xmlDoc, "BatchIdentifier", numProforma));
        
          // Añadir el número de facturas InvoicesCount dentro de Batch (en este caso, "1")
          batch.appendChild(createTextElement(xmlDoc, "InvoicesCount", "1"));
        
          // Creación del nodo TotalInvoicesAmount (total del importe de todas las facturas en el lote)
          const totalInvoicesAmount = xmlDoc.createElement("TotalInvoicesAmount");
        
          // Añadir el importe total al nodo TotalInvoicesAmount
          totalInvoicesAmount.appendChild(createTextElement(xmlDoc, "TotalAmount", totalConIva));
          batch.appendChild(totalInvoicesAmount);
          
          let totalRestante = totalConIva - YaPagado;
          totalRestante = parseFloat(totalRestante).toFixed(8)

          // Creación del nodo TotalOutstandingAmount (importe total pendiente)
          const totalOutstandingAmount = xmlDoc.createElement("TotalOutstandingAmount");
        
          // Añadir el importe total pendiente
          totalOutstandingAmount.appendChild(createTextElement(xmlDoc, "TotalAmount", totalRestante));
          batch.appendChild(totalOutstandingAmount);
        
          // Creación del nodo TotalExecutableAmount (importe total ejecutable)
          const totalExecutableAmount = xmlDoc.createElement("TotalExecutableAmount");
        
          // Añadir el importe total ejecutable
          totalExecutableAmount.appendChild(createTextElement(xmlDoc, "TotalAmount", totalRestante));
          batch.appendChild(totalExecutableAmount);
        
          // Añadir el código de moneda InvoiceCurrencyCode en Batch ("EUR")
          batch.appendChild(createTextElement(xmlDoc, "InvoiceCurrencyCode", "EUR"));
        
          // Añadir el nodo Batch al FileHeader
          fileHeader.appendChild(batch);
        
          // Añadir FileHeader al nodo raíz
          root.appendChild(fileHeader);
        
          // Creación del elemento Parties (para incluir al comprador y al vendedor)
          const parties = xmlDoc.createElement("Parties");
        
          // Creación del nodo SellerParty (datos del vendedor)
          const sellerParty = xmlDoc.createElement("SellerParty");
        
          // Creación del nodo TaxIdentification para identificación fiscal del vendedor //! RECOGER DE EMPRESA
          const sellerTaxIdentification = xmlDoc.createElement("TaxIdentification");
          sellerTaxIdentification.appendChild(createTextElement(xmlDoc, "PersonTypeCode", "J")); // Tipo de persona: Jurídica
          sellerTaxIdentification.appendChild(createTextElement(xmlDoc, "ResidenceTypeCode", "R")); // Tipo de residencia
          sellerTaxIdentification.appendChild(createTextElement(xmlDoc, "TaxIdentificationNumber", "B44761906")); // NIF del vendedor
          sellerParty.appendChild(sellerTaxIdentification);
        
          // Creación del nodo LegalEntity para la entidad legal del vendedor
          const legalEntity = xmlDoc.createElement("LegalEntity");
          legalEntity.appendChild(createTextElement(xmlDoc, "CorporateName", "COSTA DE VALENCIA SL")); // Nombre de la entidad
        
          // Creación del nodo AddressInSpain para la dirección del vendedor
          const addressInSpain = xmlDoc.createElement("AddressInSpain");
          addressInSpain.appendChild(createTextElement(xmlDoc, "Address", "C. del Dr. Josep Juan Dómine, 18, 1")); // Dirección
          addressInSpain.appendChild(createTextElement(xmlDoc, "PostCode", "46021")); // Código postal
          addressInSpain.appendChild(createTextElement(xmlDoc, "Town", "Poblats Marítims/Valencia")); // Ciudad
          addressInSpain.appendChild(createTextElement(xmlDoc, "Province", "Comunidad Valenciana")); // Provincia
          addressInSpain.appendChild(createTextElement(xmlDoc, "CountryCode", "ESP")); // Código de país
          legalEntity.appendChild(addressInSpain);
        
          // Añadir la dirección a la entidad legal y ésta al vendedor
          sellerParty.appendChild(legalEntity);
          parties.appendChild(sellerParty);
        
          // Creación del nodo BuyerParty (datos del comprador)
          const buyerParty = xmlDoc.createElement("BuyerParty");
        
          const paisesUE = [
            "Alemania", "Austria", "Bélgica", "Bulgaria", "Chipre", "Croacia", "Dinamarca", "Eslovaquia", "Eslovenia",
            "España", "Estonia", "Finlandia", "Francia", "Grecia", "Hungría", "Irlanda", "Italia", "Letonia", "Lituania",
            "Luxemburgo", "Malta", "Países Bajos", "Polonia", "Portugal", "República Checa", "Rumanía", "Suecia"
          ];
          let residenciaCode = "";
          if (paisFact === "España") {
            residenciaCode = "R"; //Residente
          }
          // Verificar si el país está en la lista de la Unión Europea
          else if (paisesUE.includes(paisFact)) {
            residenciaCode = "U";
          }
          // En cualquier otro caso, se considera fuera de la UE
          else {
            residenciaCode = "E";
          }

          // Creación del nodo TaxIdentification para identificación fiscal del comprador
          const buyerTaxIdentification = xmlDoc.createElement("TaxIdentification");
          buyerTaxIdentification.appendChild(createTextElement(xmlDoc, "PersonTypeCode", "F")); // Tipo de persona: Física
          buyerTaxIdentification.appendChild(createTextElement(xmlDoc, "ResidenceTypeCode", residenciaCode)); // Tipo de residencia //U -> Residente Union Europea //E -> Fueara de la union europea //R -> Residente en españa
          buyerTaxIdentification.appendChild(createTextElement(xmlDoc, "TaxIdentificationNumber", "44927665V")); // NIF del comprador
          buyerParty.appendChild(buyerTaxIdentification);
        
          // Creación del nodo Individual para la información del comprador

          let nomAlumnoSeparado = nombreAlumno.split(" ");

          const individual = xmlDoc.createElement("Individual");
          individual.appendChild(createTextElement(xmlDoc, "Name", nomAlumnoSeparado[0])); // Nombre del comprador
          individual.appendChild(createTextElement(xmlDoc, "FirstSurname", nomAlumnoSeparado[1] + " " + nomAlumnoSeparado[2])); // Primer apellido del comprador
          // Creación del nodo AddressInSpain para la dirección del comprador
          const buyerAddressInSpain = xmlDoc.createElement("AddressInSpain");
          buyerAddressInSpain.appendChild(createTextElement(xmlDoc, "Address", direcFact)); // Dirección
          buyerAddressInSpain.appendChild(createTextElement(xmlDoc, "PostCode", cpFact)); // Código postal
          buyerAddressInSpain.appendChild(createTextElement(xmlDoc, "Town", ciudadFact)); // Ciudad
          buyerAddressInSpain.appendChild(createTextElement(xmlDoc, "Province", provFact)); // Provincia //!TODO: AGREGAR PROVINCIAS AL FORM



          buyerAddressInSpain.appendChild(createTextElement(xmlDoc, "CountryCode", data[0].cca3)); // Código de país
          individual.appendChild(buyerAddressInSpain);
        
          // Añadir la dirección al nodo Individual y éste al nodo del comprador
          buyerParty.appendChild(individual);
          parties.appendChild(buyerParty);
          root.appendChild(parties);
        
          // Creación del elemento Invoices
          const invoices = xmlDoc.createElement("Invoices");
        
          // Creación del nodo Invoice (factura)
          const invoice = xmlDoc.createElement("Invoice");
        
          // Creación del nodo InvoiceHeader (encabezado de la factura)
          const invoiceHeader = xmlDoc.createElement("InvoiceHeader");
          invoiceHeader.appendChild(createTextElement(xmlDoc, "InvoiceNumber", numProforma)); // Número de factura
          invoiceHeader.appendChild(createTextElement(xmlDoc, "InvoiceSeriesCode", $("#serie").val())); // Serie de factura
          invoiceHeader.appendChild(createTextElement(xmlDoc, "InvoiceDocumentType", "FC")); // Tipo de documento
          invoiceHeader.appendChild(createTextElement(xmlDoc, "InvoiceClass", "OO")); // Clase de factura
          invoice.appendChild(invoiceHeader);
        
          // Creación del nodo InvoiceIssueData (datos de emisión)
          const invoiceIssueData = xmlDoc.createElement("InvoiceIssueData");
          invoiceIssueData.appendChild(createTextElement(xmlDoc, "IssueDate", "2024-03-28")); // Fecha de emisión
        
          // Creación del nodo InvoicingPeriod (período de facturación)
          const invoicingPeriod = xmlDoc.createElement("InvoicingPeriod");
          invoicingPeriod.appendChild(createTextElement(xmlDoc, "StartDate", "2024-03-28")); // Fecha inicio //TODO: NO SE QUE ES - FECHA INICIO
          invoicingPeriod.appendChild(createTextElement(xmlDoc, "EndDate", "2024-03-28")); // Fecha fin //TODO: NO SE QUE ES - FECHA INICIO + 1 AÑO
          invoiceIssueData.appendChild(invoicingPeriod);
        
          // Añadir los códigos de moneda y el idioma a InvoiceIssueData
          invoiceIssueData.appendChild(createTextElement(xmlDoc, "InvoiceCurrencyCode", "EUR"));
          invoiceIssueData.appendChild(createTextElement(xmlDoc, "TaxCurrencyCode", "EUR"));
          invoiceIssueData.appendChild(createTextElement(xmlDoc, "LanguageName", "es"));
          invoice.appendChild(invoiceIssueData);
        
          // Creación de TaxesOutputs (impuestos)
          const taxesOutputs = xmlDoc.createElement("TaxesOutputs");//TODO: Aqui mostrar cada uno de los ivas independientemente de si es de docencia,...

          $(".inputTextFill ").each(function(){
            let iva = parseFloat($(this).parent().parent().next().next().find("input").val().replace("%","").trim()).toFixed(2);
            let importe = parseFloat($(this).parent().parent().next().next().next().next().find("input").val().replace("€","")).toFixed(2);
            let cuota = importe * (iva / 100);
            cuota = parseFloat(cuota).toFixed(2)
            const tax1 = createTaxElement(xmlDoc, "01", iva, importe, cuota); // Impuesto 1
            taxesOutputs.appendChild(tax1);

          });
          /* const tax2 = createTaxElement(xmlDoc, "01", "21", "100.00", "21.00"); // Impuesto 2
          taxesOutputs.appendChild(tax2); */
          invoice.appendChild(taxesOutputs);
        
          // Creación del nodo InvoiceTotals (totales de la factura)
          const invoiceTotals = xmlDoc.createElement("InvoiceTotals");
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalGrossAmount", totalSinIva)); // Importe bruto total
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalGeneralDiscounts", "10.0")); // Descuentos generales
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalGeneralSurcharges", "0.0")); // Recargos generales
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalGrossAmountBeforeTaxes", totalSinIva)); // Importe bruto antes de impuestos
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalTaxOutputs", "10521.00")); // Total de impuestos aplicados
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalTaxesWithheld", "0.0")); // Total de impuestos retenidos
          invoiceTotals.appendChild(createTextElement(xmlDoc, "InvoiceTotal", "60621.00")); // Total de la factura
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalOutstandingAmount", "60621.00")); // Total pendiente
          invoiceTotals.appendChild(createTextElement(xmlDoc, "TotalExecutableAmount", "60621.00")); // Total ejecutable
          invoice.appendChild(invoiceTotals);
        
          // Creación del nodo Items (líneas de la factura)
          const items = xmlDoc.createElement("Items");
          const taxesForAloja = [
            { typeCode: "01", rate: "21", taxableBase: "50000.00", amount: "10500.00" },
            { typeCode: "01", rate: "10", taxableBase: "30000.00", amount: "3000.00" }
          ];
          const taxesForDocencia = [
            { typeCode: "01", rate: "10", taxableBase: "20000.00", amount: "2000.00" }
          ];
          const invoiceLine1 = createInvoiceLine(
            xmlDoc,
            "Alojamiento - Apartamento Compartido con estudiantes de la escuela - 1 / Hi - HABITACIÓN INDIVIDUAL",
            "1",
            "01",
            "50000.00",
            "50000.00",
            "50000.00",
            taxesForAloja[0]
          ); // Línea 1 de factura
          const invoiceLine3 = createInvoiceLine(
            xmlDoc,
            "Alojamiento - Apartamento Compartido con estudiantes de la escuela - 1 / Hi - HABITACIÓN INDIVIDUAL",
            "1",
            "01",
            "30000.00",
            "30000.00",
            "30000.00",
            taxesForAloja[1]
          );     

          const invoiceLine2 = createInvoiceLine(
            xmlDoc,
            "Docencia - Curso intensivo 20 esp - 2 horas",
            "1",
            "01",
            "100.00",
            "100.00",
            "100.00",
            taxesForDocencia[0]
          ); // Línea 2 de factura
          items.appendChild(invoiceLine1);
          items.appendChild(invoiceLine3);
          items.appendChild(invoiceLine2);
          invoice.appendChild(items);
        
          // Creación del nodo PaymentDetails (detalles de pago)
          const paymentDetails = xmlDoc.createElement("PaymentDetails");
          const installment = xmlDoc.createElement("Installment");
          installment.appendChild(createTextElement(xmlDoc, "InstallmentDueDate", "2024-04-27")); // Fecha de vencimiento
          installment.appendChild(createTextElement(xmlDoc, "InstallmentAmount", "60621.00")); // Monto del pago
          installment.appendChild(createTextElement(xmlDoc, "PaymentMeans", "04")); // Medio de pago
          paymentDetails.appendChild(installment);
          invoice.appendChild(paymentDetails);
        
          // Añadir la factura al nodo Invoices y éste al nodo raíz
          invoices.appendChild(invoice);
          root.appendChild(invoices);
        
          // Serializar el XML y convertirlo en un archivo Blob para descarga
          const serializer = new XMLSerializer();
          const xmlString = serializer.serializeToString(xmlDoc);

          // Añadir manualmente la declaración inicial XML al principio
          const xmlWithDeclaration = `<?xml version="1.0" encoding="UTF-8"?>\n${xmlString}`;

          // Convertir la cadena XML completa en un archivo Blob para descarga
          const blob = new Blob([xmlWithDeclaration], { type: "application/xml" });
        
          // Crear un enlace para la descarga del archivo XML
          const link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = "facturaE.xml";
        
          // Ejecutar la descarga del archivo y limpiar el enlace del DOM
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          
        }
    });
    }
    

// Función auxiliar para crear nodos de texto
function createTextElement(xmlDoc, tagName, textContent) {
  const element = xmlDoc.createElement(tagName);
  element.textContent = textContent;
  return element;
}

// Función auxiliar para crear un elemento Tax
function createTaxElement(xmlDoc, taxTypeCode, taxRate, taxableBaseAmount, taxAmount) {
  const tax = xmlDoc.createElement("Tax");
  tax.appendChild(createTextElement(xmlDoc, "TaxTypeCode", taxTypeCode));
  tax.appendChild(createTextElement(xmlDoc, "TaxRate", taxRate));
  
  const taxableBase = xmlDoc.createElement("TaxableBase");
  taxableBase.appendChild(createTextElement(xmlDoc, "TotalAmount", taxableBaseAmount));
  tax.appendChild(taxableBase);

  const taxAmountElement = xmlDoc.createElement("TaxAmount");
  taxAmountElement.appendChild(createTextElement(xmlDoc, "TotalAmount", taxAmount));
  tax.appendChild(taxAmountElement);

  return tax;
}

// Función auxiliar para crear un elemento InvoiceLine
// Función auxiliar para crear un elemento InvoiceLine con múltiples impuestos
function createInvoiceLine(xmlDoc, description, quantity, unitOfMeasure, unitPrice, totalCost, grossAmount, taxes) {
  const invoiceLine = xmlDoc.createElement("InvoiceLine");

  // Descripción y detalles del artículo
  invoiceLine.appendChild(createTextElement(xmlDoc, "ItemDescription", description));
  invoiceLine.appendChild(createTextElement(xmlDoc, "Quantity", quantity));
  invoiceLine.appendChild(createTextElement(xmlDoc, "UnitOfMeasure", unitOfMeasure));
  invoiceLine.appendChild(createTextElement(xmlDoc, "UnitPriceWithoutTax", unitPrice));
  invoiceLine.appendChild(createTextElement(xmlDoc, "TotalCost", totalCost));
  invoiceLine.appendChild(createTextElement(xmlDoc, "GrossAmount", grossAmount));

  // Crear el nodo TaxesOutputs para los impuestos específicos de esta línea
  const taxesOutputs = xmlDoc.createElement("TaxesOutputs");

  // Iterar sobre el arreglo de impuestos y añadir cada impuesto a TaxesOutputs
      const taxElement = xmlDoc.createElement("Tax");
      taxElement.appendChild(createTextElement(xmlDoc, "TaxTypeCode", taxes.typeCode));
      taxElement.appendChild(createTextElement(xmlDoc, "TaxRate", taxes.rate));
      
      const taxableBase = xmlDoc.createElement("TaxableBase");
      taxableBase.appendChild(createTextElement(xmlDoc, "TotalAmount", taxes.taxableBase));
      taxElement.appendChild(taxableBase);

      const taxAmountElement = xmlDoc.createElement("TaxAmount");
      taxAmountElement.appendChild(createTextElement(xmlDoc, "TotalAmount", taxes.amount));
      taxElement.appendChild(taxAmountElement);

      // Añadir el impuesto completo a TaxesOutputs
      taxesOutputs.appendChild(taxElement);

  // Añadir TaxesOutputs a la línea de factura
  invoiceLine.appendChild(taxesOutputs);

  return invoiceLine;
}


$("#facturaeButton").on("click",function(){
  generarFacturaE();
});
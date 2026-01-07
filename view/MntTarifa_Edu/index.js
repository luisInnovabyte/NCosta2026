//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "tarifaAloja_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "tarifaAloja_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-tarifaAloja-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-tarifaAloja-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var opcionesSingular = {
  0: 'SIN UNIDAD DE MEDIDA',
  1: 'Día',
  2: 'Día extra',
  3: 'Semana',
  4: 'Quincena',
  5: 'Mes',
  6: 'Trimestre',
  7: 'Año',
  8: 'Oferta especial',
  9: 'Hora',
  10: 'Descuento',
  11: 'Viaje'
};

var opcionesPlural = {
  0: 'SIN UNIDAD DE MEDIDA',
  1: 'Días',
  2: 'Días extra',
  3: 'Semanas',
  4: 'Quincenas',
  5: 'Meses',
  6: 'Trimestres',
  7: 'Años',
  8: 'Oferta especial',
  9: 'Horas',
  10: 'Descuento',
  11: 'Viajes'
};
//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
//* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//

var isDark = isColorDark("#000000"); //? TRUE SI EL COLOR ES OSCURO FALSE SI ES CLARO

var colorLetra = "black";

//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
//* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//

var tarifaAloja_table = $("#" + idDatatables + "").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idTarifasAloja" },
    { name: "codigo" },
    { name: "nombre" },
    { name: "medidaTarifasAloja" },
    { name: "importeTarifasAloja", className: "text-center wd-30" },
    { name: "descuento", className: "text-center wd-30" },
    { name: "cta1TarifasAloja", className: "tx-center wd-20" },
    { name: "cta2TarifasAloja", className: "tx-center wd-20" },
    { name: "cta3TarifasAloja", className: "tx-center wd-20" },
    { name: "tipo" },
    { name: "iva", className: "text-center wd-30" },
    { name: "estTarifasAloja" },
    { name: "accion", className: "text-center" },
  ],
  columnDefs: [
    //idTarifasAloja
    { targets: [0], orderData: [0], visible: false },
    //idTiposAloja_TarifaAloja
    { targets: [1], orderData: [1], visible: true },
    //descrTarifaAlojaInterna
    { targets: [2], orderData: [2], visible: true },
    //unidadTarifasAloja
    { targets: [3], orderData: [3], visible: true },
    //medidaTarifasAloja
    { targets: [4], orderData: [4], visible: true },
    //importeTarifasAloja
    { targets: [5], orderData: false, visible: true },
    //cta1TarifasAloja
    { targets: [6], orderData: false, visible: false },
    //cta2TarifasAloja
    { targets: [7], orderData: false, visible: false },
    //cta3TarifasAloja
    { targets: [8], orderData: false, visible: false },
    //iva
    { targets: [9], orderData: false, visible: true },
    //estTarifasAloja
    { targets: [10], orderData: [9], visible: true },
    //accion
    { targets: [11], orderData: false, visible: true },
    //accion
    { targets: [12], orderData: false, visible: true },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },

  ajax: {
    url: "../../controller/" + phpPrincipal + "?op=listarTarifasAloja",
    type: "get",
    dataType: "json",
    cache: false,
    serverSide: true,
    processData: true,
    beforeSend: function () {
      //    $('.submitBtn').attr("disabled","disabled");
      //    $('#usuario_data').css("opacity","");
    },
    complete: function (data) {},
    error: function (e) {
      console.log(e.responseText);
    },
    orderFixed: [[1, "asc"]],
    searchBuilder: {
      // Las columnas que van a aparecer en el desplegable para ser buscadas
      columns: [1, 2, 3, 4, 5],
    },
  },
}); // del DATATABLE
$('#FootCodigo').on('keyup', function () {
  tarifaAloja_table
      .columns(1)
      .search(this.value)
      .draw();
});
$('#FootDescripcion').on('keyup', function () {
  tarifaAloja_table
      .columns(2)
      .search(this.value)
      .draw();
});
$('#FootMedida').on('keyup', function () {
  tarifaAloja_table
      .columns(3)
      .search(this.value)
      .draw();
});
$('#FootImporte').on('keyup', function () {
  tarifaAloja_table
      .columns(4)
      .search(this.value)
      .draw();
});
$('#FootDescuento').on('keyup', function () {
  tarifaAloja_table
      .columns(5)
      .search(this.value)
      .draw();
});
$('#FootTipo').on('keyup', function () {
  tarifaAloja_table
      .columns(9)
      .search(this.value)
      .draw();
});
$('#FootIva').on('keyup', function () {
  tarifaAloja_table
      .columns(10)
      .search(this.value)
      .draw();
});
//* ************* ********** *////* ************* ********** *////* ************* ********** *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *////* CONFIGURACION DATATABLES *//
//* ************* ********** *////* ************* ********** *////* ************* ********** *//

$("#" + idDatatables + "")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });
$("#" + idDatatables + "").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
$("#" + idDatatables).DataTable().columns([0, 6, 7, 8]).visible(false);

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  // 1. RESETEO DE VALIDACIONES PREVIAS
  const form = $('#insertar-tarifaAloja-form');
  const campos = form.find('input, select, textarea');
  campos.removeClass('is-valid is-invalid'); // Limpiar todas las clases previas

  // 2. RECOGIDA DE VALORES
  const codTarifa = form.find('input[name="codTarifaAloja"]').val()?.trim() || '';
  const descrTarifa = form.find('input[name="DescrTarifaAloja"]').val()?.trim() || '';
  const unidadTarifa = form.find('input[name="unidadTarifasAloja"]').val()?.trim() || '';
  const importeTarifa = form.find('input[name="importeTarifasAloja"]').val()?.trim() || '';
  const descuentoTarifa = form.find('input[name="descuentoTarifas"]').val()?.trim() || '';
  
  const ivaTarifa = form.find('select[name="selectIva"]').val();
  const departamento = form.find('select[name="departamentoTarifa"]').val();

  // 3. VALIDACIÓN MANUAL CAMPO POR CAMPO
  let camposInvalidos = [];

  const marcarCampo = (selector, valido, nombreCampo) => {
    const campo = form.find(selector);
    if (valido) {
      campo.addClass('is-valid').removeClass('is-invalid');
    } else {
      campo.addClass('is-invalid').removeClass('is-valid');
      camposInvalidos.push(nombreCampo);
    }
  };

  // Validaciones
  marcarCampo('input[name="codTarifaAloja"]', codTarifa !== '', 'Código');
  marcarCampo('input[name="DescrTarifaAloja"]', descrTarifa !== '', 'Descripción');
  marcarCampo('input[name="unidadTarifasAloja"]', unidadTarifa !== '', 'Cantidad');

  const importeValido = importeTarifa !== '' && !isNaN(importeTarifa);
  marcarCampo('input[name="importeTarifasAloja"]', importeValido, 'Importe');

  const descuentoValido = !isNaN(descuentoTarifa) && parseFloat(descuentoTarifa) >= -100 && parseFloat(descuentoTarifa) <= 100;
  marcarCampo('input[name="descuentoTarifas"]', descuentoValido, 'Descuento');

  marcarCampo('select[name="selectIva"]', ivaTarifa !== null && ivaTarifa !== '', 'IVA');
  marcarCampo('select[name="departamentoTarifa"]', departamento !== null && departamento !== '', 'Departamento');

  // 4. COMPROBACIÓN FINAL
  if (camposInvalidos.length > 0) {
    toastr.error(`Errores en: ${camposInvalidos.join(', ')}`);
    return false;
  }

  // 5. ENVÍO DEL FORMULARIO (si todo es válido)
  var formData = new FormData(form[0]);

  $.ajax({
    url: "../../controller/tarifaAloja_Edu.php?op=insertarTarifasAloja",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function(data) {
      $("#insertar-tarifaAloja-modal").modal("hide");
      $("#" + idDatatables + "").DataTable().ajax.reload(null, false);
      form[0].reset();
      campos.removeClass('is-valid is-invalid');

      // ✅ SweetAlert al finalizar con éxito
      Swal.fire({
        title: 'Tarifa agregada',
        text: 'La tarifa se insertó correctamente.',
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });
    },
    error: function(xhr) {
      toastr.error("Error al enviar los datos: " + (xhr.responseJSON?.message || ''));
    }
  });
}


//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
// Función que busca la clave en función del valor, tanto en plural como en singular
function buscarIndice(valor) {
  // Convertimos el valor a buscar a minúsculas
  var valorLower = valor.toLowerCase();

  // Primero buscamos en el array de plurales
  for (var key in opcionesPlural) {
      // Convertimos el valor del array a minúsculas para comparar
      if (opcionesPlural[key].toLowerCase() === valorLower) {
          return key;  // Si encontramos el valor en el plural, devolvemos la clave
      }
  }

  // Si no se encontró en el plural, buscamos en el singular
  for (var key in opcionesSingular) {
      // Convertimos el valor del array a minúsculas para comparar
      if (opcionesSingular[key].toLowerCase() === valorLower) {
          return key;  // Si encontramos el valor en el singular, devolvemos la clave
      }
  }

  return null;  // Si no se encuentra en ninguno de los dos, retornamos null
}
function cargarElemento(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID
  $.post(
    "../../controller/tarifaAloja_Edu.php?op=recogerEditar",
    { idTarifaAloja: idElemento },
    function (data) {
      data = JSON.parse(data);
      console.log(data);
      unidadMedidaSeparado = data[0]["unidad_tarifa"].split(" ");

      

// Ejemplo de uso:
var valorBuscado = data[0]["unidad_tarifa"];
var indice = buscarIndice(valorBuscado);


      $("#DescrTarifaAlojaE").val(data[0]["nombre_tarifa"]);
      $("#codTarifaAlojaE").val(data[0]["cod_tarifa"]);
      $("#idTarifasAloja").val(data[0]["idTarifa"]);
      $("#unidadTarifasAlojaE").val(data[0]["unidades_tarifa"]);
      $("#unidadMedidaTarifaPluralE").val(indice).trigger("change");
      $("#unidadMedidaTarifaSingularE").val(indice).trigger("change");
      if(data[0]["unidades_tarifa"] > 1){
        $("#unidadMedidaTarifaPluralE").removeClass("d-none");
        $("#unidadMedidaTarifaSingularE").addClass("d-none");
      } else {
        $("#unidadMedidaTarifaSingularE").removeClass("d-none");
        $("#unidadMedidaTarifaPluralE").addClass("d-none");

      }
      $("#importeTarifasAlojaE").val(data[0]["precio_tarifa"]);
      $("#descuentoTarifasE").val(data[0]["descuento_tarifa"]);
      $("#cta1TarifasAlojaE").val(data[0]["cuenta1_tarifa"]);
      $("#cta2TarifasAlojaE").val(data[0]["cuenta2_tarifa"]);
      $("#cta3TarifasAlojaE").val(data[0]["cuenta3_tarifa"]);
      $("#selectIvaE").val(data[0]["idIva"]).trigger("change");
      $("#departamentoTarifaE").val(data[0]["idDepartament_tarifa"]).trigger("change");
      $("#textTarifasAlojaE").val(data[0]["descripcion_tarifa"]);

      $("#" + idModalEditar + "").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
    }
  );
}

function editarElemento() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  // 1. RESETEO DE VALIDACIONES PREVIAS
  const form = $('#editar-tarifaAloja-form');
  const campos = form.find('input, select, textarea');
  campos.removeClass('is-valid is-invalid'); // Limpiar todas las clases previas

  // 2. RECOGIDA DE VALORES
  const codTarifa = form.find('input[name="codTarifaAlojaE"]').val()?.trim() || '';
  const descrTarifa = form.find('input[name="DescrTarifaAlojaE"]').val()?.trim() || '';
  const unidadTarifa = form.find('input[name="unidadTarifasAlojaE"]').val()?.trim() || '';
  const importeTarifa = form.find('input[name="importeTarifasAlojaE"]').val()?.trim() || '';
  const descuentoTarifa = form.find('input[name="descuentoTarifasE"]').val()?.trim() || '';
  const ivaTarifa = form.find('select[name="selectIvaE"]').val();
  const departamento = form.find('select[name="departamentoTarifaE"]').val();

  // 3. VALIDACIÓN MANUAL CAMPO POR CAMPO
  let camposInvalidos = [];

  const marcarCampo = (selector, valido, nombreCampo) => {
    const campo = form.find(selector);
    if (valido) {
      campo.addClass('is-valid').removeClass('is-invalid');
    } else {
      campo.addClass('is-invalid').removeClass('is-valid');
      camposInvalidos.push(nombreCampo);
    }
  };

  // Validaciones
  marcarCampo('input[name="codTarifaAlojaE"]', codTarifa !== '', 'Código');
  marcarCampo('input[name="DescrTarifaAlojaE"]', descrTarifa !== '', 'Descripción');
  marcarCampo('input[name="unidadTarifasAlojaE"]', unidadTarifa !== '', 'Cantidad');

  const importeValido = importeTarifa !== '' && !isNaN(importeTarifa);
  marcarCampo('input[name="importeTarifasAlojaE"]', importeValido, 'Importe');

  const descuentoValido = !isNaN(descuentoTarifa) && parseFloat(descuentoTarifa) >= -100 && parseFloat(descuentoTarifa) <= 100;
  marcarCampo('input[name="descuentoTarifasE"]', descuentoValido, 'Descuento');

  marcarCampo('select[name="selectIvaE"]', ivaTarifa !== null && ivaTarifa !== '', 'IVA');
  marcarCampo('select[name="departamentoTarifaE"]', departamento !== null && departamento !== '', 'Departamento');

  // 4. COMPROBACIÓN FINAL
  if (camposInvalidos.length > 0) {
    toastr.error(`Errores en: ${camposInvalidos.join(', ')}`); //? INFORMAR QUE HA DADO ERROR
    return false;
  }

  // 5. ENVÍO DEL FORMULARIO (si todo es válido)
  var formData = new FormData(form[0]);

  $.ajax({
    url: "../../controller/tarifaAloja_Edu.php?op=editarTarifasAloja",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function () {
      $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR

      // Notificación con SweetAlert2
      Swal.fire({
        title: 'Tarifa editada',
        text: 'Los cambios se guardaron correctamente.',
        icon: 'success',
        confirmButtonText: 'Aceptar'
      });

      $("#editar-tarifaAloja-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
    },
    error: function () {
      toastr.error("Error al actualizar la tarifa."); //? INFORMAR QUE HA DADO ERROR
    }
  });
}


//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstado(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/" + phpPrincipal + "?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      const respuesta = JSON.parse(data);
      if (respuesta.nuevoEstado == 1) {
        toastr.success("Tarifa activada exitosamente.");
      } else {
        toastr.info("Tarifa desactivada exitosamente.");
      }
      $("#" + idDatatables + "")
        .DataTable()
        .ajax.reload(null, false); //! NO TOCAR
    }
  );
}

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#" + idModalAgregar + "").on("show.bs.modal", function () {
  //TODO: MODIFICAR ID DEL MODAL DE AGREGAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
  $("#unidadTarifasAloja").val("1");
  $("#descuentoTarifas").val("0");
});

$("#selectMedidaTarifasAloja").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});
$("#selectMedidaTarifasAlojaE").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});

$("#selectMedidaTarifasAloja").val(null).trigger("change");
$("#selectMedidaTarifasAlojaE").val(null).trigger("change");
$("#selectIva").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});
$("#selectIvaE").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});
$("#departamentoTarifa").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});
$("#departamentoTarifaE").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});

$("#tipoTarifa").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});
$("#tipoTarifaE").select2({
  theme: "bootstrap-5",
  width: "100%",
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
});

$.ajax({
  url: "../../controller/medidasAloja_Edu.php?op=listarMedidasTiposAlojaSelect",
  type: "GET",
  dataType: "json",
  success: function (res) {
    if (res.length > 0) {
      for (var i = 0; i < res.length; i++) {
        $("#selectMedidaTarifasAloja").append(
          "<option value='" + res[i][0] + "'>" + res[i][1] + "</option>"
        );
        $("#selectMedidaTarifasAlojaE").append(
          "<option value='" + res[i][0] + "'>" + res[i][1] + "</option>"
        );
        $("#selectMedidaTarifasAloja").val(null).trigger("change");
        $("#selectMedidaTarifasAlojaE").val(null).trigger("change");
      }
    }
  },
  complete: function (res) {
    /* var idUsuarioPre = $("#selectTrabajadores").val();
            $("#selectPais").val(idUsuarioPre); */
  },
  error: function (error) {
    console.log(error);
  },
});

$.ajax({
  url: "../../controller/tarifaAloja_Edu.php?op=listarIvaSelect",
  type: "GET",
  dataType: "json",
  error: function (error) {
    console.log(error);
  },
  success: function (res) {
    console.log(res);
    if (res.length > 0) {
      for (var i = 0; i < res.length; i++) {
        $("#selectIva").append(
          "<option value='" + res[i]["idIva"] + "'>" + res[i]["descrIva"] + " %" + "</option>"
        );
        $("#selectIvaE").append(
          "<option value='" + res[i]["idIva"] + "'>" + res[i]["descrIva"] + " %" + "</option>"
        );
        $("#selectIva").val(null).trigger("change");
        $("#selectIvaE").val(null).trigger("change");
      }
    }
  },
  complete: function (res) {
    /* var idUsuarioPre = $("#selectTrabajadores").val();
      $("#selectPais").val(idUsuarioPre); */
  },
});

$.ajax({
  url: "../../controller/tarifaAloja_Edu.php?op=listarDepartamentosSelect",
  type: "GET",
  dataType: "json",
  error: function (error) {
    console.log(error);
  },
  success: function (res) {
    console.log(res);
    if (res.length > 0) {
      for (var i = 0; i < res.length; i++) {
        $("#departamentoTarifa").append(
          "<option value='" + res[i]["idDepartamento"] + "'>" + res[i]["nombreDepartamento"] + "</option>"
        );
        $("#departamentoTarifaE").append(
          "<option value='" + res[i]["idDepartamento"] + "'>" + res[i]["nombreDepartamento"] + "</option>"
        );
        $("#departamentoTarifa").val(null).trigger("change");
        $("#departamentoTarifaE").val(null).trigger("change");
      }
    }
  },
  complete: function (res) {
    /* var idUsuarioPre = $("#selectTrabajadores").val();
      $("#selectPais").val(idUsuarioPre); */
  },
});
$(document).ready(function() {
  // Inicialización de los select2
  $("#unidadMedidaTarifaPlural").select2({
      theme: "bootstrap-5",
      width: "100%",
      placeholder: $(this).data('placeholder'),
      closeOnSelect: true,
      language: {
          inputTooShort: function(args) {
              var remainingChars = args.minimum - args.input.length;
              return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
          },
          maximumSelected: function(e) {
              return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
          },
          noResults: function() {
              return 'No se encontraron resultados';
          },
          searching: function() {
              return 'Buscando...';
          }
      }
  }).val(0).trigger('change');

  $("#unidadMedidaTarifaSingular").select2({
      theme: "bootstrap-5",
      width: "100%",
      placeholder: $(this).data('placeholder'),
      closeOnSelect: true,
      language: {
          inputTooShort: function(args) {
              var remainingChars = args.minimum - args.input.length;
              return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
          },
          maximumSelected: function(e) {
              return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
          },
          noResults: function() {
              return 'No se encontraron resultados';
          },
          searching: function() {
              return 'Buscando...';
          }
      }
  }).val(0).trigger('change');

  // Función que se ejecuta cuando cambia el valor del input
 // Variables para controlar si el valor ya ha sido sincronizado
var valorSincronizadoSingular = false;
var valorSincronizadoPlural = false;

$('#unidadTarifasAloja').on('input change', function() {
    var valor = parseInt($(this).val());

    if (valor === 1 && !valorSincronizadoSingular) {
        // Solo sincronizar si no ha sido sincronizado antes
        $("#unidadMedidaTarifaSingular").val($("#unidadMedidaTarifaPlural").val()).trigger('change');

        // Marcar como sincronizado
        valorSincronizadoSingular = true;
        valorSincronizadoPlural = false; // Resetear el control opuesto para permitir futura sincronización

        $('#unidadMedidaTarifaSingular').next().removeClass('d-none');
        $('#unidadMedidaTarifaPlural').next().addClass('d-none');
    } else if (valor !== 1 && !valorSincronizadoPlural) {
        // Solo sincronizar si no ha sido sincronizado antes
        $("#unidadMedidaTarifaPlural").val($("#unidadMedidaTarifaSingular").val()).trigger('change');

        // Marcar como sincronizado
        valorSincronizadoPlural = true;
        valorSincronizadoSingular = false; // Resetear el control opuesto para permitir futura sincronización

        $('#unidadMedidaTarifaSingular').next().addClass('d-none');
        $('#unidadMedidaTarifaPlural').next().removeClass('d-none');
    }
});


  // Inicialmente ocultar el select singular si el valor del input no es 1
  $('#unidadTarifasAloja').trigger('change');
});

$(document).ready(function () {
  // Inicialización de los select2 para el formulario de editar
  $("#unidadMedidaTarifaPluralE").select2({
    theme: "bootstrap-5",
    width: "100%",
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
  });

  $("#unidadMedidaTarifaSingularE").select2({
    theme: "bootstrap-5",
    width: "100%",
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
  });

  // Función que se ejecuta cuando cambia el valor del input
  // Variables para controlar si el valor ya ha sido sincronizado
  var valorSincronizadoSingularE = false;
  var valorSincronizadoPluralE = false;

  $("#unidadTarifasAlojaE").on("input change", function () {
    var valor = parseInt($(this).val());

    if (valor === 1 && !valorSincronizadoSingularE) {
      // Solo sincronizar si no ha sido sincronizado antes
      $("#unidadMedidaTarifaSingularE")
        .val($("#unidadMedidaTarifaPluralE").val())
        .trigger("change");

      // Marcar como sincronizado
      valorSincronizadoSingularE = true;
      valorSincronizadoPluralE = false; // Resetear el control opuesto para permitir futura sincronización

      $("#unidadMedidaTarifaSingularE").next().removeClass("d-none");
      $("#unidadMedidaTarifaPluralE").next().addClass("d-none");
    } else if (valor !== 1 && !valorSincronizadoPluralE) {
      // Solo sincronizar si no ha sido sincronizado antes
      $("#unidadMedidaTarifaPluralE")
        .val($("#unidadMedidaTarifaSingularE").val())
        .trigger("change");

      // Marcar como sincronizado
      valorSincronizadoPluralE = true;
      valorSincronizadoSingularE = false; // Resetear el control opuesto para permitir futura sincronización

      $("#unidadMedidaTarifaSingularE").next().addClass("d-none");
      $("#unidadMedidaTarifaPluralE").next().removeClass("d-none");
    }
  });

  // Inicialmente ocultar el select singular si el valor del input no es 1
  $("#unidadTarifasAlojaE").trigger("change");
});

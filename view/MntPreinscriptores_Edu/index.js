


/************************************************************************************************************************************************** */
/* TIPO CURSO */

//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "cursodeseado_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "tipoCurso_Edu.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "agregar-cursodeseado-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-conocimiento-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var inputTipotConocimiento = "";

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

var tipoCurso_table = $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idTipoCurso" },
    { name: "nombreTipoCurso", className: "text-center"},
    { name: "estTipoCurso", className: "text-center" },
    { name: "acciones", className: "text-center" },
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },
    



    { targets: [2], orderData: false, visible: true , className: "text-center"},

    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=listarTipoCursoPreinscripciones",
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

$("#"+idDatatables+"")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros(idDatatables);
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#"+idDatatables+"").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//


function agregarElementoCursoDeseado() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  validateMinInput();
  validateMaxInput();
  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  var formData = new FormData($("#insertar")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE

    $.ajax({
      url: "../../controller/tipoCurso_Edu.php?op=insertarTipoCurso",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ file: tipoCursoIndex.js:68 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese codigo ya existe");
        } else {
          toastr.success("El tipo de curso se ha añadido");
        }
        $("#insertar-tipocurso-modal").modal("hide");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}


//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElementoCurso(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/tipoCurso_Edu.php?op=obtenerTipoCursoPorId",
    { idTipoCurso: idElemento },
    function (data) {
      var data = JSON.parse(data);
      $("#id-curso").val(idElemento);
      //Cargar datos
      $("#nombreCursoE").val(data[0].descrTipo);
      
      $("#editar-tipoCurso-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

     
    }
  ); // Recuperar datos del cliente
}

function editarElementoCurso() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editarCurso")[0]);

    $.ajax({
      url: "../../controller/tipoCurso_Edu.php?op=editarTipoCurso",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR
        if (data == 0) {
          toastr.error("Ese codigo ya existe");
        } else {
          toastr.success("El tipo de curso se ha editado");
        }
        $("#editar-tipoCurso-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

        $("#editar-tipoCurso-modal").modal("hide");
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstadoCurso(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/" + phpPrincipal + "?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR
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
  $("#minAlumTipo").val("1");
  $("#maxAlumTipo").val("2");
});
// Seleccionar los inputs
var $minAlumTipo = $("#minAlumTipo");
var $maxAlumTipo = $("#maxAlumTipo");
var $minAlumTipoE = $("#minAlum-Tipo");
var $maxAlumTipoE = $("#maxAlum-Tipo");

// Validar al cargar la página
validateMinInput();
validateMaxInput();

// Evento para validar cuando se cambia el valor de minAlumTipo
$minAlumTipo.on("input", function () {
  validateMinInput();
  validateMaxInput();
});

// Evento para validar cuando se cambia el valor de maxAlumTipo
$maxAlumTipo.on("input", function () {
  validateMaxInput();
  var maxValue = parseInt($maxAlumTipo.val(), 10);
  if (maxValue > 99) {
    $maxAlumTipo.val(99);
  }
});
$minAlumTipoE.on("input", function () {
  validateMinInput();
  validateMaxInput();
});

// Evento para validar cuando se cambia el valor de maxAlumTipo
$maxAlumTipoE.on("input", function () {
  validateMaxInput();
  var maxValue = parseInt($maxAlumTipoE.val(), 10);
  if (maxValue > 99) {
    $maxAlumTipoE.val(99);
  }
});

// Evento para impedir que el valor de maxAlumTipo supere 99 con la flecha hacia arriba
$maxAlumTipo.on("keydown", function (e) {
  var maxValue = parseInt($maxAlumTipo.val(), 10);
  if (maxValue >= 99 && e.key === "ArrowUp") {
    e.preventDefault();
  }
});
$maxAlumTipoE.on("keydown", function (e) {
  var maxValue = parseInt($maxAlumTipoE.val(), 10);
  if (maxValue >= 99 && e.key === "ArrowUp") {
    e.preventDefault();
  }
});

// Función para validar el valor mínimo y máximo de minAlumTipo
function validateMinInput() {
  var minValue = parseInt($minAlumTipo.val(), 10);
  var minValuee = parseInt($minAlumTipoE.val(), 10);
  if (isNaN(minValue) || minValue < 1) {
    $minAlumTipo.val(1);
  } else if (minValue > 98) {
    $minAlumTipo.val(98);
  }
  if (isNaN(minValuee) || minValuee < 1) {
    $minAlumTipoE.val(1);
  } else if (minValuee > 98) {
    $minAlumTipoE.val(98);
  }
}

// Función para validar el valor mínimo y máximo de maxAlumTipo
function validateMaxInput() {
  var minValue = parseInt($minAlumTipo.val(), 10);
  var maxValue = parseInt($maxAlumTipo.val(), 10);
  if (isNaN(maxValue) || maxValue < minValue + 1) {
    $maxAlumTipo.val(minValue + 1);
  } else if (maxValue > 99) {
    $maxAlumTipo.val(99);
  }

  var minValuee = parseInt($minAlumTipoE.val(), 10);
  var maxValuee = parseInt($maxAlumTipoE.val(), 10);
  if (isNaN(maxValuee) || maxValuee < minValuee + 1) {
    $maxAlumTipoE.val(minValuee + 1);
  } else if (maxValuee > 99) {
    $maxAlumTipoE.val(99);
  }
}
















/************************************************************************************************************************************************** */
/* AGENTES */


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

var agente_table = $("#agente_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
    { name: "ID" },
    { name: "nombreAgente", className: "text-center"},
    { name: "identificador", className: "text-center" },
    { name: "domicilio", className: "text-center" },
    { name: "correo", className: "text-center" },
    { name: "estado", className: "text-center" },
    { name: "acciones", className: "text-center" }


  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },

    { targets: [1], orderData: false, visible: true },
    



    { targets: [2], orderData: false, visible: true , className: "text-center"},

    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
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

$("#agente_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('agente_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#agente_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

// Limpia inputs y validaciones al abrir modal
$('#agregar-agentes-modal').on('show.bs.modal', function () {
  const form = $(this).find('form#insertarAgente');
  form[0].reset();
  form.find('input, select, textarea').removeClass('is-valid is-invalid');
});

function agregarElementoAgentes() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  // LIMPIAR VALIDACIONES PREVIAS
  $("#insertarAgente").find('input, select, textarea').removeClass('is-valid is-invalid');

  var formData = new FormData($("#insertarAgente")[0]);

  // Mostrar valores para depuración
  for (var pair of formData.entries()) {
    console.log(pair[0]+ ': ' + pair[1]);
  }

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS
  if (!validacion) {
    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=insertarAgentes",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese Agente ya existe");
        } else {
          toastr.success("El Agente se ha añadido");
          // Limpiar formulario tras éxito
          $("#insertarAgente")[0].reset();
          $("#insertarAgente").find('input, select, textarea').removeClass('is-valid is-invalid');
        }
        $("#agregar-agentes-modal").modal("hide");
        $("#agente_table").DataTable().ajax.reload(null, false);
      },
      error: function () {
        toastr.error("Error al añadir agente.");
      }
    });
  } else {
    toastr.error("Por favor corrija los campos.");
  }
}




//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElementoAgente(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/mntPreinscripciones.php?op=obtenerAgentesPorId",
    { idAgente: idElemento },
    function (data) {
      var data = JSON.parse(data);
      console.log(data);
      $("#id-agente").val(idElemento);
      //Cargar datos
      $("#nombreAgenteE").val(data[0].nombreAgente);
      $("#identificacionFiscalAgenteE").val(data[0].identificacionFiscal);
      $("#domicilioFiscalAgenteE").val(data[0].domicilioFiscal);
      $("#correoAgenteE").val(data[0].correoAgente);
      
      $("#editar-agente-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      /* if (data[0].rolUsuario == '1') {
        $('.rol-administrador').prop('checked', true);
    } else if (data[0].rolUsuario == '0') {
        $('.rol-usuario').prop('checked', true);

    }

    if (data[0].estUsu == '1') {
        $('#estUsu').prop('checked', true);
    } else {
        $('#estUsu').prop('checked', false);
    }

    $('#selectTrabajadores option').eq(data[0].cliUsuario).prop('selected', true); */
    }
  ); // Recuperar datos del cliente
}

function editarElementoAgentes() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editarAgenteForm")[0]);

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=editarAgenteId",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#agente_table").DataTable().ajax.reload(null, false); //! NO TOCAR
       
        if (data == 0) {
          toastr.error("Ese Agente ya existe");
        } else {
          toastr.success("El Agente se ha editado");
        }
        $("#editar-agente-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstadoAgentes(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/mntPreinscripciones.php?op=cambiarEstadoAgente", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#agente_table").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}

/************************************************************************************************************************************************** */
/************************************************************************* DEPARTAMENTO ****************************************************************/
/************************************************************************************************************************************************** */
var departamentos_table = $("#departamentos_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
    { name: "ID" },
    { name: "nombredepartamento", className: "text-center" },
    { name: "Nº Factura Pro", className: "text-center" },
    { name: "Nº Factura", className: "text-center" },
    { name: "Nº Factura Negativa", className: "text-center" },
    { name: "Factura Abono Prof", className: "text-center" },
    { name: "color", className: "text-center" },
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }
  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
    { targets: [1], orderData: false, visible: true },
    { targets: [2], orderData: false, visible: true, className: "text-center" },
    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
    { targets: [5], orderData: false, visible: true, className: "text-center" }
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarDepartamentos",
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

$("#departamentos_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('departamentos_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#departamentos_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE



//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
// // INICIALIZACIÓN DE COLOR PICKER, TANTO EN MODAL DE INSERT COMO EDITAR DE DEPARTAMENTOS //
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
// // INICIALIZACIÓN DE COLOR PICKER, TANTO EN MODAL DE INSERT COMO EDITAR DE DEPARTAMENTOS //
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

$(document).ready(function () {

  // SE INICIALIZA EL COLOR PICKER EN EL MODAL DEL INSERT DE DEPARTAMENTOS
  $('#colorDepartamento').drawrpalette();

  // SE INICIALIZA EL COLOR PICKER EN EL MODAL DEL EDITAR DEPARTAMENTOS
  $('#colorDepartamentoE').drawrpalette();

  // PINTAR EL BOTÓN DE COLOR EN EL MODAL INSERT/EDITAR
  $('.drawrpallete-wrapper > button.form-control').each(function() {
    if ($(this).attr('id') === 'colorDepartamento') {
      $(this).css('background-color', $('#colorDepartamento').val() || '#007BFF');
    }
    if ($(this).attr('id') === 'colorDepartamentoE') {
      $(this).css('background-color', $('#colorDepartamentoE').val() || '#007BFF');
    }
  });

  // AL HACER CLICK EN EL BOTÓN PARA SELECCIONAR COLOR EN INSERTAR, SE ACTUALIZA EL COLOR Y EL BOTÓN
  $('#colorDepartamento').on('choose.drawrpalette', function(event, hexcolor) {
    // - SE RECOGE EL VALOR HEXADECIMAL EN EL INPUT
    $('#colorDepartamento').val(hexcolor);
    // - SE PINTA EL BOTÓN DE ESE MISMO COLOR
    $(this).siblings('button.form-control').css('background-color', hexcolor);
  });

  // AL HACER CLICK EN EL BOTÓN PARA SELECCIONAR COLOR EN EDITAR, SE ACTUALIZA EL COLOR Y EL BOTÓN
  $('#colorDepartamentoE').on('choose.drawrpalette', function(event, hexcolor) {
    // - SE RECOGE EL VALOR HEXADECIMAL EN EL INPUT
    $('#colorDepartamentoE').val(hexcolor);
    // - SE PINTA EL BOTÓN DE ESE MISMO COLOR
    $(this).siblings('button.form-control').css('background-color', hexcolor);
  });

  // EVITAR QUE LOS EVENTOS POR DEFECTO DE LA LIBRERÍA RECARGUEN LA PÁGINA
  $(document).off('click.drawrpaletteBtn').on('click.drawrpaletteBtn', '.drawrpallete-wrapper > button.form-control', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $(document).off('click.drawrpaletteInnerBtn').on('click.drawrpaletteInnerBtn', '.drawrpallete-wrapper button.ok, .drawrpallete-wrapper button.cancel', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

});


// Cuando se abra el modal de agregar departamentos
$('#agregar-departamentos-modal').on('show.bs.modal', function () {
  // Seleccionamos todos los inputs, selects y textareas dentro del formulario
  $('#insertarDepartamento').find('input, select, textarea').removeClass('is-valid is-invalid');
  
  // También puedes resetear el formulario si quieres limpiar valores
  $('#insertarDepartamento')[0].reset();

  // Color azul por defecto para el selector de color
  const colorDepto = '#007BFF';

  // Asignar color al input
  $("#colorDepartamento").val(colorDepto);

  // Cambiar color de fondo del botón del selector de color
  $("#colorDepartamento").siblings('button.form-control').css('background-color', colorDepto);
});

function agregarElementoDepartamentos() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  var formData = new FormData($("#insertarDepartamento")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=insertarDepartamentos",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ file: ...js:68 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese Departamento ya existe");
        } else {
          toastr.success("El Departamento se ha añadido");
        }
        $("#agregar-departamentos-modal").modal("hide");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#departamentos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElementoDepartamento(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/mntPreinscripciones.php?op=obtenerDepartamentoPorId",
    { idDepartamento: idElemento },
    function (data) {
      var data = JSON.parse(data);
      console.log(data);
      $("#id-departamento").val(idElemento);
      //Cargar datos
      $("#nombreDepartamentoE").val(data[0].nombreDepartamento);
      $("#prefijofacturaE").val(data[0].prefijoFactDepa);
      $("#nfacturaE").val(data[0].numFacturaDepa);
      $("#prefijofacturaproE").val(data[0].prefijoFacturaProEdu);
      $("#nfacturaproE").val(data[0].numFacturaProDepa);
      $("#prefijoabonoE").val(data[0].prefijoAbonoEdu);
      $("#nfacturaNegE").val(data[0].numFacturaNegDepa);

      $("#prefijoabonoProfE").val(data[0].prefijoAbonoProEdu);
      $("#nfacturaprofDepE").val(data[0].numFacturaProNegDepa);

       // Añadir color al campo del modal de editar
      let colorDepto = (data[0].colorDepartamento || "#007BFF").trim();
        // Asignar color al input
      $("#colorDepartamentoE").val(colorDepto);

      // Cambiar color de fondo del botón del selector de color
      $("#colorDepartamentoE").siblings('button.form-control').css('background-color', colorDepto);
      console.log(colorDepto);
      

      $("#editar-departamento-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
    }
  ); // Recuperar datos del cliente
}

function editarElementoDepartamento() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#insertarDepartamentoE")[0]);

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=editarDepartamentoId",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#departamentos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
       
        if (data == 0) {
          toastr.error("Ese Departamento ya existe");
        } else {
          toastr.success("El Departamento se ha editado");
        }
        $("#editar-departamento-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}


//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstadoDepartamentos(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/mntPreinscripciones.php?op=cambiarEstadoDepartamentos", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#departamentos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}







/************************************************************************************************************************************************** */
/************************************************************************* CONOCIMIENTO ****************************************************************/
/************************************************************************************************************************************************** */
var conocimientos_table = $("#conocimientos_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
  
    { name: "ID" },
    { name: "nombre conocimiento", className: "text-center"},
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }

  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
    { targets: [1], orderData: false, visible: true },
    { targets: [2], orderData: false, visible: true , className: "text-center"},
    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarConocimientos",
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

$("#conocimientos_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('conocimientos_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#conocimientos_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE


function cambiarEstadoConocimientos(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/mntPreinscripciones.php?op=cambiarEstadoConocimiento", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado del conocimiento cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#conocimientos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}



//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

$('#agregar-conocimientos-modal').on('show.bs.modal', function () {
    $('#insertarConocimiento').find('input, select, textarea').removeClass('is-valid is-invalid');
    // Si quieres también limpiar los valores:
    $('#insertarConocimiento')[0].reset();
  });

function agregarElementoConocimiento() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  var formData = new FormData($("#insertarConocimiento")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=insertarConocimientos",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ file: ...js:68 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese conocimiento ya existe");
        } else {
          toastr.success("El conocimiento se ha añadido");
        }
        $("#agregar-conocimientos-modal").modal("hide");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#conocimientos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}



function cargarElementoConocimientos(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/mntPreinscripciones.php?op=obtenerConocimientoPorId",
    { idConocimiento: idElemento },
    function (data) {
      var data = JSON.parse(data);
      $("#id-conocimiento").val(idElemento);
      //Cargar datos
      $("#nombreConocimientoE").val(data[0].nombreConocimiento);
      
      $("#editar-conocimientos-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

     
    }
  ); // Recuperar datos del cliente
}



function editarElementoConocimiento() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editarConocimiento")[0]);

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=editarConocimientoId",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#conocimientos_table").DataTable().ajax.reload(null, false); //! NO TOCAR
       
        if (data == 0) {
          toastr.error("Ese conocimiento ya existe");
        } else {
          toastr.success("El Conocimiento se ha editado");
        }
        $("#editar-conocimientos-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}



function cambiarEstadoBildungsurlaub(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/mntPreinscripciones.php?op=cambiarEstadoBildungsurlaub", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#bildungsurlaub_table").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}






/************************************************************************************************************************************************** */
/************************************************************************* BILDUNGSURLAUB************************************************************/
/************************************************************************************************************************************************** */

var bildungsurlaub_table = $("#bildungsurlaub_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
  
    { name: "ID" },
    { name: "nombre bildungsurlaub", className: "text-center"},
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }

  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
    { targets: [1], orderData: false, visible: true },
    { targets: [2], orderData: false, visible: true , className: "text-center"},
    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarBildungsurlaub",
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

$("#bildungsurlaub_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('bildungsurlaub_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#bildungsurlaub_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE






//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

// Al abrir el modal de Bildungsurlaub, limpiar validaciones previas
$('#agregar-Bildungsurlaub-modal').on('show.bs.modal', function () {
  // Limpiar validaciones
  $('#insertarBildungsurlaub').find('input, select, textarea').removeClass('is-valid is-invalid');

  // Limpiar valores de los campos
  $('#insertarBildungsurlaub')[0].reset();
});


function guardarElementoBildungsurlaub() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  var formData = new FormData($("#insertarBildungsurlaub")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=insertarBildungsurlaub",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ file: ...js:68 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese Bildungsurlaub ya existe");
        } else {
          toastr.success("El Bildungsurlaub se ha añadido");
        }
        $("#agregar-Bildungsurlaub-modal").modal("hide");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#bildungsurlaub_table").DataTable().ajax.reload(null, false); //! NO TOCAR
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

function cargarElementoBildungsurlaub(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/mntPreinscripciones.php?op=obtenerBildungsurlaubPorId",
    { idElemento: idElemento },
    function (data) {
      var data = JSON.parse(data);
      $("#id-bildun").val(idElemento);
      //Cargar datos
      $("#nombreBildungsurlaubE").val(data[0].nombreBildun);
      
      $("#editar-bildun-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

     
    }
  ); // Recuperar datos del cliente
}


function editarElementoBildungsurlaub() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editarBildun")[0]);

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=editarBildungsurlaubId",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#bildungsurlaub_table").DataTable().ajax.reload(null, false); //! NO TOCAR
       
        if (data == 0) {
          toastr.error("Ese bildungsurlaub ya existe");
        } else {
          toastr.success("El bildungsurlaub se ha editado");
        }
        $("#editar-bildun-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}


/************************************************************************************************************************************************** */
/************************************************************************* T. DOC INDENTI ***********************************************************/
/************************************************************************************************************************************************** */


var tipoIdentificativo_table = $("#tipoIdentificativo_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
  
    { name: "ID" },
    { name: "nombre tipoIdentificativo", className: "text-center"},
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }

  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
    { targets: [1], orderData: false, visible: true },
    { targets: [2], orderData: false, visible: true , className: "text-center"},
    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarTipoIdentificativo",
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

$("#tipoIdentificativo_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('tipoIdentificativo_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#tipoIdentificativo_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE





//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

$('#agregar-identidad-modal').on('show.bs.modal', function () {
  // Elimina clases de validación
  $('#insertarIdentidad').find('input, select, textarea').removeClass('is-valid is-invalid');

  // Vacía los campos del formulario
  $('#insertarIdentidad')[0].reset();
});


function guardarElementoIdentidad() {
  //! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  var formData = new FormData($("#insertarIdentidad")[0]);

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=insertarIdentidad",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log("🚀 ~ file: ...js:68 ~ data:", datos);

        if (datos == 0) {
          toastr.error("Ese D.Identidad ya existe");
        } else {
          toastr.success("El D.Identidad se ha añadido");
        }
        $("#agregar-identidad-modal").modal("hide");

        // Vaciar los datos del FormData
        formData.forEach(function (value, key) {
          formData.delete(key);
        });
        $("#tipoIdentificativo_table").DataTable().ajax.reload(null, false); //! NO TOCAR
      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

function cargarElementoIdentidad(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.post(
    "../../controller/mntPreinscripciones.php?op=cargarElementoIdentidadxId",
    { idElemento: idElemento },
    function (data) {
      var data = JSON.parse(data);
      $("#id-identidadE").val(idElemento);
      //Cargar datos
      $("#nombreIdentidadE").val(data[0].nombreIdentificativo);
      
      $("#editar-identidad-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

     
    }
  ); // Recuperar datos del cliente
}


function editarElementoIdentidad() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editarIdentidadE")[0]);

    $.ajax({
      url: "../../controller/mntPreinscripciones.php?op=editarIdentidad",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#tipoIdentificativo_table").DataTable().ajax.reload(null, false); //! NO TOCAR
       
        if (data == 0) {
          toastr.error("Ese Tipo Documento ya existe");
        } else {
          toastr.success("El T.Documento se ha editado");
        }
        $("#editar-identidad-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      }, // del success
    }); // del ajax
  } else {
    toastr.error("Por favor corrija los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}



function cambiarEstadoTipoIdentificativo(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/mntPreinscripciones.php?op=cambiarEstadoIdentificativo", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#tipoIdentificativo_table").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}

/************************************************************************************************************************************************** */
/************************************************************************ ERASMUS  ******************************************************************/
/************************************************************************************************************************************************** */



var erasmus_table = $("#erasmus_table").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [
  
    { name: "ID" },
    { name: "nombre Erasmus", className: "text-center"},
    { name: "Estado", className: "text-center" },
    { name: "Acciones", className: "text-center" }

  ],
  columnDefs: [
    {
      targets: [0],
      orderData: false,
      visible: false,
      className: "secundariaDef",
    },
    { targets: [1], orderData: false, visible: true },
    { targets: [2], orderData: false, visible: true , className: "text-center"},
    {
      targets: [3],
      orderData: false,
      visible: true,
      className: "secundariaDef",
    },
  ],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },
  ajax: {
    // url: '../../controller/usuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/mntPreinscripciones.php?op=listarErasmus",
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

$("#erasmus_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros('erasmus_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#erasmus_table").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE




//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "tipocurso_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "tipoCurso_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-tipocurso-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-tipoCurso-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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

var tipocurso_table = $("#" + idDatatables + "").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idTipo" },
    { name: "descrTipo" },
    { name: "codTipo" },
   
    { name: "textTipo" },
    { name: "estTipoCurso", className: "text-center" },
    { name: "accion", className: "text-center" },
  ],
  columnDefs: [
    //idTipo
    {
      targets: [0],
      orderData: [0],
      visible: false,
      type: "num",
      className: "secundariaDef",
    },
    //descrTipo
    { targets: [1], orderData: [1], visible: true },
    //codTipo
    { targets: [2], orderData: [2], visible: true },
    //textTipo
    { targets: [3], orderData: [3], visible: true },
    //capacidad
    { targets: [4], orderData: false, visible: true },
    //estTipoCurso
    
    //Accion
    {
      targets: [5],
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
    url: "../../controller/" + phpPrincipal + "?op=listarTipoCurso",
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

//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *////* AGREGAR *//
//* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *////* ******* *//

function agregarElemento() {
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
          toastr.error("Ese código ya existe");
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

function cargarElemento(idElemento) {
  //! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR

  //? LIMPIAR MANUALMENTE CAMPOS Y CLASES DE VALIDACIÓN
  $("#id-tipocursoE").val("").removeClass("is-valid is-invalid");
  $("#descripcion-TipoE").val("").removeClass("is-valid is-invalid");
  $("#codigo-TipoE").val("").removeClass("is-valid is-invalid");
  $("#minAlum-TipoE").val("").removeClass("is-valid is-invalid");
  $("#maxAlum-TipoE").val("").removeClass("is-valid is-invalid");
  $("#text-TipoE").val("").removeClass("is-valid is-invalid").css("border-color", "");

  $.post(
    "../../controller/tipoCurso_Edu.php?op=obtenerTipoCursoPorId",
    { idTipoCurso: idElemento },
    function (data) {
      var data = JSON.parse(data);
      $("#id-tipocursoE").val(idElemento);

      //Cargar datos
      $("#descripcion-TipoE").val(data[0].descrTipo);
      $("#codigo-TipoE").val(data[0].codTipo);
      $("#minAlum-TipoE").val(data[0].minAlumTipo);
      $("#maxAlum-TipoE").val(data[0].maxAlumTipo);
      $("#text-TipoE").val(data[0].textTipo);
      $("#text-TipoE").text(data[0].textTipo);
      $("#" + idModalEditar + "").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

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

function editarElemento() {
  //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO

  validateMinInput();
  validateMaxInput();

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMBOS VACIOS ( FALSE = NO HAY CAMBIOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    var formData = new FormData($("#editar-tipoCurso")[0]);

    $.ajax({
      url: "../../controller/tipoCurso_Edu.php?op=editarTipoCurso",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        $("#" + idDatatables + "").DataTable().ajax.reload(null, false); //! NO TOCAR
        if (data == 0) {
          toastr.error("Ese codigo ya existe");
        } else {
          toastr.success("El tipo de curso se ha editado");
        }
        $("#" + idModalEditar + "").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

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

function cambiarEstado(idElemento) {
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

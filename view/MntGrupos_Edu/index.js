//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "grupos_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "grupos_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-tipocurso-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-grupos-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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

var pagos_table = $("#" + idDatatables + "").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idGrupo", data: "0", width: "9%" },
    { name: "nomGrupo" },
    { name: "direcGrupo" },
    { name: "telGrupo" },
    { name: "identificadorGrupo" },
    { name: "estGrupo" },
    { name: "accion", "className": "text-center", class: "text-center" }
],
columnDefs: [
    //idGrupo
    { targets: [0], orderData: [0], visible: false, type: 'num', className: 'secundariaDef' },
    //descrGrupo
    { targets: [1], orderData: [1], visible: true, type: 'string' },
    //codGrupo
    { targets: [2], orderData: [2], visible: true, type: 'string' },
    //textGrupo
    { targets: [3], orderData: [3], visible: true, type: 'string' },
    //estGrupo
    { targets: [4], orderData: [4], visible: true },

    { targets: [5], orderData: false, visible: true } ,

    //accion
    { targets: [6], orderData: false, visible: true, className: 'secundariaDef' } //SecundariaDef para que el Colvis no los saque
],

  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },

 "ajax": {
        //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945
        url: "../../controller/grupos_Edu.php?op=listarGrupos",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            //    $('.submitBtn').attr("disabled","disabled");
            //    $('#usuario_data').css("opacity","");
        }, complete: function (data) {
        },
        error: function (e) {
            console.log(e.responseText);
        }
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

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS

  let validacion = validarCamposVacios(); //? VALIDAR SI HAY CAMPOS VACIOS ( FALSE = NO HAY CAMPOS VACIOS, TRUE = HAY CAMPOS VACIOS )
  if (!validacion) {
    //? SI LA VALIDACION DEVUELVE FALSE
    var formData = new FormData($("#insertar-grupos-form")[0]);

    
    $.ajax({
      url: "../../controller/grupos_Edu.php?op=insertarGrupo",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function () {
          $('#grupos_table').DataTable().ajax.reload(null, false);

  
          swal.fire(
              'Añadido',
              'El grupo se ha añadido',
              'success'
          )

          $("#insertar-grupos-form")[0].reset();

          $('#insertar-grupo-modal').modal('hide');
      }
  });
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
  limpiarModalValidaciones(); //?  ELIMINA LAS CLASES IS-VALID E IS-INVALID

  $.ajax({
    url: "../../controller/grupos_Edu.php?op=recogerEditar",
    type: "POST",
    data: { 'idGrupo': idElemento },
    dataType: "json",

    success: function (response) {
        $("#id-grupos").val(response[0])
        $("#nomGrupoE").val(response[1])
        $("#direcGrupoE").val(response[2])
        $("#telGrupoE").val(response[3])
        $("#cifGrupoE").val(response[4])
        $("#" + idModalEditar + "").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR


    } // del success
}); // del ajax
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
    var formData = new FormData($("#editar-grupos-form")[0]);

    $.ajax({
        url: "../../controller/grupos_Edu.php?op=editarGrupo",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function () {

        toastr.success("El grupo se ha editado");
            $('#grupos_table').DataTable().ajax.reload(null, false);

            $("#" + idModalEditar + "").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
        }
    }); // del success
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

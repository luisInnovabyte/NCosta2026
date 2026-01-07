//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "trabajadores_table" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "trabajadores.php" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "agregar-trabajador-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-accionescontado-modal" //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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

var trabajadores_table = $("#"+idDatatables+"").DataTable({ //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idTrabajador" },
    { name: "nombreTrabajador", className: "text-center"},
    { name: "profesionesTrabajador", className: "text-center"},
    { name: "estTrabajador", className: "text-center" },
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


    { targets: [2], orderData: false, visible: true },
    { targets: [3], orderData: false, visible: true , className: "text-center"},

    {
      targets: [4],
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

    url: "../../controller/"+phpPrincipal+"?op=mostrarElementos",
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
      
      calcularColores();
    },
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

function agregarElemento() {//! NO TOCAR
  //? FUNCION PARA AGREGAR EL NUEVO ELEMENTO

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nombre = $("#nombreTrabajador").val();
  let profesiones = $("#profesionTrabajador").val();
  
  if (!validarArrayVacio(nombre) && !validarArrayVacio(profesiones)) {
    //? SI LA VALIDACION DEVUELVE FALSE
    $.post(
      "../../controller/"+phpPrincipal+"?op=agregarElemento",//! NO TOCAR
      { nombre:nombre,profesiones:profesiones },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? AGREGAR ELEMENTO
        $("#"+idModalAgregar+"").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE AGREGAR
        toastr.success("Trabajador/a Agregado/a."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
      }
    );
  } else {
    toastr.error("Por favor completa los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *////* EDITAR *//
//* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *////* ****** *//

function cargarElemento(idElemento) {//! NO TOCAR
  //? FUNCION PARA RECOGER LA INFORMACION DEL ELEMENTO A EDITAR
  $.post(
    "../../controller/"+phpPrincipal+"?op=cargarElemento",//! NO TOCAR
    { idElemento: idElemento },//! NO TOCAR
    function (data) {
      //? RECOGER DATOS DE LA BASE DE DATOS
      data = JSON.parse(data);
      console.log(data);
      //TODO: CARGAR TANTOS CAMPOS COMO SEA NECESARIOS
      $('#nombreTrabajadorE').val(data[0]["idUsuario_trabajador"]).trigger('change');
      var valoresArray = JSON.parse(data[0]["arrayProfesiones_trabajador"]); // Array con los valores a seleccionar
      $('#profesionTrabajadorE').val(valoresArray).trigger('change');
      $("#editando").text("Trabajador/a"); 
      $("#hiddenid").val(data[0]["idAccion"]); 

      $('#nombreTrabajadorE').prop('disabled', true);
      $("#"+idModalEditar+"").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
    }
  );
}

function editarElemento() { //! NO TOCAR
  //? FUNCION PARA EDITAR EL ELEMENTO
  let idElemento = $("#hiddenid").val(); //! NO TOCAR

  //TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
  let nombre = $("#nombreTrabajadorE").val();
  let profesiones = $("#profesionTrabajadorE").val();

  if (!validarArrayVacio(nombre) && !validarArrayVacio(profesiones)) {
    //? SI LA VALIDADCION DEVUELVE FALSE
    $.post(
      "../../controller/"+phpPrincipal+"?op=agregarElemento",//! NO TOCAR
      { nombre:nombre,profesiones:profesiones },//TODO: RECOGER TANTOS CAMPOS COMO SEA NECESARIOS
      function (data) {
        //? GUARDAR CAMBIOS

        $("#"+idModalEditar+"").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR
        toastr.success("Trabajador/a Editado/a."); //TODO: MODIFICAR MENSAJE DE SUCCESS
        $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
      }
    );
  } else {
    toastr.error("Por favor completa los campos."); //? INFORMAR QUE HA DADO ERROR
  }
}

//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *////* CAMBIAR ESTADO *//
//* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *////* ******* ****** *//

function cambiarEstado(idElemento) { //! NO TOCAR
  //? FUNCION PARA CAMBIAR ESTADO DEL ELEMENTO
  $.post(
    "../../controller/"+phpPrincipal+"?op=cambiarEstado", //! NO TOCAR
    { idElemento: idElemento }, //! NO TOCAR
    function (data) {
      //? EDITAR ESTADO
      toastr.success("Estado cambiado."); //TODO: MODIFICAR MENSAJE DE SUCCESS
      $("#"+idDatatables+"").DataTable().ajax.reload(null, false); //! NO TOCAR
    }
  );
}

//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *////* FUNCION AL ABRIR MODALES *//
//* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *////* ******* ** ***** ******* *//

$("#"+idModalAgregar+"").on("show.bs.modal", function () {//TODO: MODIFICAR ID DEL MODAL DE AGREGAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarSeleccion(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
});

//* ** ********* *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* JS ADICIONAL *//
//* ** ********* *//

function limpiarSeleccion() {
  $('#nombreTrabajador').val(null).trigger('change');
  $('#profesionTrabajador').val(null).trigger('change');
  deselectFirstElement("nombreTrabajador");
  deselectFirstElement("profesionTrabajador");
  
}

function deselectFirstElement(idSelect2) {
  var $select = $('#'+idSelect2);
  var selectedValues = $select.val(); // Obtiene los valores seleccionados

  if (selectedValues && selectedValues.length > 0) {
    selectedValues.shift(); // Elimina el primer elemento
    $select.val(selectedValues).trigger('change'); // Actualiza el select2 con los nuevos valores
  }
}


$.post("../../controller/usuario.php?op=listarUsuarios", {}, function(data) {
  data = JSON.parse(data); // Asegúrate de parsear el JSON si no está ya parseado
  console.log(data);
  $.each(data, function(index, usuario) {
    $("#nombreTrabajador").append("<option value='" + usuario.idUsu + "'>" + usuario.nombreUsu + " " + usuario.apellidosUsu + " ("+ usuario.correoUsu +")</option>");
    $("#nombreTrabajadorE").append("<option value='" + usuario.idUsu + "'>" + usuario.nombreUsu + " " + usuario.apellidosUsu + " ("+ usuario.correoUsu +")</option>");
  });
});

$.post("../../controller/profesiones.php?op=listarProfesiones", {}, function(data) {
  data = JSON.parse(data); // Asegúrate de parsear el JSON si no está ya parseado
  $.each(data, function(index, profesion) {
    $("#profesionTrabajador").append("<option value='" + profesion.idProfesion + "' data-color='" + profesion.color_profesiones + "'>" + profesion.descripcion_profesiones + "</option>");
    $("#profesionTrabajadorE").append("<option value='" + profesion.idProfesion + "' data-color='" + profesion.color_profesiones + "'>" + profesion.descripcion_profesiones + "</option>");

  });
});

$('#nombreTrabajador').select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'placeholder' ),
  closeOnSelect: true,
  maximumSelectionLength: 1,
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
} );

$( '#profesionTrabajador' ).select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'placeholder' ),
  closeOnSelect: false,
  templateResult: formatState,
  templateSelection: formatState,
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
} ).on('select2:open', function() {
  $('.select2-results__options').addClass('text-center');
});

$('#nombreTrabajadorE').select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'placeholder' ),
  closeOnSelect: true,
  maximumSelectionLength: 1,
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
} );

$( '#profesionTrabajadorE' ).select2( {
  theme: "bootstrap-5",
  width: "100%",
  placeholder: $( this ).data( 'placeholder' ),
  closeOnSelect: false,
  templateResult: formatState,
  templateSelection: formatState,
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
} ).on('select2:open', function() {
  $('.select2-results__options').addClass('text-center');
});

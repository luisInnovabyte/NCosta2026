//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "contenido_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "contenido_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalAgregar = "insertar-contenido-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var idModalEditar = "editar-nivel-modal"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO

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

var contenido_table = $("#" + idDatatables + "").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar

  columns: [

    { name: "idContenido" },
    { name: "idTitular" },
    { name: "idNivel" },
    { name: "idTipo" },
    { name: "txtContenido" },
    { name: "txtTitular" },
    { name: "txtObs" },
    { name: "txtTipo" },
    { name: "codigoTipo" },
    { name: "txtNivel" },
    { name: "codigoNivel" },
    { name: "contNivel" },
    { name: "semNivel" },
    { name: "estCont" },
    { name: "accion", "className": "text-center" }
],
columnDefs: [
    //idContenido
    { targets: [0], orderData: [0], visible: false, className: 'secundariaDef'},
    //idTitular
    { targets: [1], orderData: [1], visible: false, className: 'd-none'},
    //idNivel
    { targets: [2], orderData: [2], visible: false, className: 'd-none'},
    //idTipo
    { targets: [3], orderData: [3], visible: true , className: 'd-none'},
    //txtTipo
    { targets: [4], orderData: [4], visible: true },
    //txtNivel
    { targets: [5], orderData: [5], visible: true },
    //txtContenido
    { targets: [6], orderData: false, visible: true },
    //txtTitular
    { targets: [7], orderData: [7], visible: true , className: 'd-none'},
    //txtObs
    { targets: [8], orderData: [8], visible: true , className: 'd-none'},
    //codigoTipo
    { targets: [9], orderData: [9], visible: false},
    //codigoNivel
    { targets: [10], orderData: [10], visible: true },
    //contNivel
    { targets: [11], orderData: [11], visible: true },
    //semNivel
    { targets: [12], orderData: [12], visible: true },
    //estCont
    { targets: [13], orderData: [13], visible: true },
    //accion
    { targets: [14], orderData: false, visible: true}
],
  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 3],
  },


  "ajax": {
    // url: '../../controller/usssuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/"+phpPrincipal+"?op=listarContenido",
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


var contenido_table_titular = $('#contenido_table_titular').DataTable({

  columns: [

      { name: "idTipo" },
      { name: "descrTipo" },
      { name: "codTipo" },
      { name: "estTipoCurso", "className": "text-center" },
      { name: "accion", "className": "text-center" }
  ],
  columnDefs: [
      //idTipo
      { targets: [0], orderData: [0], visible: false,type: 'num', className: 'secundariaDef' },
      //descrTipo
      { targets: [1], orderData: [1], visible: true },
      //codTipo
      { targets: [2], orderData: [2], visible: true },
      //textTipo
      { targets: [3], orderData: [3], visible: true },
      //Accion
      { targets: [4], orderData: false, visible: true,className: 'secundariaDef' }
  ],

  "ajax": {

      url: "../../controller/titContenido_Edu.php?op=listarContenido",
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
      },
       orderFixed: [[1, "asc"]],
      searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
          columns: [1, 2, 3, 4]
      },
  }
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
$('#contenido_table_titular tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
  // Obtén la instancia de la tabla DataTables
  var tabla = $('#contenido_table_titular').DataTable();

  // Obtén el objeto de datos de la fila actual
  var data = tabla.row(this).data();

  var idTitular = data[0];
  var nombreTitular = data[1];
  
  $("#verTitular").text(nombreTitular);
  $("#titularSelect").val(idTitular);
  $("#verTitular1").text(nombreTitular);
  $("#titularSelect1").val(idTitular);
  $("#modal-titulares").modal('hide');
});
$("#contenido_table_titular").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
$("#contenido_table_titular").DataTable().columns([2,4]).visible(false);
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
$(document).ready(function() {
  // Inicializar el select2 con la configuración que ya tienes
  $("#selectCurso").select2({
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
  });
  $("#selectCurso1").select2({
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
  });

  $("#selectCurso").val(null).trigger('change');
  $("#selectCurso1").val(null).trigger('change');
  $("#selectNivel").select2({
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
  });
  $("#selectNivel1").select2({
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
  });

  $("#selectNivel").val(null).trigger('change');
  $("#selectNivel1").val(null).trigger('change');
});

$("#" + idModalAgregar + "").on("show.bs.modal", function () {
  //TODO: MODIFICAR ID DEL MODAL DE AGREGAR
  //? FUNCION QUE SE EJECUTA ANTES DE ABRIR EL MODAL DE AGREGAR
  limpiarModalInputs(); //? LIMPIAR TODOS LOS INPUTS DE UN MODAL Y LAS CLASES IS-VALID E IS-INVALID
});

function agregarContenido(){
  let titular = $("#titularSelect").val();
  let curso = $("#selectCurso").val();
  let nivel = $("#selectNivel").val();
  let contenido = $("#contenido").val();
  if(titular == 0 || curso == 0 || nivel == 0 || contenido == ""){
      toastr.error("Tienes campos sin completar");
  } else {
      
      $.post("../../controller/contenido_Edu.php?op=insertar",{titular:titular,curso:curso,nivel:nivel,contenido:contenido},function (data) {
        toastr.success("Contenido agregado");
          contenido_table.ajax.reload();
          $("#selectCurso").val(null).trigger('change');
        
          $("#selectNivel").val(null).trigger('change');
          $("#verTitular").text("SELECCIONE UN TITULAR");
          $("#titularSelect").val("");
          $("#contenido").val("")
          $("#contenido").text("")
      });
  }
}

function editarContenido(idCont,idTit,idTipo,idNivel,contenido,nombreTitular){
    $("#verTitular1").text(nombreTitular);
    $("#titularSelect1").val(idTit);
    $("#selectCurso1").val(idTipo).trigger("change");
    $("#selectNivel1").val(idNivel).trigger("change");
    $("#contenido1").val(contenido);
    $("#addCont").addClass("fadeOut");
    $("#addCont").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
        if($("#addCont").hasClass("fadeOut")){
            // La animación ha terminado, añadimos la clase d-none
            $("#addCont").addClass("d-none");
            $("#addCont").removeClass("fadeOut");
            $("#editCont").removeClass("d-none");
            $("#editCont").addClass("fadeIn");
            $("#editCont").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                $("#editCont").removeClass("fadeIn");
            });
        }
    });
    console.log("🚀 ~ idCont:", idCont)
    $("#contenidoSelected").val(idCont);
}

function quitarModoEdicion(){
  $("#editCont").addClass("fadeOut");
  $("#editCont").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
      if($("#editCont").hasClass("fadeOut")){

          // La animación ha terminado, añadimos la clase d-none
          $("#editCont").addClass("d-none");
          $("#editCont").removeClass("fadeOut");
          $("#addCont").removeClass("d-none");
          $("#addCont").addClass("fadeIn");
          $("#addCont").on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
              $("#addCont").removeClass("fadeIn");
          });
      }
  });
}
function editarContenidoGuardar(){
  let idCont =  $("#contenidoSelected").val();
  let titular = $("#titularSelect1").val();
  let curso = $("#selectCurso1").val();
  let nivel = $("#selectNivel1").val();
  let contenido = $("#contenido1").val();
  if(titular == 0 || curso == 0 || nivel == 0 || contenido == ""){
      toastr.error("Tienes campos sin completar");
  } else {
      
      $.post("../../controller/contenido_Edu.php?op=editar",{titular:titular,curso:curso,nivel:nivel,contenido:contenido,idCont:idCont},function (data) {
          contenido_table.ajax.reload();
          quitarModoEdicion();
          toastr.success("Contenido editado");

      });
  }
}
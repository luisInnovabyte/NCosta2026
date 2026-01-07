//* ********* **** ******** ********  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* VARIABLES PARA ACELERAR PROCESOS  *//
//* ********* **** ******** ********  *//

var idDatatables = "objetivos_table"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
var phpPrincipal = "objetivos_Edu.php"; //TODO: CAMBIAR EL STRING SEGUN EL MANTENIMIENTO
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
const idTitularSelect = $('#titObjetivoId').val();
var contenido_table = $("#" + idDatatables + "").DataTable({
  //TODO: CAMBIAR LA VARIABLE SEGUN EL MANTENIMIENTO
  select: false, // nos permite seleccionar filas para exportar
  columns: [

    { name: "idTipo" },
    { name: "titular", "className": "text-center" },

    { name: "descrTipo", "className": "text-center" },
    
    { name: "estTipoCurso", "className": "text-center" },
    { name: "accion", "className": "text-center" }
],
columnDefs: [

    //idTipo
    { targets: [0], orderData: [0], visible: false,type: 'num', className: 'secundariaDef' },
    //descrTipo
    { targets: [1], orderData: [1], visible: false },
    //codTipo
    { targets: [2], orderData: [2], visible: true},
    { targets: [3], orderData: [3], visible: true},

 
    { targets: [4], orderData: false, visible: true,className: 'secundariaDef' }
],
  searchBuilder: {
    // Las columnas que van a aparecer en el desplegable para ser buscadas
    columns: [1, 2,3],
  },


  "ajax": {
    // url: '../../controller/usssuario.php?op=listar',
    //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

    url: "../../controller/objetivos_Edu.php?op=listarObjetivo&idTit="+idTitularSelect,
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
// Oculta la columna 0 y 1
contenido_table.column(0).visible(false);
contenido_table.column(1).visible(false);

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
});

function agregarObjetivo(){
  let titular = idTitularSelect
  let contenido = $("#contenido").val();
  if(contenido == ""){
      toastr.error("Tienes campos sin completar");
  } else {
      
    $.post("../../controller/objetivos_Edu.php?op=insertar",{titular:titular,contenido:contenido},function (data) {
        toastr.success("Contenido agregado");
          contenido_table.ajax.reload();
         
          $("#contenido").val("")
          $("#contenido").text("")
      });
  }
}

function editarObjetivo(idCont,contenido){
    
    $("#contenido1").val(contenido);
    $("#contenidoSelected").val(idCont);

    $("#editar-objetivos-modal").modal("show"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

}


function editarObjetivoGuardar(){

  let idCont =  $("#contenidoSelected").val();
  let contenido = $("#contenido1").val();
  if(contenido == ""){
      toastr.error("Tienes campos sin completar");
  } else {
      
      $.post("../../controller/objetivos_Edu.php?op=editar",{contenido:contenido,idCont:idCont},function (data) {
          contenido_table.ajax.reload();
          toastr.success("Contenido editado");
          $("#editar-objetivos-modal").modal("hide"); //TODO: MODIFICAR ID DEL MODAL DE EDITAR

      });
  }
}
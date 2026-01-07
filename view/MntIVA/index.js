var isDark = isColorDark("#000000"); // TRUE SI EL COLOR ES OSCURO FALSE SI ES CLASE

var colorLetra = "black";

var iva_table = $("#iva_table").DataTable({
  select: false, // nos permite seleccionar filas para exportar

  columns: [
    { name: "idPrioridad" },
    { name: "descPrioridad", className: "text-center" },
    { name: "colorPrioridad", className: "text-center" },
    { name: "estPrioridad", className: "text-center" },
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

    { targets: [2], orderData: false, visible: true, className: "tx-center" },

    { targets: [3], orderData: false, visible: true },

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

    url: "../../controller/iva.php?op=mostrarIva",
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
$("#iva_table")
  .DataTable()
  .on("draw.dt", function () {
    controlarFiltros("iva_table");
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
  });

$("#iva_table").addClass("width-100");


//*  AGREGAR IVA *//

function agregarIva() {  
  // Validar Campos
 
  if (
    validarCamposVacios()

  ) {
    toastr.warning("Alguno de los campos no cumple con los requisitos.");
  } else {
    valorIva = $("#valorIva").val();
    descrIva = $("#descrIva").val();

    $.post(
      "../../controller/iva.php?op=insertarIva",
      {
        valorIva: valorIva,
        descrIva: descrIva,
      },

      function (data) {
        console.log(data);
        if (data != true) {
          toastr["error"](data);
        } else {


          $("#valorIva").val("");
          $("#descrIva").val("");
          $("#textIva").val("");
  

          // Cierra el modal con el ID "agregar-cliente-modal"
          $("#agregar-iva-modal").modal("hide");

          $("#iva_table").DataTable().ajax.reload(null, false);

          toastr["success"]("¡IVA creado correctamente!");
        }
      }
    );
  }
}

//* CAMBIAR ESTADO *//

function cambiarEstado(idIva){
  $.post("../../controller/iva.php?op=cambiarEstado",{idIva:idIva},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
  
      $('#iva_table').DataTable().ajax.reload(null, false);

    console.log(data);
      data = JSON.parse(data);
      let estIva = data[0][0];

      if (estIva == 1){

        $.post("../../controller/iva.php?op=activarIva",{idIva:idIva},function (data) {

        toastr["success"]('¡IVA activado!');

        });

      }else{
        $.post("../../controller/iva.php?op=desactivarIva",{idIva:idIva},function (data) {

        toastr["warning"]('¡IVA desactivado!');
      });

      }

  })
}

//* CARGAR Y EDITAR IVA *//

function cargarIva(idIva){
  $.post("../../controller/iva.php?op=recogerDatosIva",{idIva:idIva},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      data = JSON.parse(data);
      let idIva = data[0][0];
      let valorIva = data[0][1];
      let descrIva = data[0][2];



      $("#valorIvaE").val(valorIva);
      $("#descrIvaE").val(descrIva);

      $("#idIvaHidden").val(idIva);
      $("#editar-iva-modal").modal("show");
  })

}

function editarIva(){
  let idIva = $("#idIvaHidden").val();
  let valorIva = $("#valorIvaE").val();
  let descrIva = $("#descrIvaE").val();


      $.post("../../controller/iva.php?op=editarIva",{idIva:idIva,valorIva:valorIva, descrIva:descrIva},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
  
        $('#iva_table').DataTable().ajax.reload(null, false);

          $("#editar-iva-modal").modal("hide");

          toastr["success"]('¡IVA editado!');


    });

  
}
//* FUNCION AL ABRIR MODALES *//
$("#agregar-iva-modal").on("show.bs.modal", function(){
  limpiarModalInputs();
});

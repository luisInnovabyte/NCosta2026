
var documentos_table = $('#asistencia_table').DataTable({
    /*===============================================================*/
    /*==============================================================*/
    /*    DEFINICION DE LA PARTE PARTICULAR DEL DATATABLES         */
    /*============================================================*/
    /*===========================================================*/
    columns: [

        { name: "nombre" },
        { name: "fechaAsistida", "className": "text-center" },
        { name: "fechaFinalizada", "className": "text-center" },
        { name: "motivo", "className": "text-center" },
        { name: "estado", "className": "text-center" },
        { name: "TiempoTotal", "className": "text-center" }

    ],
    columnDefs: [
        //nombre
        { targets: [0], orderData: [0], visible: true, type: 'string' },
        //fechaAsistida
        { targets: [1], orderData: [1], visible: true, type: 'string' },
        
        { targets: [2], orderData: [2], visible: true},
        //fechaFinalizada
        { targets: [3], orderData: [3], visible: true},
        //motivo
        { targets: [4], orderData: [4], visible: true },
        //tiempototal
        { targets: [5], orderData: [5], visible: true },

      
    ],

    "ajax": {
        // url: '../../controller/usssuario.php?op=listar',
        //  https://programacion.net/articulo/subir_una_imagen_en_un_formulario_mediante_ajax_1945

        url: "../../controller/asistencia.php?op=listarAsistencia",
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
        orderFixed: [[2, "asc"]],
        searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
            columns: [1, 2, 3, 4]
        },
    }
}); //ANCHO del DATATABLE
$("#asistencia_table").addClass("width-100");

$(document).ready(function() {
    // Función para obtener parámetros de la URL
    function getParameterByName(name) {
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }
  
    // Recuperar el valor del parámetro "buscar"
    const buscarTexto = getParameterByName('buscar') || '';
  
  
    try {
      const buscarTexto = getParameterByName('buscar') || '';
      if (buscarTexto) {
          console.log('Buscando:', buscarTexto);
          documentos_table.search(buscarTexto).draw();
          $('.dataTables_filter input[type="search"]').val(buscarTexto);
      }
  } catch (error) {
      console.error('Error aplicando el filtro:', error);
  }
  
  });
/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
// BUSCAR POR DESCRIPCION
$('#FootNombre').on('keyup', function () {
    documentos_table
        .columns(1)
        .search(this.value)
        .draw();
});
/************************************************/
/*    FIN DE LOS FILTROS DE LOS PIES        ****/
/**********************************************/

$('#asistencia_table').DataTable().on('draw.dt', function () {
    controlarFiltros('asistencia_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});



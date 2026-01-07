/**********************************************************************/
/*********************************************************************/
/********************************************************************/


/******************************************************/
/*********** BOTONES DE ACTIVAR Y DESACTIVAR *********/
/****************************************************/
function apuntarme(idUsu, idAct) {
  swal.fire({
      title: 'Actividad',
      text: "¿Desea participar en la actividad?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
      reverseButtons: true
  }).then((result) => {
      if (result.isConfirmed) {
          $.post("../../controller/actividades_edu.php?op=apuntarse", { idUsu: idUsu, idAct: idAct }, function (data) {
              $('#act_usuario_table').DataTable().ajax.reload();
  
              swal.fire(
                  'Actividad',
                  '¡Te has inscrito correctamente!',
                  'success'
              )
          });

      }
  })
}


function desapuntarme(idUsu, idAct) {
console.log(idUsu);
console.log(idAct);
  swal.fire({
      title: 'Actividades',
      text: "¿Desea cancelar su participación en la actividad?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
      reverseButtons: true
  }).then((result) => {
      if (result.isConfirmed) {

          $.post("../../controller/actividades_edu.php?op=desapuntarse", { idUsu: idUsu, idAct: idAct }, function (data) {

              $('#act_usuario_table').DataTable().ajax.reload();
  
              swal.fire(
                  'Actividades',
                  'Has cancelado tu participación exitosamente.',
                  'success'
              )
          });
      }
  })
}

/***************************************/
/****** DATATABLE ACTIVIDADES *********/
/*************************************/

var documentos_table = $('#act_usuario_table').DataTable({
    language: {
        emptyTable: "No hay actividades disponibles"
    },
  buttons:[],
  columns: [

      { name: "idAct" },
      { name: "actividad" },
      { name: "fechaActividad" },
      { name: "horasLectivas" },
      { name: "puntoEncuentro" },
      { name: "pdf", "className": "text-center" },
      { name: "inscribirse", "className": "text-center" }
  ],
  columnDefs: [

      //idAct
      { targets: [0], orderData: [0], visible: false , type: 'num', className: 'secundariaDef'},
      //actividad
      { targets: [1], orderData: [1], visible: true },
      //fechaActividad
      { targets: [2], orderData: [1], visible: true },
      //horasLectivas
      { targets: [3], orderData: [1], visible: true },
      //puntoEncuentro
      { targets: [4], orderData: [1], visible: true },
      //inscribirse
      { targets: [5], orderData: false, visible: true, className: 'secundariaDef' },
      //pdf
      { targets: [6], orderData: false, visible: true ,className: 'secundariaDef'}
  ],

  "ajax": {

      url: "../../controller/actividades_edu.php?op=mostrarAct",
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



/***************************************/
/*********** RESPONSIVE DATATABLE *********/
/*************************************/

$('#act_usuario_table').DataTable().on('draw.dt', function () {
  controlarFiltros('act_usuario_table');
  // La función está en el mainJs.php, es común para todos
  // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
$('#act_usuario_table').addClass('width-100'); //responsive
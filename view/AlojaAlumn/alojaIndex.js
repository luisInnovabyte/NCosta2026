
/*==================================*/
/*     INICIO DEL DATATABLES        */
/*==================================*/

/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES      */
/*============================================================*/
/*===========================================================*/

// Está en un archivo aparte comunDataTables.js

/*===============================================================*/
/*==============================================================*/
/*                             FIN                             */
/*    DEFINICION DE LOS PARAMETROS COMUNES DEL DATATABLES     */
/*===========================================================*/
/*==========================================================*/



/*===============================================================*/
/*==============================================================*/
/*    DEFINICION DE LA PARTE PARTICULAR DEL DATATABLES         */
/*============================================================*/
/*===========================================================*/

/***********************************/
/**********ACTIVAR ALOJA**************/
/*********************************/

var idAlumn = $("#idAlumn").val();
$('#aloja2_table').DataTable({

    columns: [

        { name: "ID" },
        { name: "Tipo Alojamiento" },
        { name: "Nombre" },
        { name: "FechaIni" },
        { name: "FechaFin" },

        { name: "Dirección" },
        { name: "Ver", className: "text-center" },
        { name: "Valoración", className: "text-center" },

        /* { name: "Opiniones", className: "text-center" } */
    ],
    columnDefs: [

        //ID
        { targets: [0], orderData: [0], visible: false , className: 'secundariaDef' },
        //Tipo Alojamiento
        { targets: [1], orderData: [1], visible: true },
        //Nombre
        { targets: [2], orderData: [1], visible: true },
        //Estancia
        { targets: [3], orderData: [1], visible: true },
    
        //Dirección
        { targets: [4], orderData: [1], visible: true },
        //ver
        { targets: [5], orderData: false, visible: true },
        //valorar
        { targets: [6], orderData: false, visible: true },

        { targets: [7], orderData: false, visible: true },

        /* //Opiniones
        { targets: [6], orderData: false, visible: true }, */

    ],

    "ajax": {


        url: "../../controller/alojamientos.php?op=listarAlojamiento2&idAlumn=" + idAlumn,
        //url: "../../controller/alojamientos.php?op=listarAlojamiento",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            //    $('.submitBtn').attr("disabled","disabled");
            //    $('#usuario_data').css("opacity","");
        }, complete: function (data) {
            console.log(data);
            
        },
        error: function (e) {
            console.log(e.responseText);
        },
        orderFixed: [[1, "asc"]],
        searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
            columns: [1, 2, 3, 4]
        },
    }
});
//ANCHO del DATATABLE
$("#aloja2_table").addClass("width-100");




$('#aloja2_table').DataTable().on('draw.dt', function () {
    controlarFiltros('aloja2_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/


//#######################################################\\
//#######################################################\\
//################ FORMULARIO ALOJAMIENTO ###############\\
//#######################################################\\
//#######################################################\\

//********************************************************//
//******************* ENVIAR CORREO *********************//
//**************** FAMILIA PARA DETALLES ***************//
//*****************************************************//
condicion = $('#condition').val();
if (condicion == 'editAdmin') {
    $('#botonEnviar').removeClass('d-none');
} else {
    $('#botonEnviar').addClass('d-none');
}

//**************************************************//
//*************************************************//
//************************************************//
//***********************************************//

//#######################################################\\
//#######################################################\\
//#######################################################\\
//#######################################################\\
//#######################################################\\



function getIdAloja(id) {
    $("#idAloja_AlojaVi").val(id);
}
function getIdAlojaOpi(idAloja, idUsu) {
    $('#agregar-opis-modal').modal('show');

    $("#idAloja_AlojaOpi").val(idAloja);
    $("#idUsu").val(idUsu);

    //comprobar Estado del alumno del alojamiento, si ha hecho reseña/valoración
    $.ajax({
        url: "../../controller/alojamientos.php?op=getAlojaOpi&idAloja=" + idAloja + "&idUsu=" + idUsu,
        type: "GET",
        dataType: 'json',
        success: function (data) {

            if (data == null || data == '') {
                //vaciar cuando le das al boton cerrar
                $("#cerrar").on("click", function () {
                    $("#insertar-opiniones-form")[0].reset();
                    $('#descrAlojaOpi').summernote('reset');
                    $("#default-star-rating").raty('reload');
                });
                insertarOpi();

            } else {
                   // Vaciar los datos del FormData  
        $('#descrAlojaOpi').summernote('reset');
        $("#editar-idioma-form")[0].reset();
        $("#default-star-rating").raty('reload');

                $('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', false);
                $("#fechaAlojaOpi").val(data[0].fechaOpi);
                $('#default-star-rating').raty('score', data[0].ratingOpi);
                $("#descrAlojaOpi").summernote("code", data[0].descrOpi);
                $("#insertar-opiniones-form").on("submit", function (event) {
                    event.preventDefault();

                    var formData = new FormData($("#insertar-opiniones-form")[0]);

                    $.ajax({
                        url: "../../controller/alojamientos.php?op=comprobarEstadoOpi",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (texto) {
                            $('#editar-idioma-modal').modal('hide');

                            swal.fire(
                                'Valoración',
                                'Valoración editada',
                                'success'
                            )

                        } // del success
                    }); // del ajax

                    $('#insertar-opiniones-modal').modal('hide');

                });


            }
        } // del success
    }); // del ajax

}

// SUMMERNOTE MODAL INSERTAR 
actiSumernote('descrAlojaOpi'); 






// FORM AÑADIR OPINIONES
function insertarOpi() {
    $("#insertar-opiniones-form").on("submit", function (event) {
        event.preventDefault();

        var formData = new FormData($("#insertar-opiniones-form")[0]);

        $.ajax({
            url: "../../controller/alojamientos.php?op=comprobarEstadoOpi",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (texto) {

                swal.fire(
                    'Valoración',
                    'Valoración añadida',
                    'success'
                )
                $('#aloja2_table').DataTable().ajax.reload();

            } // del success
        }); // del ajax
        $('#agregar-opis-modal').modal('hide');

        // Vaciar los datos del FormData  
        $('#descrAlojaOpi').summernote('reset');
        $("#insertar-opiniones-form")[0].reset();
        $("#default-star-rating").raty('reload');
    });
}




//#######################################################\\
//#######################################################\\   
//#######################################################\\
//#######################################################\\

//rating

$(function () {

    $.fn.raty.defaults.path = '../../public/js/images/rating/';

    // Default
    $('#default-star-rating').raty();

});

$('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', true);
$(document).ready(function () {
    // Inicializar la librería raty
    $('#default-star-rating').raty();

    // Escuchar cambios en el campo de valoración
    $('#default-star-rating').on('click', function () {
        // Obtener el valor de la valoración
        var rating = $('#default-star-rating').raty('score');

        // Si el valor está vacío, deshabilitar el botón
        if (rating == '') {
            $('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', true);

        } else {
            // Si no, habilitar el botón
            $('#insertar-opiniones-form').find('button[type="submit"]').prop('disabled', false);

        }
    });
});


//***** CALENDARIO  */

/* 

$(document).ready(function () {

    // Load the Visualization API and the piechart package.
    google.charts.load('current', { 'packages': ['corechart'] });
    // para el grafico de calendario
    google.charts.load('current', { 'packages': ['calendar'] });


    google.charts.setOnLoadCallback(drawChart_3); // gráfico de calendario
    function drawChart_3() {
        const data = new google.visualization.DataTable();
        data.addColumn({ type: 'date', id: 'Fecha' });
        data.addColumn({ type: 'number', id: 'Ocupado' });
    
        $.ajax({
            url: "../../controller/chart.php?op=calendarioxllamadas",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                const rows = [];
                for (let i = 0; i < response.length; i++) {
                    const llamadas = parseInt(response[i].c_llamadas_total);
                    if (!isNaN(llamadas)) {
                        const fechaCompleta = new Date(response[i].fechaLlamada);
                        const fechaLlamada = new Date(fechaCompleta.getFullYear(), fechaCompleta.getMonth(), fechaCompleta.getDate());
                        rows.push([fechaLlamada, llamadas]);
                    }
                }
                data.addRows(rows);
    
                const options = {
                    title: 'Total de Llamadas por Fecha',
                    height: 350,
                    noDataPattern: {
                        backgroundColor: '#76a7fa',
                        color: '#a0c3ff'
                    },
                    calendar: {
                        cellSize: 23,
                        focusedCellColor: {
                            stroke: '#d3362d',
                            strokeOpacity: 1,
                            strokeWidth: 2,
                        },
                        dayOfWeekLabel: {
                            fontName: 'Roboto',
                            fontSize: 12,
                            color: '#1a8763',
                            bold: true,
                            italic: false,
                        },
                        daysOfWeek: 'DLMMJVS',
                        underYearSpace: 10,
                        yearLabel: {
                            fontName: 'Roboto',
                            fontSize: 32,
                            color: '#1A8763',
                            bold: true,
                            italic: false
                        }
                    }
                };
    
                const chart = new google.visualization.Calendar(document.getElementById('ch36'));
                chart.draw(data, options);
    
                google.visualization.events.addListener(chart, 'select', function () {
                    const selection = chart.getSelection();
                    if (selection.length > 0 && selection[0].date) {
                        const fecha = new Date(selection[0].date); // Convertir a Date real
                        const fechaFormateada = fecha.toISOString().split('T')[0];
                
                        // Mostrar fecha en el modal
                        $('#fechaSeleccionada').text(fechaFormateada);
                        $('#inputFecha').val(fechaFormateada);
                
                        // Elimina manualmente el tooltip de Google Charts si existe
                        $('.google-visualization-tooltip').remove();
                        // Mostrar el modal
                        const modal = new bootstrap.Modal(document.getElementById('modalFechaSeleccionada'));
                        modal.show();
                    }
                });
                
    
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data: " + error);
                $('#chart_div').html('<div class="alert alert-danger">Error al cargar el gráfico. Por favor, inténtelo de nuevo más tarde.</div>');
            }
        });
    }
    

}); */
  google.charts.load("current", { packages: ["calendar"] });
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var dataTable = new google.visualization.DataTable();
  dataTable.addColumn({ type: 'date', id: 'Día' });
  dataTable.addColumn({ type: 'number', id: 'Eventos' });
  dataTable.addColumn({ type: 'string', role: 'tooltip' });

  function addDateRange(data, startDate, endDate, value, tooltip) {
    let current = new Date(startDate);
    while (current <= endDate) {
      data.push([new Date(current), value, tooltip]);
      current.setDate(current.getDate() + 1);
    }
  }

  let data = [];

  // Obtener idAlumn global
  let idAlumn = $("#idAlumn").val();

  // Petición AJAX para traer alojamientos del alumno
  $.ajax({
    url: "../../controller/alojamientos.php?op=listarAlojamiento2&idAlumn=" + idAlumn,
    type: "GET",
    dataType: "json",
    success: function (response) {
      const alojamientos = response.aaData; // <<--- AQUÍ ESTABA EL PROBLEMA

      alojamientos.forEach(item => {
        const tipo = item[1];       // Ej: "Residencia de estudiantes"
        const alumno = item[2];     // Ej: "José Vilar Beas"
        const fechaInicioStr = item[3]; // "16-04-2025"
        const fechaFinHtml = item[4];   // "<b class=...>14:06</b> 30-04-2025"

        // Parsear fecha de inicio
        const inicioParts = fechaInicioStr.split("-");
        const fechaInicio = new Date(+inicioParts[2], +inicioParts[1] - 1, +inicioParts[0]);

        // Extraer fecha de fin con regex
        const matchFin = fechaFinHtml.match(/(\d{2})-(\d{2})-(\d{4})$/);
        if (!matchFin) return;

        const fechaFin = new Date(+matchFin[3], +matchFin[2] - 1, +matchFin[1]);

        // Tooltip personalizado
        const tooltip = `${tipo} - ${alumno}`;

        // Añadir rango dinámico
        addDateRange(data, fechaInicio, fechaFin, 5, tooltip);
      });

      // Agrega los datos al DataTable
      dataTable.addRows(data);

      var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

      var options = {
        title: "Alojamientos",
        height: 600,
        width: 1000,
        calendar: {
          cellSize: 20,
          focusedCellColor: {
            stroke: '#4285F4',
            strokeOpacity: 0.5,
            strokeWidth: 1
          }
        },
        noDataPattern: {
          backgroundColor: '#fff',
          color: '#eee'
        },
        colorAxis: {
          minValue: 0,
          maxValue: 10,
          colors: ['#cfe9ff', '#2196f3']  // De azul claro a azul más intenso
        }
      };

      chart.draw(dataTable, options);
    },
    error: function (e) {
      console.error("Error al cargar alojamientos:", e.responseText);
    }
  });
}

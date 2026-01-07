

/***************************************/
/******* MOSTRAR TABLA  ****************/
/***** DEPENDIENDO ROL ****************/
/***************************************/

rolUsuario = $('#rolUsuario').val();
if (rolUsuario == '1') //Administrador
{
    $('#tablaProfe').addClass('d-none');
    $('#tablaAdmin').removeClass('d-none');

} else { // Profesor
    $('#tablaProfe').removeClass('d-none');
    $('#tablaAdmin').addClass('d-none');
}

/***************************************/
/*********** BOTONES DE ACTIVAR Y DESACTIVAR *********/
/*************************************/
function activarActUsuario(idAct) {
    swal.fire({
        title: 'Activar',
        text: "¿Desea activar la actividad?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/actividades_edu.php?op=activar", { idAct: idAct }, function (data) {

                $('#act_usuario_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Activado',
                    'La actividad se ha activado',
                    'success'
                )
            });
        }
    })
}

function desactivarActUsuario(idAct) {
    swal.fire({
        title: 'Desactivar',
        text: "¿Desea desactivar la actividad?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/actividades_edu.php?op=eliminar", { idAct: idAct }, function (data) {

                $('#act_usuario_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Desactivado',
                    'La actividad se ha desactivado',
                    'success'
                )
            });
        }
    })
}
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
/***************************************************/
/*********** DATATABLE Actividades admin *********/
/*************************************************/

$('#act_admin_table').DataTable({

    columns: [

        { name: "idAct" },
        { name: "actividad" },
        { name: "fechaActividad" },
        { name: "horasLectivas" },
        { name: "puntoEncuentro" },
        { name: "Departamentos", "className": "text-center" },
        { name: "Aforo", "className": "text-center" },
        { name: "estado", "className": "text-center" },
        { name: "alumno", "className": "text-center" },
        { name: "cartel", "className": "text-center" },
        { name: "editar", "className": "text-center" },

    ],
    columnDefs: [

        // idAct
        { targets: [0], orderData: [0], visible: false },
        // actividad
        { targets: [1], orderData: [1], visible: true },
        // fechaActividad
        { targets: [2], orderData: [1], visible: true },
        { targets: [3], orderData: [1], visible: true },
        // horasLectivas
        { targets: [4], orderData: false, visible: true },
        // puntoEncuentro
        { targets: [5], orderData: [1], visible: true },
        // estado
        { targets: [6], orderData: [7], visible: true },
        // alumno
        { targets: [7], orderData: false, visible: true },
        // cartel
        { targets: [8], orderData: false, visible: true },
        // editar
        { targets: [9], orderData: false, visible: true },
        { targets: [10], orderData: false, visible: true },

    ],

    "ajax": {

        url: "../../controller/actividades_edu.php?op=mostrarActAdmin",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            // $('.submitBtn').attr("disabled", "disabled");
            // $('#usuario_data').css("opacity", "");
        },
        complete: function () {
            // Se eliminó acceso a extraData porque no existe en el JSON
            // $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
        },
        error: function (e) {
            console.log(e.responseText);
        }
    },
    orderFixed: [[1, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [1, 2, 3, 4, 5, 6, 7]
    },
}); // del DATATABLE




$('#act_admin_table').DataTable().on('draw.dt', function () {
    controlarFiltros('act_admin_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/
/***************************************/
/*********** RESPONSIVE DATATABLE *********/
/*************************************/
$('#act_admin_table').addClass('width-100'); //responsive


/***************************************/
/*********** DATATABLE Actividades admin *********/
/*************************************/
tableActProfe = $('#act_prof_table').DataTable({
    language: {
        emptyTable: "No hay actividades disponibles"
    },
    columns: [

        { name: "idAct" },
        { name: "idGuia", "className": "text-center" },
        { name: "actividad" },
        { name: "fechaActividad" },
        { name: "horario" },
        { name: "horasLectivas" },
        { name: "puntoEncuentro" },
        { name: "estado", "className": "text-center" },
        { name: "alumno", "className": "text-center" },
        { name: "cartel", "className": "text-center" },

    ],
    columnDefs: [

        //idAct
        { targets: [0], orderData: [0], visible: false },
        //actividad
        { targets: [1], orderData: [1], visible: true },
        //fechaActividad
        { targets: [2], orderData: [1], visible: true },
        //horario
        { targets: [3], orderData: [1], visible: true },
        //horasLectivas
        { targets: [4], orderData: [1], visible: true },
        //puntoEncuentro
        { targets: [5], orderData: [1], visible: true },
        //alumno
        { targets: [6], orderData: false, visible: true },
        //cartel
        { targets: [7], orderData: false, visible: true },

        { targets: [8], orderData: false, visible: true }, // Esta es la línea que oculta la última columna

        { targets: [9], orderData: false, visible: false } // Esta es la línea que oculta la última columna

    ],

    "ajax": {

        url: "../../controller/actividades_edu.php?op=mostrarActProf",
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
    orderFixed: [[1, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [0, 1, 2, 3, 4]
    },
});

     // Añadir la lógica de filtrado
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var filterValue = $('input[name="filter"]:checked').val();
    var idGuia = data[9]; // Columna correcta para idGuia

    console.log("Filtro seleccionado:", filterValue);
    console.log("idGuia fila:", idGuia, "vs idUsuarioProfesorado:", $('#idUsuarioProfesorado').val());

    if (filterValue === "all") {
        return true; // Mostrar todas las filas
    }
    if (filterValue === "idGuia") {
        return String(idGuia) === String($('#idUsuarioProfesorado').val());
    }
    return true; // Mostrar todas por defecto
});


    // Escuchar el cambio en los radiobuttons
    $('input[name="filter"]').on('change', function () {
        tableActProfe.draw(); // Refresca la tabla aplicando el filtro
    });

    tableActProfe.column(9).visible(false); // OCULTAMOS LA COLUMNA GUIA

$('#act_prof_table').DataTable().on('draw.dt', function () {
    controlarFiltros('act_prof_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

/*==================================*/
/*     FIN DEL DATATABLES           */
/*==================================*/

/***************************************/
/*********** RESPONSIVE DATATABLE *********/
/*************************************/
$('#act_prof_table').addClass('width-100'); //responsive







// PREVENIR QUE EN LOS CAMPOS MIN Y MAX ALUMNOS ENTREN CARACTERES NO NUMERICOS 
$(document).ready(function () {
    // Seleccione el campo de entrada "capaAula" por su identificador
    var capaAula = $('#minAlum-Tipo');

    // Agregue un controlador de eventos para el evento "keypress" en el campo de entrada
    capaAula.on('keypress', function (event) {
        // Obtener el código ASCII de la tecla presionada
        var charCode = (event.which) ? event.which : event.keyCode;

        // Permitir solo caracteres numéricos (códigos ASCII 48-57)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault(); // Impide la entrada de otros caracteres
        }
    });
});

$(document).ready(function () {
    // Seleccione el campo de entrada "capaAula" por su identificador
    var capaAula = $('#maxAlum-Tipo');

    // Agregue un controlador de eventos para el evento "keypress" en el campo de entrada
    capaAula.on('keypress', function (event) {
        // Obtener el código ASCII de la tecla presionada
        var charCode = (event.which) ? event.which : event.keyCode;

        // Permitir solo caracteres numéricos (códigos ASCII 48-57)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault(); // Impide la entrada de otros caracteres
        }
    });
});


//**********************************************************************/   
// FUNCION MIN Y MAX ALUMNOS (min no puede ser mayor que max y viceversa)
// MODAL INSERTAR 
$(document).ready(function () {
    // Obtener los inputs de minAlumTipo y maxAlumTipo
    var minAlumTipo = $('#minAlumTipo');
    var maxAlumTipo = $('#maxAlumTipo');

    // Agregar evento "change" a minAlumTipo
    minAlumTipo.on('change', function () {
        // Verificar si el valor es mayor que el de maxAlumTipo
        if (parseInt(minAlumTipo.val()) > parseInt(maxAlumTipo.val())) {
            // Actualizar el valor de maxAlumTipo
            maxAlumTipo.val(minAlumTipo.val()).trigger('change');
        }
        // Actualizar el atributo "max" de maxAlumTipo
        maxAlumTipo.attr('max', parseInt(minAlumTipo.val()));
    });

    // Agregar evento "change" a maxAlumTipo
    maxAlumTipo.on('change', function () {
        // Verificar si el valor es menor que el de minAlumTipo
        if (parseInt(maxAlumTipo.val()) < parseInt(minAlumTipo.val())) {
            // Actualizar el valor de minAlumTipo
            minAlumTipo.val(maxAlumTipo.val()).trigger('change');
        }
        // Actualizar el atributo "min" de minAlumTipo
        minAlumTipo.attr('min', parseInt(maxAlumTipo.val()));
    });
});
// MODAL EDITAR
$(document).ready(function () {
    // Obtener los inputs de minAlumTipo y maxAlumTipo
    var minAlumTipo = $('#minAlum-Tipo');
    var maxAlumTipo = $('#maxAlum-Tipo');

    // Agregar evento "change" a minAlumTipo
    minAlumTipo.on('change', function () {
        // Verificar si el valor es mayor que el de maxAlumTipo
        if (parseInt(minAlumTipo.val()) > parseInt(maxAlumTipo.val())) {
            // Actualizar el valor de maxAlumTipo
            maxAlumTipo.val(minAlumTipo.val()).trigger('change');
        }
        // Actualizar el atributo "max" de maxAlumTipo
        maxAlumTipo.attr('max', parseInt(minAlumTipo.val()));
    });

    // Agregar evento "change" a maxAlumTipo
    maxAlumTipo.on('change', function () {
        // Verificar si el valor es menor que el de minAlumTipo
        if (parseInt(maxAlumTipo.val()) < parseInt(minAlumTipo.val())) {
            // Actualizar el valor de minAlumTipo
            minAlumTipo.val(maxAlumTipo.val()).trigger('change');
        }
        // Actualizar el atributo "min" de minAlumTipo
        minAlumTipo.attr('min', parseInt(maxAlumTipo.val()));
    });
    
});
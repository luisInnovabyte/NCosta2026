idAloja = $('#idVisAloja').val();
var opis_table = $('#opis_table').DataTable({
    columns: [

        { name: "ID" },
        { name: "Nombre" },
        { name: "Correo" },
        { name: "Telefono" },
        { name: "Valoracion" },
        { name: "Comentario" },
        { name: "Fecha" },
        { name: "Acciones", className: "text-center" }
    ],
    columnDefs: [

        //ID
        { targets: [0], orderData: [0], visible: false },
        //Nombre
        { targets: [1], orderData: [1], visible: true },
        //Correo
        { targets: [2], orderData: [2], visible: true },
        //Telefono
        { targets: [3], orderData: [3], visible: true },
        //Valoracion
        { targets: [4], orderData: [1], visible: true },
        //Comentario
        { targets: [5], orderData: [0], visible: true },
        //Fecha
        { targets: [6], orderData: false, visible: true },
        //Acciones
        { targets: [7], orderData: false, visible: true, class:"secundariaDef" }

    ],

    "ajax": {


        url: "../../controller/alojamientos.php?op=listarOpisAlojamiento&idAloja=" + idAloja,
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
    orderFixed: [[0, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [0,1,2,3,4]
    },
});
//ANCHO del DATATABLE
$("#opis_table").addClass("width-100");



$('#opis_table').DataTable().on('draw.dt', function () {
    controlarFiltros('opis_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

//ANCHO del DATATABLE
$("#opis_table").addClass("width-100");




function activar(idOpi) {
    swal.fire({
        title: 'Activar',
        text: "¿Desea activar la opinión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=activarOpi", { idOpi: idOpi }, function (data) {

                $('#opis_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Activado',
                    'La opinión se ha activado',
                    'success'
                )
            });
        }
    })
}
/***********************************/
/**********DESACTIVAR OPI**************/
// /*********************************/
function desactivar(idOpi) {
    swal.fire({
        title: 'Desactivar',
        text: "¿Desea desactivar la opión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=desactivarOpi", { idOpi: idOpi }, function (data) {

                $('#opis_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Desactivado',
                    'La opinión se ha activado',
                    'success'
                )
            });
        }
    })
}

//cargar datos editar
function cargarDatos(idVis) {
    $.ajax({
        url: "../../controller/alojamientos.php?op=cargarDatosEditar",
        type: "POST",
        data: { 'idVis': idVis },
        dataType: "json",

        success: function (response) {
            $("#idVis").val(response[0]['IdAlojaVis']);
            $("#quienAlojaVis").val(response[0]['quienAlojaVis']);
            $("#descrImpreAloja").summernote('code', response[0]['descrImpreAloja']);
            $("#fechaAlojaVis").val(response[0]['fechaAlojaVis']);
        } // del success
    });// del ajax
}

$("#editar-opinion-form").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData($("#editar-opinion-form")[0]);

    $.ajax({
        url: "../../controller/alojamientos.php?op=editarOpinion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function () {

            $('#opis_table').DataTable().ajax.reload();

            swal.fire(
                'Editado',
                'La opinión se ha editado',
                'success'
            )
            $('#editar-opinion-modal').modal('hide');
        }
    }); // del success
}); // del ajax

actiSumernote('descrAlojaOpi'); 


//rating

$(function () {

    $.fn.raty.defaults.path = '../../public/js/images/rating/';

    // Default
    $('#default-star-rating').raty();

});
// select name
$.ajax({
    url: '../../controller/alojamientos.php?op=listarUsuariosSelect',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {
        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#nombreOpi").append("<option value='" + res[i][0] + "'>" + res[i][1] + " (" + res[i][2] + ")</option>");

            }


        }
    },
    complete: function (res) {
        /* var idUsuarioPre = $("#selectTrabajadores").val();
        $("#selectPais").val(idUsuarioPre); */
    }
});
// CARGAR DATOS CAMPOS EDITAR 
function cargarDatosEditar(idOpi) {

    $('#idAloja_AlojaOpi').val(idOpi);

    $.post("../../controller/alojamientos.php?op=obtenerOpiId", { idOpi: idOpi }, function (data) {

        var data = JSON.parse(data);

        $('#nombreOpi').val(data[0].idUsu_IdOpi);
        $("#fechaAlojaOpi").val(data[0].fechaOpi);
        $('#default-star-rating').raty('score', data[0].ratingOpi);
        $('#descrAlojaOpi').summernote('code', data[0].descrOpi);
    }) // Recuperar datos del cliente
}

// GUARDAR EDITAR
$("#editar-opinion-form").on("submit", function (event) {
    event.preventDefault();

    var formData = new FormData($("#editar-opinion-form")[0]);
    var rating = $('#default-star-rating').raty('score');
    formData.append('rating', rating);
    $.ajax({
        url: "../../controller/alojamientos.php?op=editarOpi",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (texto) {

            swal.fire(
                'Editado',
                'Datos de la opinión editados.',
                'success'
            )

            $('#opis_table').DataTable().ajax.reload();


        } // del success
    }); // del ajax

    $('#editar-opiniones-modal').modal('hide');
});
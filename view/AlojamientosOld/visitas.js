idVisita = $('#idVisAloja').val();

function cargarVisita(idVisita) {
    var visitas_table = $('#visitas_table').DataTable({
        columns: [

            { name: "ID" },
            { name: "Visitante" },
            { name: "Fecha visita" },
            { name: "Observacion" },
            { name: "Acciones", className: "text-center" }
        ],
        columnDefs: [

            //ID
            { targets: [0], orderData: [0], visible: false },
            //Visitante
            { targets: [1], orderData: [1], visible: true },
            //Fecha visita
            { targets: [2], orderData: [0], visible: true },
            //Observacion
            { targets: [3], orderData: false, visible: true },
            //Acciones
            { targets: [4], orderData: false, visible: true, class:"secundariaDef" }

        ],

        "ajax": {


            url: "../../controller/alojamientos.php?op=listarVisitasAlojamiento&idVisita=" + idVisita,
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
            columns: [0,1,2,3]
        },
    });
    //ANCHO del DATATABLE
    $("#visitas_table").addClass("width-100");
    
/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
$('#Visitante').on('keyup', function () {
    visitas_table
        .columns(1)
        .search(this.value)
        .draw();
});
$('#visitas_table').DataTable().on('draw.dt', function () {
    controlarFiltros('visitas_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

}

cargarVisita(idVisita);
//ANCHO del DATATABLE
$("#visitas_table").addClass("width-100");



function eliminarVisita(idAloja) {
    swal.fire({
        title: 'Visita',
        text: "¿Desea eliminar la visita?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=eliminarVisita", { idAloja_AlojaVi: idAloja }, function (data) {

                $('#visitas_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Visita',
                    'La visita se ha eliminado',
                    'success'
                )
            });
        }
    })
}

actiSumernote('descrImpreAloja'); 


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

$("#editar-visitas-form").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData($("#editar-visitas-form")[0]);

    $.ajax({
        url: "../../controller/alojamientos.php?op=editarVisita",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function () {

            $('#visitas_table').DataTable().ajax.reload();

            swal.fire(
                'Editado',
                'La visita se ha editado',
                'success'
            )
            $('#editar-visitas-modal').modal('hide');
        }
    }); // del success
}); // del ajax
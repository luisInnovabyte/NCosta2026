idAloja = $('#idVisAloja').val();
console.log("id de alojamiento:",idAloja);

var visitas_table = $('#visitas_table').DataTable({
    columns: [

        { name: "ID" },
        { name: "Visitante" },
        { name: "FechaVisita" },
        { name: "Observacion" },
        { name: "Acciones", className: "text-center" }
    ],
    columnDefs: [

        //ID
        { targets: [0], orderData: [0], visible: false },
        //VISITANTE
        { targets: [1], orderData: [1], visible: true },
        //FECHAVISITA
        { targets: [2], orderData: [2], visible: true },
        //OBSERVACIÓN
        { targets: [3], orderData: [3], visible: true },
        //ACCIONES
        { targets: [4], orderData: false, visible: true, class:"secundariaDef" }

    ],

    "ajax": {


        url: "../../controller/alojamientos.php?op=listarVisitasAlojamiento&idVisita=" + idAloja,
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            //    $('.submitBtn').attr("disabled","disabled");
            //    $('#usuario_data').css("opacity","");
        }, complete: function (data) {
                console.log("Datos recibidos:", data);

        },
        error: function (e) {
            console.log(e.responseText);
        }
    },
    orderFixed: [[0, "asc"]],
    searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
        columns: [1,2,3,4]
    },
});
//ANCHO del DATATABLE
$("#visitas_table").addClass("width-100");



$('#visitas_table').DataTable().on('draw.dt', function () {
    controlarFiltros('visitas_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});

//ANCHO del DATATABLE
$("#visitas_table").addClass("width-100");

/***********************************/
/**********ELIMINAR VISITA**************/
// /*********************************/
function eliminarVisita(idTokenVisita) {
    swal.fire({
        title: 'Eliminar',
        text: "¿Desea eliminar la visita?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controller/alojamientos.php?op=eliminarVisita", { idAloja_AlojaVi: idTokenVisita }, function (data) {

                $('#visitas_table').DataTable().ajax.reload();
    
                swal.fire(
                    'Desactivado',
                    'La visita se ha eliminado',
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
                console.log("Respuesta del servidor:", response);

            $("#idVis").val(response[0]['IdAlojaVis']);
            $("#quienAlojaVis").val(response[0]['quienAlojaVis']);
            $("#descrImpreAloja").summernote('code', response[0]['descrImpreAloja']);
            $("#fechaAlojaVis").val(response[0]['fechaAlojaVis']);
        } // del success
    });// del ajax
}

$("#editar-visitas-form").on("submit", function (e) {
    e.preventDefault();

    // Obtener valores y limpiar espacios
    const quienAlojaVis = $("#quienAlojaVis").val().trim();
    const fechaAlojaVis = $("#fechaAlojaVis").val().trim();
    // Para summernote: obtener contenido HTML, eliminar etiquetas y limpiar espacios
    const descrImpreAloja = $("#descrImpreAloja").summernote('code').replace(/<\/?[^>]+(>|$)/g, "").trim();

    let camposVacios = [];

    if (!quienAlojaVis) camposVacios.push("Visitante");
    if (!fechaAlojaVis) camposVacios.push("Fecha de visita");
    if (!descrImpreAloja) camposVacios.push("Descripción");

    if (camposVacios.length > 0) {
        Swal.fire({
            toast: true,
            icon: 'warning',
            title: `Completa los campos: ${camposVacios.join(", ")}`,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
        return;
    }

    // Todo bien, enviar formulario
    var formData = new FormData($("#editar-visitas-form")[0]);

    $.ajax({
        url: "../../controller/alojamientos.php?op=editarVisita",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            $('#visitas_table').DataTable().ajax.reload();
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'La visita se ha editado',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
            $('#editar-visitas-modal').modal('hide');
        }
    });
});





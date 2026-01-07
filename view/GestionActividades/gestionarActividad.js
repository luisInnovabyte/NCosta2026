$(document).ready(function () {
    
    $("#fecActDesde").on("change", function () {
        var fecActDesde = new Date($(this).val());
        $("#fecActHasta").val(fecActDesde.toISOString().split('T')[0]);
    });

    // Evento para calcular las horas lectivas al cambiar los campos relevantes
    $("#fecActDesde, #fecActHasta, #horaInicioAct, #horaFinAct").change(function () {
        calcularHorasLectivas();
    });

    // Función para calcular las horas lectivas
    function calcularHorasLectivas() {
        var fechaDesde = new Date($("#fecActDesde").val());
        var fechaHasta = new Date($("#fecActHasta").val());
        var horaInicio = $("#horaInicioAct").val();
        var horaFin = $("#horaFinAct").val();

        // Verificar que las fechas y horas sean válidas
        if (!isNaN(fechaDesde) && !isNaN(fechaHasta) && horaInicio && horaFin) {
            var diffInDays = Math.ceil((fechaHasta - fechaDesde) / (1000 * 60 * 60 * 24)); // Diferencia en días

            // Calcular horas lectivas en el primer día
            var horasLectivasPrimerDia = calcularHorasDia(horaInicio, "23:59");

            // Calcular horas lectivas en el último día
            var horasLectivasUltimoDia = calcularHorasDia("00:00", horaFin);

            // Calcular horas lectivas en los días intermedios
            var horasLectivasIntermedios = (diffInDays - 1) * 24;

            var horasLectivasAct = horasLectivasPrimerDia + horasLectivasUltimoDia + horasLectivasIntermedios;

            // Redondear el resultado y asegurarse de que no sea negativo
            horasLectivasAct = Math.max(Math.round(horasLectivasAct), 0);

            $("#horasLectivasAct").val(horasLectivasAct);
        }
    }

    // Función para calcular las horas entre una hora de inicio y una hora de fin en un día
    function calcularHorasDia(horaInicio, horaFin) {
        var horaInicioSplit = horaInicio.split(":");
        var horaFinSplit = horaFin.split(":");
        var horaInicioObj = new Date();
        var horaFinObj = new Date();

        horaInicioObj.setHours(horaInicioSplit[0], horaInicioSplit[1]);
        horaFinObj.setHours(horaFinSplit[0], horaFinSplit[1]);

        var diffInMillis = horaFinObj - horaInicioObj;
        var diffInHours = diffInMillis / (1000 * 60 * 60);

        return diffInHours;
    }

});
$("input[name='minAlumTipo']").TouchSpin(
    {
        min: 1,
        max: 999,
    }
);

$("input[name='maxAlumTipo']").TouchSpin(
    {
        min: 1,
        max: 999,
    }
);

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

$(document).ready(function () {
    // Seleccione el campo de entrada "capaAula" por su identificador
    var capaAula = $('#maxAlumTipo');

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
// recogemos IdActividad
idAct = $('#idAct').val();

// CREAR ACTIVIDAD (NO SE HA PASADO idAct)
if (idAct == '') {

    $("#current-page").text("Crear Actividad");
    $("#current-title").text("Crear Actividad");

    //Cargar listado de personal GUIA 
    $.ajax({
        url: '../../controller/personal_Edu.php?op=recogerPersonal',
        type: 'GET',
        dataType: 'json',
        error: function (error) {
            console.log(error);
        },
        success: function (res) {

            if (res.length > 0) {
                for (var i = 0; i < res.length; i++) {
                    $("#idPersonal_guiaAct").append("<option value='" + res[i].idPersonal + "'>" + res[i].nomPersonal + " " + res[i].apePersonal + "</option>");
                }
            }
        }
        // ,
        // complete: function (res) {
        //     var idUsuarioPre = $("#idPersonal_guiaAct").val();
        //     $("#idPersonal_guiaAct").val(idUsuarioPre);
        // }
    });

    $("#newActividad_form").on("submit", function (e) {

        e.preventDefault();
        var fecActDesde = new Date($("#fecActDesde").val());
        var fecActFinSolicitud = new Date($("#fecActFinSolicitud").val());

        var obsAct = $("#obsAct").val();

        if (obsAct == '') {
            // La fecha de inicio es menor que la fecha límite de inscripción
            toastr.error("Complete la descripción de la actividad");
            return;
        }

        if (fecActDesde < fecActFinSolicitud) {
            // La fecha de inicio es menor que la fecha límite de inscripción
            toastr.error("La fecha de inicio de la actividad no puede ser menor que la fecha límite de inscripción.");
            return;
        }

        // if (!fecActHasta) {
        //     fecActHasta = fecActDesde; // Asignar la fecha de inicio a la fecha de fin
        //     $("#fecActHasta").val(fecActHasta); // Actualizar el campo de fecha de fin
        // }


        if (fecActDesde < fecActFinSolicitud) {
            // La fecha de inicio es menor que la fecha límite de inscripción
            toastr.error("La fecha de inicio de la actividad no puede ser menor que la fecha límite de inscripción.");
            return;
        }

        var fecActHasta = new Date($("#fecActHasta").val());


        if (fecActHasta < fecActDesde) {
            // La fecha de fin de actividad es menor que la fecha de inicio
            toastr.error("La fecha de fin de la actividad no puede ser menor que la fecha de inicio.");
            return;
        }
        var minAlumTipoRegex = /^(?:[1-9]|[1-9][0-9]{1,2}|999)$/;
        var maxAlumTipoRegex = /^(?:[1-9]|[1-9][0-9]{1,2}|999)$/;
        var minAlumTipoValue = $('#minAlumTipo').val();
        var maxAlumTipoValue = $('#maxAlumTipo').val();

        if (!minAlumTipoRegex.test(minAlumTipoValue)) {
            swal.fire(
                'Error',
                'Formato inválido en el campo Mínimo de Alumnos (Min - 1 y Max - 999)',
                'error'
            );
            return;
        }

        if (!maxAlumTipoRegex.test(maxAlumTipoValue)) {
            swal.fire(
                'Error',
                'Formato inválido en el campo Máximo de Alumnos (Min - 1 y Max - 999)',
                'error'
            );
            return;
        }

        if (dropzoneError) {
            // Agregar aquí la acción que desee cuando se haya producido un error en el dropzone
            toastr["error"]('Error en la subida de archivos. Si el problema persiste, te sugerimos recargar la página.');
            console.log(dropzoneError);
            return;
        }

        // Agregar aquí la acción que desee cuando no se haya producido un error en el dropzone
        console.log("No se han producido errores en el dropzone");

        var formData = new FormData();

        // Recoger valores de los campos del formulario
        var descrAct = $("#descrAct").val();
        var fecActFinSolicitud = $("#fecActFinSolicitud").val();
        var fecActDesde = $("#fecActDesde").val();
        var fecActHasta = $("#fecActHasta").val();
        var horaInicioAct = $("#horaInicioAct").val();
        var horaFinAct = $("#horaFinAct").val();
        var horasLectivasAct = $("#horasLectivasAct").val();
        var puntoEncuentroAct = $("#puntoEncuentroAct").val();
        var idPersonal_guiaAct = $("#idPersonal_guiaAct").val();
        var minAlumTipoValue = $("#minAlumTipo").val();
        var maxAlumTipoValue = $("#maxAlumTipo").val();

        var obsAct = $("#obsAct").val();

        formData.append("descrAct", descrAct);
        formData.append("fecActFinSolicitud", fecActFinSolicitud);
        formData.append("fecActDesde", fecActDesde);
        formData.append("fecActHasta", fecActHasta);
        formData.append("horaInicioAct", horaInicioAct);
        formData.append("horaFinAct", horaFinAct);
        formData.append("horasLectivasAct", horasLectivasAct);
        formData.append("puntoEncuentroAct", puntoEncuentroAct);
        formData.append("idPersonal_guiaAct", idPersonal_guiaAct);
        formData.append("obsAct", obsAct);

        formData.append("minAlumTipo", minAlumTipoValue);
        formData.append("maxAlumTipo", maxAlumTipoValue);

        var files = myDropzone.files;

        for (var i = 0; i < files.length; i++) {
            formData.append("files[]", files[i]);
        }

        // Obtén los valores seleccionados
        var departamentosSelect = $('#departamentosSelect').val();
        formData.append("departamentos", departamentosSelect);

        // Enviar petición Ajax con los datos del formulario y los nombres de archivo del Dropzone
        $.ajax({
            url: "../../controller/actividades_edu.php?op=insertar",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == '1') {
                    Swal.fire({
                        title: 'Actividad creada con éxito',
                        text: "¿Qué deseas hacer ahora?",
                        icon: 'success',
                        showDenyButton: true,
                        showCancelButton: false,
                        allowOutsideClick: false, // Evita que se cierre haciendo clic fuera del modal
                        confirmButtonText: 'Crear más actividades',
                        denyButtonText: 'Ver actividades',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            // Redirigir
                            window.location.href = "gestionarActividad.php";
                        } else if (result.isDenied) {
                            window.location.href = "index.php";

                        }
                    })

                }else if(response == '00'){
                    toastr["error"]('Inserte una imagen.');

 
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error al enviar la petición Ajax: " + textStatus + ", " + errorThrown);
            }
        });
    });
}
// EDITAR ACTIVIDAD (SE HA PASADO idAct)
if (idAct !== '') {
    // Cambiar textos, botones...
    $("#current-page").text("Editar Actividad");
    $("#current-title").text("Editar Actividad");
    $("#botonGuardar").removeClass("btn-success").addClass("btn-info");
    $("#botonCambiarImg").removeClass("d-none");

    //Cargar listado de personal GUIA 
    $.ajax({
        url: '../../controller/personal_Edu.php?op=recogerPersonal',
        type: 'GET',
        dataType: 'json',
        error: function (error) {
            console.log(error);
        },
        success: function (res) {

            if (res.length > 0) {
                for (var i = 0; i < res.length; i++) {
                    $("#idPersonal_guiaAct").append("<option value='" + res[i].idPersonal + "'>" + res[i].nomPersonal + " " + res[i].apePersonal + "</option>");
                }
            }
        }
        // ,
        // complete: function (res) {
        //     var idUsuarioPre = $("#idPersonal_guiaAct").val();
        //     $("#idPersonal_guiaAct").val(idUsuarioPre);
        // }
    });
   
    // CARGA DE DATOS AL EDITAR
     $.ajax({
        url: "../../controller/actividades_edu.php?op=cargarDatosEditar",
        type: "POST",
        data: { 'idAct': idAct },
        dataType: "json",

        success: function (response) {
            $("#idAct").val(response[0]['idAct']);
            $("#descrAct").val(response[0]['descrAct']);
            $("#fecActFinSolicitud").val(response[0]['fecActFinSolicitud']);
            $("#fecActDesde").val(response[0]['fecActDesde']);
            $("#fecActHasta").val(response[0]['fecActHasta']);
            var horaInicio = moment(response[0]['horaInicioAct'], "HH:mm:ss").format("HH:mm");
        
            $("#horaInicioAct").val(horaInicio);
            var horaFin = moment(response[0]['horaFinAct'], "HH:mm:ss").format("HH:mm");
            $("#horaFinAct").val(horaFin);
            $("#horasLectivasAct").val(response[0]['horasLectivasAct']);
            $("#minAlumTipo").val(response[0]['minAlumAct']);
            $("#maxAlumTipo").val(response[0]['maxAlumAct']);
            $("#puntoEncuentroAct").val(response[0]['puntoEncuentroAct']);
            $("select#idPersonal_guiaAct").val(response[0]['idPersonal_guiaAct']);
            $("#obsAct").summernote('code', response[0]['obsAct']);
            $("#imgAct").val(response[0]['imgAct']);
            // DROPZONE
            $("#my-great-dropzone").addClass('d-none');
            $("#imgCabecera").removeClass('d-none').attr('src', `../../public/img/actividades/${response[0]['imgAct']}`);
            // MOSTRAR BOTONES ACTIVAR O DESACTIVAR
            if (response[0]['estadoAct'] == 1) {
                $("#desactivarActividad").removeClass('d-none');
            }
            else if (response[0]['estadoAct'] == 0) {
                $("#activarActividad").removeClass('d-none');
            }
        } // del success
    });// del ajax


    // FUNCIONALIDAD BOTONES ACTIVAR Y DESACTIVAR
    /***********************************/
    /**********ACTIVAR ACTIVIDAD**************/
    /*********************************/

    function activar(idAct) {
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

                $.post("../../controller/actividades_edu.php?op=activarActividad", { idAct: idAct }, function (data) {
                    swal.fire(
                        'Activado',
                        'La Actividad se ha activado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            $("#activarActividad").addClass('d-none');
                            $("#desactivarActividad").removeClass('d-none');
                        }
                    });
                });

            }
        })
    }
    /***********************************/
    /****DESACTIVAR MEDIDAALOJA********/
    /*********************************/
    function desactivar(idAct) {
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

                $.post("../../controller/actividades_edu.php?op=desactivarActividad", { idAct: idAct }, function (data) {
                    swal.fire(
                        'Desactivado',
                        'La Actividad se ha desactivado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            $("#desactivarActividad").addClass('d-none');
                            $("#activarActividad").removeClass('d-none');
                        }
                    });
                });

            }
        })
    }


    $("#newActividad_form").on("submit", function (e) {

        e.preventDefault();
        var fecActDesde = new Date($("#fecActDesde").val());
        var fecActFinSolicitud = new Date($("#fecActFinSolicitud").val());
        // if (!fecActHasta) {
        //     fecActHasta = fecActDesde; // Asignar la fecha de inicio a la fecha de fin
        //     $("#fecActHasta").val(fecActHasta); // Actualizar el campo de fecha de fin
        // }

        if (fecActDesde < fecActFinSolicitud) {
            // La fecha de inicio es menor que la fecha límite de inscripción
            toastr.error("La fecha de inicio de la actividad no puede ser menor que la fecha límite de inscripción.");
            return;
        }

        var fecActHasta = new Date($("#fecActHasta").val());


        if (fecActHasta < fecActDesde) {
            // La fecha de fin de actividad es menor que la fecha de inicio
            toastr.error("La fecha de fin de la actividad no puede ser menor que la fecha de inicio.");
            return;
        }



        if (dropzoneError) {
            // Agregar aquí la acción que desee cuando se haya producido un error en el dropzone
            toastr["error"]("<svg width='27px' height='27px' viewBox='0 0 54 54' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:sketch='http://www.bohemiancoding.com/sketch/ns'><title>Error</title><defs></defs><g id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd' sketch:type='MSPage'><g id='Check-+-Oval-2' sketch:type='MSLayerGroup' stroke='#747474' stroke-opacity='0.198794158' fill='#FFFFFF' fill-opacity='0.816519475'> <path d='M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z' id='Oval-2' sketch:type='MSShapeGroup'></path></g></g></svg>", 'Error en la subida de archivos');

            return;
        }

        // Agregar aquí la acción que desee cuando no se haya producido un error en el dropzone
        console.log("No se han producido errores en el dropzone");

        var formData = new FormData();

        // Recoger valores de los campos del formulario
        var idAct = $("#idAct").val();
        var descrAct = $("#descrAct").val();
        var fecActFinSolicitud = $("#fecActFinSolicitud").val();
        var fecActDesde = $("#fecActDesde").val();
        var fecActHasta = $("#fecActHasta").val();
        var horaInicioAct = $("#horaInicioAct").val();
        var horaFinAct = $("#horaFinAct").val();
        var horasLectivasAct = $("#horasLectivasAct").val();
        
        var puntoEncuentroAct = $("#puntoEncuentroAct").val();
        var idPersonal_guiaAct = $("#idPersonal_guiaAct").val();
        var obsAct = $("#obsAct").val();
        var imgAct = $("#imgAct").val();
        var minAlumTipo = $("#minAlumTipo").val();
        var maxAlumTipo = $("#maxAlumTipo").val();

        formData.append("idAct", idAct);
        formData.append("descrAct", descrAct);
        formData.append("fecActFinSolicitud", fecActFinSolicitud);
        formData.append("fecActDesde", fecActDesde);
        formData.append("fecActHasta", fecActHasta);
        formData.append("horaInicioAct", horaInicioAct);
        formData.append("horaFinAct", horaFinAct);
        formData.append("horasLectivasAct", horasLectivasAct);
        formData.append("puntoEncuentroAct", puntoEncuentroAct);
        formData.append("idPersonal_guiaAct", idPersonal_guiaAct);
        formData.append("obsAct", obsAct);
        formData.append("minAlumTipo", minAlumTipo);
        formData.append("maxAlumTipo", maxAlumTipo);
        var departamentosSelect = $('#departamentosSelect').val();
       
        formData.append("departamentos", departamentosSelect);
        var files = myDropzone.files;

        if (files.length == 0) {
            formData.append("imgAct", imgAct);
        }
        else {
            for (var i = 0; i < files.length; i++) {
                formData.append("files[]", files[i]);
            }
        }
      

        // Enviar petición Ajax con los datos del formulario y los nombres de archivo del Dropzone
        $.ajax({
            url: "../../controller/actividades_edu.php?op=editar",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == '1') {
                    Swal.fire({
                        title: 'Actividad editada con éxito',
                        text: "",
                        icon: 'success',
                        showCancelButton: false,
                        allowOutsideClick: false, // Evita que se cierre haciendo clic fuera del modal
                        denyButtonText: 'Ver actividades',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            // Redirigir
                            window.location.href = "index.php";
                        } else if (result.isDenied) {
                            window.location.href = "index.php";

                        }
                    })

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error al enviar la petición Ajax: " + textStatus + ", " + errorThrown);
            }
        });
    });

}

function showDropzone() {
    if ($("#my-great-dropzone").hasClass('d-none')) {
        $("#imgCabecera").addClass('d-none');
        $("#my-great-dropzone").removeClass('d-none');
    }
    else {
        $("#imgCabecera").removeClass('d-none');
        $("#my-great-dropzone").addClass('d-none');
    }
}




// SUMMERNOTE OBSERVACIONES
actiSumernote('obsAct'); 


// Configuracion del DROPZONE
Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("#my-great-dropzone", {
    addRemoveLinks: true,
    paramName: "file[]", // El nombre que se le dará al archivo en la petición POST
    maxFiles: 1,
    maxFilesize: 2, // Tamaño máximo permitido de los archivos (en MB)
    acceptedFiles: ".jpeg,.jpg,.png", // Tipos de archivos aceptados
    success: function (file, response) {
        alert(errorMessage);
        // Hacer algo con los nombres de archivo y la respuesta del servidor, como agregarlos a un array y enviarlos mediante Ajax
    }
});

var dropzoneError = false;
myDropzone.on("removedfile", function (file) {
    if (file.status === "error") {
        dropzoneError = false;
    }
});
myDropzone.on("error", function (file, errorMessage) {
    dropzoneError = true;
    toastr["error"](errorMessage, 'Error al cargar el archivo ' + file.name);

    $('#miBotonSubir').addClass('d-none');
});

myDropzone.on("success", function (file) {
    if (!dropzoneError && myDropzone.getQueuedFiles().length === 0) {
        // Ejecutar acción en caso de que no haya errores y no haya archivos en el dropzone
        console.log("No hay archivos en el dropzone");
    } else if (!dropzoneError) {
        // Ejecutar acción en caso de que no haya errores y haya archivos en el dropzone
        console.log("Archivos cargados con éxito");
        // Aquí puedes agregar la acción que deseas ejecutar
    }
});

//**********************************************************************/
//*********************************************************************/
//********** VALIDACION CAMPOS ***************************************/
//*******************************************************************/
//******************************************************************/                                   

$('#descrAct').blur(function () {
    campo1 = new validarCampos($('#descrAct'), /^[a-zA-Z0-9áéíóúÁÉÍÓÚüÜñÑ.,;:¿?!¡()\-/ ]{0,100}$/gm, $('#infoDescrAct'));
    campo1.validar();
});

$('#fecActFinSolicitud').blur(function () {
    campo1 = new validarCampos($('#fecActFinSolicitud'), /^(\d{4})-(0[1-9]|1[0-2])-([0-2][1-9]|3[01])$/gm, $('#infoFecActFinSolicitud'));
    campo1.validar();
});
$('#fecActDesde').blur(function () {
    campo1 = new validarCampos($('#fecActDesde'), /^(\d{4})-(0[1-9]|1[0-2])-([0-2][1-9]|3[01])$/gm, $('#infoFecActDesde'));
    campo1.validar();
});
$('#fecActHasta').blur(function () {
    campo1 = new validarCampos($('#fecActHasta'), /^(\d{4})-(0[1-9]|1[0-2])-([0-2][1-9]|3[01])$/gm, $('#infoFecActHasta'));
    campo1.validar();
});
$('#horaInicioAct').blur(function () {
    campo1 = new validarCampos($('#horaInicioAct'), /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/gm, $('#infoHoraInicioAct'));
    campo1.validar();
});
// $('#horaFinAct').blur(function () {
//     campo1 = new validarCampos($('#horaFinAct'), /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/gm, $('#infoHoraFinAct'));
//     campo1.validar();
// });
$('#horasLectivasAct').blur(function () {
    campo1 = new validarCampos($('#horasLectivasAct'), /^\d{0,11}$/gm, $('#infoHorasLectivasAct'));
    campo1.validar();
});
$('#puntoEncuentroAct').blur(function () {
    campo1 = new validarCampos($('#puntoEncuentroAct'), /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,;:¡!¿?'"\-_\s]{0,105}$/gm, $('#infoPuntoEncuentroAct'));
    campo1.validar();
});
$('#obsAct').blur(function () {
    campo1 = new validarCampos($('#obsAct'), /^[\s\S]{0,16777215}$/gm, $('#infoObsAct'));
    campo1.validar();
});


//DESABILITAR BOTON GUARDAR
/* $(document).ready(function () {
    // Verificar si los campos con el símbolo * están vacíos
    function checkEmptyFields() {
        var empty = false;
        $('input[required]').each(function () {
            if ($(this).val() == '') {
                empty = true;
            }
        });
        return empty;
    }

    // Desactivar el botón de guardar si hay campos vacíos
    $('#botonGuardar').prop('disabled', checkEmptyFields());
    $('input[required]').on('keyup blur', function () {
        $('#botonGuardar').prop('disabled', checkEmptyFields());
    });
}); */
$(".js-example-placeholder-multiple").select2({
    theme: "bootstrap-5", // Tema de Bootstrap 5
    allowClear: true, // Permite limpiar la selección
    placeholder: 'Seleccione departamentos',
    language: {
      
        noResults: function () {
            return 'No se encontraron resultados';
        },
        searching: function () {
            return 'Buscando...';
        }
    },
  
});

$('#idPersonal_guiaAct').select2({
    theme: "bootstrap-5", // Tema de Bootstrap 5
    placeholder: $('#idPersonal_guiaAct').data('placeholder'), // Obtener el placeholder desde el atributo data-placeholder
    closeOnSelect: true, // Cierra el menú después de seleccionar un elemento
    allowClear: true, // Permite limpiar la selección
    language: {
        inputTooShort: function (args) {
            var remainingChars = args.minimum - args.input.length;
            return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
        },
        maximumSelected: function (args) {
            return 'Solo puedes seleccionar ' + args.maximum + ' elemento';
        },
        noResults: function () {
            return 'No se encontraron resultados';
        },
        searching: function () {
            return 'Buscando...';
        }
    },
    minimumResultsForSearch: 0 // Esto hace que la búsqueda siempre esté visible, incluso con pocos elementos
  });
// CARGA DE DATOS AL EDITAR

$.ajax({
    url: '../../controller/mntPreinscripciones.php?op=recogerDepartamentosActivo',
    type: 'GET',
    dataType: 'json',
    error: function (error) {
        console.log(error);
    },
    success: function (res) {

        if (res.length > 0) {
            for (var i = 0; i < res.length; i++) {
                $("#departamentosSelect").append("<option value='" + res[i].idDepartamentoEdu + "'>" + res[i].nombreDepartamento + "</option>");
            }
        }

        $.ajax({
            url: "../../controller/actividades_edu.php?op=cargarDatosEditar",
            type: "POST",
            data: { 'idAct': idAct },
            dataType: "json",

            success: function (response) {
                console.log(response);
                $("#idAct").val(response[0]['idAct']);
                $("#descrAct").val(response[0]['descrAct']);
                $("#fecActFinSolicitud").val(response[0]['fecActFinSolicitud']);
                $("#fecActDesde").val(response[0]['fecActDesde']);
                $("#fecActHasta").val(response[0]['fecActHasta']);
                var horaInicio = moment(response[0]['horaInicioAct'], "HH:mm:ss").format("HH:mm");
            
                $("#horaInicioAct").val(horaInicio);
                var horaFin = moment(response[0]['horaFinAct'], "HH:mm:ss").format("HH:mm");
                $("#horaFinAct").val(horaFin);
                $("#horasLectivasAct").val(response[0]['horasLectivasAct']);
                $("#minAlumTipo").val(response[0]['minAlumAct']);
                $("#maxAlumTipo").val(response[0]['maxAlumAct']);
                $("#puntoEncuentroAct").val(response[0]['puntoEncuentroAct']);
                // Asignar el valor al select con Select2
                $("#idPersonal_guiaAct").val(response[0]['idPersonal_guiaAct']).trigger('change');

                $("#obsAct").summernote('code', response[0]['obsAct']);
                $("#imgAct").val(response[0]['imgAct']);
                // DROPZONE
                $("#my-great-dropzone").addClass('d-none');
                $("#imgCabecera").removeClass('d-none').attr('src', `../../public/img/actividades/${response[0]['imgAct']}`);
                // MOSTRAR BOTONES ACTIVAR O DESACTIVAR
                if (response[0]['estadoAct'] == 1) {
                    $("#desactivarActividad").removeClass('d-none');
                }
                else if (response[0]['estadoAct'] == 0) {
                    $("#activarActividad").removeClass('d-none');
                }
              
                    departamentoBD = response[0]['idsDepartamentos'];
                    // Convierte los valores a un array
                    var departamentos = departamentoBD.split(',');
                    // Asigna los valores al select
                    $('#departamentosSelect').val(departamentos);
                    // Actualiza el select2 para reflejar los valores seleccionados
                    $('#departamentosSelect').trigger('change');
                        // Aquí puedes poner cualquier otra acción que desees realizar
            

            
            } // del success
        });// del ajax

        }
        
        });

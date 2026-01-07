if (!codGrupoTabla2) {
    // CREACIÓN DE GRUPO
    
    // DATOS DE LA LISTA DE ALUMNOS
    let seleccionados = [];
    let noSeleccionados = [];

    // Recoge los seleccionados
    $('#listAddAlumnos option:selected').each(function () {
        seleccionados.push($(this).val());
    });

    // Recoge los NO seleccionados
    $('#listAddAlumnos option:not(:selected)').each(function () {
        noSeleccionados.push($(this).val());
    });

    console.log("Seleccionados:", seleccionados);
    console.log("No Seleccionados:", noSeleccionados);

    console.log("Alum IZ:", alumnosIzquierda);
    console.log("Alum Derec:", alumnosDerecha);

    console.log("Lista total Izquierda:", alumnosIzquierda);
    console.log("Lista actual:", noSeleccionados);

    // Extraer los IDs de la lista inicial
    let idsIzquierda = alumnosIzquierda.map(alumno => String(alumno[0])); // Convertimos a string si es necesario
    // Determinar quiénes se añadieron (están en noSeleccionados pero no en alumnosIzquierda)
    let addListaIzquierda = noSeleccionados.filter(id => !idsIzquierda.includes(String(id)));
    // Determinar quiénes ya no están (estaban en alumnosIzquierda pero no en noSeleccionados)
    let eliminadosListaIzquierda = alumnosIzquierda.filter(alumno => !noSeleccionados.includes(String(alumno[0])));
    console.log("add Izq:", addListaIzquierda);
    console.log("Eliminados Izq:", eliminadosListaIzquierda); 


    // Extraer los IDs de la lista inicial
    let idsDerecha = alumnosDerecha.map(alumnoD => String(alumnoD[0])); // Convertimos a string si es necesario
    // Determinar quiénes se añadieron (están en noSeleccionados pero no en alumnosIzquierda)
    let addListaDerecha = seleccionados.filter(idD => !idsDerecha.includes(String(idD)));
    // Determinar quiénes ya no están (estaban en alumnosIzquierda pero no en noSeleccionados)
    let eliminadosListaDerecha = alumnosDerecha.filter(alumnoD => !seleccionados.includes(String(alumnoD[0])));
    console.log("add Der:", addListaDerecha);
    console.log("Eliminados Der:", eliminadosListaDerecha); 

    // --- GENERACIÓN DE CÓDIGO NUEVO ---
    codigoNuevo = $('#codigoText').text(); //ESIGA2
    let fechaActual = new Date().toISOString().split('T')[0].replace(/-/g, ''); 
    let codNivel = codigoNuevo + fechaActual; // Concatena el grupo con la fecha
    console.log("Nuevo código generado:", codNivel);
      // INFORMACION DE LA LLEGADA //
    $.ajax({
        url: "../../controller/grupos.php?op=crearGruposAlumnos",
        type: "POST",
        dataType: "json",
        contentType: "application/json", // Importante para enviar JSON
        cache: false,
        processData: false,
        data: JSON.stringify({
            codGrupoTabla1: codGrupoTabla1,
            identificadorTabla1:identificadorTabla1,
            addListaIzquierda: addListaIzquierda,
            eliminadosListaIzquierda: eliminadosListaIzquierda,
            addListaDerecha: addListaDerecha,
            codNivel:codNivel,
            fechaActual:fechaActual
        }),
        success: function(response) {
            console.log("Datos procesados:", response);
            toastr.success('Los grupos '+codGrupoTabla1+ ' y '+codGrupoTabla2+' han sido actualizados.')
            cambiarAlumnoACursos();
            descargando();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición:", textStatus, errorThrown);
            descargando();

        }
        
    });



    descargando();
}else{ // ACCEDEMOS A PASAR LOS GRUPOS
    }
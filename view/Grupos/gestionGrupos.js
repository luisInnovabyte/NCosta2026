
  //* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *////* FUNCION PARA CAMBIAR EL COLOR DE LETRA SI ES NECESARIO *//
  //* ******* **** ******* ** ***** ** ***** ** ** ********* *////* ******* **** ******* ** ***** ** ***** ** ** ********* *//
  $('.duallistbox-nuevo-curso').bootstrapDualListbox({
    moveSelectedLabel: 'Añadir seleccionado',
    moveAllLabel: 'Añadir Todos',
    removeSelectedLabel: 'Eliminar Seleccionado',
    removeAllLabel: 'Eliminar Todo',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: false,

})
  var isDark = isColorDark("#000000"); //? TRUE SI EL COLOR ES OSCURO FALSE SI ES CLARO
  
  var colorLetra = "black";
  var alumnosDerecha;
  var alumnosIzquierda;
  //* ********** *////* ********** *////* ********** *////* ********** *////* ********** *////* ********** *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
  //* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *////* DATATABLES *//
    // Desactivar temporalmente los botones de transferencia
  /*   function desactivarTransferencia() {
        console.log('Desactivando');
        $('.move, .remove, .moveAll, .removeAll').prop('disabled', true);
    }

    // Activar nuevamente los botones de transferencia
    function activarTransferencia() {
        $('.move, .remove, .moveAll, .removeAll').prop('disabled', false);
    } */

    cargarTablaCursosTodos();
    function cargarTablaCursosTodos() {
        var cursosTablaTodos = $("#cursosTablaTodos").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
           
            columns: [
                { name: "idCurso" },
                { name: "Ruta", className: "text-center" },
                { name: "Codigo", className: "text-center" },
                { name: "Fecha", className: "text-center" },
                { name: "Alumnos Apuntados", className: "text-center" },
                { name: "Capacidad", className: "text-center" },
                { name: "idGrupo", className: "text-center" },
                { name: "codGrupo", className: "text-center" },
                { name: "idRuta", className: "d-none" },
                { name: "codIdioma", className: "d-none"},
                { name: "codTipoCurso", className: "d-none" },
                { name: "idNumIdioma", className: "d-none"},
                { name: "idNumcodTipoCurso", className: "d-none" }
            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: false, // Oculta la columna ID
                }
            ],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6,7,8,9,10,11], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/grupos.php?op=mostrarGruposTodos",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
               
                beforeSend: function () {
                    // Aquí puedes agregar acciones antes de la solicitud
                },
                complete: function (data) {
                    // Aquí puedes agregar acciones después de la solicitud
                },
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            }
        });
        cursosTablaTodos.page.len(5).draw();

      

    }
    
    function cargarRutas(){
       $('#divRutas').removeClass('d-none');
       $('#divCursosRight').addClass('d-none');
       $('#divNewGrupo').addClass('d-none');

       
       let idioma = $("#idIiomaTablaT").val();
       let curso = $("#idTipoCursoTablaT").val();
       $("#selectIdioma").val(idioma).trigger('change');
       $("#selectCurso").val(curso).trigger('change');


    }
    function cambiarAlumnoACursos(){
        $("#listAddAlumnos").html("");
        // FUNCION DE LA TABLA PRINCIPAL, QUE VUELVE AL ESTADO INICIAL PARA SELECCIONAR LOS GRUPOS
        $('#divAlumnosTablaTodos').addClass('d-none');
        $('#divCursosTablaTodos').removeClass('d-none');

        $('#divAlumnos').addClass('d-none');

        $('#alertCursos').removeClass('d-none');

        $('#divCursosRight').addClass('d-none');
        $('#divAlumnosTablaRight').addClass('d-none');

        $('#divBotonesNewL').addClass('d-none')
        $('#divBotonesNewR').addClass('d-none')
        $('#divNewGrupo').addClass('d-none')

        $('#divRutas').addClass('d-none');
        $('#divAlumnosTablaRutaRight').addClass('d-none')

        $('#codGrupoTablaT').text('');
        $('#identificadorTablaT').text('');
        
        $('#codGrupoTablaR').text('');
        $('#identificadorTablaR').text('');

        $('#divDatosRutaR').addClass('d-none');

    }

    function cambiarAlumnoACursosRight(){
        $('#divAlumnosTablaRight').addClass('d-none');
        $('#divCursosRight').removeClass('d-none');

        $('#divAlumnos').addClass('d-none');

        $('#listAddAlumnos option:selected').remove();
        $('#listAddAlumnos').bootstrapDualListbox('refresh'); // Refresca el Dual List Box
        $('#divBotonesNewR').addClass('d-none')

        $('#divNewGrupo').removeClass('d-none');
        $('#divAlumnosTablaRutaRight').addClass('d-none')
        
        $('#divDatosRutaR').addClass('d-none') 

        $('#codGrupoTablaR').text('');
        $('#identificadorTablaR').text('');

     
    }


    $('#cursosTablaTodos tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        $('#divBotonesNewL').removeClass('d-none')

        $('#divNewGrupo').removeClass('d-none');

        toastr.info('Curso seleccionado');
        var tabla = $('#cursosTablaTodos').DataTable();
        $('#alertCursos').addClass('d-none');
        // Obtén el objeto de datos de la fila actual
        var data = tabla.row(this).data();
        var rutaLabels = data[1];
        console.log(rutaLabels);
        var codigoText = data[2];
        console.log(codigoText);
        var fechaInicio = data[3];
        console.log(fechaInicio);
        var alumnosApuntados = data[4];
        console.log(alumnosApuntados);
        var capacidad = data[5];
        console.log(capacidad);
        var idCursoNum = data[6];
        console.log(idCursoNum);
        var codGrupo = data[7];
        console.log(codGrupo);
        var idRuta = data[8];
        console.log(idRuta);
        var codIdioma = data[9];
        console.log(codIdioma);
        var codTipoCurso = data[10];
        console.log(codTipoCurso);
        var idIdioma = data[11];
        console.log(idIdioma);
        var idTipoCurso = data[12];
        console.log(idTipoCurso);

        $('#idIiomaTablaT').val(idIdioma);
        $('#idTipoCursoTablaT').val(idTipoCurso);

        // CARGAR TABLA RIGHT
        cargarTablaCursos(idRuta, codGrupo,codIdioma,codTipoCurso);
        // ASIGNACION DE DATOS
        $('#labelsRuta').html('')
        $('#labelsRuta').append(rutaLabels)
        

        $('#codigoTablaT').html('')
        $('#codigoTablaT').append(codigoText)

        $('#fechaInicioTablaT').html('')
        $('#fechaInicioTablaT').append(fechaInicio)

        $('#alumnosInscritosTablaT').html('')
        $('#alumnosInscritosTablaT').append(alumnosApuntados)
    
        $('#capacidadInscritoTablaT').html('')
        $('#capacidadInscritoTablaT').append(capacidad)
      
        $('#identificadorTablaT').html('')
        $('#identificadorTablaT').append(idCursoNum)
              
        $('#codGrupoTablaT').html('')
        $('#codGrupoTablaT').append(codGrupo)
 

        $('#divAlumnosTablaTodos').removeClass('d-none');
        $('#divCursosTablaTodos').addClass('d-none');

        $('#divCursosRight').removeClass('d-none');

         
        $.get("../../controller/grupos.php", 
            {
                op: "mostrarAlumnosCodGrupo", 
                codGrupo: codGrupo
            }, 
            function(response) {   
                console.log(response);  
        
                // Convertir la respuesta JSON en un array de objetos
                alumnosIzquierda = JSON.parse(response);
                $("#listAddAlumnos").html("");
         
                for (var i = 0; i < alumnosIzquierda.length; i++) {
                    var row = alumnosIzquierda[i];
                    let fechaNuevaCurso = '';

                    if (alumnosIzquierda[i].fechaNuevaCursos) {
                    // Convertir la fecha a objeto Date
                    const fecha = new Date(alumnosIzquierda[i].fechaNuevaCursos);

                    // Formatear en formato europeo (dd/mm/yyyy)
                    const dia = String(fecha.getDate()).padStart(2, '0');
                    const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                    const anio = fecha.getFullYear();

                    fechaNuevaCurso = ' - Salto el: ' + dia + '/' + mes + '/' + anio;
                    } else {
                    // Si no hay fecha, lo dejamos vacío
                    fechaNuevaCurso = '';
                    }
                        $("#listAddAlumnos").append("<option value="+alumnosIzquierda[i].idCurso+">("+alumnosIzquierda[i].idCurso+' - '+ (alumnosIzquierda[i].emailUsuario ? alumnosIzquierda[i].emailUsuario : '') +") "+ (alumnosIzquierda[i].nomAlumno ? alumnosIzquierda[i].nomAlumno : '') +" "+ (alumnosIzquierda[i].apeAlumno ? alumnosIzquierda[i].apeAlumno : '')+ fechaNuevaCurso +"</option>");
                     
                }
                $('#listAddAlumnos').bootstrapDualListbox('refresh');

            }
        ).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición:", textStatus, errorThrown);
        });
        
      
     
      });
  
     
      // TABLA 2 RIGHT

      function cargarTablaCursos(idCursoSeleccionado,codGrupo,codIdioma,codTipoCurso) {
        console.log(idCursoSeleccionado);
         var cursosTabla = $("#cursosTablaRight").DataTable({
            pageLength: 5, // Muestra solo 5 registros por página
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]], // Opciones del selector de registros
            select: false, // No permite seleccionar filas para exportar
            buttons:[],
            columns: [
                { name: "idCurso" },
                { name: "Ruta", className: "text-center" },
                { name: "Codigo", className: "text-center" },
                { name: "Fecha", className: "text-center" },
                { name: "FechaFin", className: "text-center" },
                { name: "Alumnos Apuntados", className: "text-center" },
                { name: "Capacidad", className: "text-center" },
                { name: "idGrupo", className: "text-center" },
                { name: "codGrupo", className: "text-center" }

            ],
            columnDefs: [
                {
                    targets: [0],
                    visible: false, // Oculta la columna ID
                }
            ],
            searchBuilder: {
                columns: [1, 2, 3, 4,5,6,7,8], // Ajustado a las columnas existentes
            },
            ajax: {
                url: "../../controller/grupos.php?op=mostrarGruposTodosRight",
                type: "get",
                dataType: "json",
                cache: false,
                serverSide: true,
                data: { idCursoSeleccionado: idCursoSeleccionado, codGrupo:codGrupo, codIdioma:codIdioma, codTipoCurso:codTipoCurso},
                beforeSend: function () {
                    // Aquí puedes agregar acciones antes de la solicitud
                },
                complete: function (data) {
                    // Aquí puedes agregar acciones después de la solicitud
                },
                error: function (e) {
                    console.error("Error en la carga de la tabla:", e);
                }
            }
        });
        cursosTabla.page.len(5).draw();

        $("#cursosTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE
 
    }



    // SELECCIONAR GRUPO RIGHT
    
    $('#cursosTablaRight tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
        // Obtén la instancia de la tabla DataTables
        toastr.info('Curso seleccionado');
        $('#divBotonesNewR').removeClass('d-none')
        $('#divNewGrupo').addClass('d-none')

        
        var tabla = $('#cursosTablaRight').DataTable();
      
        // Obtén el objeto de datos de la fila actual
        var data = tabla.row(this).data();
        var rutaLabels = data[1];
        console.log(rutaLabels);
        var codigoText = data[2];
        console.log(codigoText);
        var fechaInicio = data[3];
        console.log(fechaInicio);
        var alumnosApuntados = data[5];
        console.log(alumnosApuntados);
        var capacidad = data[6];
        console.log(capacidad);
        var idCursoNum = data[7];
        console.log(idCursoNum);
        var codGrupo = data[8];
        console.log(codGrupo);
        var idRuta = data[9];
        console.log(idRuta);
        // CARGAR TABLA RIGHT
        // ASIGNACION DE DATOS
        $('#labelsRutaR').html('')
        $('#labelsRutaR').append(rutaLabels)
        

        $('#codigoTablaR').html('')
        $('#codigoTablaR').append(codigoText)

        $('#fechaInicioTablaR').html('')
        $('#fechaInicioTablaR').append(fechaInicio)

        $('#alumnosInscritosTablaR').html('')
        $('#alumnosInscritosTablaR').append(alumnosApuntados)
    
        $('#capacidadInscritoTablaR').html('')
        $('#capacidadInscritoTablaR').append(capacidad)
      
        $('#identificadorTablaR').html('')
        $('#identificadorTablaR').append(idCursoNum)
              
        $('#codGrupoTablaR').html('')
        $('#codGrupoTablaR').append(codGrupo)
 
        
        $('#divAlumnosTablaRight').removeClass('d-none');
        $('#divCursosRight').addClass('d-none');

        $('#divAlumnos').removeClass('d-none');

        $.get("../../controller/grupos.php", 
            {
                op: "mostrarAlumnosCodGrupoRight", 
                codGrupo: codGrupo
            }, 
            function(response) {   
              
                 // Convertir la respuesta JSON en un array de objetos
                 alumnosDerecha = JSON.parse(response);
                 /* $("#listAddAlumnos").html(""); */
          
                 for (var i = 0; i < alumnosDerecha.length; i++) {
                     var row = alumnosDerecha[i];
                    let fechaNuevaCurso = '';

                    if (alumnosIzquierda[i].fechaNuevaCursos) {
                    // Convertir la fecha a objeto Date
                    const fecha = new Date(alumnosIzquierda[i].fechaNuevaCursos);

                    // Formatear en formato europeo (dd/mm/yyyy)
                    const dia = String(fecha.getDate()).padStart(2, '0');
                    const mes = String(fecha.getMonth() + 1).padStart(2, '0');
                    const anio = fecha.getFullYear();

                    fechaNuevaCurso = ' - Salto el: ' + dia + '/' + mes + '/' + anio;
                    } else {
                    // Si no hay fecha, lo dejamos vacío
                    fechaNuevaCurso = '';
                    }

                     $("#listAddAlumnos").append("<option value="+alumnosDerecha[i].idCurso+" selected='selected'>("+alumnosDerecha[i].idCurso+ ' - '+ (alumnosDerecha[i].emailUsuario ? alumnosDerecha[i].emailUsuario : '') +") "+ (alumnosDerecha[i].nomAlumno ? alumnosDerecha[i].nomAlumno : '') +" "+ (alumnosDerecha[i].apeAlumno ? alumnosDerecha[i].apeAlumno : '')+ fechaNuevaCurso  +"</option>");
                      
                 }
                 $('#listAddAlumnos').bootstrapDualListbox('refresh');
 
         
                $('#listAddAlumnos').bootstrapDualListbox('refresh');
              
            }
        ).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición:", textStatus, errorThrown);
        });
        
      
     
      });
      $(document).on("contextmenu", ".box1 select option, .box2 select option", function(event) {
        event.preventDefault(); // Evita el menú contextual del navegador
    
        let idCurso = $(this).val();
        let selectedText = $(this).text();
    
        console.log("Clic derecho en:", idCurso, selectedText);



        // RECOJO DATOS DEL 
        $.get("../../controller/grupos.php", 
            {
                op: "recogerAlumnoXidGrupo", 
                idCurso: idCurso
            }, 
            function(response) {   
              console.log(response)
              response = JSON.parse(response);

              let idLlegada = response[0].idLlegada_cursos;
              console.log(idLlegada)

            // cargar todos los datos
              $.get("../../controller/grupos.php", 
                {
                    op: "mostrarAlumnoXId",
                    idAlumno: idLlegada
                }, 
                function(response) {   
                    console.log(response);             
                    try {
                        var data = JSON.parse(response);
                        console.log("Datos procesados:", data);
                        idAlumno = data[0]['idAlumno'];
                        nombreAlumno = data[0]['nomAlumno'];
                        apeAlumno = data[0]['apeAlumno'];
                        tokenUsu = data[0]['tokenUsu'];
                        avatar = data[0]['avatarUsu'];
                        $('#adaptacionesDiv').html('');


                        // CURSOS
                        idLlegada = data[0]['id_llegada'];
                        nivelAsignado = data[0]['nivelasignado_llegadas'];
                      
                        $('#idiomaTxt').text(data[0]['descrIdioma']);
                        console.log(data[0]['descrIdioma'])
                        $('#tipoTxt').text(data[0]['descrTipo']);
                        $('#nivelTxt').text(data[0]['descrNivel']);
    
                        if(data[0]['agoraAlumno'] == 1){
                            $('#adaptacionesDiv').append('<span class="badge bg-danger-subtle text-danger border border-opacity-25 border-danger">Agorafobia</span>');
                        }
                        if(data[0]['minusvaliaAlumno'] == 1){
                            $('#adaptacionesDiv').append('<span class="badge bg-warning-subtle text-danger border border-opacity-25 border-warning">Discapacidad ♿</span>');
                        }
                        if (data[0]['obsMinusvaliaAlumno']) {
                            $('#adaptacionesDiv').append('<br><span>Otros: ' + data[0]['obsMinusvaliaAlumno'] + '</span> ');
                        }
                        if (data[0]['preferenciaHoraria']) {
                            if (data[0]['preferenciaHoraria'] == 1) {
                                horarioTexto = "Mañanas";
                            } else if (data[0]['preferenciaHoraria'] == 2) {
                                horarioTexto = "Tardes";
                            } else if (data[0]['preferenciaHoraria'] == 0) {
                                horarioTexto = "Sin Preferencias";
                            }
                            $('#adaptacionesDiv').append('<br><span><b>Horario: ' + horarioTexto + '</b></span><br>');                   
                            if(data[0]['fechaNuevaCursos'] == null){
                                $('#ultimoCurso').html('');
                            }else{
                                $('#ultimoCurso').html('');
                                $('#ultimoCurso').append('<p><b> Último cambio de curso: ' + convertirFechaEuropea(data[0]['fechaNuevaCursos']) + '</b></p>');                   

                            }
                        }
                        //perfil
                        $('#idAlumno').val(idAlumno);

                        $('#nombreAlumno').text(nombreAlumno+' '+apeAlumno);
                        $('#botonPerfil').attr('href', '../Perfil/?tokenUsuario='+tokenUsu+'');
                        $('#avatarUsu').attr('src', '../../public/assets/images/users/'+avatar+'');
    
                        // GRUPO AMIGOS
                        $('#grupoAmigos').html('');
                        $('#listaAmigos').html('');
    
                        
                        if (data[0]['grupoAmigos']) {
                            $('#grupoAmigos').append('<span class="badge bg-info-subtle text-info border border-info">' + data[0]['grupoAmigos'] + '</span>');
                            let grupoAmigosText = data[0]['grupoAmigos'];
                            console.log(grupoAmigosText)
                             // INFORMACION DE AMIGOS //
                            let depaSelect = $('#selectDepartamento').val();
                            $.get("../../controller/grupos.php", 
                                {
                                    op: "recogerGrupoAmigos",
                                    nombreGrupo: grupoAmigosText,
                                    depaSelect:depaSelect
                                }, 
                                function(response) {                
                                    try {
                                        var data = JSON.parse(response);
                                        console.log("Datos amigos:", data);
                                          
                                           // Recorrer cada objeto del array
                                           data.forEach(function(item) {
                                               // Crear un párrafo con la información (puedes ajustar qué mostrar)
                                              
                                               var contenido = `<span class="badge bg-info-subtle text-white border border-white tx-15">${item.nomAlumno}</span>`;
                                               console.log(contenido);
                                               // Agregarlo al div
                                               $("#listaAmigos").append(`<label>${contenido}</label>`);
                                           });
                                       
                                    } catch (error) {
                                        console.error("Error al parsear JSON:", error);
                                    }
                                }
                            ).fail(function(jqXHR, textStatus, errorThrown) {
                                console.error("Error en la petición:", textStatus, errorThrown);
                            });
                        }else{
                            $('#grupoAmigos').append('<span class="badge bg-danger-subtle text-danger border border-danger">Sin Grupo de Amigos</span>');
    
                        }
                          
                             
                            
    
                            $('#idLlegada').val(idLlegada);
                            $('#nivelAsignado').val(nivelAsignado);
    
    
    
                            // INFORMACION DE LA LLEGADA //
                            $.get("../../controller/grupos.php", 
                                {
                                    op: "mostrarLlegadaXId",
                                    idLlegada: idLlegada
                                }, 
                                function(response) {                
                                    try {
                                        var data = JSON.parse(response);
                                        console.log("Datos procesados:", data);
                                        
                                        // Seleccionar el div donde se van a agregar los elementos
                                        var matriculasDiv = $("#matriculasDiv");
                            
                                        // Limpiar contenido previo si es necesario
                                        matriculasDiv.empty();
                            
                                        // Recorrer cada objeto del array
                                        data.forEach(function(item) {
                                            // Crear un párrafo con la información (puedes ajustar qué mostrar)
                                            function formatoEuropeo(fecha) {
                                                if (!fecha) return ''; // Manejar valores nulos o indefinidos
                                                let partes = fecha.split('-'); // Suponiendo que viene en formato "YYYY-MM-DD"
                                                if (partes.length === 3) {
                                                    return `${partes[2]}/${partes[1]}/${partes[0]}`;
                                                }
                                                return fecha; // En caso de otro formato, devolver sin cambios
                                            }
                                            
                                            var contenido = `<span class="badge bg-info-subtle text-info border border-info tx-15">${item.codTarifa_matriculacion}</span> 
                                                             <span class="badge bg-success-subtle text-success border border-success tx-15">${formatoEuropeo(item.fechaInicioMatriculacion)}</span> 
                                                             <span class="badge bg-danger-subtle text-danger border border-danger tx-15">${formatoEuropeo(item.fechaFinMatriculacion)}</span>`;
                                            // Agregarlo al div
                                            $("#matriculasDiv").append(`<p>${contenido}</p>`);
                                            
                                        });
                                    } catch (error) {
                                        console.error("Error al parsear JSON:", error);
                                    }
                                }
                            ).fail(function(jqXHR, textStatus, errorThrown) {
                                console.error("Error en la petición:", textStatus, errorThrown);
                            });
                            
                    } catch (error) {
                        console.error("Error al parsear JSON:", error);
                    }
                }
            ).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la petición:", textStatus, errorThrown);
            });

              
            }
        ).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición:", textStatus, errorThrown);
        });
        // FINR ECOJO DATOS



        $('#seleccionarAlumno').modal('show');

        
        // Aquí puedes mostrar un menú personalizado o realizar otra acción
    });
    
  
      function guardarListasCursos(){
        cargando();
        codGrupoTabla1 = $('#codGrupoTablaT').text().trim();
        identificadorTabla1 = $('#identificadorTablaT').text().trim();
        console.log(identificadorTabla1)
        codGrupoTabla2 = $('#codGrupoTablaR').text().trim();
        identificadorTabla2 = $('#identificadorTablaR').text().trim();
        console.log(identificadorTabla2)
        console.log(codGrupoTabla2)

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
            let alumnosTraspaso = alumnosIzquierda.filter(alumno => !noSeleccionados.includes(String(alumno[0])));

            console.log("AlumnosTraspaso", alumnosTraspaso); 


              // --- GENERACIÓN DE CÓDIGO NUEVO ---
              
            idRT = $('#idRT').text(); //ESIGA2
            codigoNuevo = $('#codigoTextRT').text(); //ESIGA2
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
                    alumnosTraspaso: alumnosTraspaso,                   
                    codNivel:codNivel,
                    fechaActual:fechaActual,
                    idRT:idRT
                }),
                success: function(response) {
                    console.log("Datos procesados:", response);
                    toastr.success('Los grupos '+codGrupoTabla1+ ' y '+codGrupoTabla2+' han sido actualizados.')
                    cambiarAlumnoACursos();
                    cambiarAlumnoACursosRight()
                    descargando();
                    $('#cursosTablaTodos').DataTable().ajax.reload(null, false);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la petición:", textStatus, errorThrown);
                    descargando();

                }
                
            });

            descargando();
        }else{ // ACCEDEMOS A PASAR LOS GRUPOS


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

      
            // TRASPASAR VARIABLES PARA GESTIONAR LOS GRUPOS
            
            // INFORMACION DE LA LLEGADA //
            $.ajax({
                url: "../../controller/grupos.php?op=actualizarGruposAlumnos",
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
                    codGrupoTabla2: codGrupoTabla2,
                    identificadorTabla2:identificadorTabla2,
                    addListaDerecha: addListaDerecha,
                    eliminadosListaDerecha: eliminadosListaDerecha
                }),
                success: function(response) {
                    console.log("Datos procesados:", response);
                    toastr.success('Los grupos '+codGrupoTabla1+ ' y '+codGrupoTabla2+' han sido actualizados.');
                    $('#cursosTablaTodos').DataTable().ajax.reload(null, false);

                    cambiarAlumnoACursos();
                    descargando();
                    /* setTimeout(function() {
                        location.reload();
                    }, 3000); // 3000 ms = 3 segundos */
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la petición:", textStatus, errorThrown);
                    descargando();

                }
                
            });

            descargando();

              
        
            }
        
     
        }


        // MODAL INFORMACION GRUPO 

        function cargarInfoGrupo(dato){
        
            if (dato == 1) {
                codTabla = $('#codGrupoTablaT').text().trim(); // Eliminamos espacios vacíos
                console.log(codTabla);
                    // Obtén la celda y extrae el texto en lugar del objeto de datos
                    var codSeleccionado = $('#codGrupoTablaT').text(); 
                    console.log(codSeleccionado)
                    var rutaCod = $('#labelsRuta').html();

                    var idCurso = $('#identificadorTablaT').html();
                    var fechaCursoSelect = $('#fechaInicioTablaT').html();
                    var capacidadText = $('#capacidadInscritoTablaT').html();

                    //PARA EL MODAL DE AULAS
                    $('#grupoSeleccionadoEnd').val(codSeleccionado);

                if (!codTabla) return; // Si está vacío, salir de la función
            } else {
                codTabla = $('#codGrupoTablaR').text().trim();
                console.log(codTabla);
                    // Obtén la celda y extrae el texto en lugar del objeto de datos
                    var codSeleccionado = $('#codGrupoTablaR').text(); 
                    console.log(codSeleccionado)
                    var rutaCod = $('#labelsRutaR').html();

                    var idCurso = $('#identificadorTablaR').html();
                    var fechaCursoSelect = $('#fechaInicioTablaR').html();
                    var capacidadText = $('#capacidadInscritoTablaR').html();

                    //PARA EL MODAL DE AULAS
                    $('#grupoSeleccionadoEnd').val(codSeleccionado);

                if (!codTabla) return; // Si está vacío, salir de la función
            }


        // Asigna los valores a los inputs
        $('#codSeleccionado').val(codSeleccionado);

        $('#cursoSeleccionado').val(idCurso);
        $('#fechaSeleccionado').val(fechaCursoSelect);

        $('#divCursosTab').removeClass('d-none');

        $('#codSelectText').html(rutaCod);
        $('#fecSelectText').text(fechaCursoSelect);
        $('#capacidadText').html(capacidadText);

        $.post('../../controller/grupos.php?op=recogerAlumnosCurso', { codSeleccionado: codSeleccionado}, function(response) {
            let alumnos = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
            let html = '';
                $.each(alumnos, function (index, alumno) {
                    html += `<a href="../Perfil/?tokenUsuario=${alumno.tokenUsu}" target="_blank">
                                <label>
                                    <span class="badge text-info border border-info">${alumno.nomAlumno} ${alumno.apeAlumno}</span>
                                </label>
                             </a>`;
                });
                $('#alumnos').html(html);
                if ($('#nombreAulaModal').length === 0) {
                    console.error("El tbody #nombreAulaModal no existe en el DOM.");
                    return;
                }
                
                // 🔹 Crear filas con datos de los alumnos para la tabla
                let htmlModal = '';
                $.each(alumnos, function (index, alumno) {
                    caracteristicasAlum = [];

                    if (alumno.agoraAlumno == 1) {
                        caracteristicasAlum.push("<b class='tx-danger'>Agorofobia</b>");
                    }

                    if (alumno.minusvaliaAlumno == 1) {
                        caracteristicasAlum.push("<b class='tx-warning'>Necesidades especiales</b>");
                    }


                    htmlModal += `<tr>
                                    <td>${alumno.nomAlumno} ${alumno.apeAlumno}</td>
                                    <td>${caracteristicasAlum}</td>
                                    <td>${alumno.obsMinusvaliaAlumno}</td>
                                </tr>`;
                });

                $('#datosAlumnosModal').html(htmlModal); // 🔹 Usar `html()` para evitar duplicados
        });
        $.post('../../controller/grupos.php?op=cargarAulasGrupo', { codSeleccionado: codSeleccionado}, function(response) {
            let aula = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
            
            if (aula.length > 0) { // Verifica si el array tiene elementos
                console.log(aula); // Accede al primer objeto del array
                $('#nombreAulaView').text(aula[0].nombreAula);
                $('#locaAulaView').text(aula[0].localizacionAula);
                $('#capaAulaView').text(aula[0].capacidadAula);
                let checkboxes = '';

                if (aula[0].hibridoAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-danger"> Híbrido </label>';
                }
        
                if (aula[0].kidsAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-success"> Kids </label>';
                }
        
                if (aula[0].paraliticosAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-warning"> Paralíticos </label>';
                }
        
                if (aula[0].agoraAula == 1) {
                    checkboxes += '<label class="form-check form-check-inline tx-info"> Agorafobia </label>';
                }

                $('#caraAulaView').html(checkboxes);
                $('#observacionesAula').html(aula[0].nombreAula);

                $('.tablaViewAula').removeClass('d-none');
             
             
            } else {
                $('.tablaViewAula').addClass('d-none');

                console.log("No hay datos en la respuesta.");
            }
         
        });

        $.post('../../controller/grupos.php?op=cargarProfeGrupo', { codSeleccionado: codSeleccionado}, function(response) {
            let profe = JSON.parse(response); // 🔹 Convierte la respuesta a objeto si es necesario
            
            if (profe.length > 0) { // Verifica si el array tiene elementos
                console.log(profe); // Accede al primer objeto del array
                nombreCompleto =  profe[0].nomPersonal+" "+profe[0].apePersonal;

                $('#nombreSeleccionadoProfeView').text(nombreCompleto);
               


                $('.nombreProfeView').removeClass('d-none');
             
             
            } else {
                $('.nombreProfeView').addClass('d-none');

                console.log("No hay datos en la respuesta.");
            }
         
        });



            $('#seleccionarGrupo').modal('show');

            

        }


        
var rutasTable; // Variable global para almacenar la referencia del DataTable
function inicializarDataTableRutas() {
            idiomarr = $("#idIiomaTablaT").val();
            cursorr = $("#idTipoCursoTablaT").val();
          
                console.log(idiomarr+cursorr)
    rutasTable = $("#rutasTabla").DataTable({
        select: false,
        order: [[6, "desc"]], // Ordenar solo por la columna "Peso"
        columns: [
            { name: "id" },
            { name: "Idioma" },
            { name: "Curso" },
            { name: "Nivel" },
            { name: "Alumnos" },
            { name: "Periodicidad", className: "d-none" },
            { name: "Peso",className: "tx-center"  },
            { name: "Código" },
            { name: "Estado", className: "d-none" },
            { name: "accion", className: "d-none" }
        ],
        columnDefs: [
            { targets: 0, visible: false, width: "50px", orderable: false },
            { targets: 1, width: "100px", className: "small", orderable: false },
            { targets: 2, width: "200px", className: "small", orderable: false },
            { targets: 3, width: "100px", className: "texto-peque", orderable: false },
            { targets: 4, width: "60px", orderable: false },
            { targets: 5, width: "60px", orderable: false },
            { targets: 6, width: "50px", type: "num" }, // Única columna ordenable
            { targets: 7, width: "70px", orderable: false },
            { targets: 8, width: "70px", orderable: false },
            { targets: 9, className: "text-center", width: "80px", orderable: false }
        ],
        searchBuilder: { columns: [1, 2, 3, 4, 5, 6, 7, 8] },
        ajax: {
            url: "../../controller/rutas.php?op=listarRutas",
            type: "POST",
            data: function (d) {
                d.idioma = $("#selectIdioma").val();
                d.curso = $("#selectCurso").val();
            },
            cache: false,
            serverSide: true,
            error: function (e) {
                console.log("Error en AJAX:", e.responseText);
            }
        }
    });
    

    $("#rutasTabla").addClass("width-100"); //? AGREGA LA CLASE WIDTH-100 AL DATATABLES PARA HACERLO RESPONSIVE

}



$(document).ready(function () {
    // Inicializar el select2 con la configuración que ya tienes
    $("#selectIdioma").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data('placeholder'),
        closeOnSelect: true,
        language: {
            inputTooShort: function (args) {
                var remainingChars = args.minimum - args.input.length;
                return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
            },
            maximumSelected: function (e) {
                return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
            },
            noResults: function () {
                return 'No se encontraron resultados';
            },
            searching: function () {
                return 'Buscando...';
            }
        }
    });

 
    $("#selectCurso").select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: $(this).data('placeholder'),
        closeOnSelect: true,
        language: {
            inputTooShort: function (args) {
                var remainingChars = args.minimum - args.input.length;
                return 'Por favor, ingresa ' + remainingChars + ' o más caracteres';
            },
            maximumSelected: function (e) {
                return 'Solo puedes seleccionar ' + e.maximum + ' elemento';
            },
            noResults: function () {
                return 'No se encontraron resultados';
            },
            searching: function () {
                return 'Buscando...';
            }
        }
    });
    
    $("#selectIdioma").val(null).trigger('change');





});


console.log('asd');
$(document).ready(function () {
    inicializarDataTableRutas();

    $('#selectIdioma, #selectCurso').on('change', function () {
        console.log('sad')
        actualizarDataTable();
    });
 
});


function actualizarDataTable() {
    
    console.log('sad')

    const idioma = $("#idIiomaTablaT").val();
    const curso = $("#idTipoCursoTablaT").val();

    if (!idioma) {
        return;
    }
    if (!curso) {
        return;
    }

    console.log("Actualizando tabla con idioma:", idioma, "y curso:", curso);

    if (rutasTable) {
        rutasTable.ajax.reload(null, false); // Recarga sin reiniciar paginación
    }

}



// APARTADO RUTAS CLICK TABLA


$('#rutasTabla tbody').on('click', 'tr', function () {//! === Funcion para recoger los valores de la fila de un datatables a la que le haces click  ===
    // Obtén la instancia de la tabla DataTables
    toastr.info('Ruta seleccionada');
    /* $('#divBotonesNewR').removeClass('d-none')*/
    $('#divRutas').addClass('d-none') 
    $('#divDatosRutaR').removeClass('d-none')
    $('#divAlumnos').removeClass('d-none')

    
    
    
    
    var tabla = $('#rutasTabla').DataTable();
  
    // Obtén el objeto de datos de la fila actual
    var data = tabla.row(this).data();
    var idRT = data[0];
    var idiomaTableRuta = data[1];
    var tipoCursoTableRuta = data[2];
    var nivelTableRuta = data[3];
    var alumnosTableRuta = data[4];
    var pesoTableRuta = data[6];
    var codigoTableRuta =  $(data[7]).text().trim();
    
    // CARGAR TABLA RIGHT
    // ASIGNACION DE DATOS
    $('#rlabelsIdioma').html('')
    $('#rlabelsIdioma').append(idiomaTableRuta)
    
    $('#rlabelsTipo').html('')
    $('#rlabelsTipo').append(tipoCursoTableRuta)

    $('#rlabelsNivel').html('')
    $('#rlabelsNivel').append(nivelTableRuta)
   
     
    $('#alumnosText').html('')
    $('#alumnosText').append(alumnosTableRuta)

    $('#pesoText').html('')
    $('#pesoText').append(pesoTableRuta)

    $('#codigoTextRT').html('')
    $('#codigoTextRT').append(codigoTableRuta)
  
    $('#idRT').html('')
    $('#idRT').append(idRT)
    
  
 
  });


  //CREAR CURSO A PARTIR DE RUTA

  function crearCurso(){

    cargando();
    idAlumno = $('#idAlumno').val();
    nivelAsig = $('#nivelAsignado').val();
    if(nivelAsig == ''){
        toastr.error('Seleccione un nivel');
        descargando();

        return;
    }
    idLlegada = $('#idLlegada').val();
    let codNivel = $('#codNivel').val();
    
    if(codNivel == ''){
        toastr.error('Seleccione un nivel');
        descargando();

        return;
    }
    var fechaActual = new Date().toISOString().split('T')[0].replace(/-/g, ''); 
    codNivel = codNivel + fechaActual; // Concatena el grupo con la fecha
    console.log(codNivel);
    $.post('../../controller/grupos.php?op=crearAlumnosCurso', { idAlumno: idAlumno, nivelAsig: nivelAsig, idLlegada:idLlegada, fechaActual:fechaActual,codNivel:codNivel }, function(response) {
        descargando();
        toastr.success('Curso Añadido');
        var cursosTabla = $('#cursosTabla').DataTable();
        cursosTabla.ajax.reload(null, false); // false para mantener la página actual

        var alumnosTabla = $('#alumnosTabla').DataTable();
        alumnosTabla.ajax.reload(null, false); // false para mantener la página actual

      
        /* $('#divCrearCurso').addClass('d-none');
        $('#textEnCurso').text('En un curso'); */
    });
      descargando();

} 


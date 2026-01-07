
//* APARTADO DE CURSOS *//

//***********************/
//*** MOSTRAR TABLAS ****/
//***** BTN1 - BTN2 *****/
//***********************/

function mostrarCrearCurso() {
    $(".accionesCurso").addClass("d-none");
    $("#divCrearCurso").removeClass("d-none");
  
    comprobarCurso()
      .then(function (identificador) {
        if (identificador == false) {
          $("#identificadorCurso").val(1);
        } else {
          $("#identificadorCurso").val(identificador);
        }
      })
      .catch(function (error) {
        console.error("Error al comprobar el curso:", error);
      });
  }
  function mostrarNuevoCurso() {
    $("#listAddAlumnos").bootstrapDualListbox("refresh");
    $(".accionesCurso").addClass("d-none");
    $("#divNuevoCurso").removeClass("d-none");
  }
  function mostrarPasarCurso() {
    $('#listPasarAlumnos').bootstrapDualListbox('refresh');
    deshabilitarCurso2();

    $(".accionesCurso").addClass("d-none");
    $("#divPasarCurso").removeClass("d-none");
  }
  function mostrarAgregarProfesor() {
    $("#listarAgregarProfesor").bootstrapDualListbox("refresh");

    $(".accionesCurso").addClass("d-none");
    $("#divAgregarProfesor").removeClass("d-none");
  }
  mostrarCrearCurso();
//***********************/
//***********************/
//***********************/

//******************************/
//* MONTAMOS SELECT CON SELECT2*/
//******************************/
$('#idiomaNuevoCurso').select2({
    // Configuración de idioma
    language: {
        // Traducción personalizada para "No Results found"
        noResults: function() {
          return "No hay resultados";
        }
      }
});
$('#tipoCursoNuevoCurso').select2({
    // Configuración de idioma
    language: {
        // Traducción personalizada para "No Results found"
        noResults: function() {
          return "No hay resultados";
        }
      }
});
$('#nivelNuevoCurso').select2({
    // Configuración de idioma
    language: {
        // Traducción personalizada para "No Results found"
        noResults: function() {
          return "No hay resultados";
        }
      }
});
$('#semanaNuevoCurso').select2({
    // Configuración de idioma
    language: {
        // Traducción personalizada para "No Results found"
        noResults: function() {
          return "No hay resultados";
        }
      }
});
//******************************/
//******************************/
//******************************/

//********************************/
//***** CARGAR DATOS SELECT ******/
//********************************/

//******* SELECT IDIOMA ************/
$.post("../../controller/cursos.php?op=selectIdioma",function (data) {
   
    var data = JSON.parse(data);
    if (data.length > 0) {
        $("#idiomaNuevoCurso").empty();

        for (var i = 0; i < data.length; i++) {
            var row = data[i];
            $("#idiomaNuevoCurso").append("<option value="+data[i].idIdioma+" >("+data[i].codIdioma+") "+data[i].descrIdioma+"</option>");
        }
    }else{
        $("#idiomaNuevoCurso").empty();

    }
});

//******* SELECT TIPO CURSOS ************/
$.post("../../controller/cursos.php?op=selectTipoCurso",function (data) {
   
    var data = JSON.parse(data);
    if (data.length > 0) {
        $("#tipoCursoNuevoCurso").empty();

        for (var i = 0; i < data.length; i++) {
            var row = data[i];
            $("#tipoCursoNuevoCurso").append("<option value="+data[i].idTipo+" >("+data[i].codTipo+") "+data[i].descrTipo+"</option>");
        }
    }else{
        $("#tipoCursoNuevoCurso").empty();

    }
});

//******* SELECT NIVEL ************/
$.post("../../controller/cursos.php?op=selectNivel",function (data) {
   
    var data = JSON.parse(data);
    if (data.length > 0) {
        $("#nivelNuevoCurso").empty();

        for (var i = 0; i < data.length; i++) {
            var row = data[i];
            $("#nivelNuevoCurso").append("<option value="+data[i].idNivel+" >("+data[i].codNivel+") "+data[i].descrNivel+"</option>");
        }
         // RECOGEMOS EL NIVEL PREDETERMINADO
        var nivelCursoSelect = $('#nivelNuevoCurso').val();
        cargarSemanasNivel(nivelCursoSelect);

    }else{
        $("#nivelNuevoCurso").empty();

    }
});

//******* SELECT NIVEL ************/
$(document).ready(function() {

    // Cuando el valor de '#miInput' cambie, se ejecutará esta función
    $('#nivelNuevoCurso').on('change', function() {
        var nivelCursoSelect = $('#nivelNuevoCurso').val();
        cargarSemanasNivel(nivelCursoSelect);

    });

});

function cargarSemanasNivel(nivelCursoSelect){

    $.post("../../controller/cursos.php?op=semanaNuevoCurso",{nivelCursoSelect:nivelCursoSelect},function (data) {
    
        var data = JSON.parse(data);
        cantidadSemanas = data[0].semanasNivel;
        $("#semanaNuevoCurso").html("");
        semana = 1;
        for (var i = 0; i < cantidadSemanas; i++) {
            
            $("#semanaNuevoCurso").append("<option value="+semana+" >Semana "+semana+"</option>");
            semana++;
        }
        
    }); 
}
//******* IDENTIFICADOR IDCURSO ************/

function cargarIdentificador(){

    //** SI YA EXITE EL CURSO, DEBE DE SUMAR EL IDENTIFICADOR +1 */

  /*   $.post("../../controller/cursos.php?op=cargarIdentificadorCurso",{nivelCursoSelect:nivelCursoSelect},function (data) {
      
    });  */

}

//********************************/
//********************************/
//********************************/

//********************************/
//***** CREAR NUEVOS CURSOS  *****/
//********************************/

$(document).ready(function() {
    comprobarCurso().then(function(identificador) {

    }).catch(function(error) {
        console.error("Error al comprobar el curso:", error);
    });
    $('#idiomaNuevoCurso, #tipoCursoNuevoCurso, #nivelNuevoCurso, #semanaNuevoCurso, #fechaCurso, #identificadorCurso').on('change', function() {
        comprobarCurso().then(function(identificador) {
            if(identificador == false){
                $('#identificadorCurso').val(1);
            }else{
                $('#identificadorCurso').val(identificador);

            }

        }).catch(function(error) {
            console.error("Error al comprobar el curso:", error);
        });
    });

    $('#crearCurso').on('click', function() {
        cargando();

                
                let idiomaSelect = $('#idiomaNuevoCurso').val();
                let tipoCursoSelect = $('#tipoCursoNuevoCurso').val();
                let nivelSelect = $('#nivelNuevoCurso').val();
                let semana = $('#semanaNuevoCurso').val();
                let fecha = $('#fechaCurso').val();
                let identificador = $('#identificadorCurso').val();

                $.post("../../controller/cursos.php?op=crearCurso", {
                    idiomaSelect: idiomaSelect,
                    tipoCursoSelect: tipoCursoSelect,
                    nivelSelect: nivelSelect,
                    semana: semana,
                    fecha: fecha,
                    identificador: identificador
             
                }, function(data) {
                    descargando();
                    toastr.success('Curso creado correctamente');
                    comprobarCurso().then(function(identificador) {
                        if(identificador == false){
                            $('#identificadorCurso').val(1);
                        }else{
                            $('#identificadorCurso').val(identificador);
                
                        }
                        cargarDatatablesCursos();
                    }).catch(function(error) {
                        console.error("Error al comprobar el curso:", error);
                    });
                });

           
            descargando();

    });

});

// COMPRUEBO EL CURSO PARA VER SI YA HAY UNO CREADO, Y DEVOLVERLE LA IDENTIFICADOR + 1
function comprobarCurso() {
    
    return new Promise(function(resolve, reject) {
        let idiomaSelect = $('#idiomaNuevoCurso').val();
        let tipoCursoSelect = $('#tipoCursoNuevoCurso').val();
        let nivelSelect = $('#nivelNuevoCurso').val();
        let semana = $('#semanaNuevoCurso').val();
        let fecha = $('#fechaCurso').val();
        let identificador = $('#identificadorCurso').val();
        $.post("../../controller/cursos.php?op=comprobarCursoCreado", {
            idiomaSelect: idiomaSelect,
            tipoCursoSelect: tipoCursoSelect,
            nivelSelect: nivelSelect,
            semana: semana,
            fecha: fecha,
            identificador: identificador
        }, function(data) {
            if (data == 0) {
                resolve(false);
                
            } else {
                var identificadorSumado = parseInt(data.replace(/"/g, ''));
                identificadorSumado = identificadorSumado +1;

                resolve(identificadorSumado);
            }
        });
    });
}


//********************************/
//********************************/
//********************************/


//********************************************/
//**************** ALUMNOS *******************/
//********************************************/


//***********************/
//** TABLA NUEVO CURSO **/
//***********************/

// Inicializa el Dual List Box y establece las etiquetas
$('.duallistbox-nuevo-curso').bootstrapDualListbox({
    moveSelectedLabel: 'Añadir seleccionado',
    moveAllLabel: 'Añadir Todos',
    removeSelectedLabel: 'Eliminar Seleccionado',
    removeAllLabel: 'Eliminar Todo',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: false,

})
 $(".duallistbox-agregar-profesor").bootstrapDualListbox({
    moveSelectedLabel: "Añadir seleccionado",
    moveAllLabel: "Añadir Todos",
    removeSelectedLabel: "Eliminar Seleccionado",
    removeAllLabel: "Eliminar Todo",
    preserveSelectionOnMove: "moved",
    moveOnSelect: false,
  });
  
  $(".duallistbox-agregar-profesor")
    .bootstrapDualListbox("getContainer")
    .find(".btn")
    .addClass("btn-primary")
    .removeClass("btn-default");

//******************************/
//***** TABLA CURSO MODAL ******/
//******************************/
function cargarDatosCurso(opcion){
    var idCursoTablas = 99;
    if(opcion == 3){
        idCursoTablas = $('#idCursoPasarAlumno1').val();
    }else{
        idCursoTablas = 0;
    }
    
    
    var selectCurso1 = $('#cursos_table').DataTable({
        buttons : [],
        "autoWidth": false, // Desactiva el ajuste automático del ancho
        select: true, // nos permite seleccionar filas para exportar

        lengthMenu: [ // para sobreescribir los datos de MOSTRAR
        [5, 10, 20, -1],
        [5, 10, 20, 'Todos'] // son dos arrays, el primero son los datos y el segundo es el texto que se va a mostrar (el -1 son Todos)
        ],
        columns: [
            { name: "id", className: "text-center" },
            { name: "nombre", className: "text-center"  },
            { name: "tipoCurso", className: "text-center"  },
            { name: "nivel", className: "text-center"  },
            { name: "capacidad", className: "text-center"  },
            { name: "semana", className: "text-center"  },
            { name: "fechaCurso", className: "text-center"  },
            { name: "identificador", className: "text-center"  },
            { name: "alumnos", className: "text-center"  },
            { name: "codigo", className: "text-center"  },

        ],
        columnDefs: [

            { targets: [0], orderData: [0], visible: true, className: 'tx-center' }, //  ID
            { targets: [1], orderData: [1], visible: true, className: 'tx-center' }, // nombre
            { targets: [2], orderData: [2], visible: true, className: 'tx-center' }, // tipocuros
            { targets: [3], orderData: [3], visible: true, "width": "5px", className: 'tx-center' }, // nivel
            { targets: [4], orderData: [4], visible: true, className: 'tx-center' }, // capacidad
            { targets: [5], orderData: [5], visible: true, "width": "3px", className: 'tx-center'}, // semana
            { targets: [6], orderData: [6], visible: true, className: 'tx-center' }, // fecha curso
            { targets: [7], orderData: [7], visible: true, "width": "5px", className: 'tx-center' }, // identificador
            { targets: [8], orderData: [8], visible: true, className: 'tx-center' }, // codigo
            { targets: [9], orderData: [9], visible: true, className: 'tx-center' }, // codigo

        ],

        "ajax": {

            url: "../../controller/cursos.php?op=mostrarTablaCursos&idCursoTablas="+idCursoTablas,
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        },
        
    }); // del DATATABLE


    selectCurso1.column(0).visible(true); // Mostrar la columna 1

    $("#cursos_table").on('click', 'tbody tr:visible', function () {
        
        habilitarCurso2();
        if(opcion == 1){

            idCursoSeleccionado = $(this).children().eq(0).text();
            codigoCursoSeleccionado =  $(this).children().eq(9).text();
            alumnosMaxCurso =  $(this).children().eq(4).text();
            
            $('#idCursoAddAlumno').val(idCursoSeleccionado);
            $('#codigoText1').text(codigoCursoSeleccionado);
            $('#alumnosMaximos').text(alumnosMaxCurso);

            $('#codigoText1').removeClass('parpadeo');

            $('#selectCurso1').modal('hide');

            cargarAlumnos(idCursoSeleccionado);

        }else if(opcion == 2){

            let idCursoSeleccionado = $(this).children().eq(0).text();
            let codigoCursoSeleccionado =  $(this).children().eq(9).text();
            let alumnosMaxCurso =  $(this).children().eq(4).text();
            $('#idCursoPasarAlumno1').val(idCursoSeleccionado);
            $('#codigoText2').text(codigoCursoSeleccionado);
            $('#alumnosMaximos1').text(alumnosMaxCurso);

            $('#codigoText2').removeClass('parpadeo');

            $('#selectCurso1').modal('hide');

            $("#listPasarAlumnos").html("");
            $("#listPasarAlumnos").val("");

            $("#idCursoPasarAlumno2").val("");

            $('#codigoText3').text('Selecciona un curso')
            $('#codigoText3').addClass('parpadeo');

            opcion = 0;

        }else if(opcion == 3){

            let idCursoSeleccionado2 = $(this).children().eq(0).text();
            let codigoCursoSeleccionado2 =  $(this).children().eq(9).text();
            let alumnosMaxCurso2 =  $(this).children().eq(4).text();

            $('#idCursoPasarAlumno2').val(idCursoSeleccionado2);
            $('#codigoText3').text(codigoCursoSeleccionado2);
            $('#alumnosMaximos2').text(alumnosMaxCurso2);

            $('#codigoText3').removeClass('parpadeo');

            $('#selectCurso1').modal('hide');
           
            let idCurso1 = $('#idCursoPasarAlumno1').val();
            let idCurso2 = $('#idCursoPasarAlumno2').val();

            if (idCurso1 && idCurso2 && idCurso1 !== idCurso2) {
               
                cargarAlumnosDosCursos(idCurso1, idCurso2);
            } else if (idCurso1 === idCurso2) {
                toastr.error('No selecciones dos cursos iguales');
            }

        } else if (opcion == 4) {
            idCursoSeleccionado = $(this).children().eq(0).text();
            codigoCursoSeleccionado = $(this).children().eq(9).text();
      
            $("#idCursoProfesor").val(idCursoSeleccionado);
      
            $("#textoParpadeo").text(codigoCursoSeleccionado);
            $("#textoParpadeo").removeClass("parpadeo");
      
            $("#selectCurso1").modal("hide");
      
            cargarProfesores(idCursoSeleccionado);
          }
        // RESETEAMOS LA VARIABLE PARA ACCIÓN DE NUEVO
        opcion = 0;
        $('#listPasarAlumnos').bootstrapDualListbox('refresh');

    })
}
$("#cursos_table").addClass("width-100");

//**NUEVOS ALUMNOS**/
function cargarAlumnos(idCursoSeleccionado){


    $.post("../../controller/cursos.php?op=traerListaAlumnos",{idCursoSeleccionado:idCursoSeleccionado},function (data) {
        var data = JSON.parse(data);
        $("#listAddAlumnos").html("");
 
        for (var i = 0; i < data.length; i++) {
            var row = data[i];

            if(data[i].idCurso_alumcurso == idCursoSeleccionado){
                $("#listAddAlumnos").append("<option value="+data[i].idUsuario_alumcurso+" selected='selected'>("+ (data[i].emailUsuario ? data[i].emailUsuario : '') +") "+ (data[i].nomAlumno ? data[i].nomAlumno : '') +" "+ (data[i].apeAlumno ? data[i].apeAlumno : '') +"</option>");
            } else {
                $("#listAddAlumnos").append("<option value="+data[i].idUsuario_alumcurso+">("+ (data[i].emailUsuario ? data[i].emailUsuario : '') +") "+ (data[i].nomAlumno ? data[i].nomAlumno : '') +" "+ (data[i].apeAlumno ? data[i].apeAlumno : '') +"</option>");
            }   
        }

        $('#listAddAlumnos').bootstrapDualListbox('refresh');
    })

}

//** DESHABILITAR BOTÓN CURSO 2*/
function deshabilitarCurso2(){
    // Seleccionar el botón por su ID y deshabilitarlo
    $('#modalTabla2').prop('disabled', true);
    // Agregar la clase "disabled" para aplicar el estilo grisáceo
    $('#modalTabla2').addClass('disabled');

    $('#modalTabla2').text('Selecciona el primer curso');

}
deshabilitarCurso2();

function habilitarCurso2(){
    // Seleccionar el botón por su ID y deshabilitarlo
    $('#modalTabla2').prop('disabled', false);
    // Agregar la clase "disabled" para aplicar el estilo grisáceo
    $('#modalTabla2').removeClass('disabled');

    $('#modalTabla2').text('Seleccionar Curso');

}
//**AVANZAR CURSOS**/
function cargarAlumnosDosCursos(idCurso1,idCurso2){

    $.post("../../controller/cursos.php?op=traerListaAlumnosDosCursos",{idCurso1:idCurso1,idCurso2:idCurso2},function (data) {
        var data = JSON.parse(data);
        $("#listPasarAlumnos").val("");
 
        for (var i = 0; i < data.length; i++) {
            var row = data[i];

            if(data[i].idCurso_alumcurso == idCurso2){ // SI EL ALUMNO TIENE EL ID CURSO DOS, SE PONDRA EN LA TABLA DE LA DERECHA CON EL SELECTED
                
                $("#listPasarAlumnos").append("<option value="+data[i].idUsuario_alumcurso+" selected='selected'>("+ (data[i].emailUsuario ? data[i].emailUsuario : '') +") "+ (data[i].nomAlumno ? data[i].nomAlumno : '') +" "+ (data[i].apeAlumno ? data[i].apeAlumno : '') +"</option>");
            } else {
                $("#listPasarAlumnos").append("<option value="+data[i].idUsuario_alumcurso+">("+ (data[i].emailUsuario ? data[i].emailUsuario : '') +") "+ (data[i].nomAlumno ? data[i].nomAlumno : '') +" "+ (data[i].apeAlumno ? data[i].apeAlumno : '') +"</option>");
            }
            
        }
 
        $('#listPasarAlumnos').bootstrapDualListbox('refresh');
    }) 

}


/** GUARDAR USUARIOS A LA CLASE */

$(document).ready(function() {

    // Función para guardar el grupo al hacer clic en #guardarGrupo
    $('#guardarGrupo').click(function() {
      cargando();
      var selectedValues = $('#listAddAlumnos').val();
      // Aquí puedes hacer algo con los valores seleccionados, como enviarlos a un servidor
      var idCurso = $('#idCursoAddAlumno').val();

      $.post('../../controller/cursos.php?op=insertarAlumnosCurso', { listaAlumnos: selectedValues, idCurso: idCurso }, function(response) {
        descargando();
        toastr.success('Alumnos actualizados');

      });
      descargando();

    });

    // Función para guardar el grupo al hacer clic en #ardarGrupo
    $('#guardarGrupoAvanzarCurso').click(function() {
        cargando();

        var alumnosPasados = $('#listPasarAlumnos').val();
        var alumnosNoPasados = [];
        $('#listPasarAlumnos').find('option:not(:selected)').each(function(){

            alumnosNoPasados.push($(this).val());

        })


      var idCurso1 = $('#idCursoPasarAlumno1').val();
      var idCurso2 = $('#idCursoPasarAlumno2').val();

      $.post('../../controller/cursos.php?op=AvanzarAlumnosCurso', { alumnosPasados: alumnosPasados, alumnosNoPasados: alumnosNoPasados, idCurso1:idCurso1,idCurso2:idCurso2 }, function(response) {
        descargando();
        toastr.success('Alumnos actualizados');

      });
      descargando();

    });

  });

  function cargarDatatablesProfesor(){
    //* === TABLA CURSO MODAL - CREAR CURSO - LISTA DE CURSOS  ===
    var cursos_profesor_table = $('#cursos_profesor_table').DataTable({
        language: {
            emptyTable: "Actualmente no hay cursos disponibles para mostrar"
        },
      "autoWidth": false, // Desactiva el ajuste automático del ancho
      select: true, // nos permite seleccionar filas para exportar
      buttons : [],
      lengthMenu: [ // para sobreescribir los datos de MOSTRAR
      [5, 10, 20, -1],
      [5, 10, 20, 'Todos'] // son dos arrays, el primero son los datos y el segundo es el texto que se va a mostrar (el -1 son Todos)
      ],
      columns: [
          { name: "id", className: "text-center" },
          { name: "nombre", className: "text-center"  },
          { name: "tipoCurso", className: "text-center"  },
          { name: "nivel", className: "text-center"  },
          { name: "capacidad", className: "text-center"  },
          { name: "semana", className: "text-center"  },
          { name: "fechaCurso", className: "text-center"  },
          { name: "alumnosApuntados", className: "text-center"  },
          { name: "identificador", className: "text-center"  },
          { name: "codigo", className: "text-center"  },
          { name: "accion", className: "text-center"  },
  
      ],
      columnDefs: [
  
          { targets: [0], orderData: [0], visible: true, className: 'tx-center' }, //  ID
          { targets: [1], orderData: [1], visible: true, className: 'tx-center' }, // nombre
          { targets: [2], orderData: [2], visible: true, className: 'tx-center' }, // tipocuros
          { targets: [3], orderData: [3], visible: true, "width": "5px", className: 'tx-center' }, // nivel
          { targets: [4], orderData: [4], visible: true, className: 'tx-center' }, // capacidad
          { targets: [5], orderData: [5], visible: true, "width": "3px", className: 'tx-center'}, // semana
          { targets: [6], orderData: [6], visible: true, className: 'tx-center' }, // fecha curso
          { targets: [7], orderData: [7], visible: true, "width": "5px", className: 'tx-center' }, // identificador
          { targets: [8], orderData: [8], visible: true, className: 'tx-center' }, // codigo
          { targets: [9], orderData: [9], visible: true, className: 'tx-center' }, // accion
          { targets: [10], orderData: [10], visible: true, className: 'tx-center' }, // accion
  
  
      ],
  
      "ajax": {
  
          url: "../../controller/cursos.php?op=mostrarTablaCursosListadoProfesor",
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
      },
  }); // del DATATABLE
  $("#cursos_profesor_table").addClass("width-100");
}

cargarDatatablesProfesor();

function cargarDatatablesCursos(){
  //* === TABLA CURSO MODAL - CREAR CURSO - LISTA DE CURSOS  ===
  var cursos_todos_table = $('#cursos_todos_table').DataTable({
  
    "autoWidth": false, // Desactiva el ajuste automático del ancho
    select: true, // nos permite seleccionar filas para exportar
    buttons : [],
    lengthMenu: [ // para sobreescribir los datos de MOSTRAR
    [5, 10, 20, -1],
    [5, 10, 20, 'Todos'] // son dos arrays, el primero son los datos y el segundo es el texto que se va a mostrar (el -1 son Todos)
    ],
    columns: [
        { name: "id", className: "text-center" },
        { name: "nombre", className: "text-center"  },
        { name: "tipoCurso", className: "text-center"  },
        { name: "nivel", className: "text-center"  },
        { name: "capacidad", className: "text-center"  },
        { name: "semana", className: "text-center"  },
        { name: "fechaCurso", className: "text-center"  },
        { name: "alumnosApuntados", className: "text-center"  },
        { name: "identificador", className: "text-center"  },
        { name: "codigo", className: "text-center"  },
        { name: "accion", className: "text-center"  },

    ],
    columnDefs: [

        { targets: [0], orderData: [0], visible: true, className: 'tx-center' }, //  ID
        { targets: [1], orderData: [1], visible: true, className: 'tx-center' }, // nombre
        { targets: [2], orderData: [2], visible: true, className: 'tx-center' }, // tipocuros
        { targets: [3], orderData: [3], visible: true, "width": "5px", className: 'tx-center' }, // nivel
        { targets: [4], orderData: [4], visible: true, className: 'tx-center' }, // capacidad
        { targets: [5], orderData: [5], visible: true, "width": "3px", className: 'tx-center'}, // semana
        { targets: [6], orderData: [6], visible: true, className: 'tx-center' }, // fecha curso
        { targets: [7], orderData: [7], visible: true, "width": "5px", className: 'tx-center' }, // identificador
        { targets: [8], orderData: [8], visible: true, className: 'tx-center' }, // codigo
        { targets: [9], orderData: [9], visible: true, className: 'tx-center' }, // accion
        { targets: [10], orderData: [10], visible: true, className: 'tx-center' }, // accion


    ],

    "ajax": {

        url: "../../controller/cursos.php?op=mostrarTablaCursosListado",
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
        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
    },
}); // del DATATABLE
$("#cursos_todos_table").addClass("width-100");
}
cargarDatatablesCursos();
function cargarProfesores(idCursoSeleccionado) {
  $("#listarAgregarProfesor").find("option").remove();
  $.post(
    "../../controller/cursos.php?op=recogerProfesores",
    { idCursoSeleccionado: idCursoSeleccionado },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

      var data = JSON.parse(data);

      for (var i = 0; i < data.length; i++) {
        if (data[i].idCurso_profecurso == idCursoSeleccionado) {
          $("#listarAgregarProfesor").append(
            "<option value=" +
              data[i][0] +
              " selected='selected'>" +
              data[i][1] +
              "</option>"
          );
        } else {
          $("#listarAgregarProfesor").append(
            "<option value=" + data[i][0] + ">" + data[i][1] + "</option>"
          );
        }
      }
      $("#listarAgregarProfesor").bootstrapDualListbox("refresh");
    }
  );
}

function guardarProfesorCurso() {
    var cursoSeleccionadoGuardar = $("#idCursoProfesor").val();
    var cantidadSeleccionados = $(
      ".duallistbox-agregar-profesor option:selected"
    ).length;
    if (cantidadSeleccionados != 1) {
      toastr.error("Como maximo puede haber 1 profesor");
    } else {
      $(".duallistbox-agregar-profesor option:selected").each(function () {
        let idProfesorGuardar = $(this).val();
        cargando();
        $.post(
          "../../controller/cursos.php?op=guardarProfesorCurso",
          {
            cursoSeleccionadoGuardar: cursoSeleccionadoGuardar,
            idProfesorGuardar: idProfesorGuardar,
          },
          function (data) {
              toastr.success("Profesor asociado al curso correctamente"); 
              descargando();
          }
        );
      });
    }
    $("#listAddAlumnos").bootstrapDualListbox("refresh");
  }
  function mostrarClase(idCurso) {
    $.post("../../controller/cursos.php?op=recogerTodosCurso", { idCurso: idCurso }, function(data) {
        data = JSON.parse(data);
        if (data.length == 0) {
            toastr.error("Este curso no tiene alumnos");
        } else if (data[0].idProfe_profecurso === null || data[0].idProfe_profecurso === "") {
            toastr.error("Este curso no tiene profesor");
        } else {
            window.location.href = 'gestionCurso.php?idCurso='+idCurso;
          
        }
    });
}

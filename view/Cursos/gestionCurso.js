
    //***************************************************/
    //***************************************************/
    //***************************************************/
    //***************************************************/
    //************* LISTA DE CURSO DIA ******************/
    //***************************************************/
    idCurso = $('#idCurso').val();
    /** COMPRUEBA SI LA LISTA DEL CURSO HA SIDO CREADA */
    function cargarLista(){
        $('#alumnosCursoMostrar').html('');
        fechaSeleccionada = $('#fechaLista').val();


        $.post("../../controller/cursos.php?op=listaAsistencia",{idCurso:idCurso,fecha:fechaSeleccionada},function (dataListaHoy) { 
            // RECOGE LA LISTA DE ASISTENCIA DEL DÍA
            console.log(dataListaHoy);
            
            if(dataListaHoy == 0){

                // CREACIÓN DE NUEVA LISTA ASISTENCIAS//

                // RECOJO LA LISTA DE ALUMNOS ACTUAL //
                $.post("../../controller/cursos.php?op=recogerTodosCurso", { idCurso: idCurso }, function(alumnoCursoLista) {

                    alumnoCurso = JSON.parse(alumnoCursoLista);
                    if (alumnoCurso.length == 0) {
                        window.location.href = 'index.php';
                    } else if (alumnoCurso[0].idProfe_profecurso === null || alumnoCurso[0].idProfe_profecurso === "") {
                        window.location.href = 'index.php';
                    } else {

                            $("#profesorCursoMostrar").text(alumnoCurso[0].nomPersonal);

                            $.post("../../controller/cursos.php?op=crearListaCurso", { idCurso:idCurso, alumnoCursoLista: alumnoCurso,fecha:fechaSeleccionada }, function(dataInsert) {

                                dataInsert = JSON.parse(dataInsert);
                                console.log(dataInsert);

                                // MONTAR LISTA CUANDO EL GRUPO SE A CREADO
                                // Iterando sobre los alumnos y agregándolos al contenedor
                                if(dataInsert != 0){
                                  $("#alumnosCursoMostrar").html('');

                                    $.each(dataInsert, function(index, itemAlumno) {
                                        // SI EL ALUMNO ESTA PRESENTE SERA SUCCESS Y SI NO DANGER
                                        console.log(itemAlumno.asistencia);
                                        if(itemAlumno.asistencia == 1){
                                            claseBordeLista = 'border-success';
                                            claseBotonObjetivos = 'btn-success';
                                            textoAsistencia = 'Asistido';

                                        }else{
                                            claseBordeLista = 'border-danger';
                                            claseBotonObjetivos = 'btn-danger';
                                            textoAsistencia = 'Ausente';

                                        }

                                        $("#alumnosCursoMostrar").append(`
                                        <div type="button" data-idalumno="`+itemAlumno.idUsuario+`" class="col-6 col-lg-4 col-md-4 btnLista" style="cursor:default">
                                        <div>
                                            <div class="divColor card-hover card border-left `+claseBordeLista+`" style="border-radius: 5px">
                                            <div class="card-body" style="position: relative;">
                                            <div class="row" >
                                                <div class="col-12 col-lg-4 d-flex align-items-center">
                                                    <img class="rounded-circle" src="../../public/img/users/`+itemAlumno.avatarUsuario+`" style="width:100%">
                                                </div>
                                                <div class="col-12 col-lg-8 tx-center mg-t-10 mg-t-lg-0">
                                                    <div class="col-12 mg-lg-t-10">
                                                        <h4>`+itemAlumno.nomAlumno+` `+itemAlumno.apeAlumno+`</h4>
                                                    </div>
                                                    <div class="col-12">
                                                        <small><i>`+itemAlumno.emailUsuario+`</i></small>
                                                        <p><small class="tx-bold textAsistencia">`+textoAsistencia+`</small></p>
    
                                                    </div>
                                                    <!-- Botón en la esquina superior derecha -->
                                                </div>
                                            </div>
                                            <button type="button" class="btn `+claseBotonObjetivos+` btnObjAlum "  data-idAlum="`+itemAlumno.idUsuario+`" style="position: absolute; top: 0; right: 0;">Objetivos</button>
                                            
                                        </div>
                                        
                                            </div>
                                        </div>
                                </div>

                                        `
                      );
                    });
                  } else {
                    toastr.error(
                      "El día seleccionado no tiene lista de asistencia."
                    );
                  }
                }
              );
            }
          }
        );
      } else {
        //*****************************************************/
        /// EN CASO DE QUE EXISTA YA LA LISTA - CARGAR LISTA ///
        //*****************************************************/

        dataListaHoy = JSON.parse(dataListaHoy);

        $("#profesorCursoMostrar").text(dataListaHoy[0].nomPersonal);

        if (dataListaHoy != 0) {
          $("#alumnosCursoMostrar").html('');

          $.each(dataListaHoy, function (index, itemAlumno) {
            // SI EL ALUMNO ESTA PRESENTE SERA SUCCESS Y SI NO DANGER
            if (itemAlumno.asistencia == 1) {
              claseBordeLista = "border-success";
              claseBotonObjetivos = "btn-success";
              textoAsistencia = "Asistido";
            } else {
              claseBordeLista = "border-danger";
              claseBotonObjetivos = "btn-danger";
              textoAsistencia = "Ausente";
            }

                        $("#alumnosCursoMostrar").append(`
                        <div type="button" data-idalumno="`+itemAlumno.idUsuario+`"  class="col-6 col-lg-4 col-md-4 btnLista" style="cursor:default">
                        <div>
                            <div class="divColor card-hover card border-left `+claseBordeLista+`" style="border-radius: 5px">
                            <div class="card-body" style="position: relative;">
                            <div class="row" >
                                <div class="col-12 col-lg-4 d-flex align-items-center">
                                    <img class="rounded-circle" src="../../public/img/users/`+itemAlumno.avatarUsuario+`" style="width:100%">
                                </div>
                                <div class="col-12 col-lg-8 tx-center mg-t-10 mg-t-lg-0">
                                    <div class="col-12 mg-lg-t-10">
                                        <h4>`+itemAlumno.nomAlumno+` `+itemAlumno.apeAlumno+`</h4>
                                    </div>
                                    <div class="col-12">
                                        <small><i>`+itemAlumno.emailUsuario+`</i></small>
                                        <p><small class="tx-bold textAsistencia">`+textoAsistencia+`</small></p>

                                    </div>
                                    <!-- Botón en la esquina superior derecha -->
                                </div>
                            </div>
                            <button type="button" class="btn `+claseBotonObjetivos+` btnObjAlum "  data-idAlum="`+itemAlumno.idUsuario+`" style="position: absolute; top: 0; right: 0;">Objetivos</button>
                            
                        </div>
                        
                            </div>
                        </div>
                </div>

                        `
            );
          });
        } else {
          toastr.error("El día seleccionado no tiene lista de asistencia.");
        }
      }
    }
  )};

    // EJECUTA LA CARGA DE LA LISTA AL ACTUALIZAR FEHCA
    $('#fechaLista').on('change', function (){

        cargarLista();

    })

    // PASAR LISTA
    $('body').on('click','.btnLista', function(event){

        event.stopPropagation();

        let idUsuario = $(this).data('idalumno');
        console.log(idUsuario);
        var divAlumno= $(this);

        // Verifica si el objetivo del evento es el botón con clase btnObjAlum
        idCurso = $('#idCurso').val();

        var fechaActual = new Date();
        var dia = fechaActual.getDate();
        var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Asegura que el mes tenga dos dígitos
        var anio = fechaActual.getFullYear();
    
        var fechaActual = anio + '-' + mes + '-' + dia;
        console.log($('#fechaLista').val());
        console.log(fechaActual);
        if(fechaActual == $('#fechaLista').val()){


            $.post("../../controller/cursos.php?op=pasarLista",{idUsuario:idUsuario,idCurso:idCurso},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
    

                data = JSON.parse(data);
                let asistencia = data[0][0];
                if (asistencia == 1){
                    
                toastr["success"]('¡Alumno presente!');
                
                divAlumno.find('.divColor').removeClass('border-danger');
                divAlumno.find('.divColor').addClass('border-success');
                divAlumno.find('.textAsistencia').text('Asistido');
                divAlumno.find('.btnObjAlum').removeClass('btn-danger');
                divAlumno.find('.btnObjAlum').addClass('btn-success');

                }else{

                toastr["error"]('¡Alumno ausente!');

                divAlumno.find('.divColor').removeClass('border-success');
                divAlumno.find('.divColor').addClass('border-danger');
                divAlumno.find('.textAsistencia').text('Ausente');
                divAlumno.find('.btnObjAlum').addClass('btn-danger');
                divAlumno.find('.btnObjAlum').removeClass('btn-success');

                }
            })
        }else{

            toastr["error"]('No se puede tomar asistencia en una fecha que no sea la actual.');

        } 
      
    });
    
    
    cargarLista();


    //***************************************************/
    //***************************************************/
    //***************************************************/
    //***************************************************/
    //***************************************************/
    //***************************************************/



    
    //* PARTE VICTOR *//

    $("body").on("click",".btnObjAlum",function(event){
        event.stopPropagation();

        $("#objetivos-modal").modal("show");
            
        $("#listAddObj").html("");
        $("#listAddObj").bootstrapDualListbox('refresh');
        let idCurso = $("#idCurso").val();
        $("#idAlumnoModal").val($(this).data("idalum"));
        let idAlum = $(this).data("idalum");
        $.post("../../controller/cursos.php?op=mostrarObjetivos",{idCurso:idCurso},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
            data = JSON.parse(data);
            $.each(data, function(index, item) {
                $("#listAddObj").append("<option value='" + item.idObjetivo + "'>" + item.descrObjetivo + "</option>");
            });
            
            $.post("../../controller/cursos.php?op=recogerObjetivosXAlumno",{idAlum:idAlum,idCurso:idCurso},function (data) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
            
                data = JSON.parse(data);
                $.each(data, function(index, item) {
                    $('select option[value="'+item.idObjetivo_ObjAlum+'"]').prop('selected', true);
                });
                $("#listAddObj").bootstrapDualListbox('refresh');
            });
            $.post("../../controller/cursos.php?op=recogerObjetivosXAlumnoConNivel", {idAlum: idAlum, idCurso: idCurso}, function (data) {
                $.post("../../controller/cursos.php?op=recogerNivelActual",{idCurso:idCurso},function (nivelCurso) {//Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
                    nivelCurso = JSON.parse(nivelCurso);
                    let nivelCursoActual = nivelCurso[0].nivel_tmCursos

                        
                    data = JSON.parse(data);
                    var ultimoNivel = 0;
                    $("#listObjetivos").html("");
                    $.each(data, function(index, item) {
                        if(item.idNivel != ultimoNivel){
                            ultimoNivel = item.idNivel; // Actualiza el último nivel
                            
                            $("#listObjetivos").append(
                                `
                                <div data-nivel="`+item.idNivel+`" class="mg-l-10 checklist col-3 card border-left border-primary mg-lg-t-20" style="position: relative;">
                                
                                </div>
                                `
                  );
                }
                if (item.idNivel == nivelCursoActual) {
                  if (item.completado_ObjAlum == 1) {
                    $("[data-nivel='" + ultimoNivel + "']").append(
                      `
                                <input checked="" value="` +
                        item.idObjetivo_ObjAlum +
                        `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `">
                                <label for="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `" class="tx-18">` +
                        item.descrObjetivo +
                        `</label>
                                <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                        item.descrNivel +
                        ` - Curso Actual</nivelNombre></p></div>
                                `
                    );
                  } else {
                    $("[data-nivel='" + ultimoNivel + "']").append(
                      `
                                    <input value="` +
                        item.idObjetivo_ObjAlum +
                        `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `">
                                    <label for="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `" class="tx-18">` +
                        item.descrObjetivo +
                        `</label>
                                    <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                        item.descrNivel +
                        ` - Curso Actual</nivelNombre></p></div>
                                    `
                    );
                  }
                } else {
                  if (item.completado_ObjAlum == 1) {
                    $("[data-nivel='" + ultimoNivel + "']").append(
                      `
                                <input checked="" value="` +
                        item.idObjetivo_ObjAlum +
                        `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `">
                                <label for="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `" class="tx-18">` +
                        item.descrObjetivo +
                        `</label>
                                <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                        item.descrNivel +
                        `</nivelNombre></p></div>
                                `
                    );
                  } else {
                    $("[data-nivel='" + ultimoNivel + "']").append(
                      `
                                    <input value="` +
                        item.idObjetivo_ObjAlum +
                        `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `">
                                    <label for="` +
                        ultimoNivel +
                        `-0` +
                        item.idObjAlum +
                        `" class="tx-18">` +
                        item.descrObjetivo +
                        `</label>
                                    <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                        item.descrNivel +
                        `</nivelNombre></p></div>
                                    `
                    );
                  }
                }
                var checklistDiv = $("#listObjetivos")
                  .find(".checklist")
                  .last();
                var totalCheckboxes = checklistDiv.find(
                  'input[type="checkbox"]'
                ).length;
                var checkedCheckboxes = checklistDiv.find(
                  'input[type="checkbox"]:checked'
                ).length;

                if (checkedCheckboxes === totalCheckboxes) {
                  checklistDiv.removeClass("border-primary");
                  checklistDiv.addClass("border-success");

                  checklistDiv.find('input[type="checkbox"]').each(function () {
                    // Establece el color de fondo de los pseudo-elementos ::before y ::after
                    $(this).addClass("checkBoxOK");
                  });

                  // Aquí puedes agregar cualquier acción que quieras realizar cuando todos los checkboxes estén marcados en este checklist
                } else {
                  checklistDiv.find('input[type="checkbox"]').each(function () {
                    // Establece el color de fondo de los pseudo-elementos ::before y ::after
                    $(this).removeClass("checkBoxOK");
                  });

                  checklistDiv.addClass("border-primary");
                  checklistDiv.removeClass("border-success");
                  // Aquí puedes agregar cualquier acción que quieras realizar cuando no todos los checkboxes estén marcados en este checklist
                }
              });
            }
          );
        }
      );

      $("#listAddObj").bootstrapDualListbox("refresh");
    }
  );
});
$(".duallistbox-nuevo-obj").bootstrapDualListbox({
  moveSelectedLabel: "Añadir seleccionado",
  moveAllLabel: "Añadir Todos",
  removeSelectedLabel: "Eliminar Seleccionado",
  removeAllLabel: "Eliminar Todo",
  preserveSelectionOnMove: "moved",
  moveOnSelect: false,
});
$(".duallistbox-nuevo-contenido").bootstrapDualListbox({
  moveSelectedLabel: "Añadir seleccionado",
  moveAllLabel: "Añadir Todos",
  removeSelectedLabel: "Eliminar Seleccionado",
  removeAllLabel: "Eliminar Todo",
  preserveSelectionOnMove: "moved",
  moveOnSelect: false,
});

function guardarObjetivosAlumno() {
  cargando();
  let idAlum = $("#idAlumnoModal").val();
  let idCurso = $("#idCurso").val();
  var selectObjetivos = [];
  $("#listAddObj option:selected").each(function () {
    // Obtener el valor de la opción seleccionada y agregarlo al array
    selectObjetivos.push($(this).val());
  });
  $.post(
    "../../controller/cursos.php?op=guardarAlumObjetivos",
    { idAlum: idAlum, idCurso: idCurso, selectObjetivos: selectObjetivos },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      descargando();
      toastr.success("Objetivos del Alumno actualizados");
      $("#objetivos-modal").modal("hide");
    }
  );
}
$("#listObjetivos").on("click", "label,input", function () {
  var checklistDiv = $(this).closest(".checklist");
  var totalCheckboxes = checklistDiv.find('input[type="checkbox"]').length;
  var checkedCheckboxes = checklistDiv.find(
    'input[type="checkbox"]:checked'
  ).length;

  if (checkedCheckboxes === totalCheckboxes) {
    checklistDiv.removeClass("border-primary");
    checklistDiv.addClass("border-success");

    checklistDiv.find('input[type="checkbox"]').each(function () {
      // Establece el color de fondo de los pseudo-elementos ::before y ::after
      $(this).addClass("checkBoxOK");
    });

    // Aquí puedes agregar cualquier acción que quieras realizar cuando todos los checkboxes estén marcados en este checklist
  } else {
    checklistDiv.find('input[type="checkbox"]').each(function () {
      // Establece el color de fondo de los pseudo-elementos ::before y ::after
      $(this).removeClass("checkBoxOK");
    });

    checklistDiv.addClass("border-primary");
    checklistDiv.removeClass("border-success");
    // Aquí puedes agregar cualquier acción que quieras realizar cuando no todos los checkboxes estén marcados en este checklist
  }
});

$("body").on("click", ".objetivo-lista-marcar", function () {
  let idAlum = $("#idAlumnoModal").val();
  let idCurso = $("#idCurso").val();
  let idObj = $(this).val();
  $.post(
    "../../controller/cursos.php?op=marcarObjetivoUsuario",
    { idAlum: idAlum, idCurso: idCurso, idObj: idObj },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
    }
  );
});

function agregarQuitarContenido() {
  if (!$("#divAgregarQuitarContenido").is(":visible")) {
    $(".accionesCurso").addClass("d-none");
  }
  $("#divAgregarQuitarContenido").toggleClass("d-none");

  let idCurso = $("#idCurso").val();
  $.post(
    "../../controller/cursos.php?op=listarAllContenidos",
    { idCurso: idCurso },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      data = JSON.parse(data);
     
        $.each(data, function (index, item) {
          $("#listAddContenidos").append(
            "<option value='" +
              item.idContenido +
              "'>" +
              item.descrContenido +
              "</option>"
          );
        });
           

      $.post(
        "../../controller/cursos.php?op=recogerContenidoXAlumno",
        { idCurso: idCurso },
        function (data) {
          //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})

          data = JSON.parse(data);
          console.log(data);
          $.each(data, function (index, item) {
            $('select option[value="' + item.idCont_ContAlum + '"]').prop(
              "selected",
              true
            );
          });
          $("#listAddContenidos").bootstrapDualListbox("refresh");
        }
      );
    }
  );
}
function listarContenidos() {
  if (!$("#divListarContenido").is(":visible")) {
    $(".accionesCurso").addClass("d-none");
  }
  $("#divListarContenido").toggleClass("d-none");
  let idCurso = $("#idCurso").val();
  $.post(
    "../../controller/cursos.php?op=recogerContenidoConNivel",
    { idCurso: idCurso },
    function (data) {
      data = JSON.parse(data);
      console.log(data);
      $("#listContenidos").html("");
      $("#listContenidos").append(
        `
                <div class="checkContenido mg-l-10 checklist col-12 card border-left border-primary mg-lg-t-20" style="position: relative;">
                
                </div>
                `
      );
      if(data == ''){
        $('#listContenidos').html('<p class="tx-bold tx-danger">Sin contenidos añadidos, contacte con un superior.</p>')
      }else{
        $.each(data, function (index, item) {
          console.log(item);
          if (item.completado_ContAlum == 1) {
            $(".checkContenido").append(
              `
              <input checked="" value="` +
                item.idContenido +
                `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                item.idNivel +
                `-0` +
                item.idContenido +
                `">
                            <label for="` +
                item.idNivel +
                `-0` +
                item.idContenido +
                `" class="tx-18">` +
                item.descrContenido +
                `</label>
                            <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                item.codNivel +
                ` - Tipo: ` +
                item.descrTipo +
                `</nivelNombre></p></div>
                            `
            );
          } else {
            $(".checkContenido").append(
              `
                            <input value="` +
                item.idContenido +
                `" class="objetivo-lista-marcar tx-18" name="r" type="checkbox" id="` +
                item.idNivel +
                `-0` +
                item.idContenido +
                `">
                            <label for="` +
                item.idNivel +
                `-0` +
                item.idContenido +
                `" class="tx-18">` +
                item.descrContenido +
                `</label>
                            <div class="tx-right bg-white" style="position: absolute; top: -11px; right: 10px;"><p class="bold tx-black">Nivel: <nivelNombre>` +
                item.codNivel +
                ` - Tipo: ` +
                item.descrTipo +
                `</nivelNombre></p></div>
                            `
            );
          }
        });
      }


      var checklistDiv = $(".checkContenido");
      var totalCheckboxes = checklistDiv.find('input[type="checkbox"]').length;
      var checkedCheckboxes = checklistDiv.find(
        'input[type="checkbox"]:checked'
      ).length;

      if (checkedCheckboxes === totalCheckboxes) {
        checklistDiv.removeClass("border-primary");
        checklistDiv.addClass("border-success");

        checklistDiv.find('input[type="checkbox"]').each(function () {
          // Establece el color de fondo de los pseudo-elementos ::before y ::after
          $(this).addClass("checkBoxOK");
        });

        // Aquí puedes agregar cualquier acción que quieras realizar cuando todos los checkboxes estén marcados en este checklist
      } else {
        checklistDiv.find('input[type="checkbox"]').each(function () {
          // Establece el color de fondo de los pseudo-elementos ::before y ::after
          $(this).removeClass("checkBoxOK");
        });

        checklistDiv.addClass("border-primary");
        checklistDiv.removeClass("border-success");
        // Aquí puedes agregar cualquier acción que quieras realizar cuando no todos los checkboxes estén marcados en este checklist
      }
    }
  );
}


$("#listContenidos").on("click", "input", function () {
  var checklistDiv = $(this).closest(".checklist");
  var totalCheckboxes = checklistDiv.find('input[type="checkbox"]').length;
  var checkedCheckboxes = checklistDiv.find(
    'input[type="checkbox"]:checked'
  ).length;

  if (checkedCheckboxes === totalCheckboxes) {
    checklistDiv.removeClass("border-primary");
    checklistDiv.addClass("border-success");

    checklistDiv.find('input[type="checkbox"]').each(function () {
      // Establece el color de fondo de los pseudo-elementos ::before y ::after
      $(this).addClass("checkBoxOK");
    });

    // Aquí puedes agregar cualquier acción que quieras realizar cuando todos los checkboxes estén marcados en este checklist
  } else {
    checklistDiv.find('input[type="checkbox"]').each(function () {
      // Establece el color de fondo de los pseudo-elementos ::before y ::after
      $(this).removeClass("checkBoxOK");
    });

    checklistDiv.addClass("border-primary");
    checklistDiv.removeClass("border-success");
    // Aquí puedes agregar cualquier acción que quieras realizar cuando no todos los checkboxes estén marcados en este checklist
  }
  let idContenidoMarcado = $(this).val();

  let idCurso = $("#idCurso").val();
  $.post(
    "../../controller/cursos.php?op=marcarContenidoCurso",
    { idCurso: idCurso, idContenidoMarcado: idContenidoMarcado },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
    }
  );
});
$("body").on("click", "#guardarContenido", function () {
  cargando();
  let idCurso = $("#idCurso").val();
  var selectContenido = [];
  $("#listAddContenidos option:selected").each(function () {
    // Obtener el valor de la opción seleccionada y agregarlo al array
    selectContenido.push($(this).val());
  });
  $.post(
    "../../controller/cursos.php?op=guardarCursoContenido",
    { idCurso: idCurso, selectContenido: selectContenido },
    function (data) {
      //Ejemplo : $.post("../../controller/usuario.php?op=listarID",{id:id},function (data) {})
      descargando();
      toastr.success("Contenido del Curso actualizados");
    }
  );
});

//* FIN PARTE VICTOR *//
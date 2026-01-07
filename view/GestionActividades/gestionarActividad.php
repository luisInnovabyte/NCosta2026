<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php include("../Home/asignacionColorPrincipal.php"); ?>
    <?php
      session_start();
      $rolUsuario =  $_SESSION['usu_rol'];

    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1','2']);
    // ROL USUARIO

    ?>
    <!--end head-->
    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        /* SWITCH */
/* From Uiverse.io by cbolson */ 
.switch {
  --_switch-bg-clr: #70a9c5;
  --_switch-padding: 2px; /* antes: 4px */
  --_slider-bg-clr: rgba(12, 74, 110, 0.65);
  --_slider-bg-clr-on: rgba(12, 74, 110, 1);
  --_slider-txt-clr: #ffffff;
  --_label-padding: 0.4rem 0.8rem; /* antes: 1rem 2rem */
  --_switch-easing: cubic-bezier(0.47, 1.64, 0.41, 0.8);
  color: white;
  width: fit-content;
  display: flex;
  justify-content: center;
  border-radius: 9999px;
  cursor: pointer;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  position: relative;
  isolation: isolate;
}

.switch input[type="checkbox"] {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
.switch > span {
  display: grid;
  place-content: center;
  transition: opacity 300ms ease-in-out 150ms;
  padding: var(--_label-padding);
}
.switch::before,
.switch::after {
  content: "";
  position: absolute;
  border-radius: inherit;
  transition: inset 150ms ease-in-out;
}
/* switch slider */
.switch::before {
  background-color: var(--_slider-bg-clr);
  inset: var(--_switch-padding) 50% var(--_switch-padding)
    var(--_switch-padding);
  transition:
    inset 500ms var(--_switch-easing),
    background-color 500ms ease-in-out;
  z-index: -1;
  box-shadow:
    inset 0 1px 1px rgba(0, 0, 0, 0.3),
    0 1px rgba(255, 255, 255, 0.3);
}
/* switch bg color */
.switch::after {
  background-color: var(--_switch-bg-clr);
  inset: 0;
  z-index: -2;
}
/* switch hover & focus */
.switch:focus-within::after {
  inset: -0.25rem;
}
.switch:has(input:checked):hover > span:first-of-type,
.switch:has(input:not(:checked)):hover > span:last-of-type {
  opacity: 1;
  transition-delay: 0ms;
  transition-duration: 100ms;
}
/* switch hover */
.switch:has(input:checked):hover::before {
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    45%;
}
.switch:has(input:not(:checked)):hover::before {
  inset: var(--_switch-padding) 45% var(--_switch-padding)
    var(--_switch-padding);
}
/* checked - move slider to right */
.switch:has(input:checked)::before {
  background-color: var(--_slider-bg-clr-on);
  inset: var(--_switch-padding) var(--_switch-padding) var(--_switch-padding)
    50%;
}
/* checked - set opacity */
.switch > span:last-of-type,
.switch > input:checked + span:first-of-type {
  opacity: 0.75;
}
.switch > input:checked ~ span:last-of-type {
  opacity: 1;
}
    </style>
</head>



<body>

    <!--start mainHeader-->
    <?php include("../../config/templates/mainHeader.php"); ?>
    <!--end mainHeader-->


    <!--start sidebar-->
    <?php include("../../config/templates/mainSidebar.php"); ?>
    <!--end sidebar-->

    <!-- **************************************** -->
    <!--                BREADCUM                  -->
    <!-- **************************************** -->
    <!-- <span class="breadcrumb-item active">Mantenimiento</span> -->
    <!-- **************************************** -->
    <!--                FIN DEL BREADCUM                  -->
    <!-- **************************************** -->

    <!-- ***************************************************** -->
    <!--                CABECERA DE LA PAGINA                  -->
    <!-- ***************************************************** -->
    <input type="hidden" id="rolUsuario" value="<?php echo $rolUsuario ?>">

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Actividades</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-12 pageTitle mt-3">
                <div class="row">
                    <div class="col-1 wd-auto-force">
                        <i class="fa-solid fa-triangle-exclamation tx-50-force"></i>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <div class="row">
                            <h4 class="col-12 tx-18">AVISOS GERENCIA</h4>
                            <p class="mb-0 col-12 tx-16"></p>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">Gestionar Actividades</h2>
                    <div class="my-3 border-top"></div>


                                    <!-- **************************************** -->
                                    <!--             CONTENIDO PRINCIPAL          -->
                                    <!-- **************************************** -->

                                    
                                    <div class="col-lg-12 ">
                                <div class="form-layout form-layout-4 ">
                                    <h5 class="br-section-label" id="current-title">Crear actividad</h5>
                                    <br>
                                    <br>

                                    <form method="POST" id="newActividad_form">
                                        <!-- row -->
                                        <div class="row">
                                            <div class="col-6 mg-b-10">
                                                <!-- ID -->
                                                <input type="hidden" name="idAct" id="idAct" value="<?php echo $_GET['idAct'] ?>">
                                                <!-- IMAGEN -->
                                                <input type="hidden" name="imgAct" id="imgAct">
                                                <label class="col-sm-12 col-md-12 form-control-label">Nombre: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="descrAct" name="descrAct" minlength="2" maxlength="100" placeholder="Título de la actividad" required/>

                                                <div class="row">
                                                    <span id="infoDescrAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 100 caracteres</span>
                                                </div>


                                            </div><!-- row -->
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha límite de inscripción: <span class="tx-danger">*</span></label>

                                                <input type="date" class="form-control" id="fecActFinSolicitud" name="fecActFinSolicitud" placeholder="Seleccione una fecha" required/>

                                                <div class="row">
                                                    <span id="infoFecActFinSolicitud" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de inicio actividad: <span class="tx-danger">*</span></label>

                                                <input type="date" class="form-control" id="fecActDesde" name="fecActDesde" placeholder="Seleccione una fecha" required/>

                                                <div class="row">
                                                    <span id="infoFecActDesde" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                </div>

                                            </div>
                                            <br>
                                            <!-- row -->
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Fecha de fin actividad: <span class="tx-danger"></span></label>

                                                <input type="date" class="form-control" id="fecActHasta" name="fecActHasta" placeholder="Seleccione una fecha" />

                                                <div class="row">
                                                    <span id="infoFecActHasta" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Día/Mes/Año</span>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- row -->

                                        <br>

                                        <!-- row Desplegable-->
                                        <div class="row">

                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Hora inicio actividad: <span class="tx-danger">*</span></label>

                                                <input type="time" class="form-control" id="horaInicioAct" name="horaInicioAct" onClick="this.select()" required/>

                                                <div class="row">
                                                    <span id="infoHoraInicioAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Horas:Minutos</span>
                                                </div>


                                            </div><!-- row -->
                                            <br>
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Hora fin actividad: </label>

                                                <input type="time" class="form-control" id="horaFinAct" name="horaFinAct" onClick="this.select()"/>

                                                <div class="row">
                                                    <span id="infoHoraFinAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Horas:Minutos</span>
                                                </div>


                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Horas lectivas previstas: <span class="tx-danger"></span></label>
                                                <input type="number" class="form-control" id="horasLectivasAct" name="horasLectivasAct" min=1 max=300/>

                                                <div class="row">
                                                    <span id="infoHorasLectivasAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 11 caracteres numéricos</span>
                                                </div>

                                            </div><!-- row -->
                                            <br>
                                            <div class="col-6 mg-b-10">
                                                <label class="col-sm-12 col-md-12 form-control-label">Punto de encuentro: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="puntoEncuentroAct" name="puntoEncuentroAct" minlength="2" maxlength="105" required />

                                                <div class="row">
                                                    <span id="infoPuntoEncuentroAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 105 caracteres</span>
                                                </div>
                                        </div>
                                        
                                        </div><!-- row -->

                                        <br>
                                        <div class="row mg-b-10">
                                            <div class="row col-6">
                                                <div class="form-group col-6 ">
                                                    <label for="recipient-name" class="control-label">Min. Alumnos:</label>
                                                    <input type="text" name="minAlumTipo" value="1" class="form-control" id="minAlumTipo" min=1 required>
                                                    <span id="infoMinAlumTipo" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">(Min - 1 y Max - 999)</span>
                                                </div>
                                                <div class="form-group col-6 ">
                                                    <label for="recipient-name" class="control-labelcol">Max. Alumnos:</label>
                                                    <input type="text" name="maxAlumTipo" value="1" class="form-control" id="maxAlumTipo" min=1 required>
                                                    <span id="infoMaxAlumTipo" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">(Min - 1 y Max - 999) </span>
                                                </div>
                                            </div>

                                            <div class="row col-6">
                                                <div class="col-sm-12 col-md-12 col-lg-12 mg-t-10 mg-sm-t-0">
                                                <label class="col-sm-12 col-md-12 col-lg-12 form-control-label">Guía: <span class="tx-danger">*</span></label>

                                                        <div class="input-group " style="width:100%">
                                                            <select class="select2 " data-placeholder="SELECCIONE UN GUÍA"  id="idPersonal_guiaAct" name="idPersonal_guiaAct">
                                                            <option></option>

                                                            </select>
                                                        </div>
                                                    
                                                </div>
                                            </div>
                                            

                                            
                                        </div><!-- row -->
                                        <div class="row d-flex justify-content-center text-center">
                                            <div class="col-sm-12 col-md-12 col-lg-12 mg-t-10 mg-sm-t-0">
                                                <label class="col-sm-12 col-md-12 col-lg-12 form-control-label">
                                                    ¿En qué departamentos quieres que se vea? <span class="tx-danger">*</span>
                                                </label>
                                                <div class="mx-auto" style="width: 50%;">
                                                    <select class="js-example-placeholder-multiple js-states form-control" id="departamentosSelect" multiple="multiple"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row mg-b-10">
                                            <label for="recipient-name" class="col-sm-12 col-md-12 col-lg-12 form-control-label">Descripción de la actividad:</label>
                                            <div class="col-sm-12 col-md-12 col-lg-12 mg-t-10 mg-sm-t-0">
                                                <textarea id="obsAct" name="obsAct"></textarea>
                                            </div>
                                            <div class="row">
                                                <span id="infoObsAct" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500"></span>
                                            </div>
                                        </div><!-- row -->
                                        <!-- Inicio del dropzone -->

                                        <!-- Fin del dropzone -->
                                        <!-- <div class="sig sigWrapper"> -->
                                        <label for="recipient-name" class="control-label">Imagen de cabecera:</label>
                                        <br>
                                            <img src="" id="imgCabecera" class='d-none wd-100p ' height="300">
                                            <div action="#" class="dropzone" id="my-great-dropzone">
                                                <div class="fallback">
                                                    <input id="file" name="file" type="file" multiple />
                                                </div>
                                            </div>
                                            <div class="row">
                                                    <span id="infoImgCabecera" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Max. 2 MB</span>
                                            </div>
                                        <div class=" form-layout-footer mg-t-30 pd-t-20 ">
                                            <!-- <button type="button" id="cancelar" class="btn btn-dark mg-sm-t-10">Volver</button> -->
                                            <button type="submit" name="action" id="botonGuardar" value="add" class="btn btn-success mg-sm-t-10">Guardar</button>
                                            <button type="button" name="botonCambiarImg" id="botonCambiarImg" class="btn btn-warning mg-sm-t-10 d-none" onclick="showDropzone()">Cambiar Cabecera</button>
                                            <button type="button" name="desactivarActividad" id="desactivarActividad" class="btn btn-danger mg-sm-t-10 d-none" onclick="desactivar(<?php echo $_GET['idAct'] ?>)">Desactivar</button>
                                            <button type="button" name="activarActividad" id="activarActividad" class="btn btn-success mg-sm-t-10 d-none" onclick="activar(<?php echo $_GET['idAct'] ?>)">Activar</button>
                                            <a href="index.php" class="btn btn-dark mg-sm-t-10">Volver</a>

                                        </div><!-- form-layout-footer -->
                                        <!-- form-layout-footer -->
                                    </form>
                                </div><!-- form-layout -->
                            </div>
                    <!-- **************************************** -->
                    <!-- **************************************** -->
                    <!-- **************************************** -->

                </div>
            </div>
        </div>

    </main>
    <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->



    <?php include("../../config/templates/searchModal.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    
    <script src="gestionarActividad.js"></script>
    <!--end plugins extra-->



</body>

</html>
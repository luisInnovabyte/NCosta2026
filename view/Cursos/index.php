<?php 
session_start();

?>
<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

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

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Cursos</li>
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
                    <h2 class="card-title">Creación de Cursos y Asignación de Estudiantes</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                    






        <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

<!-- ============================================================== -->
<!-- CONTENIDO DE LA PÁGINA  -->
<!-- ============================================================== -->

    <div class="card-body">
    
        <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-10">
                <div class="card-body">
                    <h4 class="card-title">Creación de Cursos y Asignación de Estudiantes</h4>
                    <h6 class="card-subtitle">En esta sección, podrás crear nuevos cursos, añadir alumnos a los cursos y también cambiarlos de curso.</h6> <br><br>
                </div>
            </div>
            <!-- <div class="col-sm-12 col-md-12 col-lg-2 offset-lg-10"> -->
        
        </div>

        <!--  CURSO -->
        
        <div class="row">

            <!-- ACCIONES -->
            <div class="row col-12 mg-t-30  bd-0 shadow-base   rounded justify-content-center tx-center align-items-center">
                                            
                    <!-- Acciones -->
                    <div class="col-12 mg-b-20 mg-t-10">
                        <h2>Acciones</h2>
                    </div>
                    <!-- BOTON 1 -->
                    <div class="col-md-3 col-12 mg-t-10 mg-b-30" >
                        <button type="button" onclick="mostrarCrearCurso()" class="btn waves-effect tx-bold waves-light btn-block btn-success">Crear Curso</button>
                    </div>
                    <!-- BOTON 2 -->
                    <div class="col-md-3 col-12  mg-t-10 mg-b-30">
                        <button type="button" onclick="mostrarNuevoCurso()" class="btn waves-effect tx-bold waves-light btn-block btn-info">Añadir Alumnos</button>
                    </div>
                    <!-- BOTON 3 -->
                    <div class="col-md-3 col-12  mg-t-10 mg-b-30">
                        <button type="button" onclick="mostrarPasarCurso()" class="btn waves-effect tx-bold waves-light btn-block btn-cyan">Avanzar Curso</button>
                    </div>
                     <!-- BOTON 4 -->
                        <div class="col-md-3 col-12  mg-t-10 mg-b-30">
                            <button type="button" onclick="mostrarAgregarProfesor()" class="btn waves-effect tx-bold waves-light btn-block btn-primary">Añadir Profesor</button>
                        </div>

            </div>



            <!-- SELECCIONE CURSO BOTON 1 - CREAR CURSO -->
            <div id="divCrearCurso" class="accionesCurso col-12 card-line d-none mg-t-30">
                                                
                <!-- titulos -->
                <div class="col-12 mg-t-20 mg-b-20">
                    <h3 class="tx-success card-title">Crear curso</h3>
                    <small>En este apartado podrás crear un nuevo curso</small>
                </div>
                

                <!-- NUEVO CURSO -->
                <div class="row col-12 justify-content-center  mg-b-30 tx-center align-items-center">
                    
             
                    <!-- IDIOMA -->
                    <div class="col-12 form-group mg-t-10  col-xl-2">
                        <label for="idioma" class="col-12">Idioma</label>
                        <select name="idioma" id="idiomaNuevoCurso" style="width: 100%" class="js-example-responsive form-control">
                           
                        </select>
                    </div>

                    <!-- Tipo de Curso -->
                    <div class="col-12 col-xl-2  form-group  mg-t-10">
                        <label for="tipoCurso" class="col-12 ">Tipo de Curso</label>
                        <select name="tipoCurso" id="tipoCursoNuevoCurso" style="width: 100%" class="js-example-responsive form-control">
                    
                        </select>
                    </div>

                    <!-- Nivel -->
                    <div class="col-12 col-xl-2  form-group  mg-t-10">
                        <label for="nivel" class="col-12">Nivel</label>
                        <select name="nivel" id="nivelNuevoCurso" style="width: 100%" class="js-example-responsive form-control">
               
                        </select>
                    </div>
                    <!-- Semana -->
                    <div class="col-12 col-xl-2  form-group mg-t-10 ">
                        <label for="semana" class="col-12 ">Semana</label>
                            <select id="semanaNuevoCurso" style="width: 100%" class="js-example-responsive form-control" name="semana">
                                
                            </select>
                    </div>

                    <!-- Semana Anterior-->
                    <div class="col-12 col-xl-2  form-group  mg-t-10">
                        <label for="semanaAnterior" class="col-12">Fecha</label>
                        <input type="date" id="fechaCurso" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <!-- Id Curso -->
                    <div class="col-12 col-xl-1 form-group mg-t-10">
                        <label for="idCurso" class="col-12">Identificador</label>
                        <input type="text" id="identificadorCurso" readonly value="1" class="tx-center form-control">
                    </div>

                    <!-- Boton Crear Curso -->
                    <div class="col-12 col-xl-1  form-group   mg-t-10 ">
                        <label for="" class="col-12"></label>
                        <button type="button" id="crearCurso" class="btn waves-effect waves-light btn-outline-info">Crear Curso</button>
                    </div>

                </div>                       
              

            </div>

            <!-- SELECCIONE CURSO BOTON 2 - NUEVO CURSO -->
            <div id="divNuevoCurso" class="accionesCurso col-12  card-line d-none mg-t-30">
                
                <!-- titulos -->
                <div class="col-12 mg-t-20 mg-b-20">
                    <h3 class="tx-info card-title">Añadir alumnos</h3>
                    <small>Añada alumnos al curso nuevo</small>
                </div>
                
           
                <div class="col-md-6 col-12">
                        <!-- SELECCIONE CURSO -->
                        <div class="col-12 mg-b-20">
                        <label for="curso" class="col-12">Seleccione un Curso</label>
                            <!-- BOTON 1 -->
                            <div class="col-12 mg-t-10 mg-b-30">
                            <button type="button" onclick="cargarDatosCurso(1)" class="btn waves-effect tx-bold waves-light btn-block btn-info" data-toggle="modal" data-target="#selectCurso1">Seleccionar Curso</button>
                            </div>
                        </div>
                        <p class="col-12 tx-20 tx-bold tx-underline"></p>
                </div>

                <!-- TITULO INDICATIVO -->
                <div class="row col-12 mg-t-20 justify-content-center tx-center align-items-center">

                    <div class="col-md-6 col-12 row">
                        <p class="col-12 tx-20 tx-bold tx-underline">Alumnos</p>
                    </div>
                    <span><i class="fa-solid tx-20 fa-chevron-right"></i></span>

                    <div class="col-md-6 col-12">
                        <input type="hidden" id="idCursoAddAlumno">
                        <p id="codigoText1" class="col-12 tx-20 tx-bold tx-underline parpadeo">Selecciona un Curso</p>
                    </div>

                    <div class="col-12">
                        <select multiple="multiple" size="10" id="listAddAlumnos" class="duallistbox-nuevo-curso">
                        </select>
                    </div>

                    <div class="d-flex col-12 justify-content-end text-right  tx-bold">
                        <small id="alumnosMaximos" class="text-right-force tx-bold"></small>
                    </div>

                    <div class="mg-t-20 mg-b-20">
                        <button id="" class="btn btn-dark btn-outline" type="button" onclick="location.reload();"> <span> Cancelar </span> </button>
                        <button class="btn btn-success" type="button" id="guardarGrupo"> Guardar Curso </button>
                    </div>
                </div>
                </div>

            </div>
            
            <!-- SELECCIONE CURSO BOTON 3 - PASAR CURSO-->
            <div id="divPasarCurso" class="accionesCurso col-12  card-line d-none  mg-t-30">
                
                <!-- Titulos -->
                <div class="col-12 mg-t-20 mg-b-20">
                    <h3 class="tx-info card-title">Avanzar curso</h3>
                    <small>En este apartado podrás pasar alumnos de un curso a otro</small>
                </div>
                
               
                <!-- TITULO INDICATIVO -->
                <div class="row col-12 mg-t-20 d-flex justify-content-center tx-center align-items-center">
                    
                    <div class="col-md-6 col-12">
                            <!-- SELECCIONE CURSO -->
                            <div class="col-12 mg-b-20">
                                <label for="curso" class="col-12">Primer Curso</label>
                                <!-- BOTON 1 -->
                                <div class="col-12 mg-t-10 mg-b-30">
                                    <button type="button" onclick="cargarDatosCurso(2)" class="btn waves-effect tx-bold waves-light btn-block btn-cyan" data-toggle="modal" data-target="#selectCurso1">Seleccionar Curso</button>
                                </div>
                            </div>
                            <p class="col-12 tx-20 tx-bold tx-underline"></p>
                    </div>

                    <!-- <span><i class="fa-solid tx-20 fa-chevron-right"></i></span> -->

                    <div class="col-md-6 col-12">

                            <!-- SELECCIONE CURSO -->
                            <div class="col-12   mg-b-20">
                                <label for="curso" class="col-12">Segundo Curso</label>
                                <!-- BOTON 2 -->
                                <div class="col-12 mg-t-10 mg-b-30">
                                    <button type="button" onclick="cargarDatosCurso(3)" id="modalTabla2" class="btn waves-effect tx-bold waves-light btn-block btn-cyan" data-toggle="modal" data-target="#selectCurso1">Seleccionar Curso</button>
                                </div>
                            </div>

                        <p class="col-12 tx-20  tx-bold tx-underline"></p>
                    </div>
                    
                    <div class="col-md-6 col-12 row">
                        <input type="hidden" id="idCursoPasarAlumno1">

                        <p id="codigoText2" class="col-12 tx-20 tx-bold tx-underline parpadeo">Selecciona un Curso</p>
                    </div>
                    <span><i class="fa-solid tx-20 fa-chevron-right"></i></span>

                    <div class="col-md-6 col-12">
                        <input type="hidden" id="idCursoPasarAlumno2">
                        <p id="codigoText3" class="col-12 tx-20 tx-bold tx-underline parpadeo">Selecciona un Curso</p>
                    </div>

                    <div class="col-12">
                        <select multiple="multiple" size="10" id="listPasarAlumnos" class="duallistbox-nuevo-curso">
                        </select>
                    </div>

                    <div class="mg-t-20 mg-b-20">
                        <button id="print" class="btn btn-dark btn-outline " type="button"> <span> Cancelar </span> </button>
                        <button class="btn btn-success" type="button" id="guardarGrupoAvanzarCurso"> Guardar Curso </button>
        </div>
    </div>

</div>

</div>
<!-- SELECCIONE CURSO BOTON 4 - PASAR CURSO-->
<div id="divAgregarProfesor" class="accionesCurso col-12  card-line d-none  mg-t-30">

    <!-- Titulos -->
    <div class="col-12 mg-t-20 mg-b-20">
        <h3 class="tx-primary card-title">Agregar Profesor</h3>
        <small>En este apartado podrás asociar los profesores a cada curso.</small>
    </div>


    <!-- TITULO INDICATIVO -->
    <div class="row col-12 mg-t-20 d-flex justify-content-center tx-center align-items-center">

        <div class="col-md-6 col-12">
            <!-- SELECCIONE CURSO -->
            <div class="col-12 mg-b-20">
                <label for="curso" class="col-12">Lista de profesores</label>
                <!-- BOTON 1 -->
                <div class="col-12 mg-t-10 mg-b-30">
                    <button type="button" onclick="cargarDatosCurso(4)" class="btn waves-effect tx-bold waves-light btn-block btn-primary" data-toggle="modal" data-target="#selectCurso1">Seleccionar Curso</button>
                </div>
            </div>
            <p class="col-12 tx-20 tx-bold tx-underline"></p>
        </div>

        <!-- <span><i class="fa-solid tx-20 fa-chevron-right"></i></span> -->

        <div class="col-md-6 col-12">

            <!-- SELECCIONE CURSO -->
            <div class="col-12   mg-b-20">
                <label for="curso" class="col-12"></label>
                <!-- BOTON 2 -->
                <div class="col-12 mg-t-10 mg-b-30">
                </div>
            </div>

            <p class="col-12 tx-20  tx-bold tx-underline"></p>
        </div>

        <div class="col-md-6 col-12 row">
            <input type="hidden" id="idCursoProfesor">
            <p id="" class="col-12 tx-20 tx-bold tx-underline">Profesores</p>
        </div>
        <span><i class="fa-solid tx-20 fa-chevron-right"></i></span>

        <div class="col-md-6 col-12">
            <input type="hidden" id="">
            <p id="textoParpadeo" class="col-12 tx-20 tx-bold tx-underline parpadeo">Selecciona un Curso</p>
        </div>

        <div class="col-12">
            <select multiple="multiple" size="10" id="listarAgregarProfesor" class="duallistbox-agregar-profesor">
            </select>
        </div>

        <div class="mg-t-20 mg-b-20">
            <button id="" class="btn btn-dark btn-outline " type="button"> <span> Cancelar </span> </button>
            <button class="btn btn-success" type="button" onClick="guardarProfesorCurso();"> Guardar Curso </button>
                        </div>
                    </div>

                    </div>

                </div>

            </div>


            
        </div>
</div>

<!-- ============================================================== -->
<!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
<!-- ============================================================== -->

</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->





























































































                    </div>

                </div>
            </div>
            </div>
            </div>
    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>

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

    <script src="cursoIndex.js"></script>

    <!--end plugins extra-->



</body>

</html>
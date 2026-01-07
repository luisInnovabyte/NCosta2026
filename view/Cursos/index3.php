<!DOCTYPE html>
<html lang="es">
<?php include '../../config/funciones.php' ?>
<!-- Hace falta por que ahí está la funcion que genera las tablas en HTML -->

<head>
    <?php include_once '../../config/templates/mainHead.php' ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    checkAccess(['1','2']);
    ?>
    <!-- CSS DE ALERTAS -->
    <!-- CSS DE DROPZONE IMG -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/dropzone/dist/min/dropzone.min.css">
    <!-- CSS DE LAS TABLAS ALUMNOS -->
    <link rel="stylesheet" type="text/css" href="../../public/js/libs/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css">


</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php include_once '../../config/templates/mainPreloader.php' ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->



    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <?php include_once '../../config/templates/mainLogo.php' ?>
                    <!-- ============================================================== -->
                    <!-- FIN Logo -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ================================================================================ -->
                    <!--PARTE SUPERIOR DESPUES DEL SIDEBAR (TRES LINEAS, CAJA DE REGALO, CAMPANA y SOBRE) -->
                    <!-- ================================================================================ -->
                    <?php include_once '../../config/templates/mainNavbar.php' ?>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once '../../config/templates/mainSidebar.php' ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- CABECERA DE LA PAGINA Y TITULO  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- CABECERA-->
                    <!-- ============================================================== -->
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Cursos</h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="..\Home">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Cursos</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- FIN DE CABECERA DE LA PAGINA Y TITULO  -->
            <!-- ============================================================== -->


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
                                <div class="row">
                                <div class="table-responsive ">
                                    <?php
                                    $nombreTabla = "cursos_todos_table";
                                    $nombreCampos = ["Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad", "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo", "Acción"];
                                    $nombreCamposFooter = [
                                        "Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad", "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo","Acción"
                                    ];

                                    $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                                    echo $tablaHTML;
                                    ?>

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

            <?php include_once 'modalCursos.php' ?>
            <?php include_once 'modalVerClase.php' ?>

            <!-- ============================================================== -->
            <!-- MODAL AYUDA  -->
            <!-- ============================================================== -->
            <?php include_once '../../config/modalAyudas/modalAyuda.php' ?>

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <?php include_once '../../config/templates/mainFooter.php' ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <div class="chat-windows"></div>


    <?php include_once '../../config/templates/mainJs.php' ?>

    <!-- SCRIPTS PERSONALIZADOS -->
    <!-- TouchSpin + - -->
    <script src="../../public/js/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- ALERTAS  -->
    <script src="../../dist/js/custom.min.js"></script>

    <!-- DropZone IMG -->
    <script src="../../public/js/libs/dropzone/dist/min/dropzone.min.js"></script>

    <!-- Llamada de la parte común del datatables -->
    <script src="../../config/templates/comunDataTables.js"></script>
    
    <!-- DUAL LISTBOX -->
    <script src="../../public/js/libs/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../public/js/dist/pages/forms/dual-listbox/dual-listbox.js"></script>

    <script src="cursoIndex.js"></script>

</body>

</html>
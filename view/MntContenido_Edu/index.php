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
        
.fadeIn {
  opacity: 0;
  animation: fadeInAnimation 0.5s ease-in-out forwards;
}

@keyframes fadeInAnimation {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
.fadeOut {
  opacity: 1;
  animation: fadeOutAnimation 0.5s ease-in-out forwards;
}

@keyframes fadeOutAnimation {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

    </style>
    
    <?php 
    
        require_once("../../config/conexion.php");
        require_once("../../config/funciones.php");
        require_once("../../models/TipoCurso_Edu.php");
        require_once("../../models/Niveles_Edu.php");
        $cursos = new TipoCurso();
        $datos = $cursos->listarTipoCurso();
        $niveles = new Niveles();
        $datosN = $niveles->listarNiveles();

    
    ?>
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
                        <li class="breadcrumb-item" aria-current="page">Mantenimientos</li>
                        <li class="breadcrumb-item" aria-current="page">Contenidos</li>
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
                    <h2 class="card-title">Contenidos</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card radius-10">
                                <div class="card-body p-0">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Mostrar Leyenda
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-primary waves-effect tx-12-force col-12 col-lg-1">Agregar</button>
                                                    <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force"> Al presionar este botón se empezará el proceso para <label class="fw-bold">agregar</label> una nueva opción a la aplicación, esto permitirá tener diferentes opciones.</label>
                                                </div>

                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-info waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-edit"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force"> Con este botón podrás <label class="fw-bold">editar</label> la información de la opción seleccionada.</label>
                                                </div>

                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-success waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-check"></i></button>
                                                    <button class="btn btn-danger waves-effect tx-12-force col-12 col-lg-1 mg-lg-l-10 mg-lg-t-0-force mg-l-0 mg-t-10-force"><i class="fa-solid fa-xmark"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-8  mg-t-10-force mg-lg-t-0-force"> Con estos botones podrás <label class="fw-bold tx-success">activar</label> / <label class="fw-bold tx-danger">desactivar</label> las opciones, <label class="fw-bold tx-success">permitiendo</label> / <label class="fw-bold tx-danger">denegando</label> su <label class="fw-bold">uso en apartados de la aplicación</label>.</label>
                                                </div>
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-primary btn-icon waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-eye"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force"> Te mostrara una ventana con <label class="fw-bold">información adicional</label> de la opción seleccionada.</label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-12 d-flex justify-content-end mg-b-10">
                            <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#insertar-contenido-modal">Agregar Nivel</button>
                        </div> -->
                        <div class="row">
                              
                    <div class="row" id="addCont">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"></h4>
                                    <div class="repeater-default m-t-30">
                                        <div data-repeater-list="">
                                            <div data-repeater-item="">
                                                <form>
                                                    <div class="input-group">
                                                        <div class="form-group col-md-3" style="z-index: 0">
                                                            <label for="verTitular" class="">Titular</label>
                                                            <button type="button"   class="btn btn-outline-success  form-control waves-effect waves-light" id="verTitular" data-bs-toggle="modal" data-bs-target="#modal-titulares">SELECCIONE UN TITULAR</button>
                                                            
                                                            <input type="hidden" class="form-control" id="titularSelect" value="0">

                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="curso" class="">Curso</label><br>
                                                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO"  style="width: 100%;  height: 65px !important;" id="selectCurso">
                                                                <?php foreach($datos as $row){?>
                                    
                                                                    <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                                                <?php } ?>
                                                            </select>                                                       
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="nivel" class="">Nivel</label><br>
                                                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR NIVEL"  style="width: 100%;  height: 65px !important;" id="selectNivel">
                                                                <?php foreach($datosN as $row){?>
                                    
                                                                    <option value="<?php echo $row["idNivel"] ?>"><?php echo $row["codNivel"] ?></option>
                                                                <?php } ?>
                                                        </select>                                                       
                                                        </div>
                                                       
                                                        <div class="form-group col-md-3">
                                                            <label for="contenido">Contenido</label>

                                                            <textarea class="autoArea form-control" id="contenido" rows="1" placeholder="Saludar y despedirse en español..." data-type="3" data-min="0" data-max="300" data-new-input="0" data-descripcion="1" data-required = "1" style="min-inline-size: auto !important"></textarea>

                                                        </div>
                                                       
                                                    </div>
                                                </form>
                                                <hr>
                                            </div>
                                        </div>
                                        <button class="btn btn-info waves-effect waves-light" onClick="agregarContenido()">Añadir Contenido</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row d-none" id="editCont">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"></h4>
                                    <div class="repeater-default m-t-30">
                                        <div data-repeater-list="">
                                            <div data-repeater-item="">
                                                <form>
                                                <input type="hidden" id="contenidoSelected">
                                                    <input type="hidden" id="titularSelect1">
                                                    <div class="input-group">
                                                        <div class="form-group col-md-3" style="z-index: 0">
                                                            <label for="verTitular1" class="">Titular</label>
                                                            <button type="button"   class="btn btn-outline-success  form-control waves-effect waves-light" id="verTitular1" data-bs-toggle="modal" data-bs-target="#modal-titulares">SELECCIONE UN TITULAR</button>
                                                            
                                                            <input type="hidden" class="form-control" id="titularSelect" value="0">

                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="curso" class="">Curso</label><br>
                                                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CURSO"  style="width: 100%;  height: 65px !important;" id="selectCurso1">
                                                                <?php foreach($datos as $row){?>
                                    
                                                                    <option value="<?php echo $row["idTipo"] ?>"><?php echo $row["descrTipo"] ?></option>
                                                                <?php } ?>
                                                            </select>                                                       
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="nivel" class="">Nivel</label><br>
                                                            <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR NIVEL"  style="width: 100%;  height: 65px !important;" id="selectNivel1">
                                                                <?php foreach($datosN as $row){?>
                                    
                                                                    <option value="<?php echo $row["idNivel"] ?>"><?php echo $row["codNivel"] ?></option>
                                                                <?php } ?>
                                                        </select>                                                       
                                                        </div>
                                                       
                                                        <div class="form-group col-md-3">
                                                            <label for="contenido">Contenido</label>

                                                            <textarea class="autoArea form-control" id="contenido1" rows="1" placeholder="Saludar y despedirse en español..." data-type="3" data-min="0" data-max="300" data-new-input="0" data-descripcion="1" data-required = "1" style="min-inline-size: auto !important"></textarea>

                                                        </div>
                                                       
                                                    </div>
                                                </form>
                                                <hr>
                                            </div>
                                        </div>
                                        <button class="btn btn-info waves-effect waves-light" onClick="editarContenidoGuardar()">Editar Contenido
                                        </button>
                                        <button class="btn btn-danger waves-effect waves-light" onClick="quitarModoEdicion()">Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  

                            <div class="col-12">
                                <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                <div class="row">

                                    <div class="table-responsive order-mobile-first">
                                        <?php
                                        $nombreTabla = "contenido_table";
                                        $nombreCampos = ["IdObjetivo","idTitular","idNivel","idTipoCurso","Tipo curso","Nivel","Contenido","Titular","Observaciones","Codigo tipo","Codigo Nivel","Texto nivel","Semanas nivel","Estado","Acciones"];
                                        $nombreCamposFooter = ["IdObjetivo","idTitular","idNivel","idTipoCurso","Tipo curso","Nivel","Contenido","Titular","Observaciones","Codigo tipo","Codigo Nivel","Texto nivel","Semanas nivel","Estado","Acciones"];

                                        $cantidadGrupos = 1; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                                        $columGrupos = []; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                                        $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                                        $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                                        $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                                        $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                                        $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                                        echo $tablaHTML;
                                        ?>
                                    </div>
                                </div>
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
<?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
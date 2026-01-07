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
                        <li class="breadcrumb-item" aria-current="page">Mantenimientos</li>
                        <li class="breadcrumb-item" aria-current="page">Varios - interesados</li>
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
                    <h2 class="card-title">Mantenimientos Interesados</h2>
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

                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-danger" role="tablist">


                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#dangerAgentes" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Agentes</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dangerDepartamentos" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bxs-building-house font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Departamentos</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dangerConocimientos" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-book-bookmark font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Conocimientos</div>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dangerBildun" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bxs-user-badge font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Bildungsurlaub</div>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dangerTipoDoc" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Tipo Doc. Identificativo</div>
                                        </div>
                                    </a>
                                </li>


                                <li class="nav-item d-none" role="presentation">
                                    <a class="nav-link d-none" data-bs-toggle="tab" href="#dangerErasmus" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-world font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Erasmus</div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content py-3">

                                <div class="tab-pane fade" id="dangerhome" role="tabpanel">

                                    <!-- CONTENT -->



                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#insertar-tipocurso-modal">Agregar Curso Deseado</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "cursodeseado_table";
                                                $nombreCampos = ["ID", "Nombre", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre", "Estado", "Acciones"];

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


                                    <!-- FIN CONTENT -->

                                </div>
                                <div class="tab-pane fade" id="dangerprofile" role="tabpanel">
                                    <!-- CONTENT -->




                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar-conocimiento-modal">Agregar Conocimiento</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "agentes_table";
                                                $nombreCampos = ["ID", "Nombre", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre", "Estado", "Acciones"];

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




                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade  show active" id="dangerAgentes" role="tabpanel">
                                    <!-- CONTENT -->




                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar-agentes-modal">Agregar Agente</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "agente_table";
                                                $nombreCampos = ["ID", "Nombre Agente", "Identificación", "Domicilio", "Correo", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre Agente", "Identificación", "Domicilio", "Correo", "Estado", "Acciones"];

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




                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade" id="dangerDepartamentos" role="tabpanel">
                                    <!-- CONTENT -->




                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-2" data-bs-toggle="modal" data-bs-target="#agregar-departamentos-modal">Agregar Departamentos</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "departamentos_table";
                                                $nombreCampos = ["ID", "Nombre departamento", "Factura", "Factura Proforma", "Factura Abono", "Factura Abono Prof", "Estado",  "Color",  "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre departamento", "Factura", "Factura Proforma", "Factura Abono", "Factura Abono Prof", "Estado",  "Color", "Acciones"];

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




                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade" id="dangerConocimientos" role="tabpanel">
                                    <!-- CONTENT -->



                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar-conocimientos-modal">Agregar Conocimiento</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "conocimientos_table";
                                                $nombreCampos = ["ID", "Nombre conocimiento", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre conocimiento", "Estado", "Acciones"];

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


                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade" id="dangerBildun" role="tabpanel">
                                    <!-- CONTENT -->



                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar-Bildungsurlaub-modal">Agregar Bildungsurlaub</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "bildungsurlaub_table";
                                                $nombreCampos = ["ID", "Nombre Bildungsurlaub", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre Bildungsurlaub", "Estado", "Acciones"];

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


                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade" id="dangerTipoDoc" role="tabpanel">
                                    <!-- CONTENT -->



                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar-identidad-modal">Agregar Identificativo</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "tipoIdentificativo_table";
                                                $nombreCampos = ["ID", "Nombre", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre", "Estado", "Acciones"];

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


                                    <!-- FIN CONTENT -->
                                </div>
                                <div class="tab-pane fade d-none" id="dangerErasmus" role="tabpanel">
                                    <!-- CONTENT -->



                                    <div class="col-12 d-flex justify-content-end mg-b-10">
                                        <button class="btn btn-primary waves-effect col-12 col-lg-1" data-bs-toggle="modal" data-bs-target="#agregar--modal">Agregar Erasmus</button>
                                    </div>
                                    <div class="col-12">
                                        <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                                        <div class="row">

                                            <div class="table-responsive order-mobile-first">
                                                <?php
                                                $nombreTabla = "erasmus_table";
                                                $nombreCampos = ["ID", "Nombre", "Estado", "Acciones"];
                                                $nombreCamposFooter = ["ID", "Nombre", "Estado", "Acciones"];

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


                                    <!-- FIN CONTENT -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>




            </div>




    </main>
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>

    <?php include_once 'modalAgregarCurso.php' ?>
    <?php include_once 'modalEditarCurso.php' ?>

    <?php include_once 'modalAgregarAgentes.php' ?>
    <?php include_once 'modalEditarAgente.php' ?>


    <?php include_once 'modalAgregarDepartamentos.php' ?>
    <?php include_once 'modalEditarDepartamento.php' ?>

    <?php include_once 'modalAgregarConocimientos.php' ?>
    <?php include_once 'modalEditarConocimientos.php' ?>

    <?php include_once 'modalAgregarBildun.php' ?>
    <?php include_once 'modalEditarBildun.php' ?>


    <?php include_once 'modalAgregarIdentidad.php' ?>
    <?php include_once 'modalEditarIdentidad.php' ?>

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
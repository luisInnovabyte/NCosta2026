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

        /* Estilos profesionales para la página */
        .page-header-custom {
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: white;
        }
        .page-header-custom h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .page-header-custom p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            border-radius: 8px 8px 0 0;
            transition: all 0.2s ease;
        }
        .nav-tabs-custom .nav-link:hover {
            color: #1AA3E8;
            background-color: rgba(26, 163, 232, 0.1);
        }
        .nav-tabs-custom .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
        }
        .btn-add-record {
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-add-record:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 163, 232, 0.4);
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

            <!-- Header profesional -->
            <div class="page-header-custom">
                <h2><i class='bx bx-cog me-2'></i>Configuración de Interesados</h2>
                <p>Gestiona agentes, departamentos, conocimientos y más opciones del sistema</p>
            </div>

            <div class="col-12 card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">


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




                                    <div class="col-12 d-flex justify-content-end mb-3">
                                        <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#agregar-agentes-modal">
                                            <i class="bx bx-plus me-1"></i>Agregar Agente
                                        </button>
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




                                    <div class="col-12 d-flex justify-content-end mb-3">
                                        <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#agregar-departamentos-modal">
                                            <i class="bx bx-plus me-1"></i>Agregar Departamento
                                        </button>
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



                                    <div class="col-12 d-flex justify-content-end mb-3">
                                        <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#agregar-conocimientos-modal">
                                            <i class="bx bx-plus me-1"></i>Agregar Conocimiento
                                        </button>
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



                                    <div class="col-12 d-flex justify-content-end mb-3">
                                        <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#agregar-Bildungsurlaub-modal">
                                            <i class="bx bx-plus me-1"></i>Agregar Bildungsurlaub
                                        </button>
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



                                    <div class="col-12 d-flex justify-content-end mb-3">
                                        <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#agregar-identidad-modal">
                                            <i class="bx bx-plus me-1"></i>Agregar Identificativo
                                        </button>
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
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

        /* From Uiverse.io by KhaledMatalkah */ 
.custom-checkbox {
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
  font-size: 16px;
  color: #333;
  transition: color 0.3s;
}

.custom-checkbox input[type="checkbox"] {
  display: none;
}

.custom-checkbox .checkmark {
  width: 24px;
  height: 24px;
  border: 2px solid #333;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
  transition: background-color 0.3s, border-color 0.3s, transform 0.3s;
  transform-style: preserve-3d;
}

.custom-checkbox .checkmark::before {
  content: "\2713";
  font-size: 16px;
  color: transparent;
  transition: color 0.3s, transform 0.3s;
}

.custom-checkbox input[type="checkbox"]:checked + .checkmark {
  background-color: #333;
  border-color: #333;
  transform: scale(1.1) rotateZ(360deg) rotateY(360deg);
}

.custom-checkbox input[type="checkbox"]:checked + .checkmark::before {
  color: #fff;
}

.custom-checkbox:hover {
  color: #666;
}

.custom-checkbox:hover .checkmark {
  border-color: #666;
  background-color: #f0f0f0;
  transform: scale(1.05);
}

.custom-checkbox input[type="checkbox"]:focus + .checkmark {
  box-shadow: 0 0 3px 2px rgba(0, 0, 0, 0.2);
  outline: none;
}

.custom-checkbox .checkmark,
.custom-checkbox input[type="checkbox"]:checked + .checkmark {
  transition: background-color 1.3s, border-color 1.3s, color 1.3s, transform 0.3s;
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
                        <li class="breadcrumb-item" aria-current="page">Tarifas</li>
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class='bx bx-purchase-tag me-2'></i>Gestión de Tarifas</h2>
                        <p>Administra las tarifas, precios y descuentos de los servicios</p>
                    </div>
                    <button type="button" class="btn btn-light btn-sm" onclick="window.open('ayuda.html', 'Ayuda', 'width=1200,height=800,scrollbars=yes,resizable=yes');">
                        <i class="fa-solid fa-circle-question"></i> Ayuda
                    </button>
                </div>
            </div>

            <div class="col-12 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end gap-2 mb-3">
                            <a class="btn btn-add-record waves-effect" href="importarTarifa.php">
                                <i class="bx bx-import me-1"></i>Importar Tarifa
                            </a>
                            <button class="btn btn-add-record waves-effect" data-bs-toggle="modal" data-bs-target="#insertar-tarifaAloja-modal">
                                <i class="bx bx-plus me-1"></i>Agregar Tarifa
                            </button>
                        </div>
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive order-mobile-first">
                                    <?php
                                    
                        $nombreTabla = "tarifaAloja_table";
                        $nombreCampos = ["ID", "Código", "Nombre", "Medida", "Importe","Descuento", "Cuenta Contable 1", "Cuenta Contable 2", "Cuenta Contable 3","Tipo", "IVA", "Estado", "Acción"];
                        $nombreCamposFooter = [
                            "ID",
                            "<input type='text' class='form-control' id='FootCodigo' name='FootCodigo' placeholder='Buscar Código'>",
                            "<input type='text' class='form-control' id='FootDescripcion' name='FootDescripcion' placeholder='Buscar Nombre'>",
                            "<input type='text' class='form-control' id='FootMedida' name='FootMedida' placeholder='Buscar Medida'>",
                            "<input type='text' class='form-control' id='FootImporte' name='FootImporte' placeholder='Buscar Importe'>",
                            "<input type='text' class='form-control' id='FootDescuento' name='FootDescuento' placeholder='Buscar Descuento'>",
                            "<input type='text' class='form-control' id='FootCuentaContable1' name='FootCuentaContable1' placeholder='Buscar C.Contable'>",
                            "<input type='text' class='form-control' id='FootCuentaContable2' name='FootCuentaContable2' placeholder='Buscar C.Contable'>",
                            "<input type='text' class='form-control' id='FootCuentaContable3' name='FootCuentaContable3' placeholder='Buscar C.Contable'>",
                            "<input type='text' class='form-control' id='FootTipo' name='FootTipo' placeholder='Buscar Tipo'>",
                            "<input type='text' class='form-control' id='FootIva' name='FootIva' placeholder='Buscar IVA'>",
                            "<input type='text' class='form-control' id='FootEstado' name='FootEstado' placeholder='Buscar Estado'>",
                            "Acción",

                        ];
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
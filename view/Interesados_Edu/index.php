<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

    // Si CamposAlternativos es 0, asignar la clase "d-none"
    $alternativoContacto = ($configJsonSetting['MntPrescriptores_Edu']['camposAlternativosContacto'] == 0) ? 'd-none' : '';
    $alternativoUbicacion = ($configJsonSetting['MntPrescriptores_Edu']['camposAlternativosUbicacion'] == 0) ? 'd-none' : '';
    $campoGrupo = ($configJsonSetting['MntPrescriptores_Edu']['campoGrupo'] == 0) ? 'd-none' : '';
    $campoBildungsurlaub = ($configJsonSetting['MntPrescriptores_Edu']['campoBildungsurlaub'] == 0) ? 'd-none' : '';
    $campoAuPair = ($configJsonSetting['MntPrescriptores_Edu']['campoAuPair'] == 0) ? 'd-none' : '';
    $campoBotonFactura = ($configJsonSetting['MntPrescriptores_Edu']['botonFactura'] == 0) ? 'd-none' : '';
    ?>
    <!--end head-->
    <style>
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

        .customizer {
            background-color: transparent;
            box-shadow: none;
        }

        .botonFlotante1 {}

        .botonFlotante2 {
            top: 61px;
            margin-right: -5px;

        }

        .botonFlotante3 {
            top: 121px;
            margin-right: -5px;
        }

        .botonFlotante4 {
            top: 181px;
            margin-right: -5px;
        }
        .botonFlotante4-1 {
            top: 242px;
            margin-right: -5px;
        }

        .botonFlotante5 {
            top: 385px;
            margin-right: -5px;
        }

        .botonFlotante5-1 {
            top: 445px;
            margin-right: -5px;
        }

        .colorBoton1 {
            background: #c1c0a3 !important;
        }

        .colorBoton2 {
            background: #ff5c0f !important;
            border-radius: 10px;
        }

        .colorBoton3 {
            background: #0080ff !important;
            border-radius: 10px;
        }

        .colorBoton4 {
            background: #dc3545 !important;
            border-radius: 10px;
        }

        .colorBoton5 {
            background: #198754 !important;
            border-radius: 10px;
        }
        .colorBoton6 {
            background: #dc2380ff  !important;
            border-radius: 10px;
        }



        /* From Uiverse.io by csozidev */
        /* From Uiverse.io by guilhermeyohan */

        .check-online {
            position: relative;
            width: 50px;
            height: 25px;
            margin: 5px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .check-online label {
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 25px;
            border-radius: 50px;
            background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .check-online label:after {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            width: 23px;
            height: 23px;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .check-online input[type="checkbox"]:checked+label {
            background: linear-gradient(to bottom, #4cd964, #5de24e);
        }

        .check-online input[type="checkbox"]:checked+label:after {
            transform: translateX(25px);
        }

        .check-online label:hover {
            background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
        }

        .check-online label:hover:after {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .yep {
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 25px;
        }

        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }

        .swing-in-top-fwd {
            -webkit-animation: swing-in-top-fwd 1s cubic-bezier(0.175, 0.885, 0.320, 1.275) both;
            animation: swing-in-top-fwd 1s cubic-bezier(0.175, 0.885, 0.320, 1.275) both;
        }

        .swing-out-top-bck {
            -webkit-animation: swing-out-top-bck 0.45s cubic-bezier(0.600, -0.280, 0.735, 0.045) both;
            animation: swing-out-top-bck 0.45s cubic-bezier(0.600, -0.280, 0.735, 0.045) both;
        }

        /* ----------------------------------------------
 * Generated by Animista on 2024-8-20 13:18:44
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

        /**
 * ----------------------------------------
 * animation swing-out-top-bck
 * ----------------------------------------
 */
        @-webkit-keyframes swing-out-top-bck {
            0% {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 1;
            }

            100% {
                -webkit-transform: rotateX(-100deg);
                transform: rotateX(-100deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 0;
            }
        }

        @keyframes swing-out-top-bck {
            0% {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 1;
            }

            100% {
                -webkit-transform: rotateX(-100deg);
                transform: rotateX(-100deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 0;
            }
        }

        /**
 * ----------------------------------------
 * animation swing-in-top-fwd
 * ----------------------------------------
 */
        @-webkit-keyframes swing-in-top-fwd {
            0% {
                -webkit-transform: rotateX(-100deg);
                transform: rotateX(-100deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 0;
            }

            100% {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 1;
            }
        }

        @keyframes swing-in-top-fwd {
            0% {
                -webkit-transform: rotateX(-100deg);
                transform: rotateX(-100deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 0;
            }

            100% {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                -webkit-transform-origin: top;
                transform-origin: top;
                opacity: 1;
            }
        }


        /* Estilo del contenedor de sugerencias */
        .suggestions-list {
            position: absolute;
            width: 400px;
            border: 1px solid #ccc;
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            /* Asegura que las sugerencias se muestran sobre otros elementos */
            display: none;
            /* Ocultamos inicialmente */
        }

        /* Estilo de cada sugerencia */
        .suggestions-list p {
            padding: 10px;
            margin: 0;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .suggestions-list p:hover {
            background-color: #f0f0f0;
        }

        /* Estilo del contenedor de sugerencias */
        .suggestions-list {
            position: absolute;
            width: 99%;
            border: 1px solid #ccc;
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            /* Asegura que las sugerencias se muestran sobre otros elementos */
            display: none;
            top: 40px
                /* Ocultamos inicialmente */
        }

        /* Estilo de cada sugerencia */
        .suggestions-list p {
            padding: 10px;
            margin: 0;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .suggestions-list p:hover {
            background-color: #f0f0f0;
        }

        .nav-link[disabled] {
            pointer-events: none;
            /* No permite clics */
            color: grey;
            /* Cambia el color */
            text-decoration: none;
            /* Sin subrayado */
            cursor: not-allowed;
            /* Cambia el cursor para indicar que está deshabilitado */
            opacity: 0.5;
            /* Reduce la opacidad */
        }



        /* PERSONALIZACION DE CARDS */


        /* Colores de fondo para cada card */
        .card-body.datos-generales {
            background-color: #e3f2fd;
            /* Azul claro */
        }

        .card-body.datos-estudiante {
            background-color: #fff3e0;
            /* Amarillo claro */
        }

        .card-body.datos-contacto {
            background-color: #e8f5e9;
            /* Verde claro */
        }

        .card-body.ubicacion {
            background-color: #f0f4c3;
            /* Verde pálido */

        }

        .card-body.observacion {
            background-color: #ede4f5;
            /* Lila claro */

        }

        /* Efecto de elevación para el card al hacer hover en un input */
        .card-hover {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card-hover:hover,
        .card-hover.active {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        }

        .form-check-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #28a745;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            display: inline-block;
            vertical-align: middle;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
            content: "\2713"; /* Agrega un símbolo de check si quieres */
        }
        #prescriptor_table tbody tr:hover { 
            cursor: pointer; /* 🔹 Muestra el cursor como puntero */
        }
        #prescriptor_table tbody tr:hover td {
            background-color: #b0e8fd !important; /* 🔹 Cambia el color al pasar el mouse */
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
                        <li class="breadcrumb-item" aria-current="page">Interesados</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <!-- Header profesional -->
            <div class="page-header-custom">
                <div class="d-flex align-items-center gap-3">
                    <h2 class="mb-0"><i class='bx bx-user-check me-2'></i>Gestión de Interesados</h2>
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#ayuda-modal" title="Ver información de ayuda">
                        <i class="bx bx-help-circle"></i>
                    </button>
                </div>
                <p>Administra y consulta la información de personas interesadas en los programas educativos</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 d-flex justify-content-end">
                        <div class="col-12" id="divDtInteresados">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive order-mobile-first">
                                    <?php
                                   
                                    $nombreTabla = "prescriptor_table";
                                    $nombreCampos = ["ID", "NICKNAME", "NOMBRE", "IDENTIFICADOR", "CORREO", "CONTACTO", "NACIMIENTO"];
                                    $nombreCamposFooter = ["ID","<input type='text' class='form-control' id='FootNick' name='FootNick' placeholder='Buscar Nickname'>",
                                    "<input type='text' class='form-control' id='FootNombre' name='FootNombre' placeholder='Buscar Nombre'>", 
                                    "<input type='text' class='form-control' id='FootIdent' name='FootIdent' placeholder='Buscar Identificador'>", 
                                    "<input type='text' class='form-control' id='FootCorreo' name='FootCorreo' placeholder='Buscar Correo'>", 
                                    "<input type='text' class='form-control' id='FootContacto' name='FootContacto' placeholder='Buscar Contacto'>", 
                                    "<input type='text' class='form-control' id='FootFecha' name='FootFecha' placeholder='Buscar Nacimiento'>"
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
            
            <div class="col-12 card mt-3 d-none" id="cardForm">
                <input type="hidden" id="prescriptorID" value="">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card card-hover">
                                <div class="card-body  datos-generales p-4">
                                    <h5 class="mb-4"><i class="bi bi-file-person"></i> Datos Generales</h5>
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="input13" class="form-label">Nombre <b class="tx-danger">*</b></label>
                                            <div class="position-relative input-icon">
                                                <input type="text" class="form-control" id="nombreCliente" placeholder="Nombre" data-type="0" data-min="1" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="input13" class="form-label">Apellidos  <b class="tx-danger">*</b></label>
                                            <div class="position-relative input-icon">
                                                <input type="text" class="form-control" id="apellidoCliente" placeholder="Apellidos" data-type="0" data-min="1" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="input13" class="form-label">Nacionalidad / Idioma</label>
                                            <div class="position-relative input-icon">
                                                <select class="select2 " id="nacionalidadCliente" >
                                                    <option value="">Nacionalidad</option>
                                                     
                                                    <!-- España y vecinos -->
                                                    <optgroup label="España y países cercanos">
                                                        <option value="Español">Español</option>
                                                        <option value="Francés">Francés</option>
                                                        <option value="Italiano">Italiano</option>
                                                        <option value="Portugués">Portugués</option>
                                                        <option value="Andorrano">Andorrano</option>
                                                        <option value="Monegasco">Monegasco</option>
                                                        <option value="Suizo">Suizo</option>
                                                        <option value="Belga">Belga</option>
                                                        <option value="Neerlandés">Neerlandés</option>
                                                        <option value="Alemán">Alemán</option>
                                                        <option value="Británico">Británico</option>
                                                    </optgroup>

                                                    <!-- Europa -->
                                                    <optgroup label="Europa">
                                                        <option value="Albanés">Albanés</option>
                                                        <option value="Austriaco">Austriaco</option>
                                                        <option value="Bielorruso">Bielorruso</option>
                                                        <option value="Búlgaro">Búlgaro</option>
                                                        <option value="Checo">Checo</option>
                                                        <option value="Chipriota">Chipriota</option>
                                                        <option value="Croata">Croata</option>
                                                        <option value="Danés">Danés</option>
                                                        <option value="Eslovaco">Eslovaco</option>
                                                        <option value="Esloveno">Esloveno</option>
                                                        <option value="Estonio">Estonio</option>
                                                        <option value="Finlandés">Finlandés</option>
                                                        <option value="Griego">Griego</option>
                                                        <option value="Húngaro">Húngaro</option>
                                                        <option value="Irlandés">Irlandés</option>
                                                        <option value="Islandés">Islandés</option>
                                                        <option value="Letón">Letón</option>
                                                        <option value="Lituano">Lituano</option>
                                                        <option value="Luxemburgués">Luxemburgués</option>
                                                        <option value="Maltés">Maltés</option>
                                                        <option value="Noruego">Noruego</option>
                                                        <option value="Polaco">Polaco</option>
                                                        <option value="Rumano">Rumano</option>
                                                        <option value="Ruso">Ruso</option>
                                                        <option value="Sueco">Sueco</option>
                                                        <option value="Turco">Turco</option>
                                                        <option value="Ucraniano">Ucraniano</option>
                                                        <option value="Serbio">Serbio</option>
                                                        <option value="Bosnio">Bosnio</option>
                                                        <option value="Montenegrino">Montenegrino</option>
                                                        <option value="Macedonio">Macedonio</option>
                                                        <option value="Kosovar">Kosovar</option>
                                                        <option value="Georgiano">Georgiano</option>
                                                        <option value="Armenio">Armenio</option>
                                                    </optgroup>

                                                    <!-- América -->
                                                    <optgroup label="América del Norte">
                                                        <option value="Estadounidense">Estadounidense</option>
                                                        <option value="Canadiense">Canadiense</option>
                                                        <option value="Mexicano">Mexicano</option>
                                                    </optgroup>

                                                    <optgroup label="Centroamérica y Caribe">
                                                        <option value="Guatemalteco">Guatemalteco</option>
                                                        <option value="Beliceño">Beliceño</option>
                                                        <option value="Hondureño">Hondureño</option>
                                                        <option value="Salvadoreño">Salvadoreño</option>
                                                        <option value="Nicaragüense">Nicaragüense</option>
                                                        <option value="Costarricense">Costarricense</option>
                                                        <option value="Panameño">Panameño</option>
                                                        <option value="Cubano">Cubano</option>
                                                        <option value="Dominicano">Dominicano</option>
                                                        <option value="Haitiano">Haitiano</option>
                                                        <option value="Puertorriqueño">Puertorriqueño</option>
                                                        <option value="Jamaicano">Jamaicano</option>
                                                        <option value="Trinitense">Trinitense</option>
                                                        <option value="Bahamés">Bahamés</option>
                                                        <option value="Barbadense">Barbadense</option>
                                                    </optgroup>

                                                    <optgroup label="América del Sur">
                                                        <option value="Argentino">Argentino</option>
                                                        <option value="Boliviano">Boliviano</option>
                                                        <option value="Brasileño">Brasileño</option>
                                                        <option value="Chileno">Chileno</option>
                                                        <option value="Colombiano">Colombiano</option>
                                                        <option value="Ecuatoriano">Ecuatoriano</option>
                                                        <option value="Paraguayo">Paraguayo</option>
                                                        <option value="Peruano">Peruano</option>
                                                        <option value="Uruguayo">Uruguayo</option>
                                                        <option value="Venezolano">Venezolano</option>
                                                        <option value="Surinamés">Surinamés</option>
                                                        <option value="Guyanés">Guyanés</option>
                                                    </optgroup>

                                                    <!-- África -->
                                                    <optgroup label="África">
                                                        <option value="Marroquí">Marroquí</option>
                                                        <option value="Argelino">Argelino</option>
                                                        <option value="Tunecino">Tunecino</option>
                                                        <option value="Libio">Libio</option>
                                                        <option value="Egipcio">Egipcio</option>
                                                        <option value="Mauritano">Mauritano</option>
                                                        <option value="Senegalés">Senegalés</option>
                                                        <option value="Maliano">Maliano</option>
                                                        <option value="Nigerino">Nigerino</option>
                                                        <option value="Nigeriano">Nigeriano</option>
                                                        <option value="Chadiano">Chadiano</option>
                                                        <option value="Camerunés">Camerunés</option>
                                                        <option value="Ghanés">Ghanés</option>
                                                        <option value="Marfileño">Marfileño</option>
                                                        <option value="Congoleño">Congoleño</option>
                                                        <option value="Sudafricano">Sudafricano</option>
                                                        <option value="Etíope">Etíope</option>
                                                        <option value="Somalí">Somalí</option>
                                                        <option value="Keniano">Keniano</option>
                                                        <option value="Tanzano">Tanzano</option>
                                                        <option value="Ugandés">Ugandés</option>
                                                        <option value="Ruandés">Ruandés</option>
                                                        <option value="Burundés">Burundés</option>
                                                        <option value="Zambiano">Zambiano</option>
                                                        <option value="Zimbabuense">Zimbabuense</option>
                                                        <option value="Botsuano">Botsuano</option>
                                                        <option value="Namibio">Namibio</option>
                                                        <option value="Mozambiqueño">Mozambiqueño</option>
                                                        <option value="Angoleño">Angoleño</option>
                                                        <option value="Madagascarense">Madagascarense</option>
                                                    </optgroup>

                                                    <!-- Asia -->
                                                    <optgroup label="Asia">
                                                        <option value="Chino">Chino</option>
                                                        <option value="Japonés">Japonés</option>
                                                        <option value="Coreano">Coreano</option>
                                                        <option value="Indio">Indio</option>
                                                        <option value="Pakistaní">Pakistaní</option>
                                                        <option value="Bangladesí">Bangladesí</option>
                                                        <option value="Nepalí">Nepalí</option>
                                                        <option value="Butanés">Butanés</option>
                                                        <option value="Sri lankés">Sri lankés</option>
                                                        <option value="Maldivo">Maldivo</option>
                                                        <option value="Tailandés">Tailandés</option>
                                                        <option value="Camboyano">Camboyano</option>
                                                        <option value="Vietnamita">Vietnamita</option>
                                                        <option value="Laosiano">Laosiano</option>
                                                        <option value="Birmano">Birmano</option>
                                                        <option value="Malayo">Malayo</option>
                                                        <option value="Singapurense">Singapurense</option>
                                                        <option value="Indonesio">Indonesio</option>
                                                        <option value="Filipino">Filipino</option>
                                                        <option value="Mongol">Mongol</option>
                                                        <option value="Kazajo">Kazajo</option>
                                                        <option value="Uzbeco">Uzbeco</option>
                                                        <option value="Tayiko">Tayiko</option>
                                                        <option value="Kirguís">Kirguís</option>
                                                        <option value="Turcomano">Turcomano</option>
                                                        <option value="Iraní">Iraní</option>
                                                        <option value="Iraquí">Iraquí</option>
                                                        <option value="Sirio">Sirio</option>
                                                        <option value="Libanés">Libanés</option>
                                                        <option value="Jordano">Jordano</option>
                                                        <option value="Israelí">Israelí</option>
                                                        <option value="Palestino">Palestino</option>
                                                        <option value="Saudí">Saudí</option>
                                                        <option value="Emiratí">Emiratí</option>
                                                        <option value="Kuwaití">Kuwaití</option>
                                                        <option value="Qatarí">Qatarí</option>
                                                        <option value="Omaní">Omaní</option>
                                                        <option value="Yemení">Yemení</option>
                                                    </optgroup>

                                                    <!-- Oceanía -->
                                                    <optgroup label="Oceanía">
                                                        <option value="Australiano">Australiano</option>
                                                        <option value="Neozelandés">Neozelandés</option>
                                                        <option value="Fiyiano">Fiyiano</option>
                                                        <option value="Samoano">Samoano</option>
                                                        <option value="Tongano">Tongano</option>
                                                        <option value="Papú">Papú</option>
                                                        <option value="Salomonense">Salomonense</option>
                                                        <option value="Vanuatuense">Vanuatuense</option>
                                                    </optgroup>



                                                </select>
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-globe2"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="input2" class="form-label">Genero</label>
                                            <input type="text" class="form-control" id="sexoCliente" placeholder="F/M/O/N" data-type="9" data-min="1" data-max="1" data-new-input="1" data-descripcion="0" data-required="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="input6" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control fechaSinHorapick" id="fechCliente" placeholder="01/01/2001" >
                                        </div>

                                        <div class="col-md-3">
                                            <label for="input145" class="form-label">Tipo de Documento</label>
                                            <div class="input-group " style="width:100%">
                                                <select class="select2 " data-placeholder="SELECCIONA TIPO DE DOCUMENTO" id="tipoDocumento">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="input13" class="form-label">Identificador  <b class="tx-danger">*</b></label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input type="text" class="form-control" id="identificador" placeholder="Escriba el identificador" data-type="3" data-min="1" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                                                
                                                
                                                <button class="btn btn-sm btn-info tx-white ms-2" title="Generar uno aleatorio" id="generateRandom" onclick="generarIdentificador()" type="button">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="input3" class="form-label">Nombre Completo </label><small class="tx-8"> SE AUTOCOMPLETA</small>
                                            <input type="text" class="form-control" id="completoCliente" placeholder="Nombre Apellidos" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input145" class="form-label">Departamento  <b class="tx-danger">*</b></label>
                                            <div class="input-group">
                                                <select class="select2 " data-placeholder="SELECCIONA DEPARTAMENTO" id="departamentoSelect">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 infoPadres d-none">
                                            <label for="input3" class="form-label">Nombre Madre </label>
                                            <input type="text" class="form-control bg-info-subtle" id="nombreMadre" placeholder="Nombre y Apellidos de la madre">
                                        </div>

                                        <div class="col-md-6 infoPadres d-none">
                                            <label for="input4" class="form-label">Nombre Padre </label>
                                            <input type="text" class="form-control  bg-info-subtle" id="nombrePadre" placeholder="Nombre y Apellidos del padre">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if ($configJsonSetting['MntPrescriptores_Edu']['divEstudiante'] == 1) { ?>
                                <div class="card-hover  card">
                                    <div class="card-body  datos-estudiante p-4">
                                        <h5 class="mb-4"><i class="bi bi-person-vcard"></i> Datos Estudiante</h5>
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label for="fechaPrevista" class="form-label">Año Previsto</label>
                                                <div class="position-relative input-icon">
                                                    <input type="number" class="form-control" value="<?php echo date('Y'); ?>" id="fechaPrevista" placeholder="2026" data-type="10" data-min="4" data-max="4" data-new-input="1" data-conteo="0" data-descripcion="0" data-required="0">
                                    
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check-fill"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="fech1Contacto" class="form-label">Fecha 1er Contacto</label>
                                                <div class="position-relative input-icon">
                                                    <input type="date" step="1" class="form-control" id="fech1Contacto" placeholder="01/01/2001" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="0" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check-fill"></i></span>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                                <label for="input13" class="form-label">Curso Deseado</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-journal-bookmark-fill"></i></span>
                                    
                                                    <input type="text" class="docenciaInput form-control tx-left-force" id="cursoDeseado" value="">
                                                    <div class="suggestions-list"></div>
                                    
                                                    <input type="hidden" id="cursoDeseado" value="">
                                                    <!--  <select class="select2 " data-placeholder="SELECCIONAR TIPO CURSO"  id="cursoDeseado">
                                                    <option></option> 
                                                    </select>  -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input13" class="form-label">¿Como nos ha conocido? Opción 1</label>
                                                <div class="input-group">
                                                    <select class="select2 " data-placeholder="SELECCIONAR CONOCIMIENTO 1" id="conocimiento1">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input13" class="form-label">¿Como nos ha conocido? Opción 2</label>
                                                <div class="input-group">
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CONOCIMIENTO 2" id="conocimiento2">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input13" class="form-label">¿Como nos ha conocido? Opción 3</label>
                                                <div class="input-group">
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONAR CONOCIMIENTO 3" id="conocimiento3">
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                                <label for="input13" class="form-label">¿Es probable que "como nos ha conocido" sea correcto?</label>
                                              
                                                <div class="position-relative input-icon">
                                                    <select class="form-select" id="probablemente">
                                                        <option value="1" selected>Sí</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <!-- <span class="position-absolute top-50 translate-middle-y"></span> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $campoGrupo; ?>">
                                                <label for="input13" class="form-label">Grupo de Amigos y Familia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                                    
                                                    <input type="text" class=" form-control tx-left-force" id="grupoCliente" placeholder="Nombre del grupo">
                                                    <div class="suggestions-list"></div>
                                    
                                                    <input type="hidden" id="cursoDeseado" value="">
                                                    <!--  <select class="select2 " data-placeholder="SELECCIONAR TIPO CURSO"  id="cursoDeseado">
                                                    <option></option> 
                                    
                                                    </select>                                                          -->
                                                </div>
                                    
                                            </div>
                                    
                                    
                                            <div class="col-md-6 <?php echo $campoBildungsurlaub; ?>">
                                                <label for="input13" class="form-label">Bildungsurlaub</label>
                                                <div class="input-group">
                                                    <select class="select2 js-example-responsive" data-placeholder="SELECCIONE BILDUNGSURLAUB" id="Bildungsurlaub">
                                                        <option value="">Seleccione una opción</option>
                                    
                                                    </select>
                                                </div>
                                            </div>
                                    
                                    
                                            <div class="col-md-6 <?php echo $campoAuPair; ?>">
                                                <label for="input13" class="form-label">Au Pair</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                                    <select class="form-select" id="aupair">
                                                        <option value="1">Sí</option>
                                                        <option value="2" selected>No</option>
                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex form-label justify-content-between  align-items-center">
                                                <div class="col-8">
                                                    <label for="input13" class="form-label">¿Está interesado en curso Híbrido?</label>
                                                </div>
                                                <div class="position-relative input-icon col-4 d-flex justify-content-end">
                                                    <div class="check-online">
                                                        <input class="yep" id="check-online" type="checkbox">
                                                        <label for="check-online"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $campoAuPair; ?>">
                                                <label for="input13" class="form-label">Preferencia Horaria</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                    <select class="form-select" id="preferenciaHoraria">
                                                        <option value="0" selected>Sin preferencia</option>
                                                        <option value="1">Mañanas</option>
                                                        <option value="2" >Tardes</option>

                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($configJsonSetting['MntPrescriptores_Edu']['divMatriculacion'] == 1) { ?>
                                <!--  <div class="card-body card p-4">
                                            <h5 class="mb-4"><i class=" bi bi-clipboard2-check"></i> Datos Matriculación</h5>
                                            <form class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="input13" class="form-label">Fecha Matricula Confirmada</label>
                                                    <div class="position-relative input-icon">
                                                        <input type="date" class="form-control" id="fechaConfirmacion" placeholder="01/01/2024" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1"></input>
                                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check-fill"></i></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="input13" class="form-label">Matriculado: Curso</label>
                                                    <input type="text" class="form-control"   id="matCurso" placeholder="igl+cp5" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="0" data-required="1">
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <label for="input13" class="form-label">Matriculado: Alojamiento</label>
                                                    <input type="text" class="form-control"  id="matAlojamiento" placeholder="Alojamiento" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="0" data-required="0">
                                                
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="input13" class="form-label">Matriculado: Fecha Inicio</label>
                                                    <div class="position-relative input-icon">
                                                        <input type="date" class="form-control" id="matFechInicio" placeholder="01/01/2024" data-type="3" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1"></input>
                                                        <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check-fill"></i></span>
                                                    </div>
                                                </div>
                                            
                                                
                                            </form>
                                        </div> -->
                            <?php } ?>

                        </div>

                        <div class="col-lg-6">
                            <?php if ($configJsonSetting['MntPrescriptores_Edu']['divContacto'] == 1) { ?>
                                <div class="card card-hover">
                                    <div class="card-body  datos-contacto  p-4">
                                        <h5 class="mb-4"><i class="bi bi-journal-bookmark"></i> Datos de Contacto</h5>
                                        <form class="row g-3">


                                            <div class="col-md-6">
                                                <label for="input15" class="form-label">Móvil Casa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="movilCasa"  tabindex="1" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-phone"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoContacto; ?>">
                                                <label for="input15" class="form-label">Móvil Alternativo</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="movilAlt"  tabindex="5" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-phone"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input15" class="form-label">Teléfono Casa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="tefCasa"  tabindex="2" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoContacto; ?>">
                                                <label for="input15" class="form-label">Teléfono Alternativo</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="tefAlt"  tabindex="6" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input16" class="form-label">E-mail Principal</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="emailCasa"  tabindex="3" placeholder="mail@domain.es" data-type="1" data-min="3" data-max="150" data-new-input="1" data-descripcion="1" data-required="1">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-envelope-fill"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoContacto; ?>">
                                                <label for="input16" class="form-label">E-mail Alternativo</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="emailAlt"  tabindex="7" placeholder="mail@domain.es" data-type="1" data-min="3" data-max="150" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-envelope-fill"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none infoPadres">
                                                <label for="input15" class="form-label ">Número Padre</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control bg-info-subtle"  tabindex="4" id="tefPadre" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  d-none infoPadres">
                                                <label for="input15" class="form-label">Número Madre</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control bg-info-subtle"  tabindex="8" id="tefMadre" placeholder="+34 612 345 678 o 612345678" data-type="12" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                                </div>
                                            </div>

                                    </div>
                                    </form>
                                </div>
                            <?php } ?>
                            <?php if ($configJsonSetting['MntPrescriptores_Edu']['divUbicacion'] == 1) { ?>

                                <div class="card card-hover">

                                    <div class="card-body ubicacion p-4">
                                        <h5 class="mb-4"><i class="bi bi-pin-map"></i> Ubicación</h5>
                                        <form class="row g-3">

                                            <div class="col-md-6">
                                                <label for="input15" class="form-label">Dirección Completa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" id="ciudadCasa"  tabindex="9" placeholder="C/ Vinatea San Ramon º1" data-type="13" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt-fill"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoUbicacion; ?>">
                                                <label for="input15"  class="form-label">Dirección Alternativa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text"  tabindex="12"  class="form-control" id="ciudadAlt" placeholder="C/ Vinatea San Ramon º5" data-type="13" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt-fill"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input15" class="form-label">C.P Casa / Ciudad</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text"  tabindex="10" class="form-control" id="cpCasa" placeholder="(Ej. 90210, 90210-1234, K1A 0B1, SW1A 1AA, C1000ABC)" data-type="13" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-house"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoUbicacion; ?>">
                                                <label for="input15" class="form-label">C.P Alternativa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text"   tabindex="13" class="form-control" id="cpAlt" placeholder="(Ej. 90210, 90210-1234, K1A 0B1, SW1A 1AA, C1000ABC)" data-type="14" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-house"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input15" class="form-label">País Casa</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text" class="form-control" tabindex="11" id="paisCasa" placeholder="España" data-type="0" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-globe"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?php echo $alternativoUbicacion; ?>">
                                                <label for="input15" class="form-label">País Alternativo</label>
                                                <div class="position-relative input-icon">
                                                    <input type="text"  tabindex="14"  class="form-control" id="paisAlt" placeholder="España" data-type="0" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-globe"></i></span>
                                                </div>
                                            </div>

                                    </div>
                                    </form>
                                </div>
                            <?php } ?>

                            <?php if ($configJsonSetting['MntPrescriptores_Edu']['divObservacion'] == 1) { ?>

                                <div class="card card-hover">

                                    <div class="card-body  observacion p-4">
                                        <h5 class="mb-4"><i class="bi bi-chat-left-text"></i> Observación</h5>
                                        <form class="row g-3">
                                            <div class="col-md-12">
                                                <textarea class="form-control" tabindex="15" id="textTipo" name="textTipo" data-type="3" data-min="0" data-max="600" data-new-input="1" data-descripcion="0" data-required="0" oninput="validateTextarea(this)"></textarea>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                            <?php } ?>






                        </div>

                    </div>

                </div>


            </div><!--end row-->





        </div>
        </div>

    </main>



    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <aside class="customizer botonFlotante2">
        <a href="javascript:void(0)" id="newClient" class="service-panel-toggle colorBoton5 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-plus"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante4 d-none " >
        <a href="javascript:void(0)" id="btnGestion" data-bs-toggle="modal" data-bs-target="#gestion-modal"  data-placement="top" title="Gestionar Interesado" class="service-panel-toggle colorBoton6  tx-20" style="opacity: 0.75">
            <i class="fa-regular fa-address-card"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante4-1  d-none" >
        <a href="javascript:void(0)" id="btnPreforma" title="Ir a llegadas" class="service-panel-toggle colorBoton2 tx-20" style="opacity: 0.75">
        <i class="fa-solid fa-plane-arrival"></i>
        </a>
    </aside>
  

    <aside class="customizer botonFlotante5-1 d-none ">
        <a href="javascript:void(0)" id="aceptClient" title="Aceptar" class="service-panel-toggle colorBoton5 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-check"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante5-1 d-none ">
        <a href="javascript:void(0)" id="updateClient" title="Actualizar" class="service-panel-toggle colorBoton5 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-check"></i>
        </a>
    </aside>
    <aside class="customizer botonFlotante5 d-none ">
        <a href="javascript:void(0)" id="cancelClient" class="service-panel-toggle colorBoton4 tx-20" style="opacity: 0.75">
            <i class="fa-solid fa-circle-xmark"></i>
        </a>
    </aside>
   



    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalClientes.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>
    <?php include_once 'modalTarifas.php' ?>
    <?php include_once 'modalInfo.php' ?>
    <?php include_once 'modalGestion.php' ?>

    <!-- Modal de Ayuda -->
    <div id="ayuda-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info bg-gradient text-white py-3">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <i class="bx bx-help-circle"></i> Información de Ayuda
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 mb-4">
                        <i class="bx bx-info-circle me-2"></i>
                        <strong>Guía de uso - Gestión de Interesados</strong>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-mouse text-primary me-2"></i>Acciones principales:</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2">
                                <i class="bx bx-chevron-right text-success me-1"></i>
                                <strong>Haga click en cualquier registro para editar</strong>
                            </li>
                            <li class="mb-2">
                                <i class="bx bx-chevron-right text-success me-1"></i>
                                <strong>Use el botón lateral</strong> <span class="badge bg-secondary"><i class="bx bx-plus"></i></span> para añadir un nuevo interesado
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3"><i class="bx bx-id-card text-warning me-2"></i>Identificación única:</h6>
                        <div class="alert alert-warning border-0">
                            <i class="bx bx-error me-2"></i>
                            Los interesados se diferencian por <strong>Identificador</strong> (DNI, NIF, NIE,...).<br>
                            <strong>No pueden haber 2 interesados con el mismo Identificador</strong>
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-semibold mb-3"><i class="bx bx-text text-info me-2"></i>Límites de caracteres:</h6>
                        <p class="text-muted mb-2">Hay apartados limitados por cantidad de caracteres para evitar entradas excesivas. Ejemplos:</p>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-1"><i class="bx bx-check-circle text-success me-1"></i><strong>Nombre:</strong> Máximo de caracteres</li>
                            <li class="mb-1"><i class="bx bx-check-circle text-success me-1"></i><strong>Apellidos:</strong> Máximo de caracteres</li>
                            <li class="mb-1"><i class="bx bx-check-circle text-success me-1"></i>Y otros campos del formulario</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Selecciona todos los inputs dentro de las cards
            const inputs = document.querySelectorAll(".card-body input, .card-body select");

            inputs.forEach(input => {
                input.addEventListener("mouseenter", function() {
                    // Añade la clase active al card correspondiente cuando el ratón entra en un input
                    const cardBody = input.closest(".card-body");
                    if (cardBody) {
                        cardBody.classList.add("active");
                    }
                });

                input.addEventListener("mouseleave", function() {
                    // Elimina la clase active cuando el ratón sale del input
                    const cardBody = input.closest(".card-body");
                    if (cardBody) {
                        cardBody.classList.remove("active");
                    }
                });
            });
        });
    </script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
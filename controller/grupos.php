<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Grupos.php");


session_start();
require_once("../models/Log.php");

$grupos = new Grupos();




switch ($_GET["op"]) {

    
    case "mostrarGruposGeneral":
           
                 
            $idioma = $_POST['idioma'];
            $curso = $_POST['curso'];

            $datos = $grupos->listarGruposGeneral($idioma,$curso);
         
            $data = array();



            foreach ($datos as $row) {
                $sub_array = array();

                // CALCULO FECHA PROXIMA //
                // CALCULO FECHA PROXIMA //
                $fechaInicio = $row["ultima_fecha"];  // Formato: Y-m-d (ej: 2025-03-26)
                $perRefresco_ruta = $row["perRefresco_ruta"];
                $medidaRefresco_ruta = $row["medidaRefresco_ruta"];  // Formato: "2 2" (2 semanas)
                $fechaResultado = '';
                $informacionTxt = '';
                if ($medidaRefresco_ruta == 0) {
                    // Si no hay unidad especificada, no se realiza el cálculo
                    $fechaResultado = 'Sin salto automático';
                    
                } else {
                    // Crear un objeto DateTime a partir de la fecha de inicio
                    $fecha = new DateTime($fechaInicio);
                
                    // Dependiendo de la medida, sumamos el período correspondiente
                    switch ($medidaRefresco_ruta) {
                        case 1: // Días
                            $fecha->modify("+$perRefresco_ruta days");
                            break;
                        case 2: // Semanas
                            $fecha->modify("+$perRefresco_ruta weeks");
                            break;
                        case 3: // Meses
                            $fecha->modify("+$perRefresco_ruta months");
                            break;
                        default:
                            $fechaResultado = 'Unidad no válida';
                            break;
                    }
                    
                    // Formatear el resultado en Y-m-d
                    if ($fechaResultado !== 'Unidad no válida') {
                        $fechaResultado = $fecha->format('Y-m-d');
                    }
                    $informacionTxt = '<label style="color: lightgray;"><i>'. $row["perRefresco_ruta"] .' ' . $row["descrRefresco"] .'</i></label>';
                }
                


                $sub_array[] = $row["idGrupo"];
                $sub_array[] = '<span class="badge bg-danger-subtle text-danger border border-danger">'. $row["codIdioma"] .' '.  $row["descrIdioma"] .'</span>
                <span class="badge bg-info-subtle text-info border border-info">'. $row["codTipo"] .' '.  $row["descrTipo"] .'</span>
                <span class="badge bg-warning-subtle text-warning border border-warning">'. $row["codNivel"] .' '.  $row["descrNivel"] .'</span>';
                $clase_bg = 'bg-success'; // Por defecto, verde (success)

                if ($row["total_alumnos"] > $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-danger'; // Rojo si supera el máximo
                } elseif ($row["total_alumnos"] == $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-warning'; // Amarillo si es igual
                }
                $sub_array[] = $row["codIdioma"] .  $row["codTipo"] . $row["codNivel"];
                $sub_array[] = fechaLocal($row["ultima_fecha"]);
                
                // AQUÍ SE PROVOCABA UN ERROR: 
                // EL ERROR OCURRÍA PORQUE HABÍAN VECES QUE (fechaResultado) era un texto y no una fecha, por lo que
                // al resetear la fecha, daba error, ya que lo que se le pasaba no era una fecha
                // PARA SOLUCIONARLO, SE COMPRUEBA QUE LA FECHA QUE SE INTENTA FORMATEAR TIENE EL FORMATO CORRECTO.
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaResultado)) {
                    $fechaLocalizada = fechaLocal($fechaResultado);
                } else {
                    $fechaLocalizada = $fechaResultado; // Ya es un texto tipo "Sin salto automático"
                }
                $sub_array[] = '<label class="tx-danger tx-bold">'. $fechaLocalizada .'</label><br>'. $informacionTxt;


                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge '. $clase_bg .'">'. $row["total_alumnos"] .'</span></button>';
                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge bg-success">'. $row["minAlum_ruta"] .'</span> - <span class="badge bg-danger">'. $row["maxAlum_ruta"] .'</span> </button>';
                $sub_array[] = $row["idGrupo"];

                $sub_array[] = $row["codGrupo"];
                $sub_array[] = '<button title="Grupo Alumnos" class="btn btn-info waves-effect" 
                onClick="cargarModalAlumnos(\''.addslashes($row["codGrupo"]).'\')">
                <i class="fa-solid fa-users"></i></button>';

                $sub_array[] = $row["id_ruta"];
                $sub_array[] = $row["codIdioma"];
                $sub_array[] = $row["codTipo"];
                $sub_array[] = $row["idiomaId_ruta"];
                $sub_array[] = $row["tipoId_ruta"];
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);


    break;
    case "mostrarAlumnosNuevos":
        $idDepartamento = $_GET['idDepartamento']; 
        $fechaInicio = $_GET['fechaInicio']; 
        $fechaFin = $_GET['fechaFin']; 

        $datos = $grupos->listarAlumnosNuevos($idDepartamento, $fechaInicio, $fechaFin);

        $data = array();



        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["id_llegada"];
            $sub_array[] = $row["nomPrescripcion"] . ' ' . $row["apePrescripcion"];
            $sub_array[] = $row["grupoAmigos"] == '' ? "Sin Grupo" : $row["grupoAmigos"];

            if (empty($row["nivelasignado_llegadas"])) {
                $sub_array[] = '<a href="../../view/Llegadas/?tokenPreinscripcion='.$row["tokenPrescriptores"].'" target="_blank" class=""><span class="badge bg-danger tx-14-force">Seleccione un nivel</span></a>';

            } else {
                $sub_array[] = $row["codIdioma"] .  $row["codTipo"] .  $row["codNivel"];
                              }
            $sub_array[] = fechaLocal($row["fechaInicioMatriculacion"]);

           
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);


        break;
    case "listarAulas":
    
    
        $datos = $grupos->listarAulas();
        
        
        $data = array();

    
        foreach ($datos as $row) {
            $sub_array = array();
            $checkboxes = '';
            $sub_array[] = $row["idAula"];
            $sub_array[] = '<p class="tx-break tx-bold">' . strtoupper($row["nombreAula"]) . '</p>';
            $sub_array[] = '<p class="tx-break tx-bold">' . strtoupper($row["localizacionAula"]) . '</p>';
            $sub_array[] = '<p class="">' . $row["capacidadAula"] . ' Alumnos</p>';
            if ($row["hibridoAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-danger"> Híbrido </label>';
            }
            
            if ($row["kidsAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-success"> Kids </label>';
            }
            
            if ($row["paraliticosAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-warning"> Paralíticos </label>';
            }
            
            if ($row["agoraAula"] == 1) {
                $checkboxes .= '<label class="form-check form-check-inline tx-info"> Agorafobia </label>';
            }
            $sub_array[] = $checkboxes; // Se almacena todo en una sola columna


            $sub_array[] = '<p class="">' . $row["observacionesAula"] . '</p>';

          
            
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);


        break;
    case "mostrarAlumnoXId":
        $idAlumno = $_GET['idAlumno']; // PARA RECOGER LA RUTA

        $datos = $grupos->mostrarAlumnoXId($idAlumno);
        echo json_encode($datos);

    break;
    
    case "recogerGrupoAmigos":
        $nombreGrupo = $_GET['nombreGrupo']; // PARA RECOGER LA RUTA
        $depaSelect = $_GET['depaSelect']; // PARA RECOGER LA RUTA

        $datos = $grupos->recogerGrupoAmigos($nombreGrupo,$depaSelect);
       
        echo json_encode($datos);

    break;
    case "recogerAlumnosCurso":
        $codSeleccionado = $_POST['codSeleccionado']; // PARA RECOGER LA RUTA

        $datos = $grupos->recogerAlumnosCurso($codSeleccionado);
    
        echo json_encode($datos);

    break;
    case "mostrarGrupos":

        $idAlumno = $_GET['idAlumno']; // PARA RECOGER LA RUTA

        $datos = $grupos->listarGruposXRuta($idAlumno);

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
                // CALCULO FECHA PROXIMA //
                // CALCULO FECHA PROXIMA //
                $fechaInicio = $row["ultima_fecha"];  // Formato: Y-m-d (ej: 2025-03-26)
                $perRefresco_ruta = $row["perRefresco_ruta"];
                $medidaRefresco_ruta = $row["medidaRefresco_ruta"];  // Formato: "2 2" (2 semanas)
                $fechaResultado = '';
                $informacionTxt = '';
                if ($medidaRefresco_ruta == 0) {
                    // Si no hay unidad especificada, no se realiza el cálculo
                    $fechaResultado = 'Sin salto automático';
                    
                } else {
                    // Crear un objeto DateTime a partir de la fecha de inicio
                    $fecha = new DateTime($fechaInicio);
                
                    // Dependiendo de la medida, sumamos el período correspondiente
                    switch ($medidaRefresco_ruta) {
                        case 1: // Días
                            $fecha->modify("+$perRefresco_ruta days");
                            break;
                        case 2: // Semanas
                            $fecha->modify("+$perRefresco_ruta weeks");
                            break;
                        case 3: // Meses
                            $fecha->modify("+$perRefresco_ruta months");
                            break;
                        default:
                            $fechaResultado = 'Unidad no válida';
                            break;
                    }
                    
                    // Formatear el resultado en Y-m-d
                    if ($fechaResultado !== 'Unidad no válida') {
                        $fechaResultado = $fecha->format('Y-m-d');
                    }
                    $informacionTxt = '<label style="color: lightgray;"><i>'. $row["perRefresco_ruta"] .' ' . $row["descrRefresco"] .'</i></label>';
                }
            $sub_array[] = $row["idRuta_cursos"];
            $sub_array[] = '<span class="badge bg-danger-subtle text-danger border border-danger">'. $row["codIdioma"] .' '.  $row["descrIdioma"] .'</span>
            <span class="badge bg-info-subtle text-info border border-info">'. $row["codTipo"] .' '.  $row["descrTipo"] .'</span>
            <span class="badge bg-warning-subtle text-warning border border-warning">'. $row["codNivel"] .' '.  $row["descrNivel"] .'</span>';
            $clase_bg = 'bg-success'; // Por defecto, verde (success)

            if ($row["total_alumnos"] > $row["maxAlum_ruta"]) {
                $clase_bg = 'bg-danger'; // Rojo si supera el máximo
            } elseif ($row["total_alumnos"] == $row["maxAlum_ruta"]) {
                $clase_bg = 'bg-warning'; // Amarillo si es igual
            }
            $sub_array[] = $row["codIdioma"] .  $row["codTipo"] . $row["codNivel"];

            $ultima_fecha = new DateTime($row["ultima_fecha"]);
            $meses = [
                'Jan' => 'Ene', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Abr',
                'May' => 'May', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago',
                'Sep' => 'Sep', 'Oct' => 'Oct', 'Nov' => 'Nov', 'Dec' => 'Dic'
            ];

           // Obtener el día y el mes en inglés de "ultima_fecha"
            $dia = $ultima_fecha->format("d");
            $mes_abrev = $ultima_fecha->format("M"); // Mes en inglés
            $sub_array[] = $dia . ' ' . $meses[$mes_abrev]; // Ejemplo: "15 Feb"

            // Formatear fechaResultado
            $fechaResultado = new DateTime($fechaResultado); // Asumimos que fechaResultado también es una fecha
            $diaResultado = $fechaResultado->format("d");
            $mes_abrevResultado = $fechaResultado->format("M"); // Mes en inglés de fechaResultado
            $sub_array[] = '<label class="tx-danger tx-bold">' . $diaResultado . ' ' . $meses[$mes_abrevResultado] . '</label><br>' . $informacionTxt;

            $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge '. $clase_bg .'">'. $row["total_alumnos"] .'</span></button>';
            $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge bg-success">'. $row["minAlum_ruta"] .'</span> - <span class="badge bg-danger">'. $row["maxAlum_ruta"] .'</span> </button>';

            $sub_array[] = $row["idGrupo"];
            $sub_array[] = $row["codGrupo"];

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        $json_string = json_encode($results);
        $file = 'A1a1.json';
        file_put_contents($file, $json_string);
        echo json_encode($results);


        break;
       
    case "crearAlumnosCurso":
        $idAlumno = $_POST['idAlumno']; // PARA RECOGER LA RUTA
        $nivelAsig = $_POST['nivelAsig']; // PARA RECOGER LA RUTA
        $idLlegada = $_POST['idLlegada']; // PARA RECOGER LA RUTA
        $fechaActual = $_POST['fechaActual']; // PARA RECOGER LA RUTA
        $codNivel = $_POST['codNivel']; // PARA RECOGER LA RUTA

        
        $datos = $grupos->crearAlumnosCurso($idAlumno,$nivelAsig,$idLlegada,$fechaActual,$codNivel);

    break;   

    case "insertarAlumnosCurso":
        $idAlumno = $_POST['idAlumno']; // PARA RECOGER LA RUTA
        $nivelAsig = $_POST['nivelAsig']; // PARA RECOGER LA RUTA
        $idLlegada = $_POST['idLlegada']; // PARA RECOGER LA RUTA
        $fechaActual = $_POST['fechaSeleccionado']; // PARA RECOGER LA RUTA
        $cantidadSeleccionado = $_POST['cantidadSeleccionado']; // PARA RECOGER LA RUTA
        $codGrupo = $_POST['codGrupo']; // PARA RECOGER LA RUTA
       
        
        $datos = $grupos->insertarAlumnosCurso($idAlumno,$nivelAsig,$idLlegada,$fechaActual,$cantidadSeleccionado,$codGrupo);

    break;   
    case "mostrarLlegadaXId":
        $idLlegada = $_GET['idLlegada']; // PARA RECOGER LA RUTA
  
        $datos = $grupos->recogerLlegadasID($idLlegada);
        echo json_encode($datos);

    break;   
    case "insertarAulaGrupo":
        $aulaSeleccionada = $_POST['aulaSeleccionada']; // PARA RECOGER LA RUTA
        $grupoSeleccionado = $_POST['grupoSeleccionado']; // PARA RECOGER LA RUTA
       
        
        $datos = $grupos->insertarAulaGrupo($aulaSeleccionada,$grupoSeleccionado);

    break;   
    case "cargarAulasGrupo":
        $codSeleccionado = $_POST['codSeleccionado']; // PARA RECOGER LA RUTA
       
        $datos = $grupos->cargarAulasGrupo($codSeleccionado);
        echo json_encode($datos);

    break;  
    case "cargarProfeGrupo":
        $codSeleccionado = $_POST['codSeleccionado']; // PARA RECOGER LA RUTA
       
        $datos = $grupos->cargarProfeGrupo($codSeleccionado);
        echo json_encode($datos);

    break;  
    case "listarPersonal":

        $idRuta = $_GET['idRuta'];
        $datos = $grupos->listarPersonalTodos($idRuta);

        

        $data = array();



        foreach ($datos as $row) {
            $sub_array = array();


            $sub_array[] = '<p class="">' . $row["idPersonal"] . '</p>';
            $sub_array[] = '<p class="">' . $row["nomPersonal"] . ' ' . $row["apePersonal"] . '</p>';
            $sub_array[] = '<p class="">' . $row["dirPersonal"] . ' - ' . $row["poblaPersonal"] . ' - ' . $row["cpPersonal"] . ' - ' . $row["provPersonal"] . ' - ' . $row["paisPersonal"] . '</p>';
            $sub_array[] = '<p class=""><a href="tel:' . $row["tlfPersonal"] . '">' . $row["tlfPersonal"] . '</a><a href="tel:' . $row["movilPersonal"] . '"> - ' . $row["movilPersonal"] . '</a></p>';
            $sub_array[] = '<p class=""><a href="mailto:' . $row["emailUsuario"] . '">' . $row["emailUsuario"] . '</a></p>';

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);


        break;
        case "insertarProfesorGrupo":
            $idProfesorSeleccionado = $_POST['idProfesorSeleccionado']; // PARA RECOGER LA RUTA
            $grupoSeleccionado = $_POST['grupoSeleccionado']; // PARA RECOGER LA RUTA

           $grupos->insertarProfesorGrupo($idProfesorSeleccionado,$grupoSeleccionado );
          
    
        break;  


        //=========================================//
        //                 GESTION GRUPOS          //
        //=========================================//
        case "mostrarAlumnosCodGrupo":
            $codGrupo = $_GET['codGrupo']; // PARA RECOGER LA RUTA
          
            $datosAlumnos = $grupos->mostrarAlumnosCodGrupo($codGrupo);
          
           

            echo json_encode($datosAlumnos);

        break;  
        case "mostrarAlumnosCodGrupoRight":
            $codGrupo = $_GET['codGrupo']; // PARA RECOGER LA RUTA
          
            $datosAlumnos = $grupos->mostrarAlumnosCodGrupoRight($codGrupo);
          
           
            echo json_encode($datosAlumnos);

        break;  
         case "mostrarGruposTodosCalendar":
         
            $datos = $grupos->listarGruposTodosCalendar();
         
            $data = array();
    
                // Colores según el estado
            function getBadgeClass($estado) {
                switch (strtolower($estado)) {
                    case 'provisional':
                        return 'bg-warning text-dark';
                    case 'publicado':
                        return 'bg-success';
                    case 'sin asignar':
                        return 'bg-secondary';
                    default:
                        return 'bg-light text-dark';
                }
            }

            foreach ($datos as $row) {
                $sub_array = array();
     
                $sub_array[] = $row["idGrupo"];
                $sub_array[] = '<span class="badge bg-danger-subtle text-danger border border-danger">'. $row["codIdioma"] .' '.  $row["descrIdioma"] .'</span>
                <span class="badge bg-info-subtle text-info border border-info">'. $row["codTipo"] .' '.  $row["descrTipo"] .'</span>
                <span class="badge bg-warning-subtle text-warning border border-warning">'. $row["codNivel"] .' '.  $row["descrNivel"] .'</span>';
                $clase_bg = 'bg-success'; // Por defecto, verde (success)
    
                if ($row["total_alumnos"] > $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-danger'; // Rojo si supera el máximo
                } elseif ($row["total_alumnos"] == $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-warning'; // Amarillo si es igual
                }
                $sub_array[] = $row["codIdioma"] .  $row["codTipo"] . $row["codNivel"];
                $sub_array[] = fechaLocal($row["ultima_fecha"]);
    
                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge '. $clase_bg .'">'. $row["total_alumnos"] .'</span></button>';
                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge bg-success">'. $row["minAlum_ruta"] .'</span> - <span class="badge bg-danger">'. $row["maxAlum_ruta"] .'</span> </button>';
    
                $sub_array[] = $row["idGrupo"];
                $sub_array[] = $row["codGrupo"];


                // Semana actual
                $clase_semana_actual = getBadgeClass($row["semana_actual"]);
                $sub_array[] = '<span class="badge '. $clase_semana_actual .'">'. $row["semana_actual"] .'</span>';

                // Semana siguiente
                $clase_semana_siguiente = getBadgeClass($row["semana_siguiente"]);
                $sub_array[] = '<span class="badge '. $clase_semana_siguiente .'">'. $row["semana_siguiente"] .'</span>';


                $sub_array[] = $row["id_ruta"];
                $sub_array[] = $row["codIdioma"];
                $sub_array[] = $row["codTipo"];
                $sub_array[] = $row["idiomaId_ruta"];
                $sub_array[] = $row["tipoId_ruta"];
                $sub_array[] = $row["est_cursos"];

                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
    
    
            break;
        
        case "mostrarGruposTodos":
         
            $datos = $grupos->listarGruposTodos();
         
            $data = array();
    
    
            foreach ($datos as $row) {
                $sub_array = array();
     
                $sub_array[] = $row["idGrupo"];
                $sub_array[] = '<span class="badge bg-danger-subtle text-danger border border-danger">'. $row["codIdioma"] .' '.  $row["descrIdioma"] .'</span>
                <span class="badge bg-info-subtle text-info border border-info">'. $row["codTipo"] .' '.  $row["descrTipo"] .'</span>
                <span class="badge bg-warning-subtle text-warning border border-warning">'. $row["codNivel"] .' '.  $row["descrNivel"] .'</span>';
                $clase_bg = 'bg-success'; // Por defecto, verde (success)
    
                if ($row["total_alumnos"] > $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-danger'; // Rojo si supera el máximo
                } elseif ($row["total_alumnos"] == $row["maxAlum_ruta"]) {
                    $clase_bg = 'bg-warning'; // Amarillo si es igual
                }
                $sub_array[] = $row["codIdioma"] .  $row["codTipo"] . $row["codNivel"];
                $sub_array[] = fechaLocal($row["ultima_fecha"]);
    
                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge '. $clase_bg .'">'. $row["total_alumnos"] .'</span></button>';
                $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge bg-success">'. $row["minAlum_ruta"] .'</span> - <span class="badge bg-danger">'. $row["maxAlum_ruta"] .'</span> </button>';
    
                $sub_array[] = $row["idGrupo"];
                $sub_array[] = $row["codGrupo"];
                $sub_array[] = $row["id_ruta"];
                $sub_array[] = $row["codIdioma"];
                $sub_array[] = $row["codTipo"];
                $sub_array[] = $row["idiomaId_ruta"];
                $sub_array[] = $row["tipoId_ruta"];
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
    
    
            break;
        

            case "mostrarGruposTodosRight":
                $idRuta = $_GET['idCursoSeleccionado'];
                $codGrupo = $_GET['codGrupo'];
                $codIdioma = $_GET['codIdioma'];
                $codTipoCurso = $_GET['codTipoCurso'];

                $datos = $grupos->listarGruposTodosRight($idRuta,$codGrupo,$codIdioma,$codTipoCurso);
              
                $data = array();
        
        
                foreach ($datos as $row) {
                    $sub_array = array();
         
                        // CALCULO FECHA PROXIMA //
                    $fechaInicio = $row["ultima_fecha"];  // Formato: Y-m-d (ej: 2025-03-26)
                    $perRefresco_ruta = $row["perRefresco_ruta"];
                    $medidaRefresco_ruta = $row["medidaRefresco_ruta"];  // Formato: "2 2" (2 semanas)
                    $fechaResultado = '';
                    $informacionTxt = '';
                    if ($medidaRefresco_ruta == 0) {
                        // Si no hay unidad especificada, no se realiza el cálculo
                        $fechaResultado = 'Sin salto automático';
                        
                    } else {
                        // Crear un objeto DateTime a partir de la fecha de inicio
                        $fecha = new DateTime($fechaInicio);
                    
                        // Dependiendo de la medida, sumamos el período correspondiente
                        switch ($medidaRefresco_ruta) {
                            case 1: // Días
                                $fecha->modify("+$perRefresco_ruta days");
                                break;
                            case 2: // Semanas
                                $fecha->modify("+$perRefresco_ruta weeks");
                                break;
                            case 3: // Meses
                                $fecha->modify("+$perRefresco_ruta months");
                                break;
                            default:
                                $fechaResultado = 'Unidad no válida';
                                break;
                        }
                        
                        // Formatear el resultado en Y-m-d
                        if ($fechaResultado !== 'Unidad no válida') {
                            $fechaResultado = $fecha->format('Y-m-d');
                        }
                        $informacionTxt = '<label style="color: lightgray;"><i>'. $row["perRefresco_ruta"] .' ' . $row["descrRefresco"] .'</i></label>';
                    }
                    
                    $sub_array[] = $row["idRuta_cursos"];
                    $sub_array[] = '<span class="badge bg-danger-subtle text-danger border border-danger">'. $row["codIdioma"] .' '.  $row["descrIdioma"] .'</span>
                    <span class="badge bg-info-subtle text-info border border-info">'. $row["codTipo"] .' '.  $row["descrTipo"] .'</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning">'. $row["codNivel"] .' '.  $row["descrNivel"] .'</span>';
                    $clase_bg = 'bg-success'; // Por defecto, verde (success)
        
                    if ($row["total_alumnos"] > $row["maxAlum_ruta"]) {
                        $clase_bg = 'bg-danger'; // Rojo si supera el máximo
                    } elseif ($row["total_alumnos"] == $row["maxAlum_ruta"]) {
                        $clase_bg = 'bg-warning'; // Amarillo si es igual
                    }
                    $sub_array[] = $row["codIdioma"] .  $row["codTipo"] . $row["codNivel"];
                    
                        $ultima_fecha = new DateTime($row["ultima_fecha"]);
                        $meses = [
                            'Jan' => 'Ene', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Abr',
                            'May' => 'May', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago',
                            'Sep' => 'Sep', 'Oct' => 'Oct', 'Nov' => 'Nov', 'Dec' => 'Dic'
                        ];

                    // Obtener el día y el mes en inglés de "ultima_fecha"
                        $dia = $ultima_fecha->format("d");
                        $mes_abrev = $ultima_fecha->format("M"); // Mes en inglés
                        $sub_array[] = $dia . ' ' . $meses[$mes_abrev]; // Ejemplo: "15 Feb"

                        // Formatear fechaResultado
                        $fechaResultado = new DateTime($fechaResultado); // Asumimos que fechaResultado también es una fecha
                        $diaResultado = $fechaResultado->format("d");
                        $mes_abrevResultado = $fechaResultado->format("M"); // Mes en inglés de fechaResultado
                        $sub_array[] = '<label class="tx-danger tx-bold">' . $diaResultado . ' ' . $meses[$mes_abrevResultado] . '</label><br>' . $informacionTxt;
        
                    $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge '. $clase_bg .'">'. $row["total_alumnos"] .'</span></button>';
                    $sub_array[] = '<button type="button" class="btn btn-dark"><span class="badge bg-success">'. $row["minAlum_ruta"] .'</span> - <span class="badge bg-danger">'. $row["maxAlum_ruta"] .'</span> </button>';
        
                    $sub_array[] = $row["idGrupo"];
                    $sub_array[] = $row["codGrupo"];
        
                    $data[] = $sub_array;
                }
                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
        
        
        break;

        // PASAR GRUPOS
        case "actualizarGruposAlumnos":
            //IZQ
       
            $data = json_decode(file_get_contents("php://input"), true);

            $codGrupoTabla1 = $data['codGrupoTabla1']; 
            $identificadorTabla1 = $data['identificadorTabla1']; 
            $addListaIzquierda = $data['addListaIzquierda']; 
            $eliminadosListaIzquierda = $data['eliminadosListaIzquierda']; 
            $codGrupoTabla2 = $data['codGrupoTabla2']; 
            $identificadorTabla2 = $data['identificadorTabla2']; 
            $addListaDerecha = $data['addListaDerecha']; 
            $eliminadosListaDerecha = $data['eliminadosListaDerecha'];

            $datosAlumnos = $grupos->actualizarGruposAlumnos($codGrupoTabla1,$identificadorTabla1,$addListaIzquierda,$eliminadosListaIzquierda,$codGrupoTabla2,$identificadorTabla2,$addListaDerecha,$eliminadosListaDerecha);
          
           
            echo json_encode($datosAlumnos);

        break;  
        // NUEVOS GRUPOS RUTAS
        case "crearGruposAlumnos":
            //IZQ
       
            $data = json_decode(file_get_contents("php://input"), true);
         
            $codGrupoTabla1 = $data['codGrupoTabla1']; 
            $identificadorTabla1 = $data['identificadorTabla1']; 
            $alumnosTraspaso = $data['alumnosTraspaso']; 
            $codNivel = $data['codNivel']; 
    
            $fechaActual = $data['fechaActual']; // PARA RECOGER LA RUTA
            $idRT = $data['idRT']; // PARA RECOGER LA RUTA

            
            $datosAlumnos = $grupos->crearGruposAlumnosRuta($codGrupoTabla1,$identificadorTabla1,$alumnosTraspaso,$codNivel,$fechaActual,$idRT);
          
           
            echo json_encode($datosAlumnos);

        break;  
        
        case "recogerAlumnoXidGrupo":

            $idCurso = $_GET['idCurso']; 

            $datosAlumnos = $grupos->recogerAlumnoXidGrupo($idCurso);
          
            echo json_encode($datosAlumnos);

        break;  
        
        case "recogerAlumnosClase":

            $codGrupo = $_POST['codGrupo']; 

            $datosAlumnos = $grupos->recogerAlumnosClase($codGrupo);
          
            echo json_encode($datosAlumnos);

        break;  
          case "recogerAlumnosClaseTabla":

                $codigoCurso = $_POST['codigoCurso']; 
                $idHorario = $_POST['idHorario']; 

                $datos = $grupos->recogerAlumnosClaseTabla($codigoCurso,$idHorario);
            
                $data = array();
        
        
                foreach ($datos as $row) {
                    $sub_array = array();
         
                        // CALCULO FECHA PROXIMA //
                
                    $sub_array[] = $row["idCurso"];
                    $sub_array[] = '<img src="../../public/assets/images/users/' . $row["avatarUsu"] . '" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;">';
                    $sub_array[] = $row["nomUsuario"].' - '. $row["nomAlumno"].' '.$row["apeAlumno"];
                    $sub_array[] = $row["identificadorPersonal"];

                    // HABRA QUE CAMBIARLO POR LA LISTA DE HORARIO
                    $estadoLista = $row["estadoAsistenciaLista"];
                    $json_string = json_encode($estadoLista);
                    $file = 'ESTADOLISTA.json';
                    file_put_contents($file, $json_string);
                    if($estadoLista == 1){
                        $sub_array[] = "<label class='badge bg-success tx-14-force'>✅ Presente</label>";
                        
                    }else if($estadoLista == 2){
                        $sub_array[] = "<label class='badge bg-danger tx-14-force'>❌ Ausente</label>";

                    }else if($estadoLista == 3){
                        $sub_array[] = "<label class='badge bg-success tx-14-force'>⏳ Llego Tarde</label>";

                    }else if($estadoLista == 4){
                        $sub_array[] = "<label class='badge bg-warning tx-14-force'>📄 Justificado</label>";
                    }else{
                        $sub_array[] = "<label class='badge bg-secondary tx-14-force'>⏳ Sin Registrar</label>";
                    }
                    $sub_array[] = $row["obsDiariaLista"];
                    $sub_array[] = $row["idAlumno_cursos"];
                    $sub_array[] = $row["idLlegada_cursos"];

                    $data[] = $sub_array;
                    
                    }
                    $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                    );
          echo json_encode($results);

        break;  

        case 'marcarTodosPresentes':
            $codigoCurso = $_POST['codigoCurso'];
            $idHorario = $_POST['idHorario']; // Recibido desde AJAX
            $idProfesor = $_SESSION['idProfesor']; // O como tengas almacenado el profesor

            $resultado = $grupos->marcarTodosPresentes($codigoCurso, $idHorario, $idProfesor);

            if ($resultado) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
            break;

        // EVITA QUE NO HAYA DOS USUARIOS EN EL MISMO CURSO 
        case 'alumnoEnCurso':

            $idLlegada = $_POST['idLlegada'];
            $idDepartamento = $_POST['idDepartamento'];
         

            $resultado = $grupos-> alumnoEnCurso($idLlegada,$idDepartamento);
           
            echo $resultado; // <-- devuelve 1 o 0 al AJAX

        break;   
            
            

            
        
}

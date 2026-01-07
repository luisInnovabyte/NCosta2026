<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Actividades_Edu.php");


$actividad = new Actividades();

switch ($_GET["op"]) {

    case "mostrarAct":
        // MOSTRAR ACTIVIDADES ALUMNOS //
        $datos = $actividad->mostrarActUsuarios();
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php", "Lista las actividades de los alumnos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        $idUsuario = $_SESSION['usu_id'];

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["idAct"];
            $sub_array[] = $row["descrAct"];            $sub_array[] = FechaLocal($row["fecActDesde"]) . ' '.horaLocalSinSegundos($row["horaInicioAct"]) .'/ ' . FechaLocal($row["fecActHasta"]) . ' ' . horaLocalSinSegundos($row["horaFinAct"]);


            if ($row["horasLectivasAct"] == 1) {
                $sub_array[] = $row["horasLectivasAct"] . " hora";
            } else if ($row["horasLectivasAct"] > 1) {
                $sub_array[] = $row["horasLectivasAct"] . " horas";
            } else {
                $sub_array[] = '';
            }


            $sub_array[] = $row["puntoEncuentroAct"];

            $sub_array[] = '<a href="infoActividad.php?idAct=' . $row["idAct"] . '"  target="_blank"><button type="button"  id="' . $row["idAct"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver PDF"><div><i class="fas fa-eye"></i></div></button></a>  ';

            $datos = $actividad->consultarAlumnoApuntado($idUsuario, $row["idAct"]);

            // if para vacio datos

            $res = empty($datos); // SI HAY DATOS == FALSE, SI NO HAY DATOS == TRUE
            if ($res == true) {
                $sub_array[] =  '<button type="button" onClick="apuntarme(' . $idUsuario . ', ' . $row["idAct"] . ');"  id="' . $idUsuario . '" class="btn btn-success btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Apuntarse"><div><i class=" fas fa-calendar-check"></i></div></button>';
            } else {
                $sub_array[] =  '<button type="button" onClick="desapuntarme(' . $idUsuario . ', ' . $row["idAct"] . ');"  id="' . $row["idAct"] . '" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Desapuntarse"><div><i class=" fas fa-calendar-times"></i></div></button>';
            }


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

        case "mostrarActUsuario":
    session_start();
    require_once("../models/Log.php");

    $idUsuario = $_SESSION['usu_id'];

    // LOG
    $nombreLog =  $idUsuario . " - " . $_SESSION['usu_nom'];
    $logI = new Log($nombreLog, "actividades.php", "Lista las actividades del alumno " . $idUsuario);
    $logI->grabarLinea();
    unset($logI);

    // Supongamos que tienes un método que retorna solo las actividades donde está apuntado el usuario:
    $datos = $actividad->mostrarActividadesPorUsuario($idUsuario);

    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();
        $sub_array[] = $row["idAct"];
        $sub_array[] = $row["descrAct"];
        $sub_array[] = FechaLocal($row["fecActDesde"]) . ' ' . horaLocalSinSegundos($row["horaInicioAct"]) . ' / ' . FechaLocal($row["fecActHasta"]) . ' ' . horaLocalSinSegundos($row["horaFinAct"]);

        if ($row["horasLectivasAct"] == 1) {
            $sub_array[] = $row["horasLectivasAct"] . " hora";
        } else if ($row["horasLectivasAct"] > 1) {
            $sub_array[] = $row["horasLectivasAct"] . " horas";
        } else {
            $sub_array[] = '';
        }

        $sub_array[] = $row["puntoEncuentroAct"];

        $sub_array[] = '<a href="infoActividad.php?idAct=' . $row["idAct"] . '" target="_blank">
                            <button type="button" id="' . $row["idAct"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver PDF">
                                <div><i class="fas fa-eye"></i></div>
                            </button>
                        </a>';

        // Solo mostramos botón para desapuntarse, ya que está apuntado
        $sub_array[] = '<button type="button" onClick="desapuntarme(' . $idUsuario . ', ' . $row["idAct"] . ');" id="' . $row["idAct"] . '" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Desapuntarse">
                            <div><i class="fas fa-calendar-times"></i></div>
                        </button>';

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



    case "insertar":

        $descrAct = ucfirst($_POST["descrAct"]);
        $fecActFinSolicitud = $_POST["fecActFinSolicitud"];
        $fecActDesde = $_POST["fecActDesde"];
        $fecActHasta = $_POST["fecActHasta"];
        $horaInicioAct = $_POST["horaInicioAct"];
        $horaFinAct = $_POST["horaFinAct"];
        $horasLectivasAct = $_POST["horasLectivasAct"];
        $puntoEncuentroAct = ucfirst($_POST["puntoEncuentroAct"]);
        $idPersonal_guiaAct = $_POST["idPersonal_guiaAct"];
        $obsAct = $_POST["obsAct"];
        $minAlumTipo = $_POST["minAlumTipo"];
        $maxAlumTipo = $_POST["maxAlumTipo"];

        $img = $_FILES["files"];
        $img_name = $img["name"];
        $img_tmp_name = $img["tmp_name"];
        $img_size = $img["size"];
        $img_error = $img["error"];

    
        $departamentos = $_POST["departamentos"];

        // Crear carpeta imagenes actividades

        if (!file_exists("../public/img/actividades/")) {
            mkdir("../public/img/actividades/", 0777);
        }

        $directorio = "../public/img/actividades/";
        if (empty($_FILES['files']['tmp_name']) || !array_filter($_FILES['files']['tmp_name'])) {
            // No se han subido imágenes
            echo '00';
            exit;
        }
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {


            // CAMINO FINAL HACIA DONDE SE DEBE COPIAR
            $archivoFinal = $directorio . basename($_FILES["files"]["name"][$key]);



            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $archivoFinal)) {

                // INSERTAMOS EN BBDD // 

                $nomImg = $_FILES['files']['name'][$key];
                $actividad->insertarActividad($descrAct, $fecActFinSolicitud, $fecActDesde, $fecActHasta, $horaInicioAct, $horaFinAct, $horasLectivasAct, $puntoEncuentroAct, $idPersonal_guiaAct, $obsAct, $nomImg, $minAlumTipo, $maxAlumTipo, $departamentos);
                
                session_start();
                require_once("../models/Log.php");

                // Archivo LOG
                $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
                $logI = new Log($nombreLog, "actividades.php", "Inserta Actividades");
                $logI->grabarLinea();
                unset($logI);
                // FIN del archivo LOG
                echo '1';
            }
        }


        break;

    case "editar":

       
        $idAct = $_POST["idAct"];
        $descrAct = ucfirst($_POST["descrAct"]);
        $fecActFinSolicitud = $_POST["fecActFinSolicitud"];
        $fecActDesde = $_POST["fecActDesde"];
        $fecActHasta = $_POST["fecActHasta"];
        $horaInicioAct = $_POST["horaInicioAct"];
        $horaFinAct = $_POST["horaFinAct"];
        $horasLectivasAct = $_POST["horasLectivasAct"];
        $puntoEncuentroAct = ucfirst($_POST["puntoEncuentroAct"]);
        $idPersonal_guiaAct = $_POST["idPersonal_guiaAct"];
        $obsAct = $_POST["obsAct"];
        $nomImg = $_POST["imgAct"];
        $minAlumTipo = $_POST["minAlumTipo"];
        $maxAlumTipo = $_POST["maxAlumTipo"];

        $img = $_FILES["files"];
        $img_name = $img["name"];
        $img_tmp_name = $img["tmp_name"];
        $img_size = $img["size"];
        $img_error = $img["error"];


        $departamentos = $_POST["departamentos"];

        // Crear carpeta imagenes actividades

        if (!file_exists("../public/img/actividades/")) {
            mkdir("../public/img/actividades/", 0777);
        }
        $directorio = "../public/img/actividades/";
       
        if (!empty($_FILES)) {
            
            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {


                // CAMINO FINAL HACIA DONDE SE DEBE COPIAR
                $archivoFinal = $directorio . basename($_FILES["files"]["name"][$key]);

               
                if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $archivoFinal)) {

                    // INSERTAMOS EN BBDD // 

                    $nomImg = $_FILES['files']['name'][$key];
                   
                    $actividad->editarActividad($idAct, $descrAct, $fecActFinSolicitud, $fecActDesde, $fecActHasta, $horaInicioAct, $horaFinAct, $horasLectivasAct, $puntoEncuentroAct, $idPersonal_guiaAct, $obsAct, $nomImg, $min, $max,$departamentos);
                    session_start();
                    require_once("../models/Log.php");

                    // Archivo LOG
                    $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
                    $logI = new Log($nombreLog, "actividades.php", "Edita Actividade " . $idAct . " " . $descrAct);
                    $logI->grabarLinea();
                    unset($logI);
                    // FIN del archivo LOG

                    echo '1';
                }
            }
        } else {
          
            $actividad->editarActividad($idAct, $descrAct, $fecActFinSolicitud, $fecActDesde, $fecActHasta, $horaInicioAct, $horaFinAct, $horasLectivasAct, $puntoEncuentroAct, $idPersonal_guiaAct, $obsAct, $nomImg, $minAlumTipo, $maxAlumTipo,$departamentos);
            session_start();
            require_once("../models/Log.php");
           
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "actividades.php", "Edita Actividades" . $idAct . " " . $descrAct);
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
            echo '1';
        }
        break;


    //////////////////////
    // MÉTODO PARA CARGAR LA EDICIÓN DE UNA ACTIVIDAD CAMBIADO EXITOSAMENTE
    // ANTES SE USABA EL CAMPO departamentoDisponibles como campo para almacenar el id de cada departamento en la propia vista de la actividad
    // AHORA SE FORMA DINÁMICAMENTE CON idsDepartamentos los departamentos de los que forma parte esa actividad 
    /////////////////////
    case "cargarDatosEditar":

        $datosActividad = $actividad->cargarDatosEditarModelo($_POST['idAct']);
    
        echo json_encode($datosActividad);

        break;

        
        /////////////////////////
    // MÉTODO PARA COMPROBAR A LA HORA DE INSERTAR A UN ALUMNO A UNA ACTIVIDAD SI PRIMERO EL ID
    // DE LA ACTIVIDAD EXISTE, PARA EVITAR PROBLEMAS MAYORES
    /////////////////////////
    case "comprobarActividadExiste":
        $actividadExiste = $actividad->comprobarActividadExisteModelo($_POST['idAct']);
        echo json_encode(['existe' => $actividadExiste]);
        break;

  case "mostrarListaAlum":
    $idAct = $_GET['idAct'];
    $listaAlum = $actividad->mostrarListaAlum($idAct);

    // Función para calcular edad
    function calcularEdad($fechaNacimiento) {
        if ($fechaNacimiento === '1970-01-01' || empty($fechaNacimiento)) {
            return null; // Señalamos que no hay edad válida
        }

        try {
            $nacimiento = new DateTime($fechaNacimiento);
            $hoy = new DateTime();
            return $hoy->diff($nacimiento)->y;
        } catch (Exception $e) {
            return null;
        }
    }

    // Función para generar badge según edad
    function badgeEdad($edad) {
        if (is_null($edad)) {
            return "<label class='badge bg-secondary tx-14-force'>Edad no introducida</label>";
        } elseif ($edad < 18) {
            return "<label class='badge bg-info tx-14-force'>{$edad} años</label>";
        } else {
            return "<label class='badge bg-success tx-14-force'>{$edad} años</label>";
        }
    }

    $data = array();

    foreach ($listaAlum as $row) {
        $sub_array = array();

        $sub_array[] = $row["idAlumno"];
        $sub_array[] = $row["nomUsuario"] . " - " . $row["nomAlumno"] . ' ' . $row["apeAlumno"];

        $edad = calcularEdad($row["fecNacAlumno"]);
        $sub_array[] = badgeEdad($edad);

        $telefono = isset($row["teleAlumno"]) && !empty($row["teleAlumno"])
            ? $row["teleAlumno"]
            : "Teléfono no disponible";

        $sub_array[] = $row["emailUsuario"] . " / " . $telefono;
        $sub_array[] = $row["idUsuario_tmalumno"];
        $sub_array[] = $row["estadoInscripcion"];

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

    case "mostrarListaAlumMatriculados":
    $depaAct = $_GET['idAct'];
    $listaAlum = $actividad->mostrarListaAlumMatriculados($depaAct);

    // Función para calcular edad desde la fecha de nacimiento
    function calcularEdad($fechaNacimiento) {
        if ($fechaNacimiento === '1970-01-01' || empty($fechaNacimiento)) {
            return null;
        }

        try {
            $nacimiento = new DateTime($fechaNacimiento);
            $hoy = new DateTime();
            return $hoy->diff($nacimiento)->y;
        } catch (Exception $e) {
            return null;
        }
    }

    // Badge según edad con valor numérico
    function badgeEdad($edad) {
        if (is_null($edad)) {
            return "<label class='badge bg-secondary tx-14-force'>Edad no introducida</label>";
        } elseif ($edad < 18) {
            return "<label class='badge bg-info tx-14-force'>{$edad} años</label>";
        } else {
            return "<label class='badge bg-success tx-14-force'>{$edad} años</label>";
        }
    }

    $data = array();

    foreach ($listaAlum as $row) {
        $sub_array = array();

        // ID de llegada
        $sub_array[] = $row["idLlegada"];

        // Nickname + nombre completo
        $sub_array[] = $row["nickname"] . " - " . $row["nomAlumno"] . ' ' . $row["apeAlumno"];

        // Edad con badge
        $edad = calcularEdad($row["fecNacAlumno"]);
        $sub_array[] = badgeEdad($edad);

        // Email + teléfono
        $telefono = isset($row["teleAlumno"]) && !empty($row["teleAlumno"])
            ? $row["teleAlumno"]
            : "Teléfono no disponible";
        $sub_array[] = $row["emailUsuario"] . " / " . $telefono;

        // Fecha inicio matrícula
        $sub_array[] = date("d/m/Y", strtotime($row["fechaInicioMatricula"]));

        // Fecha fin matrícula
        $sub_array[] = date("d/m/Y", strtotime($row["fechaFinMatricula"]));

        // ID DEL USUARIO
        $sub_array[] = $row["idUsuario_tmalumno"];

        $sub_array[] = $row["estadoInscripcion"];

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


    // AL INTENTAR INSERTAR A GENTE MATRICULADA, HAY VECES QUE DA ERROR, HAY QUE MIRARLO
    
    case "obtenerActividadesYHorasCertificado":
    $idLlegada = $_POST['idLlegada'];

    $actividades = $actividad->obtenerActividadesPorLlegadaCertificado($idLlegada);

    echo json_encode([
        "aaData" => $actividades
    ]);
    break;
        
 case "insertarAlumnoActividad":
    $idAct = $_POST['idAct'];
    $idAlumno = $_POST['selectAlumno'];
    $idLlegada = isset($_POST['idLlegada']) ? $_POST['idLlegada'] : null;

    $resultado = $actividad->insertarAlumnoActividad($idAct, $idAlumno, $idLlegada);

    session_start();
    require_once("../models/Log.php");

    if ($resultado) {
        $nombreLog = $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php", "Alumno $idAlumno fue apuntado por {$_SESSION['usu_nom']} a la actividad $idAct");
        $logI->grabarLinea();
        unset($logI);

        echo json_encode(['status' => 'success', 'message' => 'Alumno registrado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'El alumno ya está registrado en esta actividad.']);
    }
    break;

    case "desactivarActividad":

        $actividad->desactivarActividad($_POST['idAct']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "La actividad " . $_POST['idAct'] . "fue desactivada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "activarActividad":

        $actividad->activarActividad($_POST['idAct']);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "La actividad " . $_POST['idAct'] . "fue activada");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "mostrarActUsuarioPerfil":
    
        session_start();
        // Recoger idUsuario desde la petición GET o usar null si no viene
        $idUsuario = $_SESSION['usu_id'];

        // Guardar en un JSON el valor de idUsuario para debug
        $jsonPath = __DIR__ . "/debug_idUsuario.json";
        $jsonData = json_encode(['idUsuario' => $idUsuario], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($jsonPath, $jsonData);



        // Obtener las actividades del usuario
        $datos = $actividad->mostrarActUsuarioPerfil($idUsuario);

        require_once("../models/Log.php");
        $nombreLog =  $idUsuario . " - " . ($_SESSION['usu_nom'] ?? 'Usuario desconocido');
        $logI = new Log($nombreLog, "actividades.php", "Lista las actividades del usuario");
        $logI->grabarLinea();
        unset($logI);

        $data = [];
        foreach ($datos as $row) {
            $sub_array = [];
            $sub_array[] = $row["descrAct"];
            $sub_array[] = FechaLocal($row["fecActDesde"]) . ' ' . horaLocalSinSegundos($row["horaInicioAct"]) . ' / ' . FechaLocal($row["fecActHasta"]) . ' ' . horaLocalSinSegundos($row["horaFinAct"]);

            if ($row["horasLectivasAct"] > 1) {
                $sub_array[] = $row["horasLectivasAct"] . " horas";
            } elseif ($row["horasLectivasAct"] == 1) {
                $sub_array[] = "1 hora";
            } else {
                $sub_array[] = "";
            }

            $sub_array[] = $row["puntoEncuentroAct"];

            $sub_array[] = '<a href="../Actividades_Edu/infoActividad.php?idAct=' . $row["idAct"] . '" target="_blank">
                                <button type="button" class="btn btn-info btn-icon" title="Ver PDF">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </a>';

            $data[] = $sub_array;
        }

        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];

        echo json_encode($results);
        break;


    case "mostrarActAdmin":

        try {
        $datos = $actividad->mostrarActAdmin();

        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "Lista las actividades de los adminitradores");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();
        foreach ($datos as $row) {

            $sub_array = array();
            $sub_array[] = $row["idAct"];
            $sub_array[] = $row["descrAct"];
            $sub_array[] = FechaLocal($row["fecActDesde"]) . ' '.horaLocalSinSegundos($row["horaInicioAct"]) .'/ ' . FechaLocal($row["fecActHasta"]) . ' ' . horaLocalSinSegundos($row["horaFinAct"]);



            if ($row["horasLectivasAct"] == 1) {
                $sub_array[] = $row["horasLectivasAct"] . " hora";
            } else if ($row["horasLectivasAct"] > 1) {
                $sub_array[] = $row["horasLectivasAct"] . " horas";
            } else {
                $sub_array[] = '';
            }


            $sub_array[] = $row["puntoEncuentroAct"];
            $sub_array[] = $row["nombresDepartamentos"];

            $sub_array[] = '<span class="label label-rounded label-success tx-bold ">' . $row["minAlumAct"] . '/'. $row["maxAlumAct"] .'</span> ';

            if ($row["estadoAct"] == 1) {
                $sub_array[] = '<p class="tx-success tx-bold">Activa</p>';
            } else if($row["estadoAct"] == 0) {
                $sub_array[] = '<p class="tx-danger tx-bold">Inactiva</p>';
            }else if($row["estadoAct"] == 2) {
                $sub_array[] = '<p class="tx-warning tx-bold">Cancelada</p>';
            }else if($row["estadoAct"] == 3) {
                $sub_array[] = '<p class="tx-info tx-bold">Fin de Inscripción</p>';
            }

            $sub_array[] = ' <a href="alumno.php?idAct=' . $row["idAct"] . '">  <button type="button" " class="btn btn-success btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver Lista"><div><i class=" fas fa-user"></i></div></button> </a>';

            $sub_array[] = '<a href="../Actividades_Edu/infoActividad.php?idAct=' . $row["idAct"] . '"  target="_blank"><button type="button"  id="' . $row["idAct"] . '" class="btn btn-info btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver PDF"><div><i class="fas fa-eye"></i></div></button></a>  ';

            $sub_array[] = '<a href="gestionarActividad.php?idAct=' . $row["idAct"] . '"> <button type="button"  id="' . $row["idAct"] . '" class="btn btn-primary btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Editar actividad"><div><i class="fas fa-edit"></i></div></button></a>';


            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        } catch (PDOException $e) {
        $errorData = [
            'error' => true,
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'time' => date('Y-m-d H:i:s')
        ];
        file_put_contents(__DIR__ . '/error_mostrarActAdmin5.json', json_encode($errorData, JSON_PRETTY_PRINT));
        return false;  // o lanzar excepción si quieres manejarlo en otro lado
    }

        echo json_encode($results);
        break;

    case "eliminarAct":
        $actividad->delete_Actusuario($_POST["idAct"]);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "Elimina la actividad " . $_POST["idAct"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "apuntarse":
    try {
        session_start();
        $idUsu = $_POST["idUsu"];
        $idAct = $_POST["idAct"];
        $idLlegada = $_SESSION['llegada_idLlegada'];

        $actividad->apuntarse($idUsu, $idAct, $idLlegada);
        
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog = $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php", "El usuario " . $_POST["idUsu"] . " se apunta a la actividad " . $_POST["idAct"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

    } catch (Throwable $e) {
        $error = [
            "error" => true,
            "mensaje" => "Error en el proceso de apuntarse",
            "detalle" => $e->getMessage(),
            "fecha" => date("Y-m-d H:i:s"),
            "datos_enviados" => [
                "idUsu" => $_POST["idUsu"] ?? null,
                "idAct" => $_POST["idAct"] ?? null,
                "idLlegada" => $_SESSION['llegada_idLlegada'] ?? null
            ]
        ];

        file_put_contents('error_apuntarse_controlador.json', json_encode($error, JSON_PRETTY_PRINT));
    }
    break;


    case "desapuntarse":
        $idUsu = $_POST["idUsu"];
        $idAct = $_POST["idAct"];
        $actividad->desapuntarse($idUsu, $idAct);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "El usuario " . $_POST["idUsu"] . " se desapunta de la actividad " . $_POST["idAct"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

   case "mostrarAlumno":

    $idActividad = $_GET['idAct'];
    $datos = $actividad->mostrarAlum($idActividad);

    session_start();
    require_once("../models/Log.php");

    // Archivo LOG
    $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
    $logI = new Log($nombreLog, "actividades.php",  "Lista los alumnos apuntados en la actividad " . $idActividad);
    $logI->grabarLinea();
    unset($logI);
    // FIN del archivo LOG

    // Función para calcular edad
    function calcularEdad($fechaNacimiento) {
        if ($fechaNacimiento === '1970-01-01' || empty($fechaNacimiento)) {
            return null;
        }

        try {
            $nacimiento = new DateTime($fechaNacimiento);
            $hoy = new DateTime();
            return $hoy->diff($nacimiento)->y;
        } catch (Exception $e) {
            return null;
        }
    }

    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();

        // Id usuario
        $sub_array[] = $row["idUsuario_UsuarioAct"];

        // Nombre completo + email + estado matriculado
        $sub_array[] = $row["nomAlumno"] . ' ' . $row["apeAlumno"] . ' - ' . $row["emailUsuario"] . ' ' .
            (
                isset($row["idLlegada_UsuarioAct"]) && !is_null($row["idLlegada_UsuarioAct"])
                ? "<label class='badge bg-success tx-14-force ms-2'>Matriculado (" . str_pad($row["idLlegada_UsuarioAct"], 4, "0", STR_PAD_LEFT) . ")</label>"
                : "<label class='badge bg-secondary tx-14-force ms-2'>No Matriculado</label>"
            );

        // Fecha alta
        $sub_array[] = FechaHoraLocal_string($row["fecAltaUsuarioAct"]);

        // Edad con badge
        $edad = calcularEdad($row["fecNacAlumno"]);
        if (is_null($edad)) {
            $edadBadge = "<label class='badge bg-secondary tx-14-force'>Edad no introducida</label>";
        } elseif ($edad < 18) {
            $edadBadge = "<label class='badge bg-info tx-14-force'>$edad años</label>";
        } else {
            $edadBadge = "<label class='badge bg-success tx-14-force'>$edad años</label>";
        }
        $sub_array[] = $edadBadge;

        // Botón dar de baja y asistencia según permisos y rol
        $idProfesorConsulta = $_SESSION['usuPre_idInscripcion'];
        $idGuia = $row["idPersonal_guiaAct"];
        $rolUsu = $_SESSION['usu_rol'];

        if ($rolUsu == 1) {
            $sub_array[] = '<button type="button" onClick="darBaja(' . $row["idUsuarioAct"] . ');" id="' . $row["idUsuarioAct"] . '" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Dar de baja"><div><i class="fas fa-user-times"></i></div></button>';

            if ($row["asisUsuarioAct"] == 1) {
                $sub_array[] = '<button type="button" onClick="asistir(' . $row["idUsuarioAct"] . ')" id="' . $row["idUsuarioAct"] . '" class="btn btn-success btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Participando"><div><i class="fas fa-check"></i></div></button>';
            } else {
                $sub_array[] = '<button type="button" onClick="asistir(' . $row["idUsuarioAct"] . ')" id="' . $row["idUsuarioAct"] . '" class="btn btn-outline-secondary" data-toggle="tooltip-primary" data-placement="top" title="No ha participado"><div><i class="fas fa-times"></i></div></button>';
            }
        } else {
            if ($idProfesorConsulta == $idGuia) {
                $sub_array[] = '<button type="button" onClick="darBaja(' . $row["idUsuarioAct"] . ');" id="' . $row["idUsuarioAct"] . '" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Dar de baja"><div><i class="fas fa-user-times"></i></div></button>';

                if ($row["asisUsuarioAct"] == 1) {
                    $sub_array[] = '<button type="button" onClick="asistir(' . $row["idUsuarioAct"] . ')" id="' . $row["idUsuarioAct"] . '" class="btn btn-success btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Participando"><div><i class="fas fa-check"></i></div></button>';
                } else {
                    $sub_array[] = '<button type="button" onClick="asistir(' . $row["idUsuarioAct"] . ')" id="' . $row["idUsuarioAct"] . '" class="btn btn-outline-secondary" data-toggle="tooltip-primary" data-placement="top" title="No ha participado"><div><i class="fas fa-times"></i></div></button>';
                }
            } else {
                $sub_array[] = '<button type="button" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Sin acceso a permisos. Debes de ser guía."><div><i class="fa-solid fa-person-circle-minus"></i></div></button>';
                $sub_array[] = '<button type="button" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Sin acceso a permisos. Debes de ser guía."><div><i class="fa-solid fa-person-circle-minus"></i></div></button>';
            }
        }

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


 case "comprobarAlumnoInscrito":

        $idAct = $_POST['idAct'];
        $idAlumno = $_POST['idAlumno'];

        $existe = $actividad->comprobarAlumnoInscrito($idAct, $idAlumno);

        echo json_encode(["existe" => $existe]);
   
    break;


    case "noAsistir":
        $idUsuarioAct = $_POST["idUsuarioAct"];
        $actividad->noAsistir($idUsuarioAct);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "El alumno " . $_POST["idUsuarioAct"] . " no ha asistido");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "asistir":
        $idUsuarioAct = $_POST["idUsuarioAct"];
        $actividad->asistir($idUsuarioAct);
        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "El alumno " . $_POST["idUsuarioAct"] . " ha asistido");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "darBaja":
        $idUsuarioAct = $_POST["idUsuarioAct"];
        $actividad->darBaja($idUsuarioAct);

        session_start();
        require_once("../models/Log.php");

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "actividades.php",  "El alumno " . $_POST["idUsuarioAct"] . " fue eliminad@ de la actividad");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "mostrarActProf":
        session_start();
        $depaActivo = $_SESSION['llegada_idDepartamento'];
        $datos = $actividad->mostrarActProf($depaActivo);
       
        $data = array();
        // FIN del archivo LOG
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["idAct"];
            $sub_array[] = $row["descrAct"];
            $sub_array[] = FechaLocal($row["fecActDesde"]) . ' / ' . FechaLocal($row["fecActHasta"]);
            $sub_array[] = $row["horaInicioAct"] . ' - ' . $row["horaFinAct"];

            if ($row["horasLectivasAct"] == 1) {
                $sub_array[] = $row["horasLectivasAct"] . " hora";
            } else if ($row["horasLectivasAct"] > 1) {
                $sub_array[] = $row["horasLectivasAct"] . " horas";
            } else {
                $sub_array[] = '';
            }


            $sub_array[] = $row["puntoEncuentroAct"];

            if ($row["estadoAct"] == 1) {
                $sub_array[] = '<p class="tx-success tx-bold">Activa</p>';
            } else if($row["estadoAct"] == 0) {
                $sub_array[] = '<p class="tx-danger tx-bold">Inactiva</p>';
            }else if($row["estadoAct"] == 2) {
                $sub_array[] = '<p class="tx-warning tx-bold">Cancelada</p>';
            }else if($row["estadoAct"] == 3) {
                $sub_array[] = '<p class="tx-info tx-bold">Fin de Inscripción</p>';
            }else{
                $sub_array[] = '<p class="tx-info tx-bold">Error en la Actividad</p>';

            }


            $sub_array[] = ' <a href="alumno.php?idAct=' . $row["idAct"] . '">  <button type="button" " class="btn btn-success btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver Lista"><div><i class=" fas fa-user"></i></div></button> </a>';

            $sub_array[] = '<a href="../Actividades_Edu/infoActividad.php?idAct=' . $row["idAct"] . '"  target="_blank"><button type="button"  id="' . $row["idAct"] . '" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Ver PDF"><div><i class="fas fa-eye"></i></div></button></a>  ';

            $sub_array[] = $row["idPersonal_guiaAct"];

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


        /////////////////////////////////////
        // APARTADO NOTIFICACIÓN MAINMENU //
        ///////////////////////////////////

    case "notificacionActividad":

        $datosNotificacion = $actividad->actividadNotificacion();

        echo json_encode($datosNotificacion);

    

        break;

        /////////////////////////////////
        ////////////////////////////////
        ///////////////////////////////
         /////////////////////////////////////
        // TOTAL DE ALUMNOS APUNTADO A UNA ACTIVIDAD //
        ///////////////////////////////////
        case "totalActividad":
            
            $idActividad = $_POST['actividad'];
           
            $totalAsistentes = $actividad->totalAlumnoActividad($idActividad);

            echo json_encode($totalAsistentes);
    
            break;
}

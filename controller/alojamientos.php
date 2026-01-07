<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Empresa.php");
require_once("../models/Alojamientos.php");
require_once '../public/vendor/autoload.php';

session_start();
require_once("../models/Log.php");

$alojamiento = new Alojamientos();

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


switch ($_GET["op"]) {

    case "listarAlojamiento":


        session_start();
        require_once("../models/Log.php");
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista los alojamientos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $datos = $alojamiento->listarAlojamiento();


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista los alojamientos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idAloja"];

            $sub_array[] = $row["descrTiposAloja"];
            $sub_array[] = $row["idAlojamientoTexto"];
            $sub_array[] = $row["nombreAloja"] . ' ' . $row["apeAloja"];
            $sub_array[] = $row["dirAloja"] . ' ' . $row["cpAloja"] . ' ' . $row["poblaAloja"] . ' ' . $row["proviAloja"];
            $ocupados = (int)$row["capacidad_total"] - (int)$row["capacidad_ocupado"];
            $sub_array[] = '<span class="label label-rounded label-info">' . ((int)$row["HabIndiAloja"] * 1 + (int)$row["HabDobleAloja"] * 2 + (int)$row["HabTripleAloja"] * 3) . '</span>';
            $nombreCompleto =  $row["idAloja"].' - '.$row["nombreAloja"] . ' ' . $row["apeAloja"];
            
            if ($row["capacidad_ocupado"] <= 0) {
                $sub_array[] =  '<span class="label label-rounded label-info">' . '0' . '</span>';
            } else {
                $sub_array[] =  '<span class="label label-rounded label-info">' . $row["capacidad_ocupado"] . '</span>';
            }
                        

            if ($row["MediaAloja"] == 5) {
                $sub_array[] =  '<i class="fa-regular fa-face-laugh-beam tx-20 tx-success"  title="'.$row["MediaAloja"].'"></i>';
            }else if ($row["MediaAloja"] >= 4) {
                $sub_array[] =  '<i class="fa-regular fa-face-smile tx-20" style="color:#33ff33" title="'.$row["MediaAloja"].'"></i>';
            } else if ($row["MediaAloja"] >= 3 && $row["MediaAloja"] < 4) {
                $sub_array[] =  '<i class="fa-regular  fa-face-grimace tx-20 tx-warning"  title="'.$row["MediaAloja"].'"></i>';
            } else if ($row["MediaAloja"] > 0 && $row["MediaAloja"] < 3) {
                $sub_array[] =  '<i class="fa-regular fa-face-frown tx-20 tx-danger" title="'.$row["MediaAloja"].'"></i>';
            } else { 
                $sub_array[] =  '<i class="fa-regular fa-face-meh tx-20 text-muted" title="'.$row["MediaAloja"].'"></i>';
            }

            $sub_array[] =  round($row["MediaAloja"]);

            if ($row["estAloja"] == 1) {
                $sub_array[] = "<span class='tx-success tx-bold''><b>Activo</b></span>";
            } elseif ($row["estAloja"] == 0) {
                $sub_array[] = "<span class='tx-warning tx-bold''><b>Desactivado</b></span>";
            }
            // boton editar
            $sub_array[] = '<a href="datosAlojamiento.php?idAloja=' .$row["token"] . '"><button type="button" title="Editar Alojamiento" role="button" class="btn btn-primary btn-icon col-lg-5 col-6"><div><i class="fa fa-edit"></i></div></button></a>        '. ($row["estAloja"] == 1 ? '<button type="button" onClick=desactivarAlojamiento(' . $row["idAloja"] . ') class="btn btn-danger col-lg-5 col-6 mt-lg-0 mt-1" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-xmark"></i></div>' : '<button type="button" onClick=activarAlojamiento(' . $row["idAloja"] . ') class="btn btn-success col-lg-5 col-8 mt-lg-0 mt-1col-lg-5 col-8 mt-lg-0 mt-1" data-toggle="tooltip-primary" data-placement="top"><div><i class="fa-solid fa-check"></i></div>');
           $sub_array[] = '  
                <div class="btn-group ms-2">
                    <button type="button" class="btn btn-purple" 
                        onClick="mostrarOcupacion(\'' . $row["token"] . '\', \'' . $nombreCompleto . '\')" 
                        title="Ver Personas en Alojamientos" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modal-calendario">
                        <i class="fa-solid fa-users"></i>
                    </button>
                </div>';


            $sub_array[] = '
            <div class="btn-group">
                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-house-circle-check"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button type="button" onClick="getIdAloja(\'' . $row["token"] . '\')" title="Añadir Visitas" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#insertar-visitas-modal">Añadir Visita</button>
                    </li>
                    <li>
                        <a class="dropdown-item" href="consultarVisitas.php?id=' . $row["token"] . '">Ver Visitas</a>
                    </li>
                </ul>
            </div>';

            $sub_array[] = '
            <div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-comments"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button type="button" onClick="getIdAlojaOpi(\'' . $row["idAloja"] . '\')" class="dropdown-item">Añadir Opiniones</button>
                    </li>
                    <li>
                        <a class="dropdown-item" href="consultarOpiniones.php?idAloja=' . $row["token"] . '">Ver Opiniones</a>
                    </li>
                </ul>
            </div>';
        


            /*  $sub_array[] = '<a href="addAlumnos.php?idAloja=' . $row["idAloja"] . '">
           <button type="button" title="Añadir Alumnos" role="button" class="btn btn-dark btn-icon"><i class=" fas fa-user-plus"></i></button></a>  
            <a href="consultarAlumnos.php?idAloja=' . $row["idAloja"] . '">"
            <button type="button" title="Consultar Alumnos" role="button" class="btn btn-orange btn-icon">
            <i class=" fas fa-users"></i></button></a>    '; */


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
    case "listarAlojamiento2":
        // ALUMNO
        session_start();

        $idAlumn = $_SESSION["usuPre_idInscripcion"];
        $datos = $alojamiento->listarAlojamiento2($idAlumn);

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idAloja"];
            $sub_array[] = $row["descrTiposAloja"];
            $sub_array[] = $row["nombreAloja"] . ' ' . $row["apeAloja"];
            $sub_array[] = FechaLocal($row["fecEntradaAlumAloja"]);
            $sub_array[] = '<b class="tx-warning">' .horaLocalSinSegundos($row["horaSalidaAlumAloja"]).'</b> '. FechaLocal($row["fecSalidaAlumAloja"])  ;

            $sub_array[] = $row["dirAloja"] . ' ' . $row["cpAloja"] . ' ' . $row["poblaAloja"] . ' ' . $row["proviAloja"];
            if ($row["estMostrarAlumAloja"] == 1) {
                $sub_array[] = '<a href="../Alojamientos/datosAlojamiento.php?idAloja=' . $row["token"] . '"<button type="button" title="Ver Opiniones" role="button" class="btn btn-secondary btn-icon"><i class="fas fa-eye"></i></button> </a> ';
            } else {
                $sub_array[] = '<button type="button" title="No disponible" role="button" class="btn btn-secondary btn-icon" disabled>
                  <i class="fas fa-eye-slash"></i>
                </button> ';
            }
            $datos = $alojamiento->consultarOpinionxId($row["idAlumno"], $row["idAloja"]); // CONSULTAMOS SI TIENE OPINION AÑADIDA
            
            if ($datos == 'false' || $datos == null) { // NO TIENE OPINIONES
                $sub_array[] = ' <button type="button" onClick = getIdAlojaOpi("' . $row["idAloja"] . '","' . $row["idInscripcion_tmAlumno"] . '") title="Añadir comentario" role="button" class="btn btn-info btn-icon"><i class="fas fa-comments"></i></button>';
            } else { // SI TIENE, MOSTRAMOS BOTON EDITAR
                $sub_array[] = '<button type="button"  onClick = getIdAlojaOpi("' . $row["idAloja"] . '","' . $row["idInscripcion_tmAlumno"] . '") title="Editar comentario" role="button" class="btn btn-primary btn-icon" ><i class="fa fa-edit"></i></button> ';
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

        // NUEVO CASE PARA ALOJAMIENTOS EN PERFIL (USUARIO ESTÁNDAR, EN PERFIL/EDUCACIÓN)
        case "listarAlojamientoHistorico":
    // ALUMNO - HISTÓRICO DE ALOJAMIENTOS
    session_start();

    $idAlumn = $_SESSION["usuPre_idInscripcion"];
    $datos = $alojamiento->listarAlojamientoHistorico($idAlumn);

    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();

        $sub_array[] = $row["idAloja"];
        $sub_array[] = $row["descrTiposAloja"];
        $sub_array[] = $row["nombreAloja"] . ' ' . $row["apeAloja"];
        $sub_array[] = FechaLocal($row["fecEntradaAlumAloja"]);
        $sub_array[] = '<b class="tx-warning">' . horaLocalSinSegundos($row["horaSalidaAlumAloja"]) . '</b> ' . FechaLocal($row["fecSalidaAlumAloja"]);

        $sub_array[] = $row["dirAloja"] . ' ' . $row["cpAloja"] . ' ' . $row["poblaAloja"] . ' ' . $row["proviAloja"];

        if ($row["estMostrarAlumAloja"] == 1) {
            $sub_array[] = '<a href="../Alojamientos/datosAlojamiento.php?idAloja=' . $row["token"] . '"<button type="button" title="Ver Opiniones" role="button" class="btn btn-secondary btn-icon"><i class="fas fa-eye"></i></button> </a> ';
        } else {
            $sub_array[] = '<button type="button" title="No disponible" role="button" class="btn btn-secondary btn-icon" disabled>
              <i class="fas fa-eye-slash"></i>
            </button> ';
        }

        $datosOpinion = $alojamiento->consultarOpinionxId($row["idAlumno"], $row["idAloja"]);

        if ($datosOpinion == 'false' || $datosOpinion == null) {
            $sub_array[] = ' <button type="button" onClick = getIdAlojaOpi("' . $row["idAloja"] . '","' . $row["idInscripcion_tmAlumno"] . '") title="Añadir comentario" role="button" class="btn btn-info btn-icon"><i class="fas fa-comments"></i></button>';
        } else {
            $sub_array[] = '<button type="button"  onClick = getIdAlojaOpi("' . $row["idAloja"] . '","' . $row["idInscripcion_tmAlumno"] . '") title="Editar comentario" role="button" class="btn btn-primary btn-icon" ><i class="fa fa-edit"></i></button> ';
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


        // MÉTODO PARA OBTENER LOS ALUMNOS QUE HAY DENTRO DE UN ALOJAMIENTO, SE UTILIZA
        // PARA PINTAR EN EL CALENDARIO DE ALOJAMIENTOS A ESOS ALUMNOS
case "alumnosPorAlojamiento":
    // Validación básica
    if (!isset($_POST["token"]) || empty($_POST["token"])) {
        echo json_encode(["error" => "Token no proporcionado"]);
        exit;
    }

    $token = $_POST["token"];
    file_put_contents("debug_alojamiento_token.json", json_encode(["token" => $token]));

    $datos = $alojamiento->listarAlumnosPorTokenAlojamiento($token);

    $datosChart = [];

    foreach ($datos as $fila) {
        // Usamos el nuevo campo 'nombreCompletoAlojamiento'
        $nombre = $fila['nombreCompletoAlojamiento'] . " - " . $fila['nomAlumno'] . " " . $fila['apeAlumno'];
        $fechaInicio = $fila['fecEntradaAlumAloja'];
        $fechaFin = $fila['fecSalidaAlumAloja'];

        $inicio = new DateTime($fechaInicio);
        $fin = new DateTime($fechaFin);

        while ($inicio <= $fin) {
            $datosChart[] = [
                "fecha" => $inicio->format("Y-m-d"),
                "valor" => 5,
                "tooltip" => $nombre
            ];
            $inicio->modify('+1 day');
        }
    }

    echo json_encode($datosChart);
    break;

    case "listarVisitasAlojamiento":

        $idVisita = $_GET['idVisita'];
    
        $datos = $alojamiento->listarVisitasAlojamiento($idVisita);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista las visitas del alojamiento " . $_GET['idVisita']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["IdAlojaVis"];
            $sub_array[] = $row["quienAlojaVis"];
            $sub_array[] = FechaLocal($row["fechaAlojaVis"]);
            $sub_array[] = $row["descrImpreAloja"];

            // botones
            $sub_array[] = '<button type="button" onClick="cargarDatos(' . $row["IdAlojaVis"] . ')" title="Editar Visita" role="button" class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#editar-visitas-modal"><div><i class="fa fa-edit"></i></div></button> <button type="button" onClick=eliminarVisita(' . $row["IdAlojaVis"] . ') title="Eliminar Visita" role="button" class="btn btn-danger btn-icon mt-1 mt-lg-0"><div><i class="fa fa-xmark"></i></div></button>';

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

    case "listarAlumnosAloja":
        $idAloja = $_GET["idAloja"];
        $datos = $alojamiento->listarAlumnosAloja($idAloja);

        // Archivo scasc
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista los alumnos inscritos en el alojamiento " . $_GET['idAloja']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();
    

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idAlum_AlumAloja"];

            $sub_array[] = $row["nomAlumno"]." ".$row["apeAlumno"];
            $sub_array[] = $row["emailUsuario"];
            $sub_array[] = $row["teleAlumno"];
            $sub_array[] = FechaLocal($row["fecEntradaAlumAloja"]);
            $hora2 = new FechaFormato($row["horaSalidaAlumAloja"]);
            $sub_array[] = "<span class='tx-bold'>" . $hora2->horaLocalSinSegundos() . "</span> " . FechaLocal($row["fecSalidaAlumAloja"]);
            $sub_array[] = FechaLocal($row["fecMostrarAlumAloja"]);


            if ($row["estAlumAloja"] == 1) {
                $sub_array[] = "<span class='tx-success tx-bold''><b>Activo</b></span>";
            } elseif ($row["estAlumAloja"] == 0) {
                $sub_array[] = "<span class='tx-warning tx-bold''><b>Desactivado</b></span>";
            }
            //consultar historial consultarAlojas
            $sub_array[] = '
            <a href="../Perfil/?tokenUsuario=' . $row["idAlum_AlumAloja"] . '" target="_blank" title="Ver Perfil" role="button" class="btn btn-primary btn-icon">
                <div><i class="fa fa-user"></i></div>
            </a>
            <a href="../Llegadas/?tokenPreinscripcion=' . $row["idAlum_AlumAloja"] . '" target="_blank" title="Ver Llegada" role="button" class="btn btn-warning btn-icon">
                <div><i class="fa fa-plane-arrival"></i></div>
            </a>
            ';            // FACTURAR
            $sub_array[] = '<a type="button" href="../AlbaranAloja/index.php?idAloja= title="Albaran"  class="btn btn-danger btn-icon col-lg-12" ><div>Sin Albaran</div></a>';

           /*   $datosA = $alojamiento->comprobarEstado($row["idTipoAloja_TipoAloja"],$row["idAlum_AlumAloja"],$row["idAlumAloja"]);
             if(empty($datosA)){
                $sub_array[] = '<a type="button" href="../AlbaranAloja/index.php?idAloja=' . $row['idAloja_AlumAloja'] . '&idAlum=' . $row['idAlum_AlumAloja']. '&idAlumAloja=' . $row['idAlumAloja'] . '" title="Albaran"  class="btn btn-danger btn-icon col-lg-12" ><div>Sin Albaran</div></a>';
             } else if(empty($datosA[0][3])){
                $sub_array[] = '<a type="button" href="../AlbaranAloja/index.php?idAloja=' . $row['idAloja_AlumAloja'] . '&idAlum=' . $row['idAlum_AlumAloja']. '&idAlumAloja=' . $row['idAlumAloja'] . '" title="Albaran"  class="btn btn-warning btn-icon col-lg-12" ><div>Con Albaran</div></a>';
             } else {
                $sub_array[] = '<a type="button" href="../AlbaranAloja/index.php?idAloja=' . $row['idAloja_AlumAloja'] . '&idAlum=' . $row['idAlum_AlumAloja']. '&idAlumAloja=' . $row['idAlumAloja'] . '" title="Albaran"  class="btn btn-success btn-icon col-lg-12" ><div>Facturado</div></a>';
             } */
            //TODO

            // boton ELIMINAR
            $sub_array[] = '
            <div class="d-flex flex-wrap justify-content-center gap-1">
                <button type="button"
                    onClick="cargarDatosEditarAlumnAloja(' . $row["idAlumAloja"] . ')"
                    title="Editar Ficha"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                </button>
            
                ' . ($row["estAlumAloja"] == 1 ?
                    '<button type="button"
                        onClick="desactivarAlumno(' . $row["idAlumAloja"] . ')"
                        class="btn btn-danger btn-sm"
                        title="Desactivar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>' :
                    '<button type="button"
                        onClick="activarAlumno(' . $row["idAlumAloja"] . ')"
                        class="btn btn-success btn-sm"
                        title="Activar">
                        <i class="fa-solid fa-check"></i>
                    </button>'
                ) . '
            </div>';
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

    case "activarAlojamiento":

        $alojamiento->activarAlojamiento($_POST["idAloja"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];

        $logI = new Log($nombreLog, "alojamientos.php", "Activa el alojamiento " . $_POST["idAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;


    case "desactivarAlojamiento":

        $alojamiento->desactivarAlojamiento($_POST["idAloja"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];

        $logI = new Log($nombreLog, "alojamientos.php", "Desactiva el alojamiento " . $_POST["idAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;


        /////////////////////////////
        /// FORMULARIO DETALLES ////
        ///////////////////////////

    case "recogerAlojaId":

        $idAloja = $_POST['idAloja'];
        $datosAlojamiento =  $alojamiento->getAlojamiento_x_id($idAloja);

        $correoAlojamiento = $datosAlojamiento[0]['emailAloja']; // Acceder al campo 'nombre' del registro

        echo json_encode($correoAlojamiento);

        break;
        case "enviarCorreoFamilia":

            $idAloja = $_GET['idAlojamiento'];
            $correo = $_GET['correo'];
           
            $dominio_actual = $_SERVER['HTTP_HOST'];
    
            // MODIFICAR AQUÍ EL DOMINIO
            $url = 'http://' . $dominio_actual . '/N.CostaSV/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . '';
            //$url = 'https://'.$dominio_actual.'/view/Alojamientos/datosAlojamiento.php?idAloja='.$idAloja.'';
    
            // IMAGEN LOGOTIPO CORREO
            $img = 'http://' . $dominio_actual . '/public/img/logo_pequeno.png';
    
            try {
                 //Server settings
                 $mail->isSMTP();
                 $mail->Host = 'innovabyte.es'; // Servidor SMTP
                 $mail->SMTPAuth = true;
                 $mail->Username = 'luiscarlos@innovabyte.es'; // Usuario SMTP
                 $mail->Password = '27979699$C'; // Contraseña SMTP
                 $mail->SMTPSecure = 'ssl'; // Seguridad SSL
                 $mail->Port = 465; // Puerto SMTP
 
                 
                 //Recipients
                 $mail->setFrom('luiscarlos@innovabyte.es', 'Administracion');
            
                $mail->addAddress($correo, '');     //Add a recipient
                /* $mail->addAddress('ellen@example.com'); */               //Name is optional
                /* $mail->addReplyTo('info@example.com', 'Information'); */
                /* $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com'); */
                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
    
                //Attachments
                /* $mail->addAttachment($pdfDoc); */      //Add attachments
                $mail->Subject = 'Presentación de Alojamiento';
    
                $cuerpo = file_get_contents('../public/assetsForm/template/emailAlojamiento.html'); /* Ruta del template en formato HTML */
                /* parametros del template a remplazar */
                $cuerpo = str_replace("imgLogo", $img, $cuerpo);
    
                $cuerpo = str_replace("url", $url, $cuerpo);
    
                $mail->Body    = $cuerpo;
                $mail->AltBody = "Presentación de Alojamiento";
    
                $mail->send();
                $alojamiento->newToken($idAloja);
                echo '1';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            }
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
    
            $logI = new Log($nombreLog, "alojamientos.php", "Se envia un correo por el tema de alojamiento");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
        break;
        /////////////////////////////
        /////////////////////////////
        ///////////////////////////
    case "enviarAvisoAdmin":
        
        $empresa = new Empresa();
        

        $idAloja = $_GET["idAlojamiento"];
        $correo = $empresa->listarEmpresa();
        $correo = $correo[0]['emailEmpresa'];
        $dominio_actual = $_SERVER['HTTP_HOST'];


        // MODIFICAR AQUÍ EL DOMINIO
        /* $url = 'http://' . $dominio_actual . '/proyectos/CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
        $url = 'https://' . $dominio_actual . '/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja;

        // IMAGEN LOGOTIPO CORREO
        $img = 'http://' . $dominio_actual . '/public/img/logo_pequeno.png';

        try {
            //Server settings
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'innovabyte.es'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'luiscarlos@innovabyte.es'; // Usuario SMTP
            $mail->Password = '27979699$C'; // Contraseña SMTP
            $mail->SMTPSecure = 'ssl'; // Seguridad SSL
            $mail->Port = 465; // Puerto SMTP

            
            //Recipients
            $mail->setFrom('luiscarlos@innovabyte.es', 'Administracion');
           
            $mail->addAddress('jose.mvb.cc@gmail.com', 'Costa de Valencia');     //Add a recipient
            /* $mail->addAddress('ellen@example.com'); */               //Name is optional
            /* $mail->addReplyTo('info@example.com', 'Information'); */
            /* $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com'); */
            $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo

            //Attachments
            /* $mail->addAttachment($pdfDoc); */      //Add attachments
            $mail->Subject = 'Presentación de Alojamiento';

            $cuerpo = file_get_contents('../public/assetsForm/template/email.html'); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("imgLogo", $img, $cuerpo);

            $cuerpo = str_replace("url", $url, $cuerpo);

            $mail->Body    = $cuerpo;
            $mail->AltBody = "Presentación de Alojamiento";

            $mail->send();
            echo '1';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];

        $logI = new Log($nombreLog, "alojamientos.php", "Se envia un correo por el tema de alojamiento");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case  "eliminarVisita":

        $alojamiento->eliminarVisita($_POST["idAloja_AlojaVi"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se elimina la visita " . $_POST["idAloja_AlojaVi"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case  "eliminarOpi":

        $alojamiento->eliminarOpi($_POST["idOpi"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se elimina la opinión " . $_GET["idOpi"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case  "eliminarAlumno":

        $alojamiento->eliminarAlumno($_POST["idAlumn"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se elimina el alumno" . $_POST["idAlumn"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

  case "insertarVisitas":
    $idAloja_AlojaVi = $_POST["idAloja_AlojaVi"];
    $quienAlojaVis = ucfirst($_POST["quienAlojaVis"]);
    $fechaAlojaVis = $_POST["fechaAlojaVis"];
    $descrImpreAloja = $_POST["descrImpreAloja"];

    // DEBUG: Guardar datos recibidos en archivo JSON
    $datos_recibidos = [
        "idAloja_AlojaVi" => $idAloja_AlojaVi,
        "quienAlojaVis" => $quienAlojaVis,
        "fechaAlojaVis" => $fechaAlojaVis,
        "descrImpreAloja" => $descrImpreAloja
    ];

    file_put_contents("error1.json", json_encode($datos_recibidos, JSON_PRETTY_PRINT));

    // VALIDACIÓN VAN A IR AQUÍ
    $alojamiento->insertarVisitas($idAloja_AlojaVi, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja);

    // LOG
    $nombreLog = $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
    $logI = new Log($nombreLog, "alojamiento.php", "Se inserta una nueva visita ");
    $logI->grabarLinea();
    unset($logI);

    break;

    case "insertarAlojamiento":


        // GESTION
        $idAlojamientoTexto = !empty($_POST["idAlojamientoTexto"]) ? ucfirst($_POST["idAlojamientoTexto"]) : NULL;

        // AQUI COMPRUEBO QUE NO ESTAN VACIAS, Y SI ESTAN VACIAS LES ASIGNO null
        $nombreAloja = !empty($_POST["nombreAloja"]) ? ucfirst($_POST["nombreAloja"]) : NULL;
        $apeAloja = !empty($_POST["apeAloja"]) ? ucfirst($_POST["apeAloja"]) : NULL;
        $idTipoAloja_TipoAloja = !empty($_POST['selectTipoAloja']) ? $_POST['selectTipoAloja'] : NULL;
        $emailAloja = !empty($_POST['emailAloja']) ? $_POST['emailAloja'] : NULL;
        $nif = !empty($_POST['nifAloja']) ? $_POST['nifAloja'] : NULL;
        $telAloja = !empty($_POST['telAloja']) ? $_POST['telAloja'] : NULL;
        $movilAloja = !empty($_POST['movilAloja']) ? $_POST['movilAloja'] : NULL;
        $dirAloja = !empty($_POST['dirAloja']) ? ucfirst($_POST['dirAloja']) : NULL;
        $poblaAloja = !empty($_POST['poblaAloja']) ? ucfirst($_POST['poblaAloja']) : NULL;
        $proviAloja = !empty($_POST['proviAloja']) ? ucfirst($_POST['proviAloja']) : NULL;
        $cpAloja = !empty($_POST['cpAloja']) ? $_POST['cpAloja'] : NULL;
        $textDatosPublicAloja = !empty($_POST['textDatosPublicAloja']) ? $_POST['textDatosPublicAloja'] : NULL;
        $textDatosPrivateAloja = !empty($_POST['textDatosPrivateAloja']) ? $_POST['textDatosPrivateAloja'] : NULL;
        // CASA
        $metrosAloja = !empty($_POST['metrosAloja']) ? $_POST['metrosAloja'] : NULL;
        $wcAloja = !empty($_POST['wcAloja']) ? $_POST['wcAloja'] : NULL;
        $interAloja = !empty($_POST['interAloja']) ? $_POST['interAloja'] : NULL;
        $fumaAloja = !empty($_POST['fumaAloja']) ? $_POST['fumaAloja'] : NULL;
        $descrFumaAloja = !empty($_POST['descrFumaAloja']) ? $_POST['descrFumaAloja'] : NULL;
        $HabIndiAloja = !empty($_POST['HabIndiAloja']) ? $_POST['HabIndiAloja'] : NULL;
        $HabDobleAloja = !empty($_POST['HabDobleAloja']) ? $_POST['HabDobleAloja'] : NULL;
        $HabTripleAloja = !empty($_POST['HabTripleAloja']) ? $_POST['HabTripleAloja'] : NULL;
        $comidasAloja = !empty($_POST['comidasAloja']) ? $_POST['comidasAloja'] : NULL;
        $descrAnimalesAloja = !empty($_POST['descrAnimalesAloja']) ? $_POST['descrAnimalesAloja'] : NULL;
        $textCasaAloja = !empty($_POST['textCasaAloja']) ? $_POST['textCasaAloja'] : NULL;
        // FAMILIA
        $nomPadreAloja = !empty($_POST['nomPadreAloja']) ? ucfirst($_POST['nomPadreAloja']) : NULL;
        $nomMadreAloja = !empty($_POST['nomMadreAloja']) ? ucfirst($_POST['nomMadreAloja']) : NULL;
        $nacPadreAloja = !empty($_POST['nacPadreAloja']) ? $_POST['nacPadreAloja'] : NULL;
        $nacMadreAloja = !empty($_POST['nacMadreAloja']) ? $_POST['nacMadreAloja'] : NULL;
        $profPadreAloja = !empty($_POST['profPadreAloja']) ? ucfirst($_POST['profPadreAloja']) : null;
        $profMadreAloja = !empty($_POST['profMadreAloja']) ? ucfirst($_POST['profMadreAloja']) : NULL;
        $descrHijosVivenAloja = !empty($_POST['descrHijosVivenAloja']) ? $_POST['descrHijosVivenAloja'] : NULL;
        $aficAloja = !empty($_POST['aficAloja']) ? $_POST['aficAloja'] : NULL;
        // TRANSPORTE
        $linkSituacionAloja = !empty($_POST['linkSituacionAloja']) ? $_POST['linkSituacionAloja'] : NULL;
        $apieAloja = !empty($_POST['apieAloja']) ? $_POST['apieAloja'] : NULL;
        $lineaAutobusAloja = !empty($_POST['lineaAutobusAloja']) ? $_POST['lineaAutobusAloja'] : NULL;
        $minAutobusAloja = !empty($_POST['minAutobusAloja']) ? $_POST['minAutobusAloja'] : NULL;
        $lineaMetroAloja = !empty($_POST['lineaMetroAloja']) ? $_POST['lineaMetroAloja'] : NULL;
        $minMetroAloja = !empty($_POST['minMetroAloja']) ? $_POST['minMetroAloja'] : NULL;
        // ADMINISTRACION
        $hospitalPublicAloja = !empty($_POST['hospitalPublicAloja']) ? ucfirst($_POST['hospitalPublicAloja']) : NULL;
        $consultAloja = !empty($_POST['consultAloja']) ? ucfirst($_POST['consultAloja']) : NULL;
        $hospitalPrivAloja = !empty($_POST['hospitalPrivAloja']) ? ucfirst($_POST['hospitalPrivAloja']) : NULL;
        $pagoAloja = !empty($_POST['pagoAloja']) ? $_POST['pagoAloja'] : NULL;
        $motvBajaAloja = !empty($_POST['motvBajaAloja']) ? ucfirst($_POST['motvBajaAloja']) : NULL;
        $estAloja = !empty($_POST['estAloja']) ? $_POST['estAloja'] : 0;
        $tokenAlojamiento = generarToken();
        $alojamiento->insertarAlojamiento($nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja, $hospitalPublicAloja, $consultAloja, $hospitalPrivAloja, $pagoAloja, $motvBajaAloja, $estAloja, $tokenAlojamiento, $idAlojamientoTexto);

     
        break;

    case "editarAlojamientoAdmin":

        // GESTION
        // AQUI COMPRUEBO QUE NO ESTAN VACIAS, Y SI ESTAN VACIAS LES ASIGNO null
        $idAloja = $_POST["idAloja"];

        $idAlojamientoTexto = !empty($_POST["idAlojamientoTexto"]) ? ucfirst($_POST["idAlojamientoTexto"]) : NULL;

        $nombreAloja = !empty($_POST["nombreAloja"]) ? ucfirst($_POST["nombreAloja"]) : NULL;
        $apeAloja = !empty($_POST["apeAloja"]) ? ucfirst($_POST["apeAloja"]) : NULL;
        $idTipoAloja_TipoAloja = !empty($_POST['selectTipoAloja']) ? $_POST['selectTipoAloja'] : NULL;
        $emailAloja = !empty($_POST['emailAloja']) ? $_POST['emailAloja'] : NULL;
        $nif = !empty($_POST['nifAloja']) ? $_POST['nifAloja'] : NULL;
        $telAloja = !empty($_POST['telAloja']) ? $_POST['telAloja'] : NULL;
        $movilAloja = !empty($_POST['movilAloja']) ? $_POST['movilAloja'] : NULL;
        $dirAloja = !empty($_POST['dirAloja']) ? ucfirst($_POST['dirAloja']) : NULL;
        $poblaAloja = !empty($_POST['poblaAloja']) ? ucfirst($_POST['poblaAloja']) : NULL;
        $proviAloja = !empty($_POST['proviAloja']) ? ucfirst($_POST['proviAloja']) : NULL;
        $cpAloja = !empty($_POST['cpAloja']) ? $_POST['cpAloja'] : NULL;
        $textDatosPublicAloja = !empty($_POST['textDatosPublicAloja']) ? $_POST['textDatosPublicAloja'] : NULL;
        $textDatosPrivateAloja = !empty($_POST['textDatosPrivateAloja']) ? $_POST['textDatosPrivateAloja'] : NULL;
        // CASA
        $metrosAloja = !empty($_POST['metrosAloja']) ? $_POST['metrosAloja'] : NULL;
        $wcAloja = !empty($_POST['wcAloja']) ? $_POST['wcAloja'] : NULL;
        $interAloja = !empty($_POST['interAloja']) ? $_POST['interAloja'] : NULL;
        $fumaAloja = !empty($_POST['fumaAloja']) ? $_POST['fumaAloja'] : NULL;
        $descrFumaAloja = !empty($_POST['descrFumaAloja']) ? $_POST['descrFumaAloja'] : NULL;
        $HabIndiAloja = !empty($_POST['HabIndiAloja']) ? $_POST['HabIndiAloja'] : NULL;
        $HabDobleAloja = !empty($_POST['HabDobleAloja']) ? $_POST['HabDobleAloja'] : NULL;
        $HabTripleAloja = !empty($_POST['HabTripleAloja']) ? $_POST['HabTripleAloja'] : NULL;
        $comidasAloja = !empty($_POST['comidasAloja']) ? $_POST['comidasAloja'] : NULL;
        $descrAnimalesAloja = !empty($_POST['descrAnimalesAloja']) ? $_POST['descrAnimalesAloja'] : NULL;
        $textCasaAloja = !empty($_POST['textCasaAloja']) ? $_POST['textCasaAloja'] : NULL;
        // FAMILIA
        $nomPadreAloja = !empty($_POST['nomPadreAloja']) ? ucfirst($_POST['nomPadreAloja']) : NULL;
        $nomMadreAloja = !empty($_POST['nomMadreAloja']) ? ucfirst($_POST['nomMadreAloja']) : NULL;
        $nacPadreAloja = !empty($_POST['nacPadreAloja']) ? $_POST['nacPadreAloja'] : NULL;
        $nacMadreAloja = !empty($_POST['nacMadreAloja']) ? $_POST['nacMadreAloja'] : NULL;
        $profPadreAloja = !empty($_POST['profPadreAloja']) ? ucfirst($_POST['profPadreAloja']) : null;
        $profMadreAloja = !empty($_POST['profMadreAloja']) ? ucfirst($_POST['profMadreAloja']) : NULL;
        $descrHijosVivenAloja = !empty($_POST['descrHijosVivenAloja']) ? $_POST['descrHijosVivenAloja'] : NULL;
        $aficAloja = !empty($_POST['aficAloja']) ? $_POST['aficAloja'] : NULL;
        // TRANSPORTE
        $linkSituacionAloja = !empty($_POST['linkSituacionAloja']) ? $_POST['linkSituacionAloja'] : NULL;
        $apieAloja = !empty($_POST['apieAloja']) ? $_POST['apieAloja'] : NULL;
        $lineaAutobusAloja = !empty($_POST['lineaAutobusAloja']) ? $_POST['lineaAutobusAloja'] : NULL;
        $minAutobusAloja = !empty($_POST['minAutobusAloja']) ? $_POST['minAutobusAloja'] : NULL;
        $lineaMetroAloja = !empty($_POST['lineaMetroAloja']) ? $_POST['lineaMetroAloja'] : NULL;
        $minMetroAloja = !empty($_POST['minMetroAloja']) ? $_POST['minMetroAloja'] : NULL;
        // ADMINISTRACION
        $hospitalPublicAloja = !empty($_POST['hospitalPublicAloja']) ? ucfirst($_POST['hospitalPublicAloja']) : NULL;
        $consultAloja = !empty($_POST['consultAloja']) ? ucfirst($_POST['consultAloja']) : NULL;
        $hospitalPrivAloja = !empty($_POST['hospitalPrivAloja']) ? ucfirst($_POST['hospitalPrivAloja']) : NULL;
        $pagoAloja = !empty($_POST['pagoAloja']) ? $_POST['pagoAloja'] : NULL;
        $motvBajaAloja = !empty($_POST['motvBajaAloja']) ? ucfirst($_POST['motvBajaAloja']) : NULL;
        $estAloja = !empty($_POST['estAloja']) ? $_POST['estAloja'] : 0;

        $alojamiento->editarAlojamientoAdmin($idAloja, $nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja, $hospitalPublicAloja, $consultAloja, $hospitalPrivAloja, $pagoAloja, $motvBajaAloja, $estAloja, $idAlojamientoTexto);



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se edita el alojamiento " . $_POST["idAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "editarAlojamientoNOAdmin":
        
        // GESTION
        // AQUI COMPRUEBO QUE NO ESTAN VACIAS, Y SI ESTAN VACIAS LES ASIGNO null
        $idAloja = $_POST["idAloja"];
        $nombreAloja = !empty($_POST["nombreAloja"]) ? ucfirst($_POST["nombreAloja"]) : NULL;
        $apeAloja = !empty($_POST["apeAloja"]) ? ucfirst($_POST["apeAloja"]) : NULL;
        $idTipoAloja_TipoAloja = !empty($_POST['selectTipoAloja']) ? $_POST['selectTipoAloja'] : NULL;
        $emailAloja = !empty($_POST['emailAloja']) ? $_POST['emailAloja'] : NULL;
        $nif = !empty($_POST['nifAloja']) ? $_POST['nifAloja'] : NULL;
        $telAloja = !empty($_POST['telAloja']) ? $_POST['telAloja'] : 'NULL';
        $movilAloja = !empty($_POST['movilAloja']) ? $_POST['movilAloja'] : NULL;
        $dirAloja = !empty($_POST['dirAloja']) ? ucfirst($_POST['dirAloja']) : NULL;
        $poblaAloja = !empty($_POST['poblaAloja']) ? ucfirst($_POST['poblaAloja']) : NULL;
        $proviAloja = !empty($_POST['proviAloja']) ? ucfirst($_POST['proviAloja']) : NULL;
        $cpAloja = !empty($_POST['cpAloja']) ? $_POST['cpAloja'] : NULL;
        $textDatosPublicAloja = !empty($_POST['textDatosPublicAloja']) ? $_POST['textDatosPublicAloja'] : NULL;
        $textDatosPrivateAloja = !empty($_POST['textDatosPrivateAloja']) ? $_POST['textDatosPrivateAloja'] : NULL;
     
        // CASA
        $metrosAloja = !empty($_POST['metrosAloja']) ? $_POST['metrosAloja'] : NULL;
        $wcAloja = !empty($_POST['wcAloja']) ? $_POST['wcAloja'] : NULL;
        $interAloja = !empty($_POST['interAloja']) ? $_POST['interAloja'] : NULL;
        $fumaAloja = !empty($_POST['fumaAloja']) ? $_POST['fumaAloja'] : NULL;
        $descrFumaAloja = !empty($_POST['descrFumaAloja']) ? $_POST['descrFumaAloja'] : NULL;
        $HabIndiAloja = !empty($_POST['HabIndiAloja']) ? $_POST['HabIndiAloja'] : NULL;
        $HabDobleAloja = !empty($_POST['HabDobleAloja']) ? $_POST['HabDobleAloja'] : NULL;
        $HabTripleAloja = !empty($_POST['HabTripleAloja']) ? $_POST['HabTripleAloja'] : NULL;

        $comidasAloja = !empty($_POST['comidasAloja']) ? $_POST['comidasAloja'] : NULL;
        $descrAnimalesAloja = !empty($_POST['descrAnimalesAloja']) ? $_POST['descrAnimalesAloja'] : NULL;
        $textCasaAloja = !empty($_POST['textCasaAloja']) ? $_POST['textCasaAloja'] : NULL;
        // FAMILIA
        $nomPadreAloja = !empty($_POST['nomPadreAloja']) ? ucfirst($_POST['nomPadreAloja']) : NULL;
        $nomMadreAloja = !empty($_POST['nomMadreAloja']) ? ucfirst($_POST['nomMadreAloja']) : NULL;
        $nacPadreAloja = !empty($_POST['nacPadreAloja']) ? $_POST['nacPadreAloja'] : NULL;
        $nacMadreAloja = !empty($_POST['nacMadreAloja']) ? $_POST['nacMadreAloja'] : NULL;
        $profPadreAloja = !empty($_POST['profPadreAloja']) ? ucfirst($_POST['profPadreAloja']) : null;
        $profMadreAloja = !empty($_POST['profMadreAloja']) ? ucfirst($_POST['profMadreAloja']) : NULL;
        $descrHijosVivenAloja = !empty($_POST['descrHijosVivenAloja']) ? $_POST['descrHijosVivenAloja'] : NULL;
        $aficAloja = !empty($_POST['aficAloja']) ? $_POST['aficAloja'] : NULL;
        // TRANSPORTE
        $linkSituacionAloja = !empty($_POST['linkSituacionAloja']) ? $_POST['linkSituacionAloja'] : NULL;
        $apieAloja = !empty($_POST['apieAloja']) ? $_POST['apieAloja'] : NULL;
        $lineaAutobusAloja = !empty($_POST['lineaAutobusAloja']) ? $_POST['lineaAutobusAloja'] : NULL;
        $minAutobusAloja = !empty($_POST['minAutobusAloja']) ? $_POST['minAutobusAloja'] : NULL;
        $lineaMetroAloja = !empty($_POST['lineaMetroAloja']) ? $_POST['lineaMetroAloja'] : NULL;
        $minMetroAloja = !empty($_POST['minMetroAloja']) ? $_POST['minMetroAloja'] : NULL;
        // ADMINISTRACION
        $hospitalPublicAloja = !empty($_POST['hospitalPublicAloja']) ? ucfirst($_POST['hospitalPublicAloja']) : NULL;
        $consultAloja = !empty($_POST['consultAloja']) ? ucfirst($_POST['consultAloja']) : NULL;
        $hospitalPrivAloja = !empty($_POST['hospitalPrivAloja']) ? ucfirst($_POST['hospitalPrivAloja']) : NULL;
        $pagoAloja = !empty($_POST['pagoAloja']) ? $_POST['pagoAloja'] : NULL;
        $motvBajaAloja = !empty($_POST['motvBajaAloja']) ? ucfirst($_POST['motvBajaAloja']) : NULL;
        $estAloja = !empty($_POST['estAloja']) ? $_POST['estAloja'] : NULL;
       
        $alojamiento->editarAlojamientoNOAdmin($idAloja, $nombreAloja, $apeAloja, $idTipoAloja_TipoAloja, $emailAloja, $nif, $telAloja, $movilAloja, $dirAloja, $poblaAloja, $proviAloja, $cpAloja, $textDatosPublicAloja, $textDatosPrivateAloja, $metrosAloja, $wcAloja, $interAloja, $fumaAloja, $descrFumaAloja, $HabIndiAloja, $HabDobleAloja, $HabTripleAloja, $comidasAloja, $descrAnimalesAloja, $textCasaAloja, $nomPadreAloja, $nomMadreAloja, $nacPadreAloja, $nacMadreAloja, $profPadreAloja, $profMadreAloja, $descrHijosVivenAloja, $aficAloja, $linkSituacionAloja, $apieAloja, $lineaAutobusAloja, $minAutobusAloja, $lineaMetroAloja, $minMetroAloja);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "El anfitrión o la anfitriona edita el alojamiento " . $nombreAloja . '' . $_POST["idAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        break;

    case "listarUsuariosSelectFiltrado":
        $id = $_GET['id'];
        $datos = $alojamiento->listarUsuariosFiltrado($id);
        echo json_encode($datos);

        break;

    case "listarUsuariosSelect":
        $datos = $alojamiento->listarUsuarios();
        echo json_encode($datos);

        break;

    case "insertarAlumnos":
        $idAloja = $_POST["idAloja"];
        $idAlumno = $_POST["idAlumno"];
        $fecMuestraAlumAloja = $_POST["fechaMuestra"];
        $fecEntradaAlumAloja = $_POST["fecEntradaAlumAloja"];
        $fecSalidaAlumAloja = $_POST["fecSalidaAlumAloja"];
        $horaSalidaAlumAloja = $_POST["horaSalidaAlumAloja"];
        $estado = $_POST["status"];

        $alojamiento->insertarAlumnos($idAlumno, $idAloja, $fecEntradaAlumAloja, $fecSalidaAlumAloja, $horaSalidaAlumAloja, $fecMuestraAlumAloja, $estado);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se inserta un nuevo alumno");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        break;

    case "insertarOpis":
        $idUsu = $_GET["idAlumn"];
        $idUsu_IdOpi = $_POST["nombreOpi"];
        $IdAloja_idOpi = $_POST["idAloja_AlojaOpi"];
        $score = $_POST["score"];
        $descrOpi = $_POST["descrAlojaOpi"];
        $fechaOpi = $_POST["fechaAlojaOpi"];



        $alojamiento->comprobarOpisAloja($idUsu_IdOpi, $IdAloja_idOpi, $score, $descrOpi, $fechaOpi);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se inserta una nueva opinión");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
    case "insertarOpis2":

        $idUsu_IdOpi = $_SESSION["usu_id"];
        $IdAloja_idOpi = $_POST["idAloja_AlojaOpi"];
        $score = $_POST["score"];
        $descrOpi = $_POST["descrAlojaOpi"];
        $fechaOpi = $_POST["fechaAlojaOpi"];

        $alojamiento->comprobarOpisAloja($idUsu_IdOpi, $IdAloja_idOpi, $score, $descrOpi, $fechaOpi);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se inserta una nueva opinión");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "listarOpisAlojamiento":
        $idAloja = $_GET["idAloja"];
        $datos = $alojamiento->listarOpisAloja($idAloja);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista las opiniones del alojamiento.");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idOpi"];
            $sub_array[] = $row["nomUsuario"];
            $sub_array[] = $row["emailUsuario"];
            $sub_array[] = $row["teleAlumno"];
            $sub_array[] = $row["ratingOpi"];
            $sub_array[] = $row["descrOpi"];
            $sub_array[] = FechaLocal($row["fechaOpi"]);

            if ($row["estOpi"] == 1) {
                // boton desactivar
                $sub_array[] =   '<button type="button" onClick=desactivar(' . $row["idOpi"] . ') title="Desactivar Opinión" role="button" class="btn btn-danger btn-icon"><div><i class="fa fa-xmark"></i></div></button>   ';
            } else {
                // boton activar
                $sub_array[] = ' <button type="button" onClick=activar(' . $row["idOpi"] . ') title="Activar Opinión" role="button" class="btn btn-success btn-icon"><div><i class="fa-solid fa-check"></i></div></button>    ';
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

    case "cargarDatosEditar":
        $datos = $alojamiento->getVisita_x_id($_POST['idVis']);

        echo json_encode($datos);
        break;
    case "editarVisita":

        $idVis = $_POST["idVis"];
        $quienAlojaVis = ucfirst($_POST["quienAlojaVis"]);
        $fechaAlojaVis = $_POST["fechaAlojaVis"];
        $descrImpreAloja = $_POST["descrImpreAloja"];
        // VALIDACION VAN A IR AQUI
        $alojamiento->editarVisita($idVis, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se edita la visita " . $idVis);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;



    case "activarOpi":

        $alojamiento->activarOpi($_POST["idOpi"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se activiva la opinión " . $_POST['idOpi']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "desactivarOpi":

        $alojamiento->desactivarOpi($_POST["idOpi"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se desactiviva la opinión " . $_POST['idOpi']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "obtenerOpiId":

        $datosOpi = $alojamiento->get_Opi_x_id($_POST["idOpi"]);

        echo json_encode($datosOpi);

        break;
    case "editarOpi":

        $idOpi = $_POST["idAloja_AlojaOpi"];
        $rating = $_POST["rating"];
        $descrImpreAloja = $_POST["descrAlojaOpi"];

        // VALIDACION VAN A IR AQUI
        $alojamiento->editarOpi($idOpi, $rating, $descrImpreAloja);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se edita la opinión " . $_POST['idOpi']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;
    case "cargarDatosEditarAlumnAloja":
        $idAlumAloja = $_POST["idAlumAloja"];
        $datos = $alojamiento->get_AlumnAloja_x_id($idAlumAloja);
    
        echo json_encode($datos);
        break;

    case "editarAlumnAloja":

        $nombreOpi = $_POST["nombreOpi"];
        $idAlumAloja = $_POST["idAlumAloja"];
        $fechamuestra = $_POST["fechamuestra"];
        $fechaentrada = $_POST["fechaentrada"];
        $fechasalida = $_POST["fechasalida"];
        $estado = $_POST["estado"];

        // VALIDACION VAN A IR AQUI
        $alojamiento->editarAlumnAloja($idAlumAloja, $fechamuestra, $fechaentrada, $fechasalida, $estado);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se edita el alumno " . $nombreOpi . "del alojamiento " . $_GET["idAloja"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "activarAlumnAloja":

        $alojamiento->activarAlumnAloja($_POST["idAlumn"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se activiva el alumno " . $_POST['idAlumn']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;

    case "desactivarAlumnAloja":

        $alojamiento->desactivarAlumnAloja($_POST["idAlumn"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se desactiviva el alumno " . $_POST['idAlumn']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG
        break;
    case "historialAlumnosAloja":
        $idAloja = $_GET["idAlumnAloja"];
        $datos = $alojamiento->obtenerHistorial($idAloja);

        // Archivo scasc
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Lista los alumnos inscritos en el alojamiento " . $_GET['idAloja']);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG


        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idAlum_AlumAloja"];
            /*  $sub_array[] = '<input type="hidden" id="nomUsu" name="nomUsu" value="$row["nomUsuario"]" '  ; */
            $sub_array[] = $row["nomAlumno"]." ".$row["apeAlumno"];
            $sub_array[] = $row["descrTiposAloja"];
            $sub_array[] = FechaLocal($row["fecEntradaAlumAloja"]);
            $hora2 = new FechaFormato($row["horaSalidaAlumAloja"]);
            $sub_array[] = "<span class='tx-bold'>" . $hora2->horaLocalSinSegundos() . "</span> " . FechaLocal($row["fecSalidaAlumAloja"]);
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
    case "comprobarEstadoOpi":
        $idAlum = $_POST["idUsu"];
       
        $idAloja = $_POST["idAloja_AlojaOpi"];
        $score = $_POST["score"];
        $descrOpi = $_POST["descrAlojaOpi"];
        $fechaOpi = $_POST["fechaAlojaOpi"];
        $result = $alojamiento->comprobarOpisAloja($idAlum, $idAloja, $score, $descrOpi, $fechaOpi);
        break;
    case "getAlojaOpi":
        $idAloja = $_GET["idAloja"];
        $idUsu = $_GET["idUsu"];

        $resultado = $alojamiento->getopi($idAloja, $idUsu);
        echo json_encode($resultado);
        break;

        // select addalumnos.php //

    case "comprobarAlumnoSelect":
        $idAlumno = $_POST["idAlumno"];
        $idAloja = $_POST["idAloja"];

        $resultado = $alojamiento->comprobarAlumnoSelect($idAlumno, $idAloja);

        echo json_encode($resultado);
        break;
    case "listarAlumnosAlojaTarifa":
  
        $datos = $alojamiento->listarAlumnosAlojaTarifa();

        $data = array();


        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["id_llegada"];
            $sub_array[] = $row["nomPrescripcion"]." ".$row["apePrescripcion"];
            $sub_array[] = $row["nombreTarifa_alojamientos"];
            $sub_array[] = fechaLocal($row["fechaInicioAlojamientos"]);
            $sub_array[] = fechaLocal($row["fechaFinAlojamientos"]);

            $sub_array[] = '<a href="../Perfil/?tokenUsuario='.$row["tokenPrescriptores"].'"  target="_blank" type="button" title="Ver Perfil" " role="button" class="btn btn-primary btn-icon" ><div><i class="fa fa-user"></i></div></a>  <a href="../Llegadas/?tokenPreinscripcion='.$row["tokenPrescriptores"].'" target="_blank" type="button" title="Ver Llegada" " role="button" class="btn btn-warning btn-icon" ><div><i class="fa fa-plane-arrival"></i></div></a> ';
            $sub_array[] = $row["tokenPrescriptores"];

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
        
}

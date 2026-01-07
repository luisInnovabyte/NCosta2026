<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Personal_Edu.php");
require_once("../models/Usuario.php");

session_start();
require_once("../models/Log.php");

$personal = new Personal();
$usuario = new Usuario();



// CORREO //
require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


switch ($_GET["op"]) {

    case "listarPersonal":

        $datos = $personal->listarPersonalTodos();



        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Lista los personales");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();



        foreach ($datos as $row) {
            $sub_array = array();


            $sub_array[] = '<p class="">' . $row["idPersonal"] . '</p>';
            $sub_array[] = '<p class="">' . $row["nomPersonal"] . ' ' . $row["apePersonal"] . '</p>';
            $sub_array[] = '<p class="">' . $row["dirPersonal"] . ' - ' . $row["poblaPersonal"] . ' - ' . $row["cpPersonal"] . ' - ' . $row["provPersonal"] . ' - ' . $row["paisPersonal"] . '</p>';
            $sub_array[] = '<p class=""><a href="tel:' . $row["tlfPersonal"] . '">' . $row["tlfPersonal"] . '</a><a href="tel:' . $row["movilPersonal"] . '"> - ' . $row["movilPersonal"] . '</a></p>';
            $sub_array[] = '<p class=""><a href="mailto:' . $row["emailUsuario"] . '">' . $row["emailUsuario"] . '</a></p>';

            if ($row["rolUsuario"] == 0) {
                $sub_array[] = '<label class="tx-bold badge bg-dark tx-14-force"> Alumno </label>';
            } else if ($row["rolUsuario"] == 1) {
                $sub_array[] = '<label class="tx-bold badge bg-primary tx-14-force"> Administrador </label>';
            } else if ($row["rolUsuario"] == 2) {
                $sub_array[] = '<label class="tx-bold badge bg-info tx-14-force"> Profesor </label>';
            }

            if ($row["estPersonal"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-bold tx-14-force">Activo</p>';
            } elseif ($row["estPersonal"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-bold tx-14-force">Desactivado</p>';
            }



            // BOTONES DE ACCIONES
            if ($row["estPersonal"] == 1) {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' .  $row['idPersonal']. ')" id="' . $row["idPersonal"] . '" class="btn btn-primary btn-icon" data-placement="top" title="Editar Persona"><div><i class="fa fa-edit"></i></div></button> 
                
                <button type="button" onClick="cambiarEstado(' . $row["idPersonal"] . ');"  id="' . $row["idPersonal"] . '" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Persona"><div><i class="fa-solid fa-xmark"></i></div></button>';

            } else {
                $sub_array[] = ' <button type="button" onClick="cargarElemento(' .  $row['idPersonal']. ')"  id="' . $row["idPersonal"] . '" class="btn btn-primary btn-icon"  data-placement="top" title="Editar Persona"><div><i class="fa fa-edit"></i></div></button>
                <button type="button" onClick="cambiarEstado(' . $row["idPersonal"] . ');"  id="' . $row["idPersonal"] . '" class="btn btn-success btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Activar Persona"><div><i class="fa-solid fa-check"></i></div></button>';

            }
            if ($row["rolUsuario"] == 0) {
                $sub_array[] = ' <button type="button" disabled  class="btn btn-danger btn-icon" data-placement="top" title="Cursos"><div><i class="fa-solid fa-book-bookmark"></i></div></button>';
            } else if ($row["rolUsuario"] == 1) {
                $sub_array[] = ' <button type="button" disabled  class="btn btn-danger btn-icon" data-placement="top" title="Cursos"><div><i class="fa-solid fa-book-bookmark"></i></div></button>';
            } else if ($row["rolUsuario"] == 2) {
                $sub_array[] = ' <button type="button" onClick="cargarModalCursos(' .  $row['idPersonal']. ')" id="' . $row["idPersonal"] . '" class="btn btn-success btn-icon" data-placement="top" title="Cursos"><div><i class="fa-solid fa-book-bookmark"></i></div></button>';
            }


            $sub_array[] = ' <a href="../Documentos/contrato.php?idPersonal=' . $row['idPersonal'] . '"' . '  id="' . $row["idPersonal"] . '" class="btn btn-dark btn-icon"  data-placement="top" title="Ver Contratos"><div><i class="fas fa-clipboard-list"></i></div></button></a> ';
            $sub_array[] = ' <button type="button" onClick="cargarElementoSend(' .  $row['idPersonal']. ')" id="' . $row["idPersonal"] . '" class="btn btn-warning btn-icon" data-placement="top" title="Gestionar"><div><i class="fas fa-file"></i></div></button><a href="../MntAsistencia/?buscar='.$row["nomPersonal"] . ' ' . $row["apePersonal"] . ' " class="btn btn-info btn-icon mg-l-10"  data-placement="top" title="Ver Asistencias"><div><i class="fa-solid fa-business-time"></i></div></button></a> ';
            //$sub_array[] = ' <a href="../Documentos/documentopersonal.php?idPersonal=' . $row['idPersonal'] . '"' . '  id="' . $row["idPersonal"] . '" class="btn btn-info btn-icon"  data-placement="top" title="Ver Documentos"><div><i class="fas fa-file-image"></i></div></button> ';
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
        case "cargarRutasPersonal":

            $idPersonal = $_GET['idPersonal'];
            
    
            $datos = $personal->cargarRutasPersonal($idPersonal);
    
    
            // Archivo LOG
            $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
            $logI = new Log($nombreLog, "personal_Edu.php", "Lista los personales");
            $logI->grabarLinea();
            unset($logI);
            // FIN del archivo LOG
    
            $data = array();
    
    
    
            foreach ($datos as $row) {
                $sub_array = array();
    
    
                $sub_array[] = '<p class="">' . $row["id_personalRPersonal"] . '</p>';
                $sub_array[] = '<p class="">' . $row["nomPersonal"] . ' ' . $row["apePersonal"] . '</p>';
                $sub_array[] = '<p class="">' . $row["descrIdioma"] . ' - ' . $row["codIdioma"].'</p>';
                $sub_array[] = '<p class="">' . $row["descrTipo"] . ' - '.$row["codTipo"].'</p>';
                $sub_array[] = "<label class='badge bg-success tx-14-force'>".$row['codNivelDesde']."</label>";
                $sub_array[] = "<label class='badge bg-danger tx-14-force'>".$row['codNivelHasta']."</label>";

                
                $sub_array[] = "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Curso' onClick='eliminarRuta(" . $row["idRutasProfesorado"] . ")'><i class='fa fa-xmark'></i></button>";


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
        
    case "recogerPersonal":

        $datosPersonal = $personal->listarPersonal();

        echo json_encode($datosPersonal);


    break;
  
    case "recogerDepaPersonalxId":

        session_start();
        $idUsu = $_SESSION['usuPre_idInscripcion'];
       
        $depaPersonal = $personal->depaPersonalxId($idUsu);
        $cantidadResultados = count($depaPersonal);
  
        if($cantidadResultados == 1){
            $_SESSION['llegada_nombreDepartamento'] =  $depaPersonal[0]['nombreDepartamento'];
            $_SESSION['llegada_idDepartamento'] =  $depaPersonal[0]['idDepartamentoEdu'];
            $_SESSION['llegada_colorDepartamento'] = trim($depaPersonal[0]['colorDepartamento']);

            echo 'only';
        }else{
            echo json_encode($depaPersonal);
        }
    break;

    case "guardarDatosDepartamento":

    $depaSelectSelect = $_POST["depaSelect"];
    $nombreDepartamento = $_POST["nombreDepartamento"];
    $colorDepartamento = trim($_POST["colorDepartamento"]);

    $_SESSION['llegada_nombreDepartamento'] = $nombreDepartamento;
    $_SESSION['llegada_idDepartamento'] = $depaSelectSelect;
    $_SESSION['llegada_colorDepartamento'] = $colorDepartamento; // nuevo campo en sesión

    echo $nombreDepartamento;

    /*
    echo json_encode($dato);
    */
    break;

    case "insertarPersonal":


        $error = '';
        $nomPersonal = ucfirst($_POST["nomPersonal"]);
        $apePersonal = ucfirst($_POST["apePersonal"]);
        $usuPersonal = $_POST["usuPersonal"];
        $senaPersonal =  $_POST["senaPersonal"];
        $dirPersonal = ucfirst($_POST["dirPersonal"]);
        $poblaPersonal = ucfirst($_POST["poblaPersonal"]);
        $cpPersonal = $_POST["cpPersonal"];
        $provPersonal = ucfirst($_POST["provPersonal"]);
        $paisPersonal = ucfirst($_POST["paisPersonal"]);
        $tlfPersonal = $_POST["tlfPersonal"];
        $movilPersonal = $_POST["movilPersonal"];
        $emailPersonal = $_POST["emailPersonal"];
        $rolPersonal = $_POST["rolSelec"];
        $departamentos = $_POST["departamentos"];
        $estPersonal = $_POST["estUsu"];
        $tokenPreinscriptor = generarToken(30);


        // VALIDACION VAN A IR AQUI
        $datosUsu = $usuario->get_personal_x_usu($_POST["usuPersonal"],0);
        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            $error = 'Ya existe un usuario con el mismo correo <br>';
        };

        if ($error == "") {

            $personal->insertarPersonal($nomPersonal, $apePersonal, $usuPersonal, $senaPersonal, $dirPersonal, $poblaPersonal, $cpPersonal, $provPersonal, $paisPersonal, $tlfPersonal, $movilPersonal, $emailPersonal, $rolPersonal, $estPersonal, $departamentos, $tokenPreinscriptor);
            echo '1';

        }else{

            echo $error;

        }
        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Se inserta un nuevo personal");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
        

    case "recogerEditar":
        $sub_array = array();
        $datos = $personal->get_personal_x_id($_POST["idPersonal"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {


                $sub_array[] = $row["idPersonal"];
                $sub_array[] = $row["nomPersonal"];
                $sub_array[] = $row["apePersonal"];
                $sub_array[] = $row["emailUsuario"];
                $sub_array[] = $row["senaUsuario"];
                $sub_array[] = $row["dirPersonal"];
                $sub_array[] = $row["poblaPersonal"];
                $sub_array[] = $row["cpPersonal"];
                $sub_array[] = $row["provPersonal"];
                $sub_array[] = $row["paisPersonal"];
                $sub_array[] = $row["tlfPersonal"];
                $sub_array[] = $row["movilPersonal"];
                $sub_array[] = $row["emailPersonal"];
                $sub_array[] = $row["rolUsuario"];
                $sub_array[] = $row["estPersonal"];
                $sub_array[] = $row["departamentosPersonal"];
            }

            echo json_encode($sub_array);
        }
        break;

    case "editarPersonal":

        $idPersonal = $_POST["idPersonalE"];
        $nomPersonal = ucfirst($_POST["nomPersonalE"]);
        $apePersonal = ucfirst($_POST["apePersonalE"]);
        $usuPersonal = $_POST["usuPersonalE"];
        $senaPersonal =  $_POST["senaPersonalE"];
        $dirPersonal = ucfirst($_POST["dirPersonalE"]);
        $poblaPersonal = ucfirst($_POST["poblaPersonalE"]);
        $cpPersonal = $_POST["cpPersonalE"];
        $provPersonal = ucfirst($_POST["provPersonalE"]);
        $paisPersonal = ucfirst($_POST["paisPersonalE"]);
        $tlfPersonal = $_POST["tlfPersonalE"];
        $movilPersonal = $_POST["movilPersonalE"];
        $emailPersonal = $_POST["emailPersonalE"];
        $rolPersonal = $_POST["rolE"];
        $departamentosSelectE = $_POST["departamentos"];


        if (isset($_POST["estUsuE"])) {
            $estPersonal = 1;
        } else {
            $estPersonal = 0; // O cualquier otro valor por defecto que desees
        }
      

         // Obtener el usuario original de la base de datos
        $datosOriginales = $personal->get_personal_x_id($idPersonal);

        if ($datosOriginales[0]['emailUsuario'] != $usuPersonal) {
            
         
            // Solo validar si el usuario ha cambiado
            $datosUsu = $usuario->get_personal_x_usu($usuPersonal, $idPersonal);
            if (is_array($datosUsu) && count($datosUsu) > 0) {
                $error = 'Ya existe un usuario con el mismo nombre de usuario <br>';
            }
        }
        if ($error == "") {

            $personal->editarPersonal($idPersonal, $nomPersonal, $apePersonal, $usuPersonal, $senPersonal, $dirPersonal, $poblaPersonal, $cpPersonal, $provPersonal, $paisPersonal, $tlfPersonal, $movilPersonal, $emailPersonal, $rolPersonal, $estPersonal, $departamentosSelectE);
            echo '1';

        }else{

            echo $error;

        }


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Se edita el personal " .  $_POST["idPersonalE"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "activarPersonal":

        $personal->activarPersonal($_POST["idPersonal"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Se activa el personal " .  $_POST["idPersonal"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
        case "cambiarEstado":
            $idElemento = $_POST["idElemento"];
            $personal->cambiarEstado($idElemento);
            break;

    case "desactivarPersonal":

        $personal->desactivarPersonal($_POST["idPersonal"]);

        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Se desactiva el personal " .  $_POST["idPersonal"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "listarImagenesPersonal":

        $datos = $personal->listarImagenesPersonal($_POST["idPersonal"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Lista los documentos");
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = '<p class="">' . $row["idPersonal"] . '</p>';

            $sub_array[] = '<p><a href="../../public/documentos/personal/' . $row["idPersonal"] . '/' . $row["imgPersoImg"] . '" target="_blank"> '. $row["imgPersoImg"] .'</a></p>';

            // MOSTRAR IMAGEN O LOGO PDF
            if (substr($row["imgPersoImg"], -4) == ".pdf") {
                // mostrar logo pdf
                $sub_array[] = '<a href="../../public/documentos/personal/' . $row["idPersonal"] . '/' . $row["imgPersoImg"] . '" target="_blank"><i class="fa-regular fa-file-pdf fa-2xl"></i></a>';
            } else {
                // mostrar imagen       
                $sub_array[] = '<a href="../../public/documentos/personal/' . $row["idPersonal"] . '/' . $row["imgPersoImg"] . '" target="_blank"><img src="../../public/documentos/personal/' . $row["idPersonal"] . '/' . $row["imgPersoImg"] . '" width="180"></img></a>';
            }
            $sub_array[] = '<p class="">' . $row["descrPersoImg"] . '</p>';
            $sub_array[] = '<p class="">' . $row["fecAltaPersoImg"] . '</p>';

            // BOTONES DE ACCIONES

            $sub_array[] = '<a href="../../public/documentos/personal/' . $row["idPersonal"] . '/' . $row["imgPersoImg"] . '" download style="color: white;" class=""><button type="button" class="btn btn-info btn-icon " title="Descargar documento"><i class="fa-solid fa-file-arrow-down"></i></button></a>     
                <button type="button" onClick="eliminarDocumentoPersonal(' . $row["idPersoImg"] . ')" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="Eliminar documento"><div><i class="fa-solid fa-xmark"></i></div></button>';

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

    case "insertarDocumentoPersonal":

        $idPersonal = $_POST["idPersonal"];
        $descrPersoImg = ucfirst($_POST["descrPersoImg"]);

        $img = $_FILES["files"];
        $img_name = $img["name"];
        $img_tmp_name = $img["tmp_name"];
        $img_size = $img["size"];
        $img_error = $img["error"];

        // FORMATEAMOS NOMBRE PARA QUE NO HAYA NINGUNO IGUAL
        date_default_timezone_set('Europe/Madrid'); // Establecer la zona horaria de Madrid
        $fechaActual = date("Ymd"); // FECHA PARA NAME
        $numeroAleatorio = uniqid(); // Numero aleatorio para que no hayan dos imagenes iguales
        $archivo = $_FILES["files"]["name"][0]; // RECOGEMOS IMG PARA EXTENSION DEL ARCHIVO
        
        $extension = pathinfo($archivo, PATHINFO_EXTENSION); // EXTENSION DEL ARCHIVO 
        $nombreDocumento = $fechaActual . "_". $numeroAleatorio . "." . $extension; // METER AQUÍ VARIABLES PERSONALIZADOS SEGÚN SITUACIÓN

       
        $directorio = "../public/documentos/personal/$idPersonal/";


        // CAMINO FINAL HACIA DONDE SE DEBE COPIAR
        $archivoFinal = $directorio . $nombreDocumento;

        // Crear carpeta imagenes 

        if (!file_exists("../public/documentos/personal/$idPersonal")) {
            mkdir("../public/documentos/personal/$idPersonal", 0777);
        }

       
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {



            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $archivoFinal)) {

                // INSERTAMOS EN BBDD // 

                $nomImg = $nombreDocumento;

                $personal->insertarDocumentoPersonal($idPersonal, $descrPersoImg, $nomImg);

                session_start();
                
                require_once("../models/Log.php");

                // Archivo LOG
                $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
                $logI = new Log($nombreLog, "personal_Edu.php", "Se inserta un nuevo documento ");
                $logI->grabarLinea();
                unset($logI);
                // FIN del archivo LOG

                echo '1';
            }
        }

        break;

    case "eliminarDocumentoPersonal":

        $personal->eliminarDocumentoPersonal($_POST["idPersoImg"]);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "personal_Edu.php", "Se elimina el documento " .  $_POST["idPersoImg"]);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;

    case "cargarDatosEditar":
        $datos = $personal->getDocumento_x_id($_POST['idOpi']);

        echo json_encode($datos);
        break;
    case "editarDocumentos":

        $idVis = $_POST["idOpi"];
        $quienAlojaVis = ucfirst($_POST["quienAlojaVis"]);
        $fechaAlojaVis = $_POST["fechaAlojaVis"];
        $descrImpreAloja = $_POST["descrImpreAloja"];
        // VALIDACION VAN A IR AQUI
        $personal->editarDocumento($idVis, $quienAlojaVis, $fechaAlojaVis, $descrImpreAloja);


        // Archivo LOG
        $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
        $logI = new Log($nombreLog, "alojamientos.php", "Se edita la visita " . $idVis);
        $logI->grabarLinea();
        unset($logI);
        // FIN del archivo LOG

        break;
        case "enviarCredenciales":

            $correo = $_POST["email"];
            $password = $_POST["password"];
    
            $dominio_actual = $_SERVER["SERVER_NAME"];
    
    
              // Archivo LOG
              session_start();
              require_once("../models/Log.php");
              $nombreLog =  $_SESSION['usu_id'] . " - " . $_SESSION['usu_nom'];
              $logI = new Log($nombreLog, "usuario.php", "Envia correo credenciales".$correo);
              $logI->grabarLinea();
              unset($logI);
              //Fin Log
    
    
            $url = 'https://' . $dominio_actual . '';
            //$url = 'https://' . $dominio_actual . '/view/RecPass/RecPass.php?idUsu=' . $idUsuCifrada;
    
    
       
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
                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
    
                //Attachments
                $mail->Subject = 'Bienvenido a Costa de Valencia';
    
                $cuerpo = file_get_contents("../public/CorreoCredencialesPersonal.html"); /* Ruta del template en formato HTML */
                /* parametros del template a remplazar */
                $cuerpo = str_replace("url", $url, $cuerpo);
    
                $cuerpo = str_replace("userInput", $correo, $cuerpo);
                $cuerpo = str_replace("passInput", $password, $cuerpo);
    
    
    
                $mail->Body    = $cuerpo;
                $mail->AltBody = "Bienvenido - Costa de Valencia";
      
                $mail->send();
    
                echo '1';
            } catch (Exception $e) {
    
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    
            break;
              // APARTADO ENVIO DE PERSONAL
    case "enviarCorreoPersonal":
     
        $idPersonal = $_POST["idPersonal"];
        $correoSelect = $_POST["correoSelect"];

        $nuevoUsuCheck = $_POST["nuevoUsuCheck"];

        $datosPersonal = $personal->get_personal_x_id($idPersonal);
     
        if($datosPersonal == 0){
           
            
        }else{
           
            //$correo = $datosInteresado[0]['correoUsu'];
            $correo = $correoSelect; // correo del input
            $nombreUsuario = $datosPersonal[0]['emailUsuario'];
            $apellidoUsuario = $datosPersonal[0]['apellidosUsu'];
            $tokenUsuario = $datosPersonal[0]['tokenPers'];

            // MODIFICAR AQUÍ EL DOMINIO
            //$url = 'http://' . $dominio_actual . '//CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
            // IMAGEN LOGOTIPO CORREO
            $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';
    
    
            // MODIFICAR AQUÍ EL DOMINIO
            $dominio_actual = $_SERVER['SERVER_NAME'];
            $urlCambioPass = 'https://' . $dominio_actual . '/view/CambiarPass/?tokenidusu=' . $tokenUsuario . ''; 
            //$url = 'https://' . $dominio_actual . '/view/RecuperarPass/index.php?idUsu=' . $tokenUsuario;
    
            /*         $url = 'http://' . $dominio_actual . '/costaValencia/view/RecPass/RecPass.php?idUsu='.$idUsuCifrada;
     */
            $idPersonal = isset($_POST["idPersonal"]) ? $_POST["idPersonal"] : null;
            $correoSelect = isset($_POST["correoSelect"]) ? $_POST["correoSelect"] : null;

            if (empty($correoSelect) || !filter_var($correoSelect, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status' => 'error', 'message' => 'Correo no válido o vacío']);
                exit;
            }
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
           
                $mail->addAddress($correo, $nombreUsuario);     //Add a recipient
           

                $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
    
                $mail->Subject = 'Comunicado - Costa de Valencia';
    
                $cuerpo = file_get_contents("../public/mailTemplate/correoComunicadoNewPersonal.html"); /* Ruta del template en formato HTML */

                /* parametros del template a remplazar */
                if($nuevoUsuCheck == 1){ 
                    $cuerpo = str_replace('userInput', $nombreUsuario, $cuerpo); 
                    $cuerpo = str_replace('urlCambioPass', $urlCambioPass, $cuerpo);
                }else{
                    $cuerpo = str_replace('<div id="inicioSesion">', '<div id="inicioSesion" style="display: none;">', $cuerpo);
                
                }

        
                $mail->Body    = $cuerpo;
                $mail->AltBody = "Comunicado - Costa de Valencia";
    
                
                $mail->send();
              
                // Respuesta JSON
                echo json_encode(['status' => 'success', 'message' => 'Correo enviado correctamente']);
                
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => "Error al enviar el correo: {$mail->ErrorInfo}"]);
            }
        }
    break;
    // FIN ENVIO DE INTERESADO
    case "insertarPersonalCurso":

        $idProfesorado = $_POST["idProfesorado"];

        $selectCurso = $_POST["selectCurso"];
        $selectIdioma =  $_POST["selectIdioma"];
        $nivelDesdeSelect =  $_POST["nivelDesdeSelect"];
        $nivelHastaSelect =  $_POST["nivelHastaSelect"];

        // VALIDACION VAN A IR AQUI
        $datosUsu = $personal->get_ruta_x_perso($idProfesorado,$selectCurso,$selectIdioma);
        if (is_array($datosUsu) == true and count($datosUsu) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            echo $error = 'Ya existe esta combinación de Tipo Curso/Idioma  <br>';
            exit();
        };

        if ($error == "") {

            $personal->insertarPersonalCurso($idProfesorado,$selectCurso,$selectIdioma,$nivelDesdeSelect,$nivelHastaSelect);
            echo '1';

        }

        break;
    case "eliminarRuta":

        $idRutaPersonal = $_POST["idRutaPersonal"];

        $personal->eliminarRuta($idRutaPersonal);
        echo '1';

    break;
    case "cargarHastaNivel":

        $nivelDesde = $_POST["nivelDesde"];
        $selectIdiomaModal = $_POST["selectIdiomaModal"];
        $selectCursoModal = $_POST["selectCursoModal"];

        $datosNivelHasta = $personal->recogerNivelHasta($nivelDesde,$selectIdiomaModal,$selectCursoModal);
        
        echo json_encode($datosNivelHasta);

    break;
    case "cargarDesdeNivel":

        $selectIdiomaModal = $_POST["selectIdiomaModal"];
        $selectCursoModal = $_POST["selectCursoModal"];

        $datosNivelDesde = $personal->recogerNivelDesde($selectIdiomaModal,$selectCursoModal);
        
        echo json_encode($datosNivelDesde);

    break;
    
    
}

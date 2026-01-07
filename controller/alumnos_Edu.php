<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");

require_once("../models/Alumnos_Edu.php");
require_once("../models/Usuario.php");

session_start();
require_once("../models/Log.php");

$alumnos = new Alumnos();
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

    case "listarAlumnos":

        $datos = $alumnos->listarAlumnosTodos();
       
        $data = array();



        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["idUsu"];
            $sub_array[] = $row["nickUsu"];
            $sub_array[] = $row["nombreUsu"] . ' ' . $row["apellidosUsu"];
            if($row["domValAlumno"] != ''){
                $sub_array[] = $row["domValAlumno"].' - '. $row["nacionalidadPreinscriptor"];
            }else{
                $sub_array[] = $row["dirCasaPrescripcion"].' - '. $row["nacionalidadPreinscriptor"];
            }
            $sub_array[] = $row["telefonoUsu"].' - '.$row["teleAlumno"].' - '.$row["movilCasaPrescripcion"].' - '.$row["movilAltPrescripcion"];
            $sub_array[] = 'Casa: '.$row["emailCasaPrescripcion"].' Alt: '.$row["emailAltPrescripcion"].' - MailUsu:'.$row["emailUsuario"];
            $sub_array[] = 'Departamento';

            if ($row["alumnoCursoActivo"] == 0) {
                $sub_array[] = '<label class="tx-bold badge bg-secondary tx-14-force"> Interesado </label>';
            } else if ($row["alumnoCursoActivo"] == 1) {
                $sub_array[] = '<label class="tx-bold badge bg-primary tx-14-force"> Alumno </label>';
            }
            if ($row["estUsu"] == 1) {
                $sub_array[] = '<p class="badge bg-success tx-bold tx-14-force">Activo</p>';
            } elseif ($row["estUsu"] == 0) {
                $sub_array[] = '<p class="badge bg-secondary tx-bold tx-14-force">Desactivado</p>';
            }
            if ($row["estUsu"] == 1) {
                $sub_array[] = 
            '<button class="btn btn-warning waves-effect" title="Enviar correo" onClick="cargarElementoSend(' .  $row['idInscripcion_tmusuario']. ')" ><i class="fa-regular fa-envelope"></i></button>
            <button class="btn btn-danger waves-effect" title="Desactivar Usuario" onClick="cambiarEstado('.$row["idInscripcion_tmusuario"].')" class="btn btn-danger btn-icon mt-1 mt-sm-0" data-toggle="tooltip-primary" data-placement="top" title="Desactivar Persona"><div><i class="fa-solid fa-xmark"></i></div></button>';
            } else {
                $sub_array[] = 
            '<button class="btn btn-warning waves-effect" title="Enviar correo" onClick="cargarElementoSend(' .  $row['idInscripcion_tmusuario']. ')" ><i class="fa-regular fa-envelope"></i></button>
            <button class="btn btn-success waves-effect" title="Activar Usuario" onClick="cambiarEstado('.$row["idInscripcion_tmusuario"].')"><i class="fa-solid fa-user-check"></i></button>';
            }
          
            $sub_array[] = ' <a href="../Interesados_Edu/?buscar=' . $row['nickUsu'] . '"" class="btn btn-info btn-icon"  data-placement="top" title="Ver datos interesado"><div><i class="fas fa-child-reaching"></i></div></button></a> ';
            $sub_array[] = ' <a href="../Perfil/?tokenUsuario=' . $row['tokenUsu'] . '" class="btn btn-success btn-icon"  data-placement="top" title="Ver Perfil"><div><i class="fas fa-solid fa-clipboard-user"></i></div></button></a> ';

           
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
        case "recogerEditar":
        $sub_array = array();
        $datos = $alumnos->get_alumno_x_id($_POST["idAlumno"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {


                $sub_array[] = $row["idUsu"];
                $sub_array[] = $row["nomPersonal"];
                $sub_array[] = $row["apePersonal"];
                $sub_array[] = $row["emailCasaPrescripcion"];
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
        case "enviarCorreoAlumno":
            
            $idAlumno = $_POST["idAlumno"];
            $correoSelect = $_POST["correoSelect"];
    
            $nuevoUsuCheck = $_POST["nuevoUsuCheck"];
        
            $datosAlumno = $alumnos->get_alumno_x_id($idAlumno);
   
            if($datosAlumno == 0){
               
                
            }else{
               
                //$correo = $datosInteresado[0]['correoUsu'];
                $correo = $correoSelect; // correo del input
                $nickUsuario = $datosAlumno[0]['nickUsu'];
               
                $tokenUsuario = $datosAlumno[0]['tokenUsu'];
    
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
                    $mail->addAddress($correo, $nickUsuario);     //Add a recipient
               
    
                    $mail->CharSet = 'UTF-8'; // Establecer la codificación del correo
        
                    $mail->Subject = 'Comunicado - Costa de Valencia';
        
                    
                $cuerpo = file_get_contents("../public/mailTemplate/correoComunicadoNew.html"); /* Ruta del template en formato HTML */

                /* parametros del template a remplazar */
                if($nuevoUsuCheck == 1){ 
                    $cuerpo = str_replace('userInput', $nickUsuario, $cuerpo); 
                    $cuerpo = str_replace('urlCambioPass', $urlCambioPass, $cuerpo);
                }else{
                    $cuerpo = str_replace('<div id="inicioSesion">', '<div id="inicioSesion" style="display: none;">', $cuerpo);
                
                }

                if($recordatorioCheck == 1){ 
                    $cuerpo = str_replace('urlPerfil', $nickUsuario, $cuerpo);
                }else{
                    $cuerpo = str_replace('<div id="divRecordatorio">', '<div id="divRecordatorio" style="display: none;">', $cuerpo);
                }
                
                if($facturaCheck == 1){ 
                    /* $cuerpo = str_replace('urlPerfil', $nickUsuario, $cuerpo); */
                }else{
                    $cuerpo = str_replace('<div id="divFactura">', '<div id="divFactura" style="display: none;">', $cuerpo);
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
    case "cambiarEstado":
    $idElemento = $_POST["idElemento"];
    $alumnos->cambiarEstado($idElemento);
    break;

    
}

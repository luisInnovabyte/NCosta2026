<?php

//control de errores, habilitar si hay un error 500 y fijarse en el preview del navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Prescriptor.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$prescriptor = new Prescriptor();

$op = $_GET["op"];
function calcularEdad($fechaNacimiento) {
    $fechaActual = new DateTime(); // Fecha actual
    $fechaNacimiento = new DateTime($fechaNacimiento); // Fecha de nacimiento
    $edad = $fechaActual->diff($fechaNacimiento)->y; // Calcula la diferencia en años
    return $edad;
}
switch ($op) {
    case "mostrarElementos":

        $datos = $prescriptor->mostrarInscripcionesConUsuarios();
        $data = array();

        foreach ($datos as $row) {

            if ($row["fecNacPrescripcion"] == '1970-01-01') {
                $fechaNacimiento = '<span style="color: gray;">No especificada</span>';
            } else {
                $edad = calcularEdad($row["fecNacPrescripcion"]);
                
                // Formato de la fecha en tu función `fechaLocal`
                $fechaFormateada = fechaLocal($row["fecNacPrescripcion"]);
                
                // Si es menor de edad, aplicar estilo azul claro
                if ($edad < 18) {
                    $fechaNacimiento = '<b><span style="color: deepskyblue;">' . $fechaFormateada . '</span></b>';
                } else {
                    $fechaNacimiento = $fechaFormateada;
                }
            }

            $sub_array = array();
    
            $sub_array[] = $row["idPrescripcion"];
            $sub_array[] = $row["nickUsu"];
            $sub_array[] = $row["nomPrescripcion"].' '.$row["apePrescripcion"];
            $sub_array[] = $row["identificadorDocumento"];
            $sub_array[] = $row["emailCasaPrescripcion"]. ' '.$row["emailAltPrescripcion"];
            $sub_array[] = $row["movilCasaPrescripcion"].' '.$row["movilAltPrescripcion"]. ' '.$row["tefCasaPrescripcion"]. ' '.$row["tefAltPrescripcion"]. ' '.$row["numPadrePre"]. ' '.$row["numMadrePre"];
            $sub_array[] = $fechaNacimiento;
           


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
    case "recogerInfo":
        $idPrescriptor = $_POST["idPrescriptor"];
        $datos = $prescriptor->mostrarElementoxID($idPrescriptor);
        echo json_encode($datos);

        break;
    case "recogerInfoAgente":
    $idAgente = $_POST["idAgente"];
    $datos = $prescriptor->mostrarElementoxIDAgente($idAgente);
    echo json_encode($datos);

    break;

    case "recogerConocimiento";
        $datos = $prescriptor->recogerConocimiento();
        echo json_encode($datos);
    break;
    case "recogerTipoCurso";
        $datos = $prescriptor->recogerTipoCurso();
        echo json_encode($datos);
    break;
    
    case "insertarUsuTest":
        $prescriptor->insertarUsuTest();

    break;
    case "insertarPrescriptor":
        $nombreCliente = $_POST["nombreCliente"];
        $sexoCliente = $_POST["sexoCliente"];
        $apellidoCliente = $_POST["apellidoCliente"];
        $fechCliente = $_POST["fechCliente"];
        $fechaPrevista = $_POST["fechaPrevista"];
        $emailCasa = $_POST["emailCasa"];
        $emailAlt = $_POST["emailAlt"];
        $fech1Contacto = $_POST["fech1Contacto"];
        $dirCasa = $_POST["dirCasa"];
        $dirAlt = $_POST["dirAlt"];
        $cursoDeseado = $_POST["cursoDeseado"];
        $cpCasa = $_POST["cpCasa"];
        $cpAlt = $_POST["cpAlt"];
        $conocimiento1 = $_POST["conocimiento1"];
        $ciudadCasa = $_POST["ciudadCasa"];
        $ciudadAlt = $_POST["ciudadAlt"];
        $conocimiento2 = $_POST["conocimiento2"];
        $paisCasa = $_POST["paisCasa"];
        $paisAlt = $_POST["paisAlt"];
        $conocimiento3 = $_POST["conocimiento3"];
        $tefCasa = $_POST["tefCasa"];
        $tefAlt = $_POST["tefAlt"];
        $probablemente = $_POST["probablemente"];
        $movilCasa = $_POST["movilCasa"];
        $movilAlt = $_POST["movilAlt"];
        $grupoCliente = $_POST["grupoCliente"];
        $erasmusCliente = $_POST["erasmusCliente"];
        $uniOrigen = $_POST["uniOrigen"];
        $Bildungsurlaub = $_POST["Bildungsurlaub"];
        $aupair = $_POST["aupair"];
        $preferenciaHoraria = $_POST["preferenciaHoraria"];
        $fechaConfirmacion = $_POST["fechaConfirmacion"];
        $matCurso = $_POST["matCurso"];
        $matAlojamiento = $_POST["matAlojamiento"];
        $matFechInicio = $_POST["matFechInicio"];
        $textTipo = $_POST["textTipo"];
        $tokenPreinscriptor = generarToken(30);
 
        $departamentoSelect = $_POST["departamentoSelect"];

        $tipoIdentificador = $_POST["tipoIdentificador"];
        $identificador = $_POST["identificador"];

        $nombreMadrePre = $_POST["nombreMadrePre"];
        $nombrePadrePre = $_POST["nombrePadrePre"];
        $numPadrePre = $_POST["numPadrePre"];
        $numMadrePre = $_POST["numMadrePre"];
        $interesadoOnlinePre = $_POST["interesadoOnlinePre"];
        $nacionalidadPre = $_POST["nacionalidadPre"];

        
        
        $prescriptor->insertarPrescriptor($nombreCliente,$sexoCliente,$apellidoCliente,$fechCliente,$fechaPrevista,$emailCasa,$emailAlt,$fech1Contacto,$dirCasa,$dirAlt,$cursoDeseado,$cpCasa,$cpAlt,$conocimiento1,$ciudadCasa,$ciudadAlt,$conocimiento2,$paisCasa,$paisAlt,$conocimiento3,$tefCasa,$tefAlt,$probablemente,$movilCasa,$movilAlt,$grupoCliente,$erasmusCliente,$uniOrigen,$Bildungsurlaub,$aupair,$preferenciaHoraria,$fechaConfirmacion,$matCurso,$matAlojamiento,$matFechInicio,$textTipo,$tokenPreinscriptor,$departamentoSelect,$tipoIdentificador,$identificador,$nombreMadrePre,$nombrePadrePre,$numPadrePre,$numMadrePre,$interesadoOnlinePre,$nacionalidadPre);
        break;

        case "actualizarPrescriptor":
            $prescriptorID = $_POST["prescriptorID"];
            $nombreCliente = $_POST["nombreCliente"];
            $sexoCliente = $_POST["sexoCliente"];
            $apellidoCliente = $_POST["apellidoCliente"];
            $fechCliente = $_POST["fechCliente"];
            $fechaPrevista = $_POST["fechaPrevista"];
            $emailCasa = $_POST["emailCasa"];
            $emailAlt = $_POST["emailAlt"];
            $fech1Contacto = $_POST["fech1Contacto"];
            $dirCasa = $_POST["dirCasa"];
            $dirAlt = $_POST["dirAlt"];
            $cursoDeseado = $_POST["cursoDeseado"];
            $cpCasa = $_POST["cpCasa"];
            $cpAlt = $_POST["cpAlt"];
            $conocimiento1 = $_POST["conocimiento1"];
            $ciudadCasa = $_POST["ciudadCasa"];
            $ciudadAlt = $_POST["ciudadAlt"];
            $conocimiento2 = $_POST["conocimiento2"];
            $paisCasa = $_POST["paisCasa"];
            $paisAlt = $_POST["paisAlt"];
            $conocimiento3 = $_POST["conocimiento3"];
            $tefCasa = $_POST["tefCasa"];
            $tefAlt = $_POST["tefAlt"];
            $probablemente = $_POST["probablemente"];
            $movilCasa = $_POST["movilCasa"];
            $movilAlt = $_POST["movilAlt"];
            $grupoCliente = $_POST["grupoCliente"];
            $erasmusCliente = $_POST["erasmusCliente"];
            $uniOrigen = $_POST["uniOrigen"];
            $Bildungsurlaub = $_POST["Bildungsurlaub"];
            $aupair = $_POST["aupair"];
            $preferenciaHoraria = $_POST["preferenciaHoraria"];

            $fechaConfirmacion = $_POST["fechaConfirmacion"];
            $matCurso = $_POST["matCurso"];
            
            $matAlojamiento = $_POST["matAlojamiento"];
            $matFechInicio = $_POST["matFechInicio"];
            $textTipo = $_POST["textTipo"];
            $departamentoSelect = $_POST["departamentoSelect"];

            $tipoIdentificador = $_POST["tipoIdentificador"];
            $identificador = $_POST["identificador"];

            $nombreMadrePre = $_POST["nombreMadrePre"];
            $nombrePadrePre = $_POST["nombrePadrePre"];
            $numPadrePre = $_POST["numPadrePre"];
            $numMadrePre = $_POST["numMadrePre"];
            $interesadoOnlinePre = $_POST["interesadoOnlinePre"];
            $nacionalidadPre = $_POST["nacionalidadPre"];

            
            $prescriptor->actualizarPrescriptor($prescriptorID,$nombreCliente,$sexoCliente,$apellidoCliente,$fechCliente,$fechaPrevista,$emailCasa,$emailAlt,$fech1Contacto,$dirCasa,$dirAlt,$cursoDeseado,$cpCasa,$cpAlt,$conocimiento1,$ciudadCasa,$ciudadAlt,$conocimiento2,$paisCasa,$paisAlt,$conocimiento3,$tefCasa,$tefAlt,$probablemente,$movilCasa,$movilAlt,$grupoCliente,$erasmusCliente,$uniOrigen,$Bildungsurlaub,$aupair,$preferenciaHoraria,$fechaConfirmacion,$matCurso,$matAlojamiento,$matFechInicio,$textTipo,$departamentoSelect,$tipoIdentificador, $identificador, $nombreMadrePre,$nombrePadrePre,$numPadrePre,$numMadrePre,$interesadoOnlinePre,$nacionalidadPre);
            break;
    case "agregarElemento":
        $descripcion = $_POST["descripcion"];
        $color = $_POST["color"];
        $prescriptor->agregarElemento($descripcion, $color);
        break;
    case "cargarElemento":
        $idElemento = $_POST["idElemento"];
        $datos = $prescriptor->cargarElemento($idElemento);
        echo json_encode($datos);
        break;
    case "editarElemento":
        $descripcion = $_POST["descripcion"];
        $color = $_POST["color"];
        $idElemento = $_POST["idElemento"];
        $prescriptor->editarElemento($idElemento, $descripcion, $color);
        break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $prescriptor->cambiarEstado($idElemento);
        break;
    case "listarProfesiones":
        $datos = $prescriptor->mostrarElementosActivos();
        echo json_encode($datos);
        break;
    case "cargarPrescriptorXTokken":
        $tokken = $_POST["tokken"];
        $datos = $prescriptor->cargarPrescriptorXTokken($tokken);
        echo json_encode($datos);
        break;
    case "comprobarDocumento":
        $identificador = $_POST["identificador"];
        $departamentoSelect = $_POST["departamentoSelect"];

        $datos = $prescriptor->comprobarDocumento($identificador,$departamentoSelect);
        if (is_array($datos) == true and count($datos) > 0) {  // si es mayor que cero es que ya existe uno y debo sacar error
            echo 1;
        };
    break;

    // APARTADO ENVIO DE INTERESADO
    case "enviarCorreoInteresado":
        $idInteresado = $_POST["idInteresado"];
        $correoSelect = $_POST["correoSelect"];

        $recordatorioCheck = $_POST["recordatorioCheck"];
        $nuevoUsuCheck = $_POST["nuevoUsuCheck"];
        $facturaCheck = $_POST["facturaCheck"];

     
        // METER INFORMACION FACTURACION
        if($facturaCheck == 1){
            //$datos = $prescriptor->comprobarUltimaFactura($identificador,$departamentoSelect);
        }

        $datosInteresado = $prescriptor->recogerDatosInteresado($idInteresado);
      
        if($datosInteresado == 0){
           
            
        }else{
      
            //$correo = $datosInteresado[0]['correoUsu'];
            $correo = $correoSelect; // correo del input
            $nombreUsuario = $datosInteresado[0]['correoUsu'];
            $apellidoUsuario = $datosInteresado[0]['apellidosUsu'];
            $nickUsuario = $datosInteresado[0]['nickUsu'];
            $tokenUsuario = $datosInteresado[0]['tokenUsu'];

            // MODIFICAR AQUÍ EL DOMINIO
            $dominio_actual = $_SERVER['SERVER_NAME'];

            // MODIFICAR AQUÍ EL DOMINIO
            //$url = 'http://' . $dominio_actual . '//CostaValencia/CostaValencia/view/Alojamientos/datosAlojamiento.php?idAloja=' . $idAloja . ''; */
            // IMAGEN LOGOTIPO CORREO
            $img = 'https://' . $dominio_actual . '/public/img/logo_pequeno.png';
    
            $urlCambioPass = 'https://' . $dominio_actual . '/N.CostaSV/view/CambiarPass/?tokenidusu=' . $tokenUsuario . ''; 
            $urlPerfil = 'https://' . $dominio_actual . '/N.CostaSV/view/Perfil/?tokenUsuario=' . $tokenUsuario . ''; 
            $urlFacturas = 'https://' . $dominio_actual . '/N.CostaSV/view/Perfil/facturaAlum.php?tokenUsu=' . $tokenUsuario . ''; 

            //$url = 'https://' . $dominio_actual . '/view/RecuperarPass/index.php?idUsu=' . $tokenUsuario;
    
            /*         $url = 'http://' . $dominio_actual . '/costaValencia/view/RecPass/RecPass.php?idUsu='.$idUsuCifrada;
     */
            $idInteresado = isset($_POST["idInteresado"]) ? $_POST["idInteresado"] : null;
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
    
                $cuerpo = file_get_contents("../public/mailTemplate/correoComunicadoNew.html"); /* Ruta del template en formato HTML */

                /* parametros del template a remplazar */
                if($nuevoUsuCheck == 1){ 
                    $cuerpo = str_replace('userInput', $nickUsuario, $cuerpo); 
                    $cuerpo = str_replace('urlCambioPass', $urlCambioPass, $cuerpo);
                }else{
                    $cuerpo = str_replace('<div id="inicioSesion">', '<div id="inicioSesion" style="display: none;">', $cuerpo);
                
                }

                if($recordatorioCheck == 1){ 
                    $cuerpo = str_replace('urlPerfil', $urlPerfil, $cuerpo);  
                } else {
                    $cuerpo = str_replace('<div id="divRecordatorio">', '<div id="divRecordatorio" style="display: none;">', $cuerpo);
                }

                
                if($facturaCheck == 1){ 
                    $cuerpo = str_replace('urlFacturas', $urlFacturas, $cuerpo);  
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
    case "recogerUltimaFacturaPro":
        $idDepartamento = $_POST["idDepartamento"];
       

        $datos = $prescriptor->recogerDepartamentoNumeroFact($idDepartamento);
        echo json_encode($datos);

    break;

    // FIN ENVIO DE INTERESADO

    // FIN ENVIO DE INTERESADO
  
    default:
        echo "No se ha encontrado esta opción";
}

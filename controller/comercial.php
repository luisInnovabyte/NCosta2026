<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Comercial.php");

require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

session_start();

$comercial = new Comercial();

$op = $_GET["op"];

switch ($op) {
    case "comprobarJson":
        $datosJson = $_POST["datosJson"];
        ksort($datosJson);
    
        break;
    case "subirMapaWeb":
        foreach ($_FILES['file']['name'] as $key => $value) {
            $directorioDestino = "../..";

            $nombreReal = $_FILES['file']['name'][$key];
            $extension = pathinfo($nombreReal, PATHINFO_EXTENSION);
            $nombreArchivoNuevo = "site-map." . $extension;

            move_uploaded_file($_FILES['file']['tmp_name'][$key], $directorioDestino . "/" . $nombreArchivoNuevo);

        }
    break;
    case "subirImagen":
        $carpeta = $_GET["carpeta"];
        $imgsArray = array();
        foreach ($_FILES['file']['name'] as $key => $value) {
            $nombreReal = $_FILES['file']['name'][$key];
            $extension = pathinfo($nombreReal, PATHINFO_EXTENSION);

            $nombreUnico = transformarFecha("", ["d", "m", "Y", "H", "i", "s", "v", "u"]);

            $directorioDestino = "../../assets/images/$carpeta";

            $nombreArchivoNuevo = strval($nombreUnico) . "." . $extension;

            move_uploaded_file($_FILES['file']['tmp_name'][$key], $directorioDestino . "/" . $nombreArchivoNuevo);

            $imgsArray[$nombreReal] = $nombreArchivoNuevo;
        }

        echo json_encode($imgsArray);

        break;
        case "guardarMostrarOcultar":
            $datosJson = $_POST["datosMostrarOcultar"];
            $comercial -> guardarMostrarOcultar($datosJson);
        break;
        case "guardarDeliveredGoods":
            $datosJson = $_POST["datosJson"];
            $comercial -> guardarDeliveredGoods($datosJson);
        break;
        case "guardarSlider":
            $datosJson = $_POST["datosJson"];
            ksort($datosJson);
            $comercial -> guardarSlider($datosJson);
        break;
        case "guardarDigital":
            $datosJson = $_POST["datosJson"];
            ksort($datosJson);
            $comercial -> guardarDigital($datosJson);
        break;
        case "guardarClients":
            $datosJson = $_POST["datosJson"];
            ksort($datosJson['ES']['Carrousel']);
            $comercial -> guardarClients($datosJson);
        break;
        case "guardarServicio":
            $datosJson = $_POST["datosJson"];
            ksort($datosJson["envio-por-carretera"]['ES']['Elemento1']["Descripcion"]);
            ksort($datosJson["envio-por-carretera"]['ES']['Elemento3']["Descripcion"]["Cajas2"]);
            ksort($datosJson["envio-por-carretera"]['ES']['Elemento4']["Preguntas"]);
            ksort($datosJson["envio-por-carretera"]['ES']['Elemento5']["Imagenes"]);
            $comercial -> guardarServicios($datosJson);
        break;
        case "guardarOpinion":
            $datosJson = $_POST["datosJson"];
            ksort($datosJson['ES']["BloqueDerecha"]['TestimonialCarousel']);
            $comercial -> guardarOpinion($datosJson);
        break;
        case "guardarGlobalLogistics":
            $datosJson = $_POST["datosJson"];
            $comercial -> guardarGlobalLogistics($datosJson);
        break;
        case "guardarGlobalLogistics":
            $logoJson = $_POST["logoJson"];
            $comercial -> guardarLogo($logoJson);
        break;
        case "guardarMenu":
            $datosJson = $_POST["datosJson"];
            $comercial -> guardarMenu($datosJson);
        break;
        case "guardarContacto":
            $datosJson3 = $_POST["datosJson3"];
            $comercial -> guardarContacto($datosJson3);
        break;
        case "guardarHead":
            $datosJsonHead = $_POST["datosJsonHead"];
            $comercial -> guardarHead($datosJsonHead);
        break;
        case "guardarInformacion":
            $datosJson2 = $_POST["datosJson2"];
            $comercial -> guardarInformacion($datosJson2);
        break;
        case "guardarLogos":
            
            $logoJson = $_POST["logoJson"];
            
           
            $comercial -> guardarLogos($logoJson);
        break;
        case "modificarMapa":
            $mapa = $_POST["map"];
            $comercial -> modificarMapa($mapa);
        break;
        case "cambiarNombreArchivo":
            $nombreOriginal = $_POST["nombreOriginal"];
            $nombreNuevo = $_POST["nombreNuevo"];
            rename("../../".convertirASlug($nombreOriginal).".php","../../".convertirASlug($nombreNuevo).".php");
            rename("../view/IframesPersonalizar/".convertirASlug($nombreOriginal).".php","../view/IframesPersonalizar/".convertirASlug($nombreNuevo).".php");
            $rutaArchivo = "../view/Personalizar/index.php";
            $contenido = file_get_contents($rutaArchivo);

            // Reemplazar todas las instancias de $nombreOriginal con $nombreNuevo
            $contenidoActualizado = str_replace(convertirASlug($nombreOriginal).".php", convertirASlug($nombreNuevo).".php", $contenido);
            
            // Escribir el contenido actualizado en el archivo
            file_put_contents($rutaArchivo, $contenidoActualizado);


            $rutaArchivo = "../config/templates/mainSidebar.php";
            $contenido = file_get_contents($rutaArchivo);

            // Reemplazar todas las instancias de $nombreOriginal con $nombreNuevo
            $contenidoActualizado = str_replace($nombreOriginal, $nombreNuevo, $contenido);
            
            // Escribir el contenido actualizado en el archivo
            file_put_contents($rutaArchivo, $contenidoActualizado);

            $comercial -> modificarServicio($nombreOriginal,$nombreNuevo);
        break;
        case "guardarFooter":
            $datosJson = $_POST["datosJson"];
            $comercial -> guardarFooter($datosJson);
        break;


    default:
        echo "No se ha encontrado esta opción";
}

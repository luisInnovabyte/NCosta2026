

<?php
require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Rutas.php");



session_start();

$rutas = new Rutas();

$op = $_GET["op"];

switch ($op) {
    
    case "insertarCurso":
        
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
       
        // Llamada al método para guardar los datos
        $datos = $rutas->insertarCurso($idioma,$curso,$nivel,$minAlumnos,$maxAlumnos,$periodicidad,$medida,$peso);
        echo $datos;
    break;
    
    case "editarCurso":
        
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
       
        // Llamada al método para guardar los datos
        $rutas->editarCurso($idEditar,$idioma,$curso,$nivel,$minAlumnos,$maxAlumnos,$periodicidad,$medida,$peso);
    break;
    
    case "listarRutasTodas":
   
        $datos = $rutas->listarRutasActivas();

        $data = array();

   
        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["id_ruta"];
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codIdioma"] . '</span> - '. $row["descrIdioma"] . '</p>';
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codTipo"] . '</span> - '. $row["descrTipo"] . ' </p>';
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codNivel"] . '</span> - '. $row["descrNivel"] . '</p>';
            $sub_array[] = '<p class="tx-break "><span class="badge badge-warning">'. $row["minAlum_ruta"] . ' - '. $row["maxAlum_ruta"] . '</span></p>';
            $sub_array[] = '<p class="tx-break tx-bold">'. $row["perRefresco_ruta"] . ' '. $row["descrRefresco"] . '</p>';
            $sub_array[] = '<p class="tx-break tx-bold text-decoration-underline"> '. $row["codIdioma"] . $row["codTipo"] . $row["codNivel"].'</p>';
            

         
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
    case "listarRutas":
        
        $idioma = $_POST['idioma'];
        $curso = $_POST['curso'];

        $datos = $rutas->listarRutas($idioma,$curso);

        $data = array();

    
        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["id_ruta"];
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codIdioma"] . '</span> - '. $row["descrIdioma"] . '</p>';
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codTipo"] . '</span> - '. $row["descrTipo"] . ' </p>';
            $sub_array[] = '<p class="tx-break tx-bold"><span class="badge badge-info">'. $row["codNivel"] . '</span> - '. $row["descrNivel"] . '</p>';
            $sub_array[] = '<p class="tx-break "><span class="badge badge-warning">'. $row["minAlum_ruta"] . ' - '. $row["maxAlum_ruta"] . '</span></p>';
            $sub_array[] = '<p class="tx-break tx-bold">'. $row["perRefresco_ruta"] . ' '. $row["descrRefresco"] . '</p>';
            $sub_array[] = '<p class="tx-break "><span class="badge badge-secondary" data-order="'.$row["pesoRuta"].'">'.$row["pesoRuta"].'</span></p>';
            $sub_array[] = '<p class="tx-break tx-bold text-decoration-underline"> '. $row["codIdioma"] . $row["codTipo"] . $row["codNivel"].'</p>';
            

            if ($row["estadoRuta"] == 1) {
                $sub_array[] = "<span class='badge badge-success'>Activo</span>";
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Curso" onClick="cargarDatosEditar('.$row["id_ruta"].')"><i class="fa-solid fa-edit"></i></button>
                <button type="button" onClick="cambiarEstado(' . $row["id_ruta"] . ');" class="btn btn-danger" title="Desactivar"><i class="fa-solid fa-xmark"></i></button>                
                <a href="../../view/Objetivos/?idioma='. $row["idiomaId_ruta"] .'&tipo='. $row["tipoId_ruta"] .'&nivel='. $row["nivelId_ruta"] .'" class="btn btn-warning" title="Objetivos"><i class="fa-solid fa-flag"></i></a>';


            } else {
                $sub_array[] = "<span class='badge badge-secondary'>Inactivo</span>'";
                $sub_array[] = '<button class="btn btn-info waves-effect" title="Editar Curso" onClick="cargarDatosEditar('.$row["id_ruta"].')"><i class="fa-solid fa-edit"></i></button>
                <button type="button" onClick="cambiarEstado(' . $row["id_ruta"] . ');" class="btn btn-success" title="Activar"><i class="fa-solid fa-check"></i></button>
                <a href="../../view/Objetivos/?idioma='. $row["idiomaId_ruta"] .'&tipo='. $row["tipoId_ruta"] .'&nivel='. $row["nivelId_ruta"] .'" class="btn btn-warning" title="Objetivos"><i class="fa-solid fa-flag"></i></a>';

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
    case "obtenerRutaxId":

        $datosRuta = $rutas->get_ruta_x_id($_POST["idRuta"]);
        
        echo json_encode($datosRuta);

    break;
    case "obtenerRutaxIdView":

        $datosRuta = $rutas->obtenerRutaxIdView($_POST["idRuta"]);
        
        echo json_encode($datosRuta);

    break;
    
    case "comprobarExisteRutas":

        $datosRuta = $rutas->comprobarExisteRutas($_POST["idRuta"]);
        
        echo json_encode($datosRuta);

    break;
    case "cambiarEstado":
        $idElemento = $_POST["idElemento"];
        $rutas->cambiarEstado($idElemento);
    break;

    case "duplicarRuta":
        $idiomaCopiar = $_POST["idiomaCopiar"];
        $cursoCopiar = $_POST["cursoCopiar"];
        $idiomaPegar = $_POST["idiomaPegar"];
        $cursoPegar = $_POST["cursoPegar"];
        
        $respuesta = $rutas->duplicarRuta($idiomaCopiar,$cursoCopiar,$idiomaPegar,$cursoPegar);
        echo $respuesta;
    break;

    default:
        echo "No se ha encontrado esta opción";
}

?>

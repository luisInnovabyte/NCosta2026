<?php

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Usuario.php");



$usuario = new Usuario();


switch ($_GET["op"]) {

        /////////////////////////////////
        //////// SOLAPA CUENTA /////////
        ///////////////////////////////
    case "actualizarCuentaPerfil":

        $idUsuario = $_POST['idUsuario'];
        $nomUsuario = trim($_POST['nomUsuario']);
        $emailUsuario = strtolower($_POST['emailUsuario']);
        $nomAlumno = ucfirst($_POST['nomAlumno']);
        $apeAlumno = trim($_POST['apeAlumno']);
        $fecNacAlumno = $_POST['fecNacAlumno'];
        $teleAlumno = $_POST['teleAlumno'];
        $nacioAlumno = trim($_POST['nacioAlumno']);
        $ProfeEstuAlumno = trim($_POST['ProfeEstuAlumno']);
        $EmpresaAlumno = trim($_POST['EmpresaAlumno']);
        $UniAlumno = trim($_POST['UniAlumno']);
        $domValAlumno = $_POST['domValAlumno'];
        $domOrigenAlumno = $_POST['domOrigenAlumno'];

        
        $usuario->actualizarCuentaPerfil($idUsuario, $nomUsuario, $emailUsuario, $nomAlumno, $apeAlumno, $fecNacAlumno, $teleAlumno, $nacioAlumno, $ProfeEstuAlumno, $EmpresaAlumno, $UniAlumno, $domValAlumno, $domOrigenAlumno);

        echo '1';

        break;

        /////////////////////////////////
        /////////////////////////////////
        /////////////////////////////////

        ////////////////////////////////////////
        //////// SOLAPA CONOCIMIENTOS /////////
        //////////////////////////////////////

    case "actualizarConocimientosPerfil":


        $idUsuario = $_POST['idUsuario'];
        $lenMatAlumno = $_POST['lenMatAlumno'];
        $lenCon1Alumno = $_POST['lenCon1Alumno'];
        $lenCon2Alumno = $_POST['lenCon2Alumno'];
        $lenCon3Alumno = $_POST['lenCon3Alumno'];
        $lenCon4Alumno = $_POST['lenCon4Alumno'];
        $estEspAlumno = $_POST['estEspAlumno'];
        $nivEspAlumno = $_POST['nivEspAlumno'];
        $tiemEspAlumno = $_POST['tiemEspAlumno'];
        $lugEspAlumno = $_POST['lugEspAlumno'];
        $porEspAlumno = $_POST['porEspAlumno'];
        $mejEspAlumno = $_POST['mejEspAlumno'];


        $usuario->actualizarConocimientosPerfil($idUsuario, $lenMatAlumno, $lenCon1Alumno, $lenCon2Alumno, $lenCon3Alumno, $lenCon4Alumno, $estEspAlumno, $nivEspAlumno, $tiemEspAlumno, $lugEspAlumno, $porEspAlumno, $mejEspAlumno);

        echo '1';

        break;

        /////////////////////////////////////
        ////////////////////////////////////
        ///////////////////////////////////

    ////////////////////////////////////////
    ////////// SOLAPA APRENDIZAJE /////////
    //////////////////////////////////////

    case "insertarAprendizajePerfil":

       
        $idUsuario = $_POST['idUsuario'];
        $aprEspAlumno = $_POST['aprEspAlumno'];
        $gustaTraAlumno = $_POST['gustaTraAlumno'];
        $act1Alumno = $_POST['act1Alumno'];
        $act2Alumno = $_POST['act2Alumno'];
        $act3Alumno = $_POST['act3Alumno'];
        $act4Alumno = $_POST['act4Alumno'];
        $act5Alumno = $_POST['act5Alumno'];
        $act6Alumno = $_POST['act6Alumno'];
        $act7Alumno = $_POST['act7Alumno'];
        
        $usuario->actualizarAprendizajePerfil($idUsuario, $aprEspAlumno, $gustaTraAlumno, $act1Alumno, $act2Alumno, $act3Alumno, $act4Alumno, $act5Alumno, $act6Alumno, $act7Alumno);

        echo '1';

    break;
        /////////////////////////////////////
        ////////////////////////////////////
        ///////////////////////////////////

    ////////////////////////////////////////
    /////////// SOLAPA OBJETIVOS //////////
    //////////////////////////////////////
    
    case "insertarObjetivosPerfil":

       
        // Recoger los datos del formulario
        $idUsuario = $_POST['idUsuario'];
        $gus1EspAlumno = $_POST['gus1EspAlumno'];
        $gus2EspAlumno = $_POST['gus2EspAlumno'];
        $gus3EspAlumno = $_POST['gus3EspAlumno'];
        $gus4EspAlumno = $_POST['gus4EspAlumno'];
        $gus5EspAlumno = $_POST['gus5EspAlumno'];
        $gusTextEspAlumno = $_POST['gusTextEspAlumno'];
        $conAlumno = $_POST['conAlumno'];
        $conRecoAlumno = $_POST['conRecoAlumno'];
        $conAgenAlumno = $_POST['conAgenAlumno'];
            
        $usuario->actualizarObjetivosPerfil($idUsuario, $gus1EspAlumno, $gus2EspAlumno, $gus3EspAlumno, $gus4EspAlumno, $gus5EspAlumno, $gusTextEspAlumno, $conAlumno, $conRecoAlumno, $conAgenAlumno);


        echo '1';

    break;

     ////////////////////////////////////////
    /////////// SOLAPA ACTIVIDADES //////////
    //////////////////////////////////////
    
    case "insertarActividadesPerfil":

       
          // Recoger los valores de los checkbox y asignar 0 o 1 en función de si están marcados o no

            $idUsuario = $_POST['idUsuario'];
            $actSocialesAlumno = $_POST['actSocialesAlumno'];
            $actGastroAlumno = $_POST['actGastroAlumno'];
            $actCultAlumno = $_POST['actCultAlumno'];
            $actDepoAlumno = $_POST['actDepoAlumno'];
            $partActAlumno = $_POST['partActAlumno'];

            // Recoger el valor de numActAlumno
            $numActAlumno = $_POST['numActAlumno'];
            
        $usuario->actualizarActividadesPerfil($idUsuario, $actSocialesAlumno, $actGastroAlumno, $actCultAlumno, $actDepoAlumno, $partActAlumno, $numActAlumno);


        echo '1';

    break;
        /////////////////////////////////////
        ////////////////////////////////////
        ///////////////////////////////////

     ////////////////////////////////////////
    ///////// SOLAPA ADPTACIONES  //////////
    //////////////////////////////////////
    
    case "insertarAdaptacionesPerfil":

       
        // Recoger los valores de los checkbox y asignar 0 o 1 en función de si están marcados o no

          $idUsuario = $_POST['idUsuario'];
          $agoraAlumno = $_POST['agoraAlumno'];
          $minusvaliaAlumno = $_POST['minusvaliaAlumno'];
          $obsMinusvaliaAlumno = $_POST['obsMinusvaliaAlumno'];
       
          
      $usuario->actualizarAdaptacionesPerfil($idUsuario, $agoraAlumno, $minusvaliaAlumno, $obsMinusvaliaAlumno);


      echo '1';

  break;
      /////////////////////////////////////
      ////////////////////////////////////
      ///////////////////////////////////
        
    case "editarAvatar":

        session_start();
        $idUsuario = $_POST['idUsuario'];
        $avatarUsuario = $_FILES['avatar']['name'];

        // Crear carpeta imágenes de usuarios si no existe
        if (!file_exists("../public/assets/images/users/")) {
            mkdir("../public/assets/images/users/", 0777);
        }

        // Ruta de destino para guardar la imagen
        $destination = '../public/assets/images/users/' . $avatarUsuario;

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
            // Llamar a la función del modelo para editar el avatar del usuario
            $usuario->editarAvatar($avatarUsuario, $idUsuario);
            session_start();
            $_SESSION['usu_avatar'] = $avatarUsuario;
            $response = array(
                'status' => 'success',
                
                'message' => 'Avatar cambiado exitosamente.'
            );
        

            echo json_encode($response);
            exit;
        } else {
            // Error al mover la imagen
            $response = array(
                'status' => 'error',
                'message' => 'Error al cambiar el avatar.'
            );
            echo json_encode($response);
        }
        break;
}

<?php

//control de errores, habilitar si hay un error 500 y fijarse en el preview del navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/conexion.php");
require_once("../config/funciones.php");
require_once("../models/Llegadas.php");
require_once("../models/Proforma.php");

//require_once '../public/vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create an instance; passing `true` enables exceptions
//$mail = new PHPMailer(true);

session_start();

$llegada = new Llegadas();

$op = $_GET["op"];

switch ($op) {

    case "recogerLlegadas":

        $idPrescriptor = $_GET["idPrescriptor"];
        $dato = $llegada->recogerLlegadas($idPrescriptor);
        echo json_encode($dato);

        break;
    case "recogerLlegadaspost":

        $idPrescriptor = $_POST["idPrescriptor"];
        $dato = $llegada->recogerLlegadas($idPrescriptor);
        echo json_encode($dato);

        break;
    case "recogerLlegadasDT":

        $idPrescriptor = $_GET["idPrescriptor"];
        $datos = $llegada->recogerLlegadas($idPrescriptor);
      
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_llegada"];

           /*  $sub_array[] = "NUM" . str_pad($row["id_llegada"], 4, "0", STR_PAD_LEFT);  */
            $sub_array[] = "<label class='badge bg-black tx-14-force'>NUM-". str_pad($row["id_llegada"], 4, "0", STR_PAD_LEFT)."</label>";
            
            // Convertir $row["diainscripcion_llegadas"] a DD/MM/YYYY
            if (!empty($row["diainscripcion_llegadas"])) {
                $diainscripcion = DateTime::createFromFormat('Y-m-d', $row["diainscripcion_llegadas"]);
                $sub_array[] = $diainscripcion ? $diainscripcion->format('d/m/Y') : 'Formato no válido';
            } else {
                $sub_array[] = 'Dato no disponible';
            }
        
            // Convertir $row["fechallegada_llegadas"] a DD/MM/YYYY HH:MM
            if (!empty($row["fechallegada_llegadas"])) {
                $fechallegada = DateTime::createFromFormat('Y-m-d H:i:s', $row["fechallegada_llegadas"]);
                $sub_array[] = $fechallegada ? $fechallegada->format('d/m/Y H:i') : 'Formato no válido';
            } else {
                $sub_array[] = 'Dato no disponible';
            }
            $sub_array[] = $row["nombreDepartamento"];
            
            // Definir etiquetas de estado
               // Definir etiquetas de estado
            $estados = [
                '0' => "<label class='badge bg-danger tx-14-force'>Cancelado</label>",
                '1' => "<label class='badge bg-success tx-14-force'>En Proceso</label>",
                '2' => "<label class='badge bg-warning tx-14-force'>En Espera</label>",
                '3' => "<label class='badge bg-info tx-14-force'>Finalizada</label>",
                '4' => "<label class='badge bg-secondary tx-14-force'>Sin Servicio</label>",
                'default' => "<label class='badge bg-secondary tx-14-force'>Sin Resolver</label>"
            ];




            // Evaluar estMatricula
            $estadoMatricula = $estados[$row["estMatricula"]] ?? $estados['default'];

            // Evaluar estAlojamiento
            $estadoAlojamiento = $estados[$row["estAlojamiento"]] ?? $estados['default'];

            // Agregar ambos estados combinados
            $sub_array[] = $estadoMatricula . " - " . $estadoAlojamiento;

              ###############################################################################
            ##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   
            ##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)           
            ##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     
            ##     2 - ESPERANDO INICIO DE LA MATRICULACION                           
            ##     3 - FINALIZADA LA MATRICULACIÓN                                     
            ##     4 - NO TIENE MATRICULACIÓN                                          
            ###############################################################################
             // Evaluar estLlegada
             $sub_array[] = $estados[$row["estLlegada"]] ?? $estados['default'];
            
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

       // MÉTODO USADO EN js de educacion, en Perfil, para saber las llegadas en apartado Matriculaciones
case "recogerLlegadasPerfil":
    //$idPrescriptor = $_SESSION['usuPre_idInscripcion'] ?? null;
    $tokenUsu = $_GET['tokenUsuario'] ?? null;

    if ($tokenUsu == null) {
        echo json_encode([
            "error" => "No se encontró token en url."
        ]);
        exit;
    }

    $datos = $llegada->recogerLlegadasPorToken($tokenUsu);

    $data = array();

    foreach ($datos as $row) {
        $sub_array = array();

        // Número Llegada
        $sub_array[] = "<label class='badge bg-black tx-14-force'>NUM-" . str_pad($row["id_llegada"], 4, "0", STR_PAD_LEFT) . "</label>";

        // Día inscripción (formato DD/MM/YYYY)
        if (!empty($row["diainscripcion_llegadas"])) {
            $diainscripcion = DateTime::createFromFormat('Y-m-d', $row["diainscripcion_llegadas"]);
            $sub_array[] = $diainscripcion ? $diainscripcion->format('d/m/Y') : 'Formato no válido';
        } else {
            $sub_array[] = 'Dato no disponible';
        }

        // Fecha llegada (formato DD/MM/YYYY HH:mm)
        if (!empty($row["fechallegada_llegadas"])) {
            $fechallegada = DateTime::createFromFormat('Y-m-d H:i:s', $row["fechallegada_llegadas"]);
            $sub_array[] = $fechallegada ? $fechallegada->format('d/m/Y H:i') : 'Formato no válido';
        } else {
            $sub_array[] = 'Dato no disponible';
        }

        // Departamento
        $sub_array[] = $row["nombreDepartamento"];

        $estados = [
            '0' => "<label class='badge bg-danger tx-14-force'>Cancelado</label>",
            '1' => "<label class='badge bg-success tx-14-force'>En Proceso</label>",
            '2' => "<label class='badge bg-warning tx-14-force'>En Espera</label>",
            '3' => "<label class='badge bg-info tx-14-force'>Finalizada</label>",
            '4' => "<label class='badge bg-secondary tx-14-force'>En Espera</label>",
            'default' => "<label class='badge bg-secondary tx-14-force'>En Espera</label>"
        ];

        // Columna estado
        $sub_array[] = $estados[$row["estLlegada"]] ?? $estados['default'];

        // Columna acción con botones de acción
       /*  $botones = '<button title="Ver detalles" onClick=verDetalles("' . $row['id_llegada'] . '") class="btn btn-info btn-sm me-1" style="font-size: 0.85rem; width: 36px; height: 30px; padding: 4px 0; display: inline-flex; align-items: center; justify-content: center;">
        <svg class="svg-inline--fa fa-eye" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
        </button>'; */

        $botones = "<button type='button' onClick=cargarModalCursos('" . $row['id_llegada'] . "') title='Cargar cursos' class='btn btn-sm me-1' style='background-color: #f59e0b; color: white; font-size: 0.85rem; width: 36px; height: 30px; padding: 4px 0; display: inline-flex; align-items: center; justify-content: center;'>
        <i class='bi bi-book'></i>
        </button>";


        $sub_array[] = $botones;

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

case "recogerCertificadosPerfil":
    //$idPrescriptor = $_SESSION['usuPre_idInscripcion'] ?? null;
    $tokenUsu = $_GET['tokenUsuario'] ?? null;

    if ($tokenUsu === null) {
        echo json_encode([
            "error" => "No se encontró id de prescriptor en sesión o token en la URL."
        ]);
        exit;
    }

    $datos = $llegada->recogerLlegadasPorToken($tokenUsu);
    $data = [];

    $estados = [
        '0' => "<label class='badge bg-danger tx-14-force'>Cancelado</label>",
        '1' => "<label class='badge bg-success tx-14-force'>En Proceso</label>",
        '2' => "<label class='badge bg-warning tx-14-force'>En Espera</label>",
        '3' => "<label class='badge bg-info tx-14-force'>Finalizada</label>",
        '4' => "<label class='badge bg-secondary tx-14-force'>En Espera</label>",
        'default' => "<label class='badge bg-secondary tx-14-force'>En Espera</label>"
    ];

    foreach ($datos as $row) {
        $sub_array = [];

        $sub_array[] = "<label class='badge bg-black tx-14-force'>NUM-" . str_pad($row["id_llegada"], 4, "0", STR_PAD_LEFT) . "</label>";

        if (!empty($row["diainscripcion_llegadas"])) {
            $diaInscripcion = DateTime::createFromFormat('Y-m-d', $row["diainscripcion_llegadas"]);
            $sub_array[] = $diaInscripcion ? $diaInscripcion->format('d/m/Y') : 'Formato no válido';
        } else {
            $sub_array[] = 'Dato no disponible';
        }

        $sub_array[] = $row["nombreDepartamento"] ?? 'Dato no disponible';

        $estadoKey = isset($row["estLlegada"]) ? (string)$row["estLlegada"] : 'default';
        $sub_array[] = $estados[$estadoKey] ?? $estados['default'];

       $hrefCertificado = '../EvaluacionFinal/certificado.php?idLlegada=' . urlencode($row["id_llegada"]) . '&tokenUsu=' . urlencode($tokenUsu);

        if ($row["mostrarCertificadoEvaluacionFinal"] === '0' || $row["mostrarCertificadoEvaluacionFinal"] === 0 || $row["mostrarCertificadoEvaluacionFinal"] === null) {
            // Botón deshabilitado sin href y con evento onclick
            /*
            CODIGO BUENO, POR AHORA LO DEJO COMENTADO APOSTA 
            $botonVer = '<button type="button" class="btn btn-secondary btn-sm btn-no-certificado" title="Certificate not available" ' .
                        'style="font-size: 0.85rem; width: 36px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">' .
                        '<i class="fa-solid fa-ban"></i></button>';*/
                        /* CÓDIGO QUE HAY QUE CAMBIAR, SE UTILIZA REALMENTE EL DE ARRIBA, EL DE ABAJO ES SOLO PARA PRUEBAS */
            $botonVer = '<a href="' . $hrefCertificado . '" target="_blank" class="btn btn-success btn-sm" title="Download Certificate" ' .
                        'style="font-size: 0.85rem; width: 36px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">' .
                        '<i class="fa-solid fa-award"></i></a>';

        } else if ($row["mostrarCertificadoEvaluacionFinal"] === '1' || $row["mostrarCertificadoEvaluacionFinal"] === 1) {
            // Botón activo con href
            $botonVer = '<a href="' . $hrefCertificado . '" target="_blank" class="btn btn-success btn-sm" title="Download Certificate" ' .
                        'style="font-size: 0.85rem; width: 36px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">' .
                        '<i class="fa-solid fa-award"></i></a>';
        }




        $sub_array[] = $botonVer;

        $data[] = $sub_array;
    }

    echo json_encode([
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    ]);

    break;


    case "agregarLlegada":
       
            // Iterar sobre los datos enviados y asignarlos a variables
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
      
        $ultimaIdLlegada = $llegada->guardarLlegada(
                $idLlegada,
                $diaInscripcion,
                $idPrescriptorDatos,
                $departamentoSelect,
                $nombreApellidos,
                $sexo,
                $pais,
                $idAgente,
                $idGrupo,
                $idGrupoAmigo,
                $fechaLlegada,
                $lugarLlegada,
                $recogeAlumno
            ); 
            echo json_encode((int)$ultimaIdLlegada);
     break;

    case "editarLlegada":
      
            
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
    
        $idLlegada = str_replace("NUM", "", $idLlegada);
    
        // Llamada al método para guardar los datos
        $llegada->editarLlegada(
            $idLlegada,
            $diaInscripcion,
            $idPrescriptorDatos,
            $departamentoSelect,
            $nombreApellidos,
            $sexo,
            $pais,
            $idAgente,
            $idGrupo,
            $idGrupoAmigo,
            $fechaLlegada,
            $lugarLlegada,
            $recogeAlumno
        );

    break;
 

    case "recogerLledagasXIdLlegada":
        $idLlegadas = $_POST["idLlegadas"];

        $datos = $llegada->recogerLlegadasXID($idLlegadas);
       
        echo json_encode($datos);
        break;
    case "agruparLlegadasGrupo":
        $grupo = $_POST["grupo"];
        $datos = $llegada->recogerLlegadasXGrupo($grupo);
        echo json_encode($datos);

        break;
    case "guardarProforma":
        $dataFactura = $_POST["dataFactura"];

        $llegada->guardarProforma($dataFactura);
        echo json_encode($datos);
        break;

    case "actualizarProforma":
        $dataFactura = $_POST["dataFactura"];

        $llegada->actualizarProforma($dataFactura);
        echo json_encode($datos);
        break;
   case "llegadasUsu":

    $idPrescriptor = $_SESSION['usuPre_idInscripcion'];
  
    $dato = $llegada->recogerLlegadasHomeDocencia($idPrescriptor);
    $cantidadResultados = count($dato);

    if($cantidadResultados == 1){
        $_SESSION['llegada_idLlegada'] = $dato[0]['id_llegada'];
        $_SESSION['llegada_nombreDepartamento'] = $dato[0]['nombreDepartamento'];
        $_SESSION['llegada_idDepartamento'] = $dato[0]['idDepartamentoEdu'];
        $_SESSION['llegada_colorDepartamento'] = trim($dato[0]['colorDepartamento']); // añadimos el color
       
        echo 'only';
    } else {
        echo json_encode($dato);
    }

    break;

    case "guardarDatosLlegada":

    $llegadaSelect = $_POST["llegadaSelect"];

    $dato = $llegada->recogerLlegadasHomexId($llegadaSelect);
   
    $estLlegada = $dato[0]['estLlegada'];

    if($estLlegada == 1){
        echo 1;
        // SESIONES DE LLEGADAS //
        $_SESSION['llegada_idLlegada'] =  $dato[0]['id_llegada'];
        $_SESSION['llegada_nombreDepartamento'] =  $dato[0]['nombreDepartamento'];
        $_SESSION['llegada_idDepartamento'] =  $dato[0]['idDepartamentoEdu'];
        $_SESSION['llegada_colorDepartamento'] = trim($dato[0]['colorDepartamento']);

    }else{
        echo 0;
    }

    break;

    //================//
    // APARTADO NUEVO //
    //================//

    case "listarMatriculaciones":
    try {
        $proforma = new Proforma();

        $idLlegada = isset($_GET['idLlegada']) ? $_GET['idLlegada'] : null;
        if (!$idLlegada) {
            throw new Exception("Parámetro 'idLlegada' no proporcionado.");
        }

        // Consultamos si hay facturas activas (proforma o real) asociadas a la llegada
        $facturasActivas = $proforma->comprobarFacturasProformaRealesActivasSinAbonar($idLlegada);

        $facturaProforma = $facturasActivas['factura_proforma'];
        $facturaReal = $facturasActivas['factura_real'];

        $datos = $llegada->listarMatriculaciones($idLlegada);

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = strtoupper($row["codTarifa_matriculacion"]);
            $sub_array[] = $row["nombreTarifa_matriculacion"];
            $sub_array[] = $row["obsMatriculacion"];
            $sub_array[] = $row["precioTarifa_matriculacion"];
            $sub_array[] = $row["idIvaTarifa_matriculacion"];
            $sub_array[] = $row["descuento_matriculacion"];
            $sub_array[] = '<p class="tx-success tx-bold">' . fechaLocal($row["fechaInicioMatriculacion"]) . '</p>';
            $sub_array[] = '<p class="tx-danger  tx-bold">' . fechaLocal($row["fechaFinMatriculacion"]) . '</p>';

            ###############################################################################
            ##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   
            ##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)           
            ##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     
            ##     2 - ESPERANDO INICIO DE LA MATRICULACION                           
            ##     3 - FINALIZADA LA MATRICULACIÓN                                     
            ##     4 - NO TIENE MATRICULACIÓN                                          
            ###############################################################################
            if ($row["estMatriculacion_llegadas"] == '0') {
                $sub_array[] = "<label class='badge bg-danger tx-14-force'>Cancelado</label>";
            } elseif ($row["estMatriculacion_llegadas"] == '1') {
                $sub_array[] = "<label class='badge bg-success tx-14-force'>En Proceso</label>";
            } elseif ($row["estMatriculacion_llegadas"] == '2') {
                $sub_array[] = "<label class='badge bg-warning tx-14-force'>En Espera</label>";
            } elseif ($row["estMatriculacion_llegadas"] == '3') {
                $sub_array[] = "<label class='badge bg-info tx-14-force'>Finalizada</label>";
            } else {
                $sub_array[] = "<label class='badge bg-secondary tx-14-force'>Sin Resolver</label> ";
            }

            // Deshabilitamos acciones si existe factura proforma o real activa
            if ($facturaProforma == "1" || $facturaReal == "1") {
                $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Matricula' disabled onClick='editarMatriculaNew(" . $row["idMatriculacionLlegada"] . ")'><i class='fa fa-edit'></i></button>"
                    . "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Matricula' disabled onClick='eliminarMatriculaNew(" . $row["idMatriculacionLlegada"] . ")'><i class='fa fa-xmark'></i></button>";
            } else {
                $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Matricula' onClick='editarMatriculaNew(" . $row["idMatriculacionLlegada"] . ")'><i class='fa fa-edit'></i></button>"
                    . "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Matricula' onClick='eliminarMatriculaNew(" . $row["idMatriculacionLlegada"] . ")'><i class='fa fa-xmark'></i></button>";
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

        // Debug eliminado - causaba warning de permisos
    } catch (Exception $e) {
        // Capturamos errores y los registramos
        $error = [
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => [],
            "error" => true,
            "message" => $e->getMessage(),
            "code" => $e->getCode()
        ];

        echo json_encode($error);

        // Guardamos error para depuración
        file_put_contents('listarMatriculaciones_ERROR.json', json_encode($error, JSON_PRETTY_PRINT));
    }
    break;


    // INSERTAR MATRICULA

    case "insertarMatricula":
      
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
  
        // Llamada al método para guardar los datos
        $llegada->insertarMatriculacion(
            $idLlegada,$inicioDocencia,
    $finalDocencia,
    $codDocencia,
    $textEditar,
    $importeDocencia,
    $ivaDocencia,
    $descDocencia,
    $observacionesDocencias
          
        );

    case "editarMatricula":
    
        
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
    
    
        // Llamada al método para guardar los datos
        $llegada->editarMatriculacion($idMatriculaEditando,
            $idLlegada,$inicioDocencia,
            $finalDocencia,
            $codDocencia,
            $descripcion,
            $importeDocencia,
            $ivaDocencia,
            $descDocencia,
            $observacionesDocencias
        );

    break;
     
    break;
    

    case "recogerMatriculaxId":
      
        $idMatricula = $_POST['idMatricula'];
       
        // Llamada al método para guardar los datos
        $results = $llegada->recogerMatriculaxId($idMatricula);

        echo json_encode($results);

    break;
   
    //================//
    //================//
    //================//
    case "eliminarMatricula":

        $idMatricula = $_POST['idMatricula'];
           
        // Llamada al método para guardar los datos
        $llegada->eliminarMatricula($idMatricula);
    
      
        break;
    
        //================//
        //================//
        //================//

    // PAGO ANTICIPADO 

    case "insertarPagoAnticipado":
      
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }

        // Llamada al método para guardar los datos
        $llegada->insertarPagoAnticipado($idLlegadas,$importePago,$fechaPago,$medioPago,$comentarioPago);

    break;
    case "guardarEdicionPago":
      
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }

        // Llamada al método para guardar los datos
        $llegada->guardarEdicionPago($idPagoEditando,$importePago,$fechaPago,$medioPago,$comentarioPago);

    break;
    case "actualizarVisado":
      
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }

        // Llamada al método para guardar los datos
        $llegada->actualizarVisado($idLlegada,$visadoCheck,$fechaAdmision,$denegacionFecha,$denegacionMotivo);

    break;
    
    case "pagoAnticipadoxId":
      
        $idPago = $_POST['idPago'];
       
        // Llamada al método para guardar los datos
        $results = $llegada->recogerPagoxId($idPago);

        echo json_encode($results);

    break;

    case "listarPagoAnticipado":
        $idLlegada = $_GET['idLlegada'];

        $datos = $llegada->listarPagoAnticipado($idLlegada);

        $data = array();
    
        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["importePagoAnticipado"].'€';
                $sub_array[] = fechaLocal($row["fechaPagoAnticipado"]);
                $sub_array[] = strtoupper($row["nomMedioPago"]);
                $sub_array[] = $row["observacionPagoAnticipado"];
             
                $sub_array[] = "<button class='btn btn-info wave-effect ' title='Editar Pago' onClick='editarPagoAnticipado(" . $row["idPagoAnticipado"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Pago Anticipado' onClick='eliminarPagoAnticipado(" . $row["idPagoAnticipado"] . ")'><i class='fa fa-xmark'></i></button>";
                
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


    //================//
    //================//
    //================//
    case "eliminarPagoAnticipado":

        $idPago = $_POST['idPago'];
           
        // Llamada al método para guardar los datos
        $llegada->eliminarPagoAnticipado($idPago);
    
      
        break;


    //================//
    //================//
    //================//
    case "eliminarSuplido":

        $idSuplido = $_POST['idSuplido'];
           
        // Llamada al método para guardar los datos
        $llegada->eliminarSuplidos($idSuplido);
    
      
        break;

        
        case "agregarSuplido":
      
            $idLlegada = $_POST['idLlegada'];
            $importeSuplido = $_POST['importeSuplido'];
            $descrSuplido = $_POST['descrSuplido'];
           
    
    
            // Llamada al método para guardar los datos
            $results = $llegada->insertarSuplidos($idLlegada,$importeSuplido,$descrSuplido);
    
            echo json_encode($results);
    
        break;
   //================//
    //================//
    //================//

    case "agregarNivel":

        $idLlegada = $_POST['idLlegada'];
        $nivelDocencia = $_POST['nivelDocencia'];
        $observacionesNivel = $_POST['observacionesNivel'];
        $nivelDocenciaAsignado = $_POST['nivelDocenciaAsignado'];
        $semanaDocenciaAsignado = $_POST['semanaDocenciaAsignado'];


        // Llamada al método para guardar los datos
        $results = $llegada->insertarNivel($idLlegada,$nivelDocencia,$observacionesNivel,$nivelDocenciaAsignado,$semanaDocenciaAsignado);

        echo json_encode($results);

    break;

    case "agregarTransfer":

        $idLlegada = $_POST['idLlegada'];
        $codigoTarifasLlegada = $_POST['codigoTarifasLlegada'];
        $textoTarifasLlegada = $_POST['textoTarifasLlegada'];
        $importeTarifasLlegada = $_POST['importeTarifasLlegada'];
        $ivaTarifasLlegada = $_POST['ivaTarifasLlegada'];
        $diaLlegada = $_POST['diaLlegada'];
        $horaLlegada = $_POST['horaLlegada'];
        $lugarRecogidaLlegada = $_POST['lugarRecogidaLlegada'];
        $lugarEntregaLlegada = $_POST['lugarEntregaLlegada'];
        $quienRecogeLlegada = $_POST['quienRecogeLlegada'];
        $codigoTarifasRegreso = $_POST['codigoTarifasRegreso'];
        $textoTarifasRegreso = $_POST['textoTarifasRegreso'];
        $importeTarifasRegreso = $_POST['importeTarifasRegreso'];
        $ivaTarifasRegreso = $_POST['ivaTarifasRegreso'];
        $diaRegreso = $_POST['diaRegreso'];
        $horaRegreso = $_POST['horaRegreso'];
        $lugarRecogidaRegreso = $_POST['lugarRecogidaRegreso'];
        $lugarEntregaRegreso = $_POST['lugarEntregaRegreso'];
        $quienRecogeRegreso = $_POST['quienRecogeRegreso'];
        $observaciones = $_POST['observaciones'];


        // Llamada al método para guardar los datos
        $results = $llegada->insertarTransfer(
            $idLlegada,
            $codigoTarifasLlegada,
            $textoTarifasLlegada,
            $importeTarifasLlegada,
            $ivaTarifasLlegada,
            $diaLlegada,
            $horaLlegada,
            $lugarRecogidaLlegada,
            $lugarEntregaLlegada,
            $quienRecogeLlegada,
            $codigoTarifasRegreso,
            $textoTarifasRegreso,
            $importeTarifasRegreso,
            $ivaTarifasRegreso,
            $diaRegreso,
            $horaRegreso,
            $lugarRecogidaRegreso,
            $lugarEntregaRegreso,
            $quienRecogeRegreso,
            $observaciones
        );

        echo json_encode($results);

    break;
   
    //SUPLIDOS

    
    case "listarSuplidos":
        $idLlegada = $_GET['idLlegada'];

        $datos = $llegada->listarSuplidos($idLlegada);

        $data = array();
    
        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = $row["importeSuplido"].'€';
                $sub_array[] = $row["descripcionSuplido"];
             
                $sub_array[] = "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Suplido' onClick='eliminarSuplido(" . $row["idSuplido"] . ")'><i class='fa fa-xmark'></i></button>";
                
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

    //CANCELACION

    case "insertarCancelacion":

        $idLlegada = $_POST['idLlegada'];
        $fechaCancelacion = $_POST['fechaCancelacion'];
        $motivoCancelacion = $_POST['motivoCancelacion'];
     

        // Llamada al método para guardar los datos
        $results = $llegada->insertarCancelacion($idLlegada,$fechaCancelacion,$motivoCancelacion);

        echo json_encode($results);

    break;
    
    case "eliminarCancelacion":

        $idLlegada = $_POST['idLlegada'];
     

        // Llamada al método para guardar los datos
        $results = $llegada->eliminarCancelacion($idLlegada);

        echo json_encode($results);

    break;
    
    case "actualizarMatriculacion":

        $idLlegada = $_POST['idLlegada'];

        $llegada->actualizarMatriculacion($idLlegada);

    break;
    
    // ALOJAMIENTO
 
    case "actualizarAlojamiento":

        $idLlegada = $_POST['idLlegada'];
       
        $llegada->actualizarAlojamiento($idLlegada);

    break;

    case "listarAlojamientos":
        $proforma = new Proforma();
        $idLlegada = $_GET['idLlegada'];
        // Consultamos si hay facturas activas (proforma o real) asociadas a la llegada
        $facturasActivas = $proforma->comprobarFacturasProformaRealesActivasSinAbonar($idLlegada);

        $facturaProforma = $facturasActivas['factura_proforma'];
        $facturaReal = $facturasActivas['factura_real'];

        $datos = $llegada->listarAlojamientos($idLlegada);

        $data = array();
     
        foreach ($datos as $row) {         
                $sub_array = array();
                $sub_array[] = strtoupper($row["codTarifa_alojamientos"]);
                $sub_array[] = $row["nombreTarifa_alojamientos"];
                $sub_array[] = $row["precioTarifa_alojamientos"];
                $sub_array[] = $row["idIvaTarifa_alojamientos"];
                $sub_array[] = $row["descuento_Alojamientos"];
                $sub_array[] = '<p class="tx-success tx-bold">'.fechaLocal($row["fechaInicioAlojamientos"]).'</p>';
                $sub_array[] = '<p class="tx-danger  tx-bold">'.fechaLocal($row["fechaFinAlojamientos"]).'</p>';

                ###############################################################################
                ##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   
                ##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)           
                ##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     
                ##     2 - ESPERANDO INICIO DE LA MATRICULACION                           
                ##     3 - FINALIZADA LA MATRICULACIÓN                                     
                ##     4 - NO TIENE MATRICULACIÓN                                          
                ###############################################################################
                if ($row["estAlojamientos_llegadas"] == '0' ) {
                    $sub_array[] = "<label class='badge bg-danger tx-14-force'>Cancelado</label>";
                } elseif ($row["estAlojamientos_llegadas"] == '1') {
                    $sub_array[] = "<label class='badge bg-success tx-14-force'>En Proceso</label>";
                } elseif ($row["estAlojamientos_llegadas"] == '2') {
                    $sub_array[] = "<label class='badge bg-warning tx-14-force'>En Espera</label>";
                }elseif ($row["estAlojamientos_llegadas"] == '3') {
                    $sub_array[] = "<label class='badge bg-info tx-14-force'>Finalizada</label>";
                } else {
                    $sub_array[] = "<label class='badge bg-secondary tx-14-force'>Sin Resolver</label> ";
                }
                
                //$sub_array[] = "<button class='btn btn-info wave-effect ' title='Editar Alojamiento' onClick='editarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-edit'></i></button><button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Alojamiento' onClick='eliminarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-xmark'></i></button>";
                // SI EXISTE FACTURA PROFORMA O REAL ASOCIADA A LA LLEGADA, SE DESHABILITAN LAS OPCIONES DE ACCIÓN
                if ($facturaProforma == "1" || $facturaReal == "1") {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Alojamiento' disabled onClick='editarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-edit'></i></button>"
                                . "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Alojamiento' disabled onClick='eliminarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-xmark'></i></button>";
                } else if ($facturaProforma == "0" && $facturaReal == "0") {
                    $sub_array[] = "<button class='btn btn-info wave-effect' title='Editar Alojamiento' onClick='editarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-edit'></i></button>"
                                . "<button class='btn btn-danger waves-effect mg-l-10' title='Eliminar Alojamiento' onClick='eliminarAlojamientoNew(" . $row["idAlojamientoLlegada"] . ")'><i class='fa fa-xmark'></i></button>";
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

    
    case "insertarAlojamiento":
      
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
   
        // Llamada al método para guardar los datos
        $llegada->insertarAlojamiento(
                $idLlegada,$entradaAlojamiento,
            $salidaAlojamiento,
            $codAlojamiento,
            $textEditar,
            $importeAlojamiento,
            $ivaAlojamiento,
            $descuentoAlojamiento,
            $observacionesAlojamiento
        );
    break;
    case "recogerAlojamientoxId":
      
        $idAlojamiento = $_POST['idAlojamiento'];
       
        // Llamada al método para guardar los datos
        $results = $llegada->recogerAlojamientoxId($idAlojamiento);

        echo json_encode($results);

    break;
    
    case "editarAlojamiento":
    
        
        foreach ($_POST as $key => $value) {
            $$key = $value;
        }
    
       
        // Llamada al método para guardar los datos
        $llegada->editarAlojamiento($idAlojamientoEditando,
            $idLlegada,$entradaAlojamiento,
            $salidaAlojamiento,
            $codAlojamiento,
            $textEditar,
            $importeAlojamiento,
            $ivaAlojamiento,
            $descuentoAlojamiento,
            $observacionesAlojamiento
        );

    break;
       //================//
    //================//
    //================//
    case "eliminarAlojamiento":

        $idAlojamiento = $_POST['idAlojamiento'];
            
        // Llamada al método para guardar los datos
        $llegada->eliminarAlojamiento($idAlojamiento);

    
    break;

    // CASO DE LA VISTA MNT FACTURACIÓN, DESDE ALLÍ NO TENGO DESDE EL INICIO EL ID LLEGADA,
    // LO TENGO QUE SACAR DEL TR DEL DATATABLE, POR ELLO NO PUEDO OBTENER EL ID DEPARTAMENTO
    // ESTE MÉTODO ESTA PENSADO PARA QUE A LA HORA DE ABONAR UNA FACTURA PRO O REAL, PODER OBTENER
    // EL ID DEPARTAMENTO Y PODER REALIZAR LA OPERACIÓN SATISFACTORIAMENTE
    case "getDepartamentoByLlegada":
    $idLlegada = $_POST["idLlegada"];

    $datosLlegada = $llegada->recogerLlegadasHomexId($idLlegada);

    echo json_encode($datosLlegada);
    break;

    case "grupoFacturado":

        $nombreGrupo = $_POST["nombreGrupo"];
        $dato = $llegada->grupoFacturado($nombreGrupo);
        echo json_encode($dato);

    break;
    
    default:
        echo "No se ha encontrado esta opción";

    
}



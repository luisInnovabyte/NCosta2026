<?php
class Prescriptor extends Conectar
{

    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores`";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarInscripcionesConUsuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_prescriptores LEFT JOIN tm_usuario ON tm_prescriptores.idPrescripcion = tm_usuario.idInscripcion_tmusuario WHERE tm_usuario.rolUsu = 3 ORDER BY `tm_prescriptores`.`idPrescripcion` DESC";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementoxID($idPrescriptor)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` where `idPrescripcion` = $idPrescriptor";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function mostrarElementoxIDAgente($idAgente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` where `idAgente` = $idAgente";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementoxToken($token)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` where `tokenPrescriptores` = '$token'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementosActivos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos` WHERE `estProfesion` = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerDepartamentoNumeroFact($idDepartamento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu` WHERE idDepartamentoEdu = $idDepartamento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
   


    public function insertarPrescriptor($nombreCliente,$sexoCliente,$apellidoCliente,$fechCliente,$fechaPrevista,$emailCasa,$emailAlt,$fech1Contacto,$dirCasa,$dirAlt,$cursoDeseado,$cpCasa,$cpAlt,$conocimiento1,$ciudadCasa,$ciudadAlt,$conocimiento2,$paisCasa,$paisAlt,$conocimiento3,$tefCasa,$tefAlt,$probablemente,$movilCasa,$movilAlt,$grupoCliente,$erasmusCliente,$uniOrigen,$Bildungsurlaub,$aupair,$preferenciaHoraria,$fechaConfirmacion,$matCurso,$matAlojamiento,$matFechInicio,$textTipo,$tokenPreinscriptor,$departamentoSelect,$tipoIdentificador,$identificador,$nombreMadrePre,$nombrePadrePre,$numPadrePre,$numMadrePre,$interesadoOnlinePre,$nacionalidadPre)
    {
  
        $conectar = parent::conexion();
        parent::set_names();

        // Verificar si las fechas están vacías y asignar NULL en su lugar
        $fechCliente = empty($fechCliente) ? '1970-01-01' : $fechCliente;
        $fechaPrevista = empty($fechaPrevista) ? '1970-01-01' : $fechaPrevista;
        $fech1Contacto = empty($fech1Contacto) ? '1970-01-01' : $fech1Contacto;
        $fechaConfirmacion = empty($fechaConfirmacion) ? '1970-01-01' : $fechaConfirmacion;
        $matFechInicio = empty($matFechInicio) ? '1970-01-01' : $matFechInicio;

        $sql = "INSERT INTO `tm_prescriptores` (`nomPrescripcion`, `apePrescripcion`, `sexoPrescripcion`, `fecNacPrescripcion`, `anoPrevistoPrescripcion`, `emailCasaPrescripcion`, 
        `emailAltPrescripcion`, `fechContactoPrescripcion`, `dirCasaPrescripcion`, `dirAltPrescripcion`, `cursoPrescripcion`, `cpCasaPrescripcion`, 
        `cpAltPrescripcion`, `cono1Prescripcion`, `ciudadCasaPrescripcion`, `ciudadAltPrescripcion`, `cono2Prescripcion`, `paisCasaPrescripcion`, 
        `paisAltPrescripcion`, `cono3Prescripcion`, `tefCasaPrescripcion`, `tefAltPrescripcion`, `probablementePrescripcion`, `movilCasaPrescripcion`, 
        `movilAltPrescripcion`, `grupoPrescripcion`, `erasmusPrescripcion`, `uniOrigenPrescripcion`, `bildungsurlaub`, `auPair`, `fechMatConfirmacion`, `matCurso`, `matAloja`, `matFechInicio`, `obsPrescriptor`, `estPrescripcion`, `tokenPrescriptores`, `numLlegada`, `idDepartamentoEdu_prescriptores`, `fecPrescripcion`, `tipoDocumento`, `identificadorDocumento`, `nombreMadrePre`, `nombrePadrePre`, `numPadrePre`, `numMadrePre`, `interesadoOnlinePre`, `nacionalidadPreinscriptor`,`preferenciaHoraria`) 
        VALUES
         ('$nombreCliente','$apellidoCliente','$sexoCliente','$fechCliente','$fechaPrevista','$emailCasa','$emailAlt','$fech1Contacto','$dirCasa',
         '$dirAlt','$cursoDeseado','$cpCasa','$cpAlt','$conocimiento1','$ciudadCasa','$ciudadAlt','$conocimiento2','$paisCasa','$paisAlt','$conocimiento3'
         ,'$tefCasa','$tefAlt','$probablemente','$movilCasa','$movilAlt','$grupoCliente','$erasmusCliente','$uniOrigen','$Bildungsurlaub','$aupair', '1970-01-01','$matCurso','$matAlojamiento','$matFechInicio','$textTipo',1,'$tokenPreinscriptor','11','$departamentoSelect',now(),'$tipoIdentificador','$identificador','$nombreMadrePre','$nombrePadrePre','$numPadrePre','$numMadrePre','$interesadoOnlinePre','$nacionalidadPre','$preferenciaHoraria');";
       
            $sql = $conectar->prepare($sql);
            $sql->execute();

        // Obtener el último ID insertado
        $lastInsertIdInteresado = $conectar->lastInsertId();

        //***************************************/
        //********  CREACIÓN DE USUARIO  ********/
        //***************************************/

        $contador = 0;
       
        $correo = trim($emailCasa);
        $correo = strtolower($correo);

        $nombreCliente = sanearLogin($nombreCliente);
        $nombreUsuario = $nombreCliente;

       
        do {
            // Generar un número aleatorio de 3 cifras
            $numeroAleatorio = rand(100, 999);
            $nombreUsuario = trim($nombreUsuario);

            // Generar el nickname
            $nickUsuario =  $nombreUsuario.$numeroAleatorio;

            // Consulta SQL para buscar el usuario
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) as total FROM tm_usuario WHERE LOWER(nickUsu) = LOWER('$nickUsuario')";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            $resultado = $sql->fetch();

            $contador = $contador+1;
            if($contador > 4){
                $json_string = json_encode($contador);
                $file = 'AlertBucle.json';
                file_put_contents($file, $json_string);
            }

        } while ($resultado['total'] > 0); // Repetir si el nickname ya existe


        // Ahora que el nickname es único, puedes proceder con la inserción
        $sql = "INSERT INTO `tm_usuario`(`nickUsu`, `correoUsu`, `senaUsu`, `rolUsu`, `estUsu`, `obsUsu`, `avatarUsu`, `generoUsu`, `fecAltaUsu`, `fecBajaUsu`, `fecModiUsu`, `motivoBajaUsu`, `nombreUsu`, `apellidosUsu`, `fechaNacimientoUsu`, `telefonoUsu`, `movilUsu`, `razonSocialFacturacionUsu`, `identificacionFiscalUsu`, `direccionFacturacionUsu`, `codigoPostalUsu`, `provinciaUsu`, `ciudadPuebloUsu`, `paisUsu`, `personalizacionUsu`, `idiomaUsu`, `recibirNotificacionesUsu`, `registroInicioSesionUsu`, `accesoPrivadoUsu`, `ipUsu`, `tokenUsu`, `registroUsu`, `uuidUsu`, `idSoporte_tmUsuario`, `idTransportista_transportistas-Transporte`, `idAlumno_tmusuario`, `idInscripcion_tmusuario`) VALUES 
        ('$nickUsuario','$correo',MD5('AlumnoCosta12'),'3','1','Creado desde interesados','alumnoAvatar.png','x',CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),null,null,null,'$nombreCliente','$apellidoCliente','2020-10-10','$tefCasa','MOVIL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$tokenPreinscriptor',NULL,NULL,NULL,NULL,NULL,$lastInsertIdInteresado)";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // Obtener el último ID insertado
        $lastInsertIdUsuario = $conectar->lastInsertId();


        // Ahora que el nickname es único, puedes proceder con la inserción
        $sql = "INSERT INTO `tm_alumno_edu`(`nomUsuario`,`emailUsuario`,`fecAltaUsuario`, `estUsu`, `nomAlumno`, `apeAlumno`, `fecNacAlumno`, `tokenUsu`, `identificadorPersonal`, `idInscripcion_tmAlumno`, `idUsuario_tmalumno`) 
        VALUES ('$nickUsuario','$correo',CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid'),1,'$nombreCliente','$apellidoCliente','$fechCliente','$tokenPreinscriptor','$identificador',$lastInsertIdInteresado,$lastInsertIdUsuario);";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();


        //***************************************/
        //***************************************/
        //***************************************/

        return $resultado = $sql->fetchAll();
    }
    public function actualizarPrescriptor($prescriptorID,$nombreCliente,$sexoCliente,$apellidoCliente,$fechCliente,$fechaPrevista,$emailCasa,$emailAlt,$fech1Contacto,$dirCasa,$dirAlt,$cursoDeseado,$cpCasa,$cpAlt,$conocimiento1,$ciudadCasa,$ciudadAlt,$conocimiento2,$paisCasa,$paisAlt,$conocimiento3,$tefCasa,$tefAlt,$probablemente,$movilCasa,$movilAlt,$grupoCliente,$erasmusCliente,$uniOrigen,$Bildungsurlaub,$aupair,$preferenciaHoraria,$fechaConfirmacion,$matCurso,$matAlojamiento,$matFechInicio,$textTipo,$departamentoSelect,$tipoIdentificador, $identificador, $nombreMadrePre,$nombrePadrePre,$numPadrePre,$numMadrePre,$interesadoOnlinePre,$nacionalidadPre)
    {
        $conectar = parent::conexion();
        parent::set_names();
                // Verificar si las fechas están vacías y asignar NULL en su lugar
                $fechCliente = empty($fechCliente) ? '1970-01-01' : $fechCliente;
                $fechaPrevista = empty($fechaPrevista) ? '1970-01-01' : $fechaPrevista;
                $fech1Contacto = empty($fech1Contacto) ? '1970-01-01' : $fech1Contacto;
                $fechaConfirmacion = empty($fechaConfirmacion) ? '1970-01-01' : $fechaConfirmacion;
                $matFechInicio = empty($matFechInicio) ? '1970-01-01' : $matFechInicio;
        $sql = "UPDATE `tm_prescriptores` SET 
        `nomPrescripcion` = '$nombreCliente',
        `apePrescripcion` = '$apellidoCliente',
        `sexoPrescripcion` = '$sexoCliente',
        `fecNacPrescripcion` = '$fechCliente',
        `anoPrevistoPrescripcion` = '$fechaPrevista',
        `emailCasaPrescripcion` = '$emailCasa',
        `emailAltPrescripcion` = '$emailAlt',
        `fechContactoPrescripcion` = '$fech1Contacto',
        `dirCasaPrescripcion` = '$dirCasa',
        `dirAltPrescripcion` = '$dirAlt',
        `cursoPrescripcion` = '$cursoDeseado',
        `cpCasaPrescripcion` = '$cpCasa',
        `cpAltPrescripcion` = '$cpAlt',
        `cono1Prescripcion` = '$conocimiento1',
        `ciudadCasaPrescripcion` = '$ciudadCasa',
        `ciudadAltPrescripcion` = '$ciudadAlt',
        `cono2Prescripcion` = '$conocimiento2',
        `paisCasaPrescripcion` = '$paisCasa',
        `paisAltPrescripcion` = '$paisAlt',
        `cono3Prescripcion` = '$conocimiento3',
        `tefCasaPrescripcion` = '$tefCasa',
        `tefAltPrescripcion` = '$tefAlt',
        `probablementePrescripcion` = '$probablemente',
        `movilCasaPrescripcion` = '$movilCasa',
        `movilAltPrescripcion` = '$movilAlt',
        `grupoPrescripcion` = '$grupoCliente',
        `erasmusPrescripcion` = '$erasmusCliente',
        `uniOrigenPrescripcion` = '$uniOrigen',
        `bildungsurlaub` = '$Bildungsurlaub',
        `auPair` = '$aupair',
        `fechMatConfirmacion` = '1970-10-10',
        `matCurso` = '$matCurso',
        `matAloja` = '$matAlojamiento',
        `matFechInicio` = '$matFechInicio',
        `obsPrescriptor` = '$textTipo',
        `idDepartamentoEdu_prescriptores` = '$departamentoSelect',
        `tipoDocumento` = '$tipoIdentificador',
        `identificadorDocumento` = '$identificador',
        `nombreMadrePre` = '$nombreMadrePre',
        `nombrePadrePre` = '$nombrePadrePre',
        `numPadrePre` = '$numPadrePre',
        `numMadrePre` = '$numMadrePre',
        `interesadoOnlinePre` = '$interesadoOnlinePre',
        `nacionalidadPreinscriptor` = '$nacionalidadPre',
        `preferenciaHoraria` = '$preferenciaHoraria'
        WHERE `idPrescripcion` = $prescriptorID;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($descripcion, $color)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `profesiones-avisos` (`descripcion_profesiones`,`color_profesiones`) VALUES ('$descripcion','$color')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos` WHERE `idProfesion` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarPrescriptorXTokken($tokken)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` WHERE `tokenPrescriptores` = '$tokken'";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion,$color)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `profesiones-avisos` SET `descripcion_profesiones` = '$descripcion', `color_profesiones` = '$color' WHERE `idProfesion` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `profesiones-avisos` SET `estProfesion` = NOT `estProfesion` WHERE `idProfesion` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerConocimiento(){
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_conocimientos` where estConocimiento = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerTipoCurso(){
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipocurso` where estTipoCurso = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function comprobarDocumento($identificador,$departamentoSelect){
        
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_prescriptores` where identificadorDocumento = '$identificador' AND idDepartamentoEdu_prescriptores = '$departamentoSelect' ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    
    public function recogerDatosInteresado($idInteresado){
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `tm_usuario` WHERE idInscripcion_tmusuario = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$idInteresado]);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Codificar el resultado en JSON
        $json_string = json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Definir nombre de archivo (por ejemplo "datos_interesado_<id>.json")
        $file = "datos_interesado_{$idInteresado}.json";

        // Guardar JSON en archivo
        file_put_contents($file, $json_string);

        // Si no hay resultados, devuelve 0; si hay, devuelve los datos
        return empty($resultado) ? 0 : $resultado;
    }

    
    
}

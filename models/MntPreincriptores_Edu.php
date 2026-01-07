<?php

class MntPreincriptores extends Conectar
{   
   
   
    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_conocimientos`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarElementosActivos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `clientes-tipo-avisos` WHERE `estTipo_cliente` = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($descripcion,$tipo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_conocimientos` (`nombreConocimiento`,`tipoConocimiento`) VALUES ('$descripcion',$tipo)";
        
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElementoAgente($nombreAgente, $identificacionFiscal, $domicilioFiscalAgente, $correoAgente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_agentes_edu`(`nombreAgente`, `identificacionFiscal`, `domicilioFiscal`, `correoAgente`, `estAgente`) VALUES ('$nombreAgente','$identificacionFiscal','$domicilioFiscalAgente','$correoAgente','1')";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_conocimientos` WHERE `idConocimiento` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion,$tipo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_conocimientos` SET `nombreConocimiento` = '$descripcion', `tipoConocimiento` = $tipo WHERE `idConocimiento` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function recogerGruposBuscador($query)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_prescriptores WHERE `grupoPrescripcion` LIKE '%$query%'";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerCursoBuscador($query)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_prescriptores WHERE `cursoPrescripcion` LIKE '%$query%'";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarIdentidad($idElemento, $nombreIdentidadE)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipoidentificativo_edu` SET `nombreIdentificativo` = '$nombreIdentidadE' WHERE `idTipoIdentificativo` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElementoIdentidad($nombreIdentidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_tipoidentificativo_edu`(`nombreIdentificativo`, `estTipoIdentificativo`) VALUES ('$nombreIdentidad',1)";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstadoIdentificativo($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipoidentificativo_edu` SET `estTipoIdentificativo` = NOT `estTipoIdentificativo` WHERE `idTipoIdentificativo` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_conocimientos` SET `estConocimiento` = NOT `estConocimiento` WHERE `idConocimiento` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarAgentes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarAgentesTabla()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` WHERE estAgente = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarAgentesLlegadas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` where `estAgente`=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerDepartamentos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerDepartamentosActivo()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu` WHERE estDepa = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarElementoAgentexId($idAgente){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` where idAgente = $idAgente";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarAgenteXNombre($nombre){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` where nombreAgente = '$nombre'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function obtenerAgentesBuscador($query){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_agentes_edu` where estAgente = 1 AND ( `nombreAgente` LIKE '%$query%' OR `identificacionFiscal` LIKE '%$query%' OR `domicilioFiscal` LIKE '%$query%' OR `correoAgente` LIKE '%$query%' OR `idAgente` LIKE '%$query%')";
        
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarAgente($idElemento,$nombreAgenteE,$identificacionFiscalAgenteE,$domicilioFiscalAgenteE,$correoAgenteE){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_agentes_edu` SET `nombreAgente` = '$nombreAgenteE', 
        `identificacionFiscal` = '$identificacionFiscalAgenteE', `domicilioFiscal` = '$domicilioFiscalAgenteE',
        `correoAgente` = '$correoAgenteE'  WHERE `idAgente` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstadoAgente($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_agentes_edu` SET `estAgente` = NOT `estAgente` WHERE `idAgente` = $idElemento ";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarDepartamentos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu`";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function agregarElementoDepartamento($nombreDepartamento, $prefijofactura, $nfactura, $prefijofacturapro, $nfacturapro, $prefijoabonom, $nfacturaNeg, $prefijoabonoProf, $nfacturaprofDep, $colorDepartamento)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $colorDepartamento = trim($colorDepartamento);

        $sql = "INSERT INTO `tm_departamento_edu` 
        (`nombreDepartamento`, `numFacturaProDepa`, `numFacturaDepa`, `numFacturaNegDepa`, `prefijoFactDepa`, `prefijoFacturaProEdu`, `prefijoAbonoEdu`, `prefijoAbonoProEdu`, `numFacturaProNegDepa`, `colorDepartamento`, `estDepa`) VALUES 
        ('$nombreDepartamento','$nfacturapro','$nfactura','$nfacturaNeg','$prefijofactura','$prefijofacturapro','$prefijoabonom','$prefijoabonoProf','$nfacturaprofDep','$colorDepartamento','1')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function agregarElementoConocimiento($nombreConocimiento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_conocimientos`(`nombreConocimiento`, `estConocimiento`) VALUES 
        ('$nombreConocimiento',1)";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElementoBildungsurlaub($nombreBildungsurlaub)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_bildungsurlaub_edu`(`nombreBildun`, `estBildun`) VALUES 
        ('$nombreBildungsurlaub',1)";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarElementoIdentidad()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipoidentificativo_edu`";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarElementoIdentidadxId($idIdentificativo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipoidentificativo_edu` where idTipoIdentificativo  = $idIdentificativo";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarElementoDepartamentoxId($idDepartamento){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_departamento_edu` where idDepartamentoEdu = $idDepartamento";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     
    public function obtenerIdentidadPorId($idIdentificador){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipoidentificativo_edu` where idTipoIdentificativo  = $idIdentificador";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
      
    public function obtenerBildungsurlaubPorId($idElemento){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_bildungsurlaub_edu` where idBildun = $idElemento";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cargarElementoConocimientoxId($idConocimiento){
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_conocimientos` WHERE idConocimiento  = $idConocimiento";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function editarDepartamento($idElemento, $nombreDepartamentoE, $prefijofacturaE, $nfacturaE, $prefijofacturaproE, $nfacturaproE, $prefijoabonoE, $nfacturaNegE, $prefijoabonoProfE, $nfacturaprofDepE, $colorDepartamentoE){
   
        $conectar = parent::conexion();
        parent::set_names();

        $colorDepartamentoE = trim($colorDepartamentoE);

        /*
        $sql = "UPDATE `tm_departamento_edu` SET `nombreDepartamento` = '$nombreDepartamentoE',`numFacturaProDepa` = '$nfacturaproE',`numFacturaDepa` = '$nfacturaE',`numFacturaNegDepa` = '$nfacturaNegE',
        `prefijoFactDepa` = '$prefijofacturaE',`prefijoFacturaProEdu` = '$prefijofacturaproE',`prefijoAbonoEdu` = '$prefijoabonoE',`colorDepartamento` = '$colorDepartamentoE 'WHERE `idDepartamentoEdu` = $idElemento";
        */ 

        $sql = "UPDATE `tm_departamento_edu` SET `nombreDepartamento` = '$nombreDepartamentoE',`numFacturaProDepa` = '$nfacturaproE',`numFacturaDepa` = '$nfacturaE',`numFacturaNegDepa` = '$nfacturaNegE',
        `prefijoFactDepa` = '$prefijofacturaE',`prefijoFacturaProEdu` = '$prefijofacturaproE',`prefijoAbonoEdu` = '$prefijoabonoE',`prefijoAbonoProEdu` = '$prefijoabonoProfE',`numFacturaProNegDepa` = '$nfacturaprofDepE',
        `colorDepartamento` = '$colorDepartamentoE 'WHERE `idDepartamentoEdu` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
}


    public function editarBildungsurlaub($idElemento, $nombreBildungsurlaubE){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_bildungsurlaub_edu` SET 
        `nombreBildun`='$nombreBildungsurlaubE' WHERE idBildun = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cambiarEstadoBildungsurlaub($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_bildungsurlaub_edu` SET `estBildun` = NOT `estBildun` WHERE `idBildun` = $idElemento ";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    } 
    

    public function cambiarEstadoConocimiento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_conocimientos` SET `estConocimiento` = NOT `estConocimiento` WHERE `idConocimiento` = $idElemento ";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    

    public function cambiarEstadoDepartamentos($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_departamento_edu` SET `estDepa` = NOT `estDepa` WHERE `idDepartamentoEdu` = $idElemento ";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    

    public function mostrarConocimientos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_conocimientos`";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarBildungsurlaub()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_bildungsurlaub_edu`";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerBildungsurlaub()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_bildungsurlaub_edu` WHERE estBildun = 1";
     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function listarTipoIdentificativo()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipoidentificativo_edu`";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }
    public function listarErasmus()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_erasmus_edu`";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerTipoDocumento()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tipoidentificativo_edu`";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
}



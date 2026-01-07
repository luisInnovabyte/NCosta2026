<?php

class Transporte extends Conectar
{   
   
    
    public function recogerOrden($idOrden)
    {
        $idOrden = 1;
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` WHERE id_orden = $idOrden";

     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function recogerOrdenToken($idOrdenToken)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken'";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetch();

    }
    public function recogerOrdenTokenAll($idOrdenToken,$idviaje)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        if(empty($idviaje)){
            $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken'";

        } else {
            $sql = "SELECT * FROM `orden-viaje-view` WHERE tokenOrden = '$idOrdenToken' AND `idViaje`=$idviaje";

        }

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    

    public function mostrarOrdenes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` ORDER BY `TTE_COD` DESC";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function mostrarOrdenesXIdTrabajador($idTrabajador)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-Transporte` WHERE id_Transportista = '$idTrabajador' ORDER BY `TTE_COD` DESC ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function recogerIncidencia($idIncidencia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_OrdenXIncidenciaXSituaciones` WHERE idIncidencia = $idIncidencia";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
   public function mostrarIncidenciaXOrden($idOrden)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $idOrdenSinBarra = str_replace("/", "", $idOrden);

        $sql = "SELECT * FROM `view_OrdenXIncidenciaXSituaciones` WHERE idOrden_Incidencia = '$idOrdenSinBarra' AND estIncidencia = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute($resultado = $sql->fetchAll());
       
        return $resultado = $sql->fetchAll();
    }
    
    public function listarSituacion()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `situaciones-Transporte` WHERE estSituacion = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function guardarIncidencia($idOrden,$reportante,$selectSituacion,$selectViaje,$fechaIncidencia,$descripcionIncidencia,$documentos)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $documentosJson = json_encode($documentos); 

        $idOrdenSinBarra = str_replace("/", "", $idOrden);
        // Establecer la zona horaria de Madrid
        date_default_timezone_set('Europe/Madrid');
        // Formatear la fecha y hora actual en formato MySQL
        $fechaIncidencia = date('Y-m-d H:i:s'); // Formato MySQL (año-mes-día hora:minuto:segundo)
        $sql = "INSERT INTO `incidencia-Transporte`( `idOrden_Incidencia`, `transportistaIncidencia`, `situacionIncidencia`,`viajeIncidencia`, `documento`, `descripcion`, `fechaCreacionIncidencia`, `estIncidencia`) 
        VALUES ('$idOrdenSinBarra','$reportante',$selectSituacion,'$selectViaje','$documentosJson','$descripcionIncidencia','$fechaIncidencia',1)";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function cambiarEstado($idTransporte){

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `incidencia-Transporte` SET `estIncidencia`= 0 WHERE idIncidencia = $idTransporte";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

        
    public function guardarContenedor($idOrden,$numeroContenedor){

        try {
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "UPDATE `orden-Transporte` SET `contenedorActivo`= :numeroContenedor WHERE num_transporte = :idOrden";
            $stmt = $conectar->prepare($sql);
            
            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':numeroContenedor', $numeroContenedor, PDO::PARAM_STR);
            $stmt->bindParam(':idOrden', $idOrden, PDO::PARAM_STR);
            
            // Execute the statement
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log($e->getMessage());
            return 0;
        }
    }
    public function guardarPrecinto($idOrden,$precinto){

        try {
            $conectar = parent::conexion();
            parent::set_names();
            
            $sql = "UPDATE `orden-Transporte` SET `precintoActivo`= :precinto WHERE num_transporte = :idOrden";
            $stmt = $conectar->prepare($sql);
            
            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':precinto', $precinto, PDO::PARAM_STR);
            $stmt->bindParam(':idOrden', $idOrden, PDO::PARAM_STR);
            
            // Execute the statement
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log($e->getMessage());
            return 0;
        }
    }

    public function recogerViajesxOrden($idOrden){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `viaje-Transporte` WHERE id_OrdenViajeTransporte = $idOrden;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    
    
    public function recogerViajesxID($idViaje){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `viaje-Transporte` WHERE idViaje = $idViaje;";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    
    public function recogerViajesxIDOrden($idViaje){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `orden-viaje-view` WHERE idViaje = $idViaje;";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }

    public function actualizarViaje($idViaje,$fechaLlegada,$fechaSalida,$observacionesViaje){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `viaje-Transporte` SET 
        `fechaLlegadaViaje`='$fechaLlegada',`fechaSalidaViaje`='$fechaSalida',`ObservacionViaje`='$observacionesViaje',`FirmaViajeReceptor`='' WHERE idViaje = $idViaje";
 
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function recogerFirmaPerfil(){
        $dniUsu = $_SESSION["usu_identificacionFiscal"];
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `transportistas-Transporte` WHERE `idTransportistaLeader` = '$dniUsu'";
 
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }

    public function actualizarFirma($idViaje,$signature,$nombreInput,$correoInput,$DNIinput,$autorFirma,$idOrdenReceptor){
        $conectar = parent::conexion();
        parent::set_names();

        if($autorFirma == 'conductor'){
            $sql = "UPDATE `viaje-Transporte` SET 
            `FirmaViajeConductor`='$signature',`nombreViajeConductor`='$nombreInput',`dniViajeConductor`='$DNIinput' 
            WHERE idViaje = $idViaje";
           
        }else if($autorFirma == 'receptor'){ 
            $sql = "UPDATE `viaje-Transporte` SET 
            `FirmaViajeReceptor`='$signature',`nombreViajeReceptor`='$nombreInput',`correoViajeReceptor`='$correoInput',`dniViajeReceptor`='$DNIinput' 
            WHERE idViaje = $idViaje";
           
        }else if($autorFirma == 'cliente'){
            $sql = "UPDATE `orden-Transporte` SET 
            `nombreCliente`='$nombreInput',`correoCliente`='$correoInput',`dniCliente`='$DNIinput',`firmaCliente`='$signature'
             WHERE `tokenOrden` = '$idOrdenReceptor'";
        

        }
        
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    
    



}

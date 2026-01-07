<?php

class Pago extends Conectar
{

    public function listarPagos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_mediopago";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerMediosPago()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_mediopago WHERE `estMedioPago` = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerPagoID($id)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT * FROM `tm_mediopago` WHERE `idMedioPago` =$id";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    public function editarPago($nombre,$id)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "UPDATE `tm_mediopago` SET `nomMedioPago` = '$nombre' WHERE idMedioPago = $id";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    public function insertarPago($nombre)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "INSERT INTO `tm_mediopago` (`nomMedioPago`,`estMedioPago`) VALUES ('$nombre',1)";
    

    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    public function desactivarPago($id)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "UPDATE `tm_mediopago` SET `estMedioPago` = 0 WHERE idMedioPago = $id";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    public function activarPago($id)
    {
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "UPDATE `tm_mediopago` SET `estMedioPago` = 1 WHERE idMedioPago = $id";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_mediopago` SET `estMedioPago` = NOT `estMedioPago`, `fecModiMedioPago` = now(), `fecBajaMedioPago` = IF(`estMedioPago` = 1, NULL, now()) WHERE `idMedioPago` = $idElemento ";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

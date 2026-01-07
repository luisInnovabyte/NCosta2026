<?php

class TipoContrato extends Conectar
{

    public function listarTipoContrato()
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tipocontrato";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarTipoContrato($descrTipoContrato, $textTipoContrato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_tipocontrato`( `descrTipoContrato`,`textTipoContrato`, `fecAltaTipoContrato`, `estTipoContrato`) VALUES ('$descrTipoContrato', '$textTipoContrato', now(), 1)";
        
        
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function editarTipoContrato($idTipoContrato, $descrTipoContrato, $textTipoContrato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocontrato`
         SET `fecModiTipoContrato`= now() ,
         `descrTipoContrato`= '$descrTipoContrato',
         'textTipoContrato' = '$textTipoContrato'
         WHERE `idTipoContrato`= $idTipoContrato";
         
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function update_tipoContrato($idTipoContrato, $textTipoContrato, $descrTipoContrato)
    {
        session_start();

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_tipocontrato
                SET
                    textTipoContrato='$textTipoContrato',
                    descrTipoContrato='$descrTipoContrato',
                    fecModiTipoContrato=now()
                WHERE
                    idTipoContrato = '$idTipoContrato'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function activarTipoContrato($id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocontrato`
         SET `fecModiTipoContrato`= now() ,
         `fecBajaTipoContrato`= null,
         `estTipoContrato`= 1 
         WHERE `idTipoContrato`= $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarTipoContrato($id)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocontrato`
         SET `fecModiTipoContrato`= now() ,
         `fecBajaTipoContrato`= now(),
         `estTipoContrato`= 0
         WHERE `idTipoContrato`= $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_tipoContrato_x_id($idTipo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_tipocontrato
        WHERE idTipoContrato = '$idTipo'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tipocontrato` SET `estTipoContrato` = NOT `estTipoContrato`, 
            `fecModiTipoContrato` = now(),
            `fecBajaTipoContrato` = IF(`estTipoContrato` = 1, NULL, now()) WHERE `idTipoContrato` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
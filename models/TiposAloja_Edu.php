<?php

class TiposAloja extends Conectar
{

    public function listarTiposAloja()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_tiposaloja`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarTiposAloja($descrTiposAloja, $textTiposAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_tiposaloja`(`descrTiposAloja`, `textTiposAloja`) VALUES ('$descrTiposAloja', '$textTiposAloja')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_tiposAloja_x_id($idTiposAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // $sql = "SELECT * FROM `tm_tiposaloja` WHERE idTiposAloja = $idTiposAloja";
        $sql = "SELECT * FROM `tm_tiposaloja` WHERE idTiposAloja = $idTiposAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarTiposAloja($idTiposAloja, $descrTiposAloja, $textTiposAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tiposaloja` SET `fecModiTiposAloja`= now() , `descrTiposAloja`= '$descrTiposAloja', `textTiposAloja`= '$textTiposAloja' WHERE `idTiposAloja`= $idTiposAloja";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarTipoAloja($idTiposAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tiposaloja`
         SET `fecModiTiposAloja`= now() ,
         `fecBajaTiposAloja`= null,
         `estTiposAloja`= 1 
         WHERE `idTiposAloja`= $idTiposAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarTipoAloja($idTiposAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tiposaloja` SET `fecModiTiposAloja`= now() , `fecBajaTiposAloja`= now() , `estTiposAloja`= 0 WHERE `idTiposAloja`= $idTiposAloja";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_tiposaloja` SET `estTiposAloja` = NOT `estTiposAloja` WHERE `idTiposAloja` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

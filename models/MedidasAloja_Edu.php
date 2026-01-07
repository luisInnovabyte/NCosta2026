<?php

class MedidasAloja extends Conectar
{

    public function listarMedidasAloja()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_medidaaloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarMedidaAloja($descrMedidaAloja, $textMedidaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_medidaaloja`(`descrMedidaAloja`, `textMedidaAloja`, `estMedidaAloja`) VALUES ('$descrMedidaAloja', '$textMedidaAloja', 1);";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function get_medidaAloja_x_id($idMedidaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_medidaaloja` WHERE idMedidaAloja = $idMedidaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarMedidaAloja($idMedidaAloja, $descrMedidaAloja, $textMedidaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_medidaaloja`
         SET `fecModiMedidaAloja`= now() ,
         `descrMedidaAloja`= '$descrMedidaAloja',
         `textMedidaAloja`= '$textMedidaAloja'
         WHERE `idMedidaAloja`= $idMedidaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function activarMedidaAloja($idMedidaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_medidaaloja`
         SET `fecModiMedidaAloja`= now() ,
         `fecBajaMedidaAloja`= null,
         `estMedidaAloja`= 1 
         WHERE `idMedidaAloja`= $idMedidaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarMedidaAloja($idMedidaAloja)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_medidaaloja`
        SET `fecModiMedidaAloja`= now() ,
        `fecBajaMedidaAloja`= now() ,
        `estMedidaAloja`= 0 
        WHERE `idMedidaAloja`= $idMedidaAloja";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_medidaaloja` SET `estMedidaAloja` = NOT `estMedidaAloja`, `fecModiMedidaAloja` = now(), `fecBajaMedidaAloja` = IF(`estMedidaAloja` = 1, NULL, now()) WHERE `idMedidaAloja` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

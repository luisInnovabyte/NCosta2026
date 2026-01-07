<?php

class TitularContenido extends Conectar
{

    public function listarContenido()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_titulares_contenido";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarTitContenido($titular)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_titulares_contenido`(`descrTitContenido`,`fecAltaTitContenido`) VALUES ('$titular',now())";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function editarTitContenido($id,$titular)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_titulares_contenido` SET `descrTitContenido`='$titular' WHERE `idTitContenido` = $id";
       

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_titulares_contenido` SET `estTitContenido` = NOT `estTitContenido`, `fecModiTitContenido` = now(), `fecBajaTitContenido` = IF(`estTitContenido` = 1, NULL, now()) WHERE `idTitContenido` = $idElemento ";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

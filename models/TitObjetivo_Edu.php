<?php

class TitularObjetivo extends Conectar
{

    public function listarObjetivo($idiomaSelect, $tipoSelect, $nivelSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_titulares_objetivos WHERE idiomaSelect = $idiomaSelect AND tipoSelect = $tipoSelect AND nivelSelect = $nivelSelect";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarTitObjetivo($titular,$idiomaSelect, $tipoSelect, $nivelSelect)
    {
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_titulares_objetivos`(`descrTitObjetivo`,`fecAltaTitObjetivo`,`idiomaSelect`, `tipoSelect`, `nivelSelect`) VALUES ('$titular',now(),$idiomaSelect,$tipoSelect,$nivelSelect)";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function editarTitObjetivo($id,$titular,$idiomaSelect, $tipoSelect, $nivelSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_titulares_objetivos` SET `descrTitObjetivo`='$titular' WHERE `idTitObjetivo` = $id";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_titulares_objetivos` SET `estTitObjetivo` = NOT `estTitObjetivo`, `fecModiTitObjetivo` = now(), `fecBajaTitObjetivo` = IF(`estTitObjetivo` = 1, NULL, now()) WHERE `idTitObjetivo` = $idElemento ";
            
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

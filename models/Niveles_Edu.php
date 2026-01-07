<?php

class Niveles extends Conectar
{

    public function listarNiveles()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_nivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function listarNivelesSelect()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_nivel WHERE estNivel = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function insertarNivel($descrNivel, $codNivel, $textNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_nivel` WHERE `codNivel` = '$codNivel'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
      
        if(empty($resultado)){
            
            $sql = "INSERT INTO `tm_nivel`(`descrNivel`, `codNivel`, `textNivel`) VALUES ('$descrNivel', '$codNivel', '$textNivel');";
            
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return "1";
        } else {
          
            return "0";
        }
    }

    public function get_nivel_x_id($idNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_nivel` WHERE idNivel = $idNivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarNivel($idNivel, $descrNivel, $codNivel, $textNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_nivel` WHERE `codNivel` = '$codNivel' AND `idNIvel` != $idNivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        
        if(empty($resultado)){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE `tm_nivel` SET `fecModiNivel`= now() , `descrNivel`= '$descrNivel', `codNivel`= '$codNivel',`textNivel`= '$textNivel' WHERE `idNivel`= $idNivel";     
            
           
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return "1";
        } else {
            return "0";
        }
    }

    public function activarNivel($idNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_nivel`
         SET `fecModiNivel`= now() ,
         `fecBajaNivel`= null,
         `estNivel`= 1 
         WHERE `idNivel`= $idNivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function desactivarNivel($idNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_nivel`
        SET `fecModiNivel`= now() ,
        `fecBajaNivel`= now() ,
        `estNivel`= 0 
        WHERE `idNivel`= $idNivel";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_nivel` SET `estNivel` = NOT `estNivel`, 
            `fecModiNivel` = now(),
            `fecBajaNivel` = IF(`estNivel` = 1, NULL, now()) WHERE `idNivel` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

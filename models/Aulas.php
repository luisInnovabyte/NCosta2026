<?php

class Aulas extends Conectar
{

    public function listarAulas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_aulas";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarAula($descrAula,$localizacionAula,$capaAula,$textAula,$hibrido,$kids,$paraliticos,$agorafobia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tm_aulas`(`nombreAula`, `localizacionAula`, `capacidadAula`, `departamentoAula`, `observacionesAula`, `estAula`, `hibridoAula`, `kidsAula`, `paraliticosAula`, `agoraAula`) 
        VALUES ('$descrAula','$localizacionAula','$capaAula','1','$textAula','1','$hibrido','$kids','$paraliticos','$agorafobia')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_aula_x_id($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_aulas WHERE idAula = $idAula";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarAula($idAulaE,$descrAulaE,$localizacionE,$capaAulaE,$textAulaE,$hibridoE,$kidsE,$paraliticosE,$agorafobiaE)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aulas` set `nombreAula`='$descrAulaE',
        `localizacionAula`='$localizacionE',`capacidadAula`='$capaAulaE',`departamentoAula`='1',`observacionesAula`='$textAulaE', `hibridoAula`='$hibridoE', `kidsAula`='$kidsE',`paraliticosAula`='$paraliticosE', `agoraAula` = '$agorafobiaE'   WHERE idAula = $idAulaE";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    
    public function activarAula($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aulas`
         SET `estAula`= 1 
         WHERE `idAula`= $idAula";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }

    public function desactivarAula($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aulas`
        SET `estAula`= 0 
        WHERE `idAula`= $idAula";
         
         
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }
  
}
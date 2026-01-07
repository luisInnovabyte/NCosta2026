<?php

class Contrato extends Conectar
{

    public function listarContrato()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM personal_contratos_tipocontratos ORDER BY idpersonal_PersoContrato DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarContrato($idContrato,  $fechaIni, $fechaFin, $textPersoContrato, $idTipoContrato,$textJornada,$textCategoria,$textDuracion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `td_persocontrato`( `idpersonal_PersoContrato`, `idcontrato_PersoContrato`, `fecInicioPersoContrato`, `fecFinalPersoContrato`, `textPersoContrato`, `estContrato`,`categoriaContrato`, `jornadaContrato`, `duracionContrato` ) VALUES ('$idContrato','$idTipoContrato','$fechaIni','$fechaFin','$textPersoContrato','1','$textCategoria','$textJornada','$textDuracion')";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    public function cambiarEstado($idPersoContrato)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `td_persocontrato` SET `estContrato`= NOT `estContrato` WHERE idPersoContrato = $idPersoContrato";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    

    public function recogerDatosContrato($idElemento)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `personal_contratos_tipocontratos` WHERE `idPersoContrato` = $idElemento";
  

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function get_contrato_x_id($idpersonal_PersoContrato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `personal_contratos_tipocontratos` WHERE `idpersonal_PersoContrato` = $idpersonal_PersoContrato";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
  
    public function get_personal_x_id($idpersonal_PersoContrato)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_personal` WHERE `idPersonal` = $idpersonal_PersoContrato";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarContrato($idContrato,  $fechaIni, $fechaFin, $textPersoContrato, $idTipoContrato, $textCategoria, $textJornada, $textDuracion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `td_persocontrato` SET `fecInicioPersoContrato`= '$fechaIni' ,`fecFinalPersoContrato` = '$fechaFin',`textPersoContrato`= '$textPersoContrato',
        `idcontrato_PersoContrato` = '$idTipoContrato',`categoriaContrato` = '$textCategoria',`jornadaContrato` = '$textJornada',`duracionContrato` = '$textDuracion' WHERE `idPersoContrato`= '$idContrato'";




        $sql = $conectar->prepare($sql);
        $sql->execute();
    }

    
    public function delete_contrato($idUsuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE td_persocontrato
                SET
                    estContrato=0
                WHERE
                idPersoContrato = $idUsuario";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function activar_contrato($idUsuario)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE td_persocontrato
                SET
                estContrato=1

                WHERE
                idPersoContrato = $idUsuario";

               

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}
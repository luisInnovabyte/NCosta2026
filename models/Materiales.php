<?php
class Material extends Conectar
{

    public function mostrarMateriales()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_material_almacen_familia_subfamilia`";

   

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarMaterial($nombreMaterial, $fechAlta_Material, $estructuraMaterial,$familia,$subfamilia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $familia = $familia[0];
        $subfamilia = $subfamilia[0];
        //TODO: 10/05/24 añado try catch para la deteccion de errores
        try {
            //TODO: 10/05/24 modificamos sql para que inserta mas datos y no solo el nombre del cliente y su estado
            $sql = "INSERT INTO `tm_material` (`nombreMaterial`, `fechAlta_Material`, `estMaterial`, `estructuraMaterial`,`idFamilia_mateial`,`idSubFamilia_material`) VALUES ('$nombreMaterial', '$fechAlta_Material', 1, '$estructuraMaterial',$familia,$subfamilia)";

            $sql = $conectar->prepare($sql);

            $sql->execute();

            return true; // Éxito en la inserción

            return $resultado = $sql->fetchAll();
        } catch (PDOException $e) {
            return "Error en la inserción: " . $e->getMessage();
        }
    }

    public function recogerDatosMaterial($idMaterial)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_material` WHERE idMaterial = $idMaterial";

   

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function editarMaterial($idMaterial, $nombreMaterial, $fechModi_material,$estructuraMaterial,$familia,$subfamilia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $familia = $familia[0];
        $subfamilia = $subfamilia[0];
        $sql = "UPDATE `tm_material` SET `nombreMaterial`='$nombreMaterial', `fechModi_Material` = '$fechModi_material', `estructuraMaterial`='$estructuraMaterial',`idFamilia_mateial`=$familia, `idSubFamilia_material`=$subfamilia WHERE idMaterial = $idMaterial";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function cambiarEstado($idMaterial)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_material` SET `estMaterial`= NOT `estMaterial` WHERE idMaterial = $idMaterial";

        $sql = $conectar->prepare($sql);
        $sql->execute();


        $sqlEstado = "SELECT `estMaterial` FROM `tm_material` WHERE idMaterial = $idMaterial";


        $sqlEstado = $conectar->prepare($sqlEstado);
        $sqlEstado->execute();
        return $resultado = $sqlEstado->fetchAll();
    }
}

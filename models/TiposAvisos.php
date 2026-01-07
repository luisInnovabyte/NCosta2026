<?php
class Tipo extends Conectar
{

    public function mostrarTipos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tipo-avisos`";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

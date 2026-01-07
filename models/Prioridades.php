<?php
class Prioridad extends Conectar
{

    public function mostrarPrioridades()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `prioridades-avisos`";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}

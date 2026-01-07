<?php


class Asistencia extends Conectar
{

    public function listarAsistencia()
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT `idasistencia`,`idPersonal_asistencia`,`inicioAsistencia`,`finAsistencia`,`motivoAsistencia`,`nomPersonal`,`emailUsuario`,`apePersonal`,`emailPersonal`,`estado`, calcularDiferenciaFechas(inicioAsistencia,finAsistencia) as TiempoTotalFuncion FROM `asistencia_tmpersonal`;";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarAsist($idPersonal_asistencia, $motivoAsistencia)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "INSERT INTO `asistencia`(`idPersonal_asistencia`, `inicioAsistencia`, `finAsistencia`, `motivoAsistencia`) VALUES ('$idPersonal_asistencia',now(),null,'$motivoAsistencia')";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }


    public function updateAsist($idPersonal_asistencia)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "UPDATE asistencia SET finAsistencia = NOW() WHERE inicioAsistencia = (SELECT ultimaFecha FROM (SELECT MAX(inicioAsistencia) AS ultimaFecha FROM asistencia) AS subconsulta) AND idPersonal_asistencia = $idPersonal_asistencia;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    
    public function ultimoRegistro($idPersonal_asistencia)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Forzar que $idPersonal_asistencia sea un entero para evitar errores en la consulta
        $idPersonal_asistencia = (int)$idPersonal_asistencia;

        $sql = "SELECT IFNULL(finAsistencia, 0) AS resultado 
                FROM asistencia
                WHERE idPersonal_asistencia = $idPersonal_asistencia
                ORDER BY inicioAsistencia DESC
                LIMIT 1";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetch(PDO::FETCH_COLUMN);
        } else {
            $resultado = 2; // El idPersonal_asistencia no existe
        }
        return $resultado;
    }

}

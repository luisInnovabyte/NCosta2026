<?php

class ZonaAlumnos extends Conectar
{

    public function listarCursosAlumno()
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();
        $idLlegada = $_SESSION['llegada_idLlegada'];
        $idInscripcion = $_SESSION['usuPre_idInscripcion'];
  
        /* $sql = "SELECT *, ( SELECT MAX(peso_ruta) FROM tm_ruta WHERE idiomaId_ruta = tm_ruta.idiomaId_ruta AND tipoId_ruta = tm_ruta.tipoId_ruta AND est_ruta = 1 ) AS max_peso FROM cursos LEFT JOIN ruta_completo ON cursos.idRuta_cursos = ruta_completo.id_ruta LEFT JOIN tm_ruta ON cursos.idRuta_cursos = tm_ruta.id_ruta WHERE cursos.idLlegada_cursos = '$idLlegada' ORDER BY cursos.est_cursos DESC;"; */
        $sql = "SELECT *, ( SELECT MAX(peso_ruta) FROM tm_ruta WHERE idiomaId_ruta = tm_ruta.idiomaId_ruta AND tipoId_ruta = tm_ruta.tipoId_ruta AND est_ruta = 1 ) AS max_peso  FROM `cursos` left JOIN ruta_completo ON cursos.`idRuta_cursos`= ruta_completo.id_ruta LEFT JOIN tm_ruta ON cursos.idRuta_cursos = tm_ruta.id_ruta  WHERE `idAlumno_cursos` = $idInscripcion AND idLlegada_cursos = $idLlegada  ORDER BY cursos.est_cursos DESC;";
  $json_string = json_encode($sql);
  $file = 'Paconiss.json';
  file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function listarCursosAlumnoEducacion()
{
    $conectar = parent::conexion();
    parent::set_names();
    session_start();
    $idLlegada = $_SESSION['llegada_idLlegada'];

    $sql = "SELECT * FROM cursos c LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta WHERE c.idLlegada_cursos = $idLlegada ORDER BY c.fechaCrea_cursos DESC";

    $json_string = json_encode($sql);
    $file = 'ejemploEducacionCursos1.json';
    file_put_contents($file, $json_string);

    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}

public function listarCursosPorLlegadaSeleccionadaModelo($idLlegada)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT 
                c.*, 
                r.*, 
                e.idEvaluacionFinal AS idCertificado
            FROM cursos c
            LEFT JOIN ruta_completo r 
                ON c.idRuta_cursos = r.id_ruta
            LEFT JOIN evaluacionFinal e 
                ON e.idLlegadaEvaluacionFinal = c.idLlegada_cursos 
            AND e.codGrupoEvaluacionFinal = c.codGrupo
            WHERE c.idLlegada_cursos = $idLlegada
            ORDER BY c.fechaCrea_cursos DESC
            ";

    $json_string = json_encode($sql);
    $file = 'ejemploEducacionCursos1.json';
    file_put_contents($file, $json_string);

    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll();
}

public function obtenerCursosConRutaYHoras($idLlegada)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT 
                c.*, 
                r.codIdioma, r.descrIdioma, 
                r.codTipo, r.descrTipo, 
                r.codNivel, r.descrNivel, 
                g.horasLectivas 
            FROM cursos c 
            LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta 
            LEFT JOIN grupos g ON c.idGrupo = g.idGrupo 
            WHERE c.idLlegada_cursos = ? 
            ORDER BY c.fechaCrea_cursos DESC";

    file_put_contents('ejemploCursosRutaGrupo.json', json_encode($sql));

    $stmt = $conectar->prepare($sql);
    $stmt->bindValue(1, $idLlegada, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
   
}

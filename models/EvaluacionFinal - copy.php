<?php

class EvaluacionFinal extends Conectar
{

    // MÉTODO PARA OBTENER INFORMACIÓN DEL DATATABLE DE EVALUACIÓN FINAL
    // PERO SIN FILTRO DE FECHAS

    // MÉTODO ACTUALIZADO PARA QUE TAMBIÉN FILTRE POR EL DEPARTAMENTO
    // CAMBIOS RESPECTO A VERSIÓN ANTERIOR:
    // -  $sql .= " GROUP BY llegadas.id_llegada;";
    /* - if (!empty($idDepartamento)) {
            $stmt->execute([$idDepartamento]);
        } else {
            $stmt->execute();
        } 
    */

    public function mostrarAlumnosFinal($idDepartamento = null)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
            llegadas.*, 
            alumnos.*, 
            MAX(evaluacionFinal.idEvaluacionFinal) AS idEvaluacionFinal,
            MAX(evaluacionFinal.idLlegadaEvaluacionFinal) AS idLlegadaEvaluacionFinal,
            MAX(evaluacionFinal.idAlumnoTokenEvaluacionFinal) AS idAlumnoTokenEvaluacionFinal,
            MAX(evaluacionFinal.horasCertificadoEvaluacionFinal) AS horasCertificadoEvaluacionFinal,
            MAX(evaluacionFinal.mostrarCertificadoEvaluacionFinal) AS mostrarCertificadoEvaluacionFinal,
            MAX(evaluacionFinal.estadoLlegadaEvaluacionFinal) AS estadoLlegadaEvaluacionFinal,
            MAX(evaluacionFinal.codGrupoEvaluacionFinal) AS codGrupoEvaluacionFinal,
            MAX(evaluacionFinal.individualEvaluacionFinal) AS individualEvaluacionFinal,
            GROUP_CONCAT(matriculas.nombreTarifa_matriculacion SEPARATOR ' | ') AS tarifas_asociadas,
            GROUP_CONCAT(matriculas.fechaInicioMatriculacion SEPARATOR ' | ') AS fechas_inicio_matricula,
            GROUP_CONCAT(matriculas.fechaFinMatriculacion SEPARATOR ' | ') AS fechas_fin_matricula,
            MIN(matriculas.fechaInicioMatriculacion) AS fecha_inicio_mas_temprana,
            MAX(matriculas.fechaFinMatriculacion) AS fecha_fin_mas_tardia
        FROM tm_llegadas_edu llegadas
        LEFT JOIN tm_alumno_edu alumnos 
            ON llegadas.idprescriptor_llegadas = alumnos.idAlumno
        LEFT JOIN tm_matriculacionllegadas_edu matriculas
            ON llegadas.id_llegada = matriculas.idLlegada_matriculacion
        LEFT JOIN evaluacionFinal 
            ON llegadas.id_llegada = evaluacionFinal.idLlegadaEvaluacionFinal";

        if (!empty($idDepartamento)) {
            $sql .= " WHERE llegadas.iddepartamento_llegadas = ?";
        }

        $sql .= " GROUP BY llegadas.id_llegada;";

        $json_string = json_encode($sql);
        file_put_contents('PETROS.json', $json_string);

        $stmt = $conectar->prepare($sql);

        if (!empty($idDepartamento)) {
            $stmt->execute([$idDepartamento]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll();
    }

    // MÉTODO PARA OBTENER INFORMACIÓN DEL DATATABLE DE EVALUACIÓN FINAL CON FILTRO DE FECHAS

        public function obtenerAlumnosFiltrados($idDepartamento = null, $fechaInicio = null, $fechaFin = null)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
            llegadas.*, 
            alumnos.*, 
            GROUP_CONCAT(matriculas.nombreTarifa_matriculacion SEPARATOR ' | ') AS tarifas_asociadas,
            GROUP_CONCAT(matriculas.fechaInicioMatriculacion SEPARATOR ' | ') AS fechas_inicio_matricula,
            GROUP_CONCAT(matriculas.fechaFinMatriculacion SEPARATOR ' | ') AS fechas_fin_matricula,
            MIN(matriculas.fechaInicioMatriculacion) AS fecha_inicio_mas_temprana,
            MAX(matriculas.fechaFinMatriculacion) AS fecha_fin_mas_tardia
        FROM tm_llegadas_edu llegadas
        LEFT JOIN tm_alumno_edu alumnos 
            ON llegadas.idprescriptor_llegadas = alumnos.idAlumno
        LEFT JOIN tm_matriculacionllegadas_edu matriculas
            ON llegadas.id_llegada = matriculas.idLlegada_matriculacion ";

        $conditions = [];
        $params = [];

        // Filtro por departamento si viene
        if (!empty($idDepartamento)) {
            $conditions[] = "llegadas.iddepartamento_llegadas = ?";
            $params[] = $idDepartamento;
        }

        // Filtro por rango de fechas si vienen ambos parámetros
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $conditions[] = "matriculas.fechaInicioMatriculacion >= ? AND matriculas.fechaFinMatriculacion <= ?";
            $params[] = $fechaInicio;
            $params[] = $fechaFin;
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " GROUP BY llegadas.id_llegada;";

        // Guardar la consulta para debug (opcional)
        $json_string = json_encode($sql);
        $file = 'PETROS.json';
        file_put_contents($file, $json_string);

        $stmt = $conectar->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // MÉTODO PARA OBTENER INFORMACIÓN DEL DATATABLE DE EVALUACIÓN FINAL CON FILTRO DE FECHA EXACTA
public function obtenerAlumnosPorFechaExacta($idDepartamento = null, $fechaExacta = null)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT 
        llegadas.*, 
        alumnos.*, 
        GROUP_CONCAT(matriculas.nombreTarifa_matriculacion SEPARATOR ' | ') AS tarifas_asociadas,
        GROUP_CONCAT(matriculas.fechaInicioMatriculacion SEPARATOR ' | ') AS fechas_inicio_matricula,
        GROUP_CONCAT(matriculas.fechaFinMatriculacion SEPARATOR ' | ') AS fechas_fin_matricula,
        MIN(matriculas.fechaInicioMatriculacion) AS fecha_inicio_mas_temprana,
        MAX(matriculas.fechaFinMatriculacion) AS fecha_fin_mas_tardia
    FROM tm_llegadas_edu llegadas
    LEFT JOIN tm_alumno_edu alumnos 
        ON llegadas.idprescriptor_llegadas = alumnos.idAlumno
    LEFT JOIN tm_matriculacionllegadas_edu matriculas
        ON llegadas.id_llegada = matriculas.idLlegada_matriculacion ";

    $conditions = [];
    $params = [];

    // Filtro por departamento si viene
    if (!empty($idDepartamento)) {
        $conditions[] = "llegadas.iddepartamento_llegadas = ?";
        $params[] = $idDepartamento;
    }

    // Filtro por fecha exacta
    if (!empty($fechaExacta)) {
        $conditions[] = "DATE(matriculas.fechaFinMatriculacion) = ?";
        $params[] = $fechaExacta;
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " GROUP BY llegadas.id_llegada;";

    $stmt = $conectar->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}



public function obtenerActividadesPorLlegadaEvaluacion($idLlegada, $tokenUsu) 
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Buscar el ID del usuario a partir del token
        $sqlUsuario = "SELECT idUsu FROM tm_usuario WHERE tokenUsu = ?";
        $stmtUsuario = $conectar->prepare($sqlUsuario);
        $stmtUsuario->bindValue(1, $tokenUsu, PDO::PARAM_STR);
        $stmtUsuario->execute();

        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || empty($usuario["idUsu"])) {
            throw new Exception("Token de usuario no válido o no encontrado.");
        }

        $idUsuario = $usuario["idUsu"];

        // Consulta de actividades
        $sql = "
            SELECT 
                ac.idAct,
                ac.descrAct,
                ac.fecActDesde,
                ac.horaInicioAct,
                ac.fecActHasta,
                ac.horaFinAct,
                ac.horasLectivasAct,
                ac.puntoEncuentroAct,
                ac.nombresDepartamentos,
                ac.minAlumAct,
                ac.maxAlumAct,
                ac.estadoAct
            FROM 
                td_usuarioact_edu
            LEFT JOIN 
                actividadescompleto ac ON td_usuarioact_edu.idAct_UsuarioAct = ac.idAct
            WHERE 
                td_usuarioact_edu.idUsuario_UsuarioAct = ?
                AND td_usuarioact_edu.asisUsuarioAct = 1
                AND td_usuarioact_edu.idLlegada_UsuarioAct = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
        $stmt->bindValue(2, $idLlegada, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Throwable $e) {
        $errorData = [
            "error" => true,
            "mensaje" => "Error al obtener actividades.",
            "detalle" => $e->getMessage(),
            "fecha" => date("Y-m-d H:i:s"),
            "datos_enviados" => [
                "tokenUsu" => $tokenUsu,
                "idLlegada" => $idLlegada
            ]
        ];

        file_put_contents("error_actividades_certificado.json", json_encode($errorData, JSON_PRETTY_PRINT));
        header('Content-Type: application/json');
        echo json_encode($errorData, JSON_PRETTY_PRINT);
        exit;
    }
}
      public function recogerEvaluacionFinalAlumno($idLlegada) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
        ldc.idCodigoCursoLista,
        ef.idEvaluacionFinal AS idCertificado,
        ef.horasCertificadoEvaluacionFinal,
        ef.mostrarCertificadoEvaluacionFinal,
        ef.estadoLlegadaEvaluacionFinal,
        ef.codGrupoEvaluacionFinal,
        ef.individualEvaluacionFinal,
        COALESCE(horas_asistencia.total_horas_asistencia, '00:00:00') AS total_horas_asistencia,
        COALESCE(horas_justificadas.total_horas_justificadas, '00:00:00') AS total_horas_justificadas,
        SEC_TO_TIME(
            TIME_TO_SEC(COALESCE(horas_asistencia.total_horas_asistencia, '00:00:00')) +
            TIME_TO_SEC(COALESCE(horas_justificadas.total_horas_justificadas, '00:00:00'))
        ) AS total_horas
        FROM (
            SELECT idCodigoCursoLista, idLlegadaListaDiariaClase
            FROM listaDiariaClase
            WHERE estListaDiariaClase = 1
            AND idLlegadaListaDiariaClase = $idLlegada
            GROUP BY idCodigoCursoLista
        ) ldc
        LEFT JOIN evaluacionFinal ef 
        ON ef.idLlegadaEvaluacionFinal = ldc.idLlegadaListaDiariaClase
        LEFT JOIN (
            SELECT idCodigoCursoLista, 
                SEC_TO_TIME(SUM(TIME_TO_SEC(horasAsistenciaLista))) AS total_horas_asistencia
            FROM listaDiariaClase
            WHERE estadoAsistenciaLista = 1
            AND idLlegadaListaDiariaClase = $idLlegada
            GROUP BY idCodigoCursoLista
        ) AS horas_asistencia 
        ON horas_asistencia.idCodigoCursoLista = ldc.idCodigoCursoLista
        LEFT JOIN (
            SELECT idCodigoCursoLista, 
                SEC_TO_TIME(SUM(TIME_TO_SEC(horasAsistenciaLista))) AS total_horas_justificadas
            FROM listaDiariaClase
            WHERE estadoAsistenciaLista = 4
            AND idLlegadaListaDiariaClase = $idLlegada
            GROUP BY idCodigoCursoLista
        ) AS horas_justificadas 
        ON horas_justificadas.idCodigoCursoLista = ldc.idCodigoCursoLista;";
       $json_string = json_encode($sql);
       $file = 'ATRE.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

        public function recogerEvaluacionFinalAlumnoPorCurso($idLlegada, $codigoGrupo) 
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ldc.*, ef.*, horas.total_horas_asistencia 
                FROM listaDiariaClase ldc 
                LEFT JOIN evaluacionFinal ef 
                    ON ef.idLlegadaEvaluacionFinal = ldc.idLlegadaListaDiariaClase 
                LEFT JOIN (
                    SELECT idLista, SEC_TO_TIME(SUM(TIME_TO_SEC(horasAsistenciaLista))) AS total_horas_asistencia 
                    FROM listaDiariaClase 
                    WHERE estListaDiariaClase = 1 
                    AND idLlegadaListaDiariaClase = $idLlegada 
                    GROUP BY idLista
                ) AS horas 
                    ON horas.idLista = ldc.idLista 
                WHERE ldc.estListaDiariaClase = 1 
                AND ldc.idLlegadaListaDiariaClase = $idLlegada 
                AND ldc.idCodigoCursoLista = '$codigoGrupo';";

        $json_string = json_encode($sql);
        file_put_contents('evaluacionPorCurso.json', $json_string);

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

      // Método para obtener rutas
    public function obtenerRutasUsuario($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                r.id_ruta,
                r.idiomaId_ruta,
                r.tipoId_ruta,
                r.nivelId_ruta,
                r.descrIdioma,
                r.codIdioma,
                r.descrTipo,
                r.codTipo,
                r.descrNivel,
                r.codNivel,
                r.estadoRuta,
                r.pesoRuta
            FROM 
                cursos c
            INNER JOIN 
                tm_alumno_edu a ON a.idAlumno = c.idAlumno_cursos
            INNER JOIN 
                ruta_completo r ON r.id_ruta = c.idRuta_cursos
            WHERE 
                c.idLlegada_cursos = $idLlegada";

$json_string = json_encode($sql);
$file = 'SQLeVALUACIONfinal.json';
file_put_contents($file, $json_string);
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function obtenerObjetivosUsuario($idiomaSelect, $tipoSelect, $nivelSelect, $descrIdioma = '', $descrNivel = '')
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // CONSULTA QUE OBTIENEN TODOS LOS OBJETIVOS QUE HAY EN EL IDIOMA, TIPO Y NIVEL SELECCIONADO
        // EN CASO DE QUE EL OBJETIVO NO TENGA CONTENIDO, NO SALDRÁ

        $sql = "
            SELECT 
                tto.idTitObjetivo,
                tto.descrTitObjetivo,
                tto.fecAltaTitObjetivo,
                tobj.descrObjetivo
            FROM 
                tm_titulares_objetivos tto
            INNER JOIN 
                tm_objetivos tobj 
                ON tto.idTitObjetivo = tobj.idtitObjetivo_titObjetivo
            WHERE 
                tto.idiomaSelect = $idiomaSelect
                AND tto.tipoSelect = $tipoSelect
                AND tto.nivelSelect = $nivelSelect
                AND tto.estTitObjetivo = 1
                AND tobj.estObjetivo = 1
            ORDER BY 
                tto.descrTitObjetivo, tobj.idObjetivo
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        $objetivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // SE AGRUPAN LOS OBJETIVOS POR TITULAR
        $agrupados = [];
        foreach ($objetivos as $objetivo) {
            $titular = $objetivo['descrTitObjetivo'];
            if (!isset($agrupados[$titular])) {
                $agrupados[$titular] = [];
            }
            $agrupados[$titular][] = $objetivo['descrObjetivo'];
        }

        $tituloPrincipal = "CONTENIDOS TRATADOS DURANTE EL CURSO ";
        // ANTES ESTABA ASÍ : $tituloPrincipal = "CONTENIDOS TRATADOS DURANTE EL CURSO DE " . strtoupper($descrIdioma) . " PARA EXTRANJEROS -";

        $objetoRuta = [
            'titulo' => $tituloPrincipal,
            'idioma' => $descrIdioma,
            'nivel' => $descrNivel,
            'contenidos' => []
        ];

        foreach ($agrupados as $tituloSeccion => $contenidos) {
            $objetoRuta['contenidos'][] = [
                'tituloSeccion' => $tituloSeccion,
                'contenido' => $contenidos
            ];
        }

        return $objetoRuta;

    } catch (Exception $e) {
        $errorData = [
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => [],
            "error" => $e->getMessage()
        ];

        $json_string = json_encode($errorData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(__DIR__ . '/error_obtenerObjetivosUsuario.json', $json_string);

        echo $json_string;
        exit;
    }
}

// OBTENER RUTAS DEL CURSO SELECCIONADO
public function obtenerRutasUsuarioPorGrupo($idLlegada, $codigoGrupo)
{
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT 
                r.id_ruta,
                r.idiomaId_ruta,
                r.tipoId_ruta,
                r.nivelId_ruta,
                r.descrIdioma,
                r.codIdioma,
                r.descrTipo,
                r.codTipo,
                r.descrNivel,
                r.codNivel,
                r.estadoRuta,
                r.pesoRuta
            FROM 
                cursos c
            INNER JOIN 
                tm_alumno_edu a ON a.idAlumno = c.idAlumno_cursos
            INNER JOIN 
                ruta_completo r ON r.id_ruta = c.idRuta_cursos
            WHERE 
                c.idLlegada_cursos = $idLlegada
                AND c.codGrupo = '$codigoGrupo'";

    $stmt = $conectar->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function obtenerDetallesCursoAlumno($idLlegada, $codigoGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    c.fechaCrea_cursos AS fechaInicio, 
                    c.fecFinCurso AS fechaFin,
                    c.codGrupo AS codigoGrupo,
                    r.descrTipo AS tipoCurso,
                    a.nomAlumno,
                    a.apeAlumno
                FROM cursos c
                INNER JOIN tm_alumno_edu a ON a.idAlumno = c.idAlumno_cursos
                LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta
                WHERE c.idLlegada_cursos = ? AND c.codGrupo = ?";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([$idLlegada, $codigoGrupo]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Codificamos el resultado para guardarlo
        $json_string = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $file = 'listarCursosAlumno.json';
        file_put_contents($file, $json_string);

        return $result; 
    }


    public function insertarEvaluacion($horasRealizadas, $mostrarCertificado, $resultadoEvaluacion, $idLlegada, $tokenUsu, $codigoGrupo = null, $modo = 'completo')
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Determinar si es individual
        $individual = ($modo === 'individual') ? 1 : 0;

        // Asegurarse de que el valor NULL vaya bien en SQL si no hay código de grupo
        $codigoGrupoSQL = $codigoGrupo ? "'$codigoGrupo'" : "NULL";

        $sql = "INSERT INTO `evaluacionFinal`(
                    `idLlegadaEvaluacionFinal`,
                    `idAlumnoTokenEvaluacionFinal`,
                    `horasCertificadoEvaluacionFinal`,
                    `mostrarCertificadoEvaluacionFinal`,
                    `estadoLlegadaEvaluacionFinal`,
                    `codGrupoEvaluacionFinal`,
                    `individualEvaluacionFinal`
                ) VALUES (
                    '$idLlegada',
                    '$tokenUsu',
                    '$horasRealizadas',
                    '$mostrarCertificado',
                    '$resultadoEvaluacion',
                    $codigoGrupoSQL,
                    '$individual'
                )";

        // Guardar la consulta generada para debug
        $json_string = json_encode($sql);
        $file = 'evaluacionFinalinserrt.json';
        file_put_contents($file, $json_string);

        $sql = $conectar->prepare($sql);
        $success = $sql->execute();

        return ['success' => $success];
    }

    public function editarEvaluacion($idCertificado, $horasRealizadas, $mostrarCertificado, $resultadoEvaluacion, $idLlegada, $tokenUsu, $codigoGrupo = null, $modo = 'completo')
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Determinar si es individual
        $individual = ($modo === 'individual') ? 1 : 0;

        // Asegurarse de que el valor NULL vaya bien en SQL si no hay código de grupo
        $codigoGrupoSQL = $codigoGrupo ? "'$codigoGrupo'" : "NULL";

        $sql = "UPDATE `evaluacionFinal` SET
                    `idLlegadaEvaluacionFinal` = '$idLlegada',
                    `idAlumnoTokenEvaluacionFinal` = '$tokenUsu',
                    `horasCertificadoEvaluacionFinal` = '$horasRealizadas',
                    `mostrarCertificadoEvaluacionFinal` = '$mostrarCertificado',
                    `estadoLlegadaEvaluacionFinal` = '$resultadoEvaluacion',
                    `codGrupoEvaluacionFinal` = $codigoGrupoSQL,
                    `individualEvaluacionFinal` = '$individual'
                WHERE `idEvaluacionFinal` = '$idCertificado'";

        // Guardar la consulta generada para debug
        $json_string = json_encode($sql);
        $file = 'evaluacionFinal_edit1111.json';
        file_put_contents($file, $json_string);

        $sql = $conectar->prepare($sql);
        $success = $sql->execute();

        return ['success' => $success];
    }

    // CERTIFICADO //
     public function obtenerCertificadoGeneral($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ef.*, alu.*, lleg.*, mm.fechaInicio, mm.fechaFin FROM evaluacionFinal ef LEFT JOIN tm_alumno_edu alu ON ef.idAlumnoTokenEvaluacionFinal = alu.tokenUsu LEFT JOIN tm_llegadas_edu lleg ON ef.idLlegadaEvaluacionFinal = lleg.id_llegada LEFT JOIN ( SELECT idLlegada_matriculacion, MIN(fechaInicioMatriculacion) AS fechaInicio, MAX(fechaFinMatriculacion) AS fechaFin FROM tm_matriculacionllegadas_edu GROUP BY idLlegada_matriculacion) mm ON lleg.id_llegada = mm.idLlegada_matriculacion WHERE ef.idLlegadaEvaluacionFinal = $idLlegada AND individualEvaluacionFinal = 0;";
        $json_string = json_encode($sql);
        $file = 'TITEFnnn.json';
        file_put_contents($file, $json_string);
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result; 
    }
     public function obtenerCertificadoIndividual($idLlegada,$codigoGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
    ef.*,
    alu.*,
    lleg.*,
    mm.fechaInicio,
    mm.fechaFin
FROM evaluacionFinal ef
LEFT JOIN tm_alumno_edu alu 
    ON ef.idAlumnoTokenEvaluacionFinal = alu.tokenUsu
LEFT JOIN tm_llegadas_edu lleg 
    ON ef.idLlegadaEvaluacionFinal = lleg.id_llegada
LEFT JOIN (
    SELECT 
        idLlegada_matriculacion,
        MIN(fechaInicioMatriculacion) AS fechaInicio,
        MAX(fechaFinMatriculacion) AS fechaFin
    FROM tm_matriculacionllegadas_edu
    GROUP BY idLlegada_matriculacion
) mm ON lleg.id_llegada = mm.idLlegada_matriculacion
WHERE ef.idLlegadaEvaluacionFinal = $idLlegada
  AND ef.codGrupoEvaluacionFinal = '$codigoGrupo';
";
        $json_string = json_encode($sql);
        $file = 'TITEFnnn.json';
        file_put_contents($file, $json_string);
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result; 
    }

    public function obtenerEvaluacionFinalPorLlegada($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * 
                FROM evaluacionFinal 
                WHERE idLlegadaEvaluacionFinal = $idLlegada 
                AND individualEvaluacionFinal = 0";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Guardar en JSON (opcional)
        $json_string = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents('evaluacionFinalPorLlegada.json', $json_string);

        return $result;
    }



}

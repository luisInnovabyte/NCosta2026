<?php

class Horario extends Conectar
{
 
   public function listarhorario($idCurso)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM tm_horarioGrupo 
                LEFT JOIN tm_aulas ON tm_horarioGrupo.idAula_horario = tm_aulas.idAula 
                LEFT JOIN tm_personal ON tm_horarioGrupo.idProfesor_horario = tm_personal.idPersonal 
                WHERE idCurso_horario = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$idCurso]);

        $eventos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $color = '';
            $titulo = '';
            $textColor = 'white'; // por defecto

            $faltaAula = $row['idAula_horario'] == 0;
            $faltaProfesor = $row['idProfesor_horario'] == 0;

            if ($faltaAula && $faltaProfesor) {
                $color = 'red';
                $titulo = '🔴 Falta profesor y aula';
            } elseif ($faltaAula) {
                $color = '#FFD700'; // amarillo más oscuro
                $textColor = 'black'; // mejora contraste
                $titulo = '🟡 Falta aula | Prof: ' . $row['nomPersonal'] . ' ' . $row['apePersonal'];
            } elseif ($faltaProfesor) {
                $color = 'orange';
                $titulo = '🟠 Falta profesor | Aula: ' . $row['nombreAula'];
            } else {
                $color = 'green';
                $titulo = '🟢 Prof: ' . $row['nomPersonal'] . ' ' . $row['apePersonal'] . ' Aula: ' . $row['nombreAula'];
            }

            // 👇 Si no está publicado, se fuerza a gris deshabilitado
            if ($row['publicadoHorario'] == 0) {
                $color = '#B0B0B0';
                $textColor = 'white'; // por si acaso, refuerza la visibilidad sobre gris
            }

            $eventos[] = [
                'title' => $titulo,
                'start' => $row['diaInicio_horario'] . 'T' . $row['horaInicio_horario'],
                'end' => $row['diaInicio_horario'] . 'T' . $row['horaFin_horario'],
                'color' => $color,
                'textColor' => $textColor,
                'extendedProps' => [
                    'aula' => $row['idAula_horario'],
                    'descripcion' => $row['descripcion_horario'],
                    'profesor' => $row['idProfesor_horario'],
                    'idHorario' => $row['idHorario'],
                ]
            ];
        }


        header('Content-Type: application/json');
        echo json_encode($eventos);
    }

    public function listarhorarioAlumno($idCurso)
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();
        $idAlumno = $_SESSION['usuPre_idInscripcion'];

        $sql = "SELECT hg.*, a.*, p.*, tdc.*, ldc.* FROM tm_horarioGrupo hg LEFT JOIN tm_aulas a ON hg.idAula_horario = a.idAula LEFT JOIN tm_personal p ON hg.idProfesor_horario = p.idPersonal LEFT JOIN tareasDiariaClase tdc ON hg.idHorario = tdc.idHorarioTareas LEFT JOIN listaDiariaClase ldc ON hg.idHorario = ldc.idHorarioLista AND ldc.idAlumnoLista = '$idAlumno' WHERE hg.idCurso_horario = '$idCurso' ORDER BY hg.diaInicio_horario, hg.horaInicio_horario;";
        $json_string = json_encode($sql);
        $file = 'assa.json';
        file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $eventos = [];

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
             // Definir color según si hay tarea
            $tieneTarea = !empty(trim($row['descripcionTarea']));
            $colorEvento = $tieneTarea ? '#28a745' : '#007bff'; // Azul si tiene tarea, verde si no
            $eventos[] = [
                'title' => $row['nombreAula'] . ' - ' . $row['nomPersonal'] . ' ' . $row['apePersonal'],
                'start' => $row['diaInicio_horario'] . 'T' . $row['horaInicio_horario'],
                'color' => $colorEvento, // ← Aquí aplicas el color
                'end' => $row['diaInicio_horario'] . 'T' . $row['horaFin_horario'],
                'extendedProps' => [
                    'aula' => $row['nombreAula'],
                    'descripcion' => $row['descripcion_horario'],
                    'profesor' => $row['nomPersonal'].' '.$row['apePersonal'],
                    'idHorario' => $row['idHorario'],
                    'descripcionTarea' => $row['descripcionTarea'],
                    'descripcionTarePersonal' => $row['tareaIndividualListaDiaria']

                ]
            ];
        }

        header('Content-Type: application/json');
      
        echo json_encode($eventos); // <- Aquí lo imprime como JSON para FullCalendar
    }
    public function listarhorarioProfesores()
    {
        $conectar = parent::conexion();
        parent::set_names();
        session_start();
        $idProfesor = $_SESSION['usuPre_idInscripcion'];
        $sql = "SELECT h.*, a.*, p.*, IFNULL(c.est_cursos, 0) AS estCursoGrupo FROM tm_horarioGrupo h LEFT JOIN tm_aulas a ON h.idAula_horario = a.idAula LEFT JOIN tm_personal p ON h.idProfesor_horario = p.idPersonal LEFT JOIN ( SELECT codGrupo, MAX(est_cursos) AS est_cursos FROM cursos GROUP BY codGrupo ) c ON h.idCurso_horario = c.codGrupo WHERE idProfesor_horario = ?";
       
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$idProfesor]);

        $eventos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
            $eventos[] = [
                'title' => $row['nombreAula'] . ' - ' . $row['idCurso_horario'],
                'start' => $row['diaInicio_horario'] . 'T' . $row['horaInicio_horario'],
                'end' => $row['diaInicio_horario'] . 'T' . $row['horaFin_horario'],
                'extendedProps' => [
                    'aula' => $row['nombreAula'],
                    'descripcion' => $row['descripcion_horario'],
                    'profesor' => $row['nomPersonal'].' '.$row['apePersonal'],
                    'idHorario' => $row['idHorario'],
                    'idCurso' => $row['idCurso_horario'],
                    'estCurso' => $row['estCursoGrupo']

                ]
            ];
        }

        header('Content-Type: application/json');
      
        echo json_encode($eventos); // <- Aquí lo imprime como JSON para FullCalendar
    }
   public function listarProfesores($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
     
    
        $sql = "SELECT `idRuta_cursos` FROM `cursos` WHERE codGrupo = '$idGrupo' LIMIT 1;";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
 
        $resultado = $sql->fetch();

        if ($resultado) {
            $ruta = $resultado['idRuta_cursos'];
            $sql = "SELECT * FROM `tm_ruta` WHERE id_ruta = '$ruta' LIMIT 1;";

            $sql = $conectar->prepare($sql);
            $sql->execute();
            $resultado = $sql->fetch();
     
            if ($resultado) {
                $idioma = $resultado['idiomaId_ruta'];
                $tipo   = $resultado['tipoId_ruta'];
                $nivel  = $resultado['nivelId_ruta'];

                $sql = "SELECT * 
                FROM `rutasPersonal` 
                LEFT JOIN `tm_personal` 
                    ON rutasPersonal.id_personalRPersonal = tm_personal.idPersonal 
                WHERE `idIdioma_RPersonal` = $idioma
                AND `idtipo_RPersonal` = $tipo 
                AND $nivel BETWEEN `nivelDesde_RPersonal` AND `nivelHasta_RPersonal`;";
      
                $sql = $conectar->prepare($sql);
                $sql->execute();
                $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); // <-- aquí está el cambio

                echo json_encode($resultado); // ✅ ya imprime aquí


            } else {
                return null;
            }

        } else {
            return null; // o false o lo que necesites
        }
    }


     public function listarAulas()
    {
        $conectar = parent::conexion();
        parent::set_names();
     
    
        $sql = "SELECT * FROM `tm_aulas` WHERE estAula = 1";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); // <-- aquí está el cambio

        echo json_encode($resultado); // ✅ ya imprime aquí

      
    }
   public function insertarHorarios($codClase, $fecIni, $horaIni, $selectProfesores, $selectAulas, $descripcion, $horaFin, $dias, $publicadoHorario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $horaIni = trim($horaIni);
        $horaFin = trim($horaFin);
        $descripcion = addslashes($descripcion);

        $resumen = [];

        foreach ($dias as $dia) {
            $fechaDia = stripslashes(trim($dia, "'"));
            if (strpos($fechaDia, '/') !== false) {
                list($d, $m, $y) = explode('/', $fechaDia);
                $fechaDia = "$y-$m-$d";
            }

            $profesorFinal = $selectProfesores;
            $aulaFinal = $selectAulas;
            $mensaje = "";

            // 1. Validar profesor ocupado
            $sqlProfesor = "
                SELECT idCurso_horario FROM tm_horarioGrupo
                WHERE diaInicio_horario = '$fechaDia'
                AND idProfesor_horario = '$selectProfesores'
                AND horaInicio_horario < '$horaFin'
                AND horaFin_horario > '$horaIni'
            ";
            $stmt = $conectar->prepare($sqlProfesor);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $profesorFinal = 0;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje .= "⚠️ Profesor ocupado (curso {$row['idCurso_horario']}). Se insertó con profesor = 0. ";
            }

            // 2. Validar aula ocupada
            $sqlAula = "
                SELECT idCurso_horario FROM tm_horarioGrupo
                WHERE diaInicio_horario = '$fechaDia'
                AND idAula_horario = '$selectAulas'
                AND horaInicio_horario < '$horaFin'
                AND horaFin_horario > '$horaIni'
            ";
            $stmt = $conectar->prepare($sqlAula);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $aulaFinal = 0;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje .= "⚠️ Aula ocupada (curso {$row['idCurso_horario']}). Se insertó con aula = 0. ";
            }

            // 3. Validar duplicado exacto del curso
            $sqlCurso = "
                SELECT * FROM tm_horarioGrupo LEFT JOIN tm_aulas ON tm_horarioGrupo.idAula_horario = tm_aulas.idAula
                WHERE diaInicio_horario = '$fechaDia'
                AND idCurso_horario = '$codClase'
                AND horaInicio_horario < '$horaFin'
                AND horaFin_horario > '$horaIni'
            ";
            $stmt = $conectar->prepare($sqlCurso);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $resumen[] = [
                    "fecha" => $fechaDia,
                    "estado" => "error",
                    "mensaje" => "❌ El curso ya está asignado al aula {$row['nombreAula']}. No se ha insertado."
                ];
                continue;
            }

            // 4. Insertar con los valores actuales
            $sqlInsert = "
                INSERT INTO tm_horarioGrupo 
                (idCurso_horario, idAula_horario, idProfesor_horario, descripcion_horario, diaInicio_horario, horaInicio_horario, horaFin_horario, estHorario, publicadoHorario)
                VALUES ('$codClase', '$aulaFinal', '$profesorFinal', '$descripcion', '$fechaDia', '$horaIni', '$horaFin', '1','$publicadoHorario')
            ";
            $stmt = $conectar->prepare($sqlInsert);
            $stmt->execute();

            $resumen[] = [
                "fecha" => $fechaDia,
                "estado" => "ok",
                "mensaje" => !empty($mensaje) ? trim($mensaje) : null
            ];
        }


        echo json_encode([
            "status" => "parcial",
            "resumen" => $resumen
        ]);

}

        public function editarHorarios($idHorarioActual,$codClase, $fecIni, $horaIni, $selectProfesores, $selectAulas, $descripcion, $horaFin)
        {
            $conectar = parent::conexion();
            parent::set_names();

            $horaIni = trim($horaIni);
            $horaFin = trim($horaFin);
            $descripcion = addslashes($descripcion);

            $resumen = [];

            $fechaDia = stripslashes(trim($fecIni, "'"));
            if (strpos($fechaDia, '/') !== false) {
                list($d, $m, $y) = explode('/', $fechaDia);
                $fechaDia = "$y-$m-$d";
            }

            $profesorFinal = $selectProfesores;
            $aulaFinal = $selectAulas;
            $mensaje = "";

            // 1. Validar profesor ocupado
            $sqlProfesor = "
                SELECT h.idCurso_horario 
                FROM tm_horarioGrupo h
                WHERE h.diaInicio_horario = '$fechaDia'
                AND h.idProfesor_horario = '$selectProfesores'
                AND h.horaInicio_horario < '$horaFin'
                AND h.horaFin_horario > '$horaIni'
                AND h.idHorario != '$idHorarioActual'
                AND EXISTS (
                    SELECT 1 
                    FROM cursos c 
                    WHERE c.codGrupo = h.idCurso_horario 
                        AND c.est_cursos = 1
                )
            ";

            $json_string = json_encode($sqlProfesor);
            $file = 'xProfesor.json';
            file_put_contents($file, $json_string);
            $stmt = $conectar->prepare($sqlProfesor);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $profesorFinal = 0;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje .= "⚠️ Profesor ocupado (curso {$row['idCurso_horario']}). Se editó con profesor = 0. ";
            }

            // 2. Validar aula ocupada
            $sqlAula = "
                SELECT h.idCurso_horario 
                FROM tm_horarioGrupo h
                WHERE h.diaInicio_horario = '$fechaDia'
                AND h.idAula_horario = '$selectAulas'
                AND h.horaInicio_horario < '$horaFin'
                AND h.horaFin_horario > '$horaIni'
                AND h.idHorario != '$idHorarioActual'
                AND EXISTS (
                    SELECT 1 
                    FROM cursos c 
                    WHERE c.codGrupo = h.idCurso_horario 
                        AND c.est_cursos = 1
                )
            ";

            $json_string = json_encode($sqlAula);
            $file = 'xAula.json';
            file_put_contents($file, $json_string);
     
            $stmt = $conectar->prepare($sqlAula);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $aulaFinal = 0;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mensaje .= "⚠️ Aula ocupada (curso {$row['idCurso_horario']}). Se editó con aula = 0. ";
            }

            $sqlCurso = "
                SELECT * 
                FROM tm_horarioGrupo 
                LEFT JOIN tm_aulas ON tm_horarioGrupo.idAula_horario = tm_aulas.idAula
                WHERE diaInicio_horario = '$fechaDia'
                AND idCurso_horario = '$codClase'
                AND horaInicio_horario < '$horaFin'
                AND horaFin_horario > '$horaIni'
                AND idHorario != '$idHorarioActual'
                AND EXISTS (
                    SELECT 1 
                    FROM cursos c 
                    WHERE c.codGrupo = tm_horarioGrupo.idCurso_horario 
                        AND c.est_cursos = 1
                )
            ";

            $json_string = json_encode($sqlCurso);
            $file = 'xCursos.json';
            file_put_contents($file, $json_string);
            $stmt = $conectar->prepare($sqlCurso);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $resumen[] = [
                    "fecha" => $fechaDia,
                    "estado" => "error",
                    "mensaje" => "❌ El curso ya está asignado al aula '{$row['nombreAula']}'. No se ha editado."
                ];
            } else {
                // 4. Insertar con los valores actuales
                $sqlUpdate = "
                    UPDATE tm_horarioGrupo 
                    SET 
                        idCurso_horario = '$codClase',
                        idAula_horario = '$aulaFinal',
                        idProfesor_horario = '$profesorFinal',
                        descripcion_horario = '$descripcion',
                        diaInicio_horario = '$fechaDia',
                        horaInicio_horario = '$horaIni',
                        horaFin_horario = '$horaFin',
                        estHorario = '1'
                    WHERE idHorario = '$idHorarioActual'
                ";
                $stmt = $conectar->prepare($sqlUpdate);
                $stmt->execute();

                $resumen[] = [
                    "fecha" => $fechaDia,
                    "estado" => "ok",
                    "mensaje" => !empty($mensaje) ? trim($mensaje) : null
                ];
            }

            echo json_encode([
                "status" => "parcial",
                "resumen" => $resumen
            ]);
        }


     public function eliminarEvento($idHorario)
    {
        $conectar = parent::conexion();
        parent::set_names();
     
    
        $sql = "DELETE FROM `tm_horarioGrupo` WHERE idHorario = $idHorario";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        

        echo 1; // ✅ ya imprime aquí

      
    }
    public function visibilidadHorario($rutaSeleccionada,$inicioSemana,$finSemana,$estado)
    {
        $conectar = parent::conexion();
        parent::set_names();
   
        $sql = "UPDATE `tm_horarioGrupo`
        SET publicadoHorario = $estado
        WHERE idCurso_horario = '$rutaSeleccionada'
        AND diaInicio_horario BETWEEN '$inicioSemana' AND '$finSemana';
        ";
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
        

        echo 1; // ✅ ya imprime aquí

      
    }
    public function cargarEstadoSwitch($rutaSeleccionada,$inicioSemana,$finSemana)
    {
         $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT publicadoHorario
        FROM tm_horarioGrupo
        WHERE idCurso_horario = '$rutaSeleccionada'
        AND diaInicio_horario BETWEEN '$inicioSemana' AND '$finSemana'
        GROUP BY publicadoHorario
        ORDER BY COUNT(*) DESC
        LIMIT 1;";

                
        $sql = $conectar->prepare($sql);
        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        echo json_encode($resultado['publicadoHorario']); // Esto imprimirá 0 o 1

    }
     public function recogerAlumnosGrupo($rutaSeleccionada)
    {
         $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
        cursos.*, 
        tm_alumno_edu.*, 
        tm_llegadas_edu.grupoAmigos,
        tm_prescriptores.*,
        CASE tm_prescriptores.preferenciaHoraria
            WHEN 0 THEN 'Sin Preferencias'
            WHEN 1 THEN 'Mañanas'
            WHEN 2 THEN 'Tardes'
            ELSE 'Desconocido'
        END AS preferenciaPrincipal,


        GROUP_CONCAT(DISTINCT 
            CONCAT_WS(' - ', 
                CONCAT_WS(' ', gpo_prefs.nomPrescripcion, gpo_prefs.apePrescripcion),
                CASE gpo_prefs.preferenciaHoraria
                    WHEN 0 THEN 'Sin Preferencias'
                    WHEN 1 THEN 'Mañanas'
                    WHEN 2 THEN 'Tardes'
                    ELSE 'Desconocido'
                END
            )
            SEPARATOR ', '
        ) AS preferenciasGrupo

        FROM cursos

        LEFT JOIN tm_llegadas_edu 
            ON cursos.idLlegada_cursos = tm_llegadas_edu.id_llegada

        LEFT JOIN tm_alumno_edu 
            ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno

        LEFT JOIN tm_prescriptores 
            ON tm_llegadas_edu.idPrescriptor_llegadas = tm_prescriptores.idPrescripcion

              LEFT JOIN (
            SELECT 
                l2.grupoAmigos, 
                p2.nomPrescripcion,
                p2.apePrescripcion,
                p2.preferenciaHoraria
            FROM tm_llegadas_edu l2
            LEFT JOIN tm_prescriptores p2 
                ON l2.idPrescriptor_llegadas = p2.idPrescripcion
        ) AS gpo_prefs
            ON gpo_prefs.grupoAmigos = tm_llegadas_edu.grupoAmigos WHERE cursos.codGrupo = '$rutaSeleccionada' AND cursos.est_cursos = 1

        GROUP BY cursos.idCurso     
        ";

                
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

      public function listarhorarioxId($idCurso)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM tm_horarioGrupo 
                LEFT JOIN tm_aulas ON tm_horarioGrupo.idAula_horario = tm_aulas.idAula 
                LEFT JOIN tm_personal ON tm_horarioGrupo.idProfesor_horario = tm_personal.idPersonal 
                WHERE idHorario = $idCurso";
         
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
  }
     public function comprobarListaAlumno($idAlumno,$idHorario)
    {
        $conectar = parent::conexion();
        parent::set_names();
         
        $sql = "SELECT * FROM `listaDiariaClase` WHERE idHorarioLista = $idHorario AND idAlumnoLista = $idAlumno";
               
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo json_encode($resultado); // Esto imprimirá 0 o 1

         
  }
    public function insertarLista($idAlumno, $idCurso, $idHorario, $estadoAsistencia, $horaLlegada, $horasAsistencia, $motivo, $tareas, $observaciones,$tareaAlumno,$idLlegadaSelect) {
         $conectar = parent::conexion();
        parent::set_names();

        session_start();
        $idProfesor = $_SESSION['usuPre_idInscripcion'];
               
        $sqlInsert = "INSERT INTO listaDiariaClase (
            idAlumnoLista, idProfesorLista, idHorarioLista, idCodigoCursoLista,
            estadoAsistenciaLista, horasAsistenciaLista, horaLlegadaLista,
            motivoRetrasoLista, tareasRealizadasLista, obsDiariaLista, estListaDiariaClase, tareaIndividualListaDiaria,idLlegadaListaDiariaClase
        ) VALUES (
            '$idAlumno', '$idProfesor', '$idHorario', '$idCurso',
            '$estadoAsistencia', '$horasAsistencia', '$horaLlegada',
            '$motivo', '$tareas', '$observaciones', '1', '$tareaAlumno',$idLlegadaSelect
        )";
   
        $sql = $conectar->prepare($sqlInsert);
        $sql->execute();
      
    }

    public function editarLista($idLista,$idAlumno, $idCurso, $idHorario, $asistencia, $hora_llegada, $horas_asistencia, $motivo, $tareas_realizadas, $observaciones,$tareaAlumno,$idLlegadaSelect) {
        $conectar = parent::conexion();
        parent::set_names();
     

        session_start();
        $idProfesor = $_SESSION['usuPre_idInscripcion'];
        $sqlUpdate = "UPDATE listaDiariaClase SET 
        idAlumnoLista = '$idAlumno',
        idProfesorLista = '$idProfesor',
        idHorarioLista = '$idHorario',
        idCodigoCursoLista = '$idCurso',
        estadoAsistenciaLista = '$asistencia',
        horasAsistenciaLista = '$horas_asistencia',
        horaLlegadaLista = '$hora_llegada',
        motivoRetrasoLista = '$motivo',
        tareasRealizadasLista = '$tareas_realizadas',
        obsDiariaLista = '$observaciones',
        estListaDiariaClase = '1',
        tareaIndividualListaDiaria = '$tareaAlumno'
        WHERE idLista = '$idLista'";

        $sql = $conectar->prepare($sqlUpdate);
        $sql->execute();
      
    }

    // MÉTODO PARA MARCAR A TODOS LOS ALUMNOS COMO ASISTIDOS
    // - PRIMERO RECOGE LOS IDS DE LOS ALUMNOS APUNTOS A ESE GRUPO
    // - DESPUÉS HAGO UN BUCLE Y COMPRUEBO SI EXISTEN EN LA LISTA DIARIA DE CLASE
    // - SI EXISTEN, SE PONE SU ASISTENCIA COMO 1
    // - SI NO EXISTEN, SE CREA SU REGISTRO EN LA LISTA, Y SE PONE SU ASISTENCIA COMO 1 
    public function marcarTodosPresentes($codigoCurso, $idHorario, $idProfesor, $horaClase, $horasAsistidas) {
    session_start();
    $conectar = parent::conexion();
    parent::set_names();

    // Obtener alumnos del curso
    $sql = "SELECT cursos.*, tm_alumno_edu.*, tm_usuario.*, listaDiariaClase.* 
            FROM cursos 
            LEFT JOIN tm_alumno_edu ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno 
            LEFT JOIN tm_usuario ON tm_usuario.idUsu = tm_alumno_edu.idUsuario_tmalumno 
            LEFT JOIN listaDiariaClase ON listaDiariaClase.idAlumnoLista = cursos.idAlumno_cursos 
            WHERE cursos.codGrupo = ?";
    $stmt = $conectar->prepare($sql);
    $stmt->execute([$codigoCurso]);
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($alumnos as $alumno) {
        $idAlumno = $alumno['idAlumno_cursos'];
        $idLlegada = $alumno['idLlegada_cursos']; // NUEVO: se obtiene el id de llegada individual

        // Verificar si ya existe registro en listaDiariaClase para este alumno y horario
        $checkSql = "SELECT idLista FROM listaDiariaClase WHERE idAlumnoLista = ? AND idHorarioLista = ?";
        $checkStmt = $conectar->prepare($checkSql);
        $checkStmt->execute([$idAlumno, $idHorario]);
        $existe = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existe) {
            // Actualizar registro existente
            $updateSql = "UPDATE listaDiariaClase 
                          SET estadoAsistenciaLista = 1, 
                              horaLlegadaLista = ?, 
                              horasAsistenciaLista = ?,
                              idLlegadaListaDiariaClase = ?
                          WHERE idLista = ?";
            $updateStmt = $conectar->prepare($updateSql);
            $updateStmt->execute([$horaClase, $horasAsistidas, $idLlegada, $existe['idLista']]);
        } else {
            // Insertar nuevo registro
            $insertSql = "INSERT INTO listaDiariaClase 
                (idAlumnoLista, idProfesorLista, idHorarioLista, idCodigoCursoLista, estadoAsistenciaLista, horasAsistenciaLista, horaLlegadaLista, estListaDiariaClase, idLlegadaListaDiariaClase)
                VALUES (?, ?, ?, ?, 1, ?, ?, 1, ?)";
            $insertStmt = $conectar->prepare($insertSql);
            $insertStmt->execute([$idAlumno, $idProfesor, $idHorario, $codigoCurso, $horasAsistidas, $horaClase, $idLlegada]);
        }
    }

    return true;
}


    public function insertarTareaDiaria($idCurso,$idHorario,$tareaHoy) {
         $conectar = parent::conexion();
        parent::set_names();

        session_start();
        $idProfesor = $_SESSION['usuPre_idInscripcion'];
               
        $sqlInsert = "INSERT INTO `tareasDiariaClase`(`idProfesorTareas`, `idHorarioTareas`, `idCodigoCursoTarea`, `duracionTareas`, `descripcionTarea`, `estTareas`) 
        VALUES ('$idProfesor','$idHorario','$idCurso','0','$tareaHoy','1')";
   
        $sql = $conectar->prepare($sqlInsert);
      
        $sql->execute();
      
    }
   
    public function editarTareaDiaria($idTarea,$idCurso,$idHorario,$tareaHoy) {
         $conectar = parent::conexion();
        parent::set_names();
           
       $sqlUpdate = "UPDATE `tareasDiariaClase` 
              SET `descripcionTarea` = '$tareaHoy'
                  
              WHERE `idTareasDiaria` = '$idTarea'";
        $sql = $conectar->prepare($sqlUpdate);
        $sql->execute();

        return $resultado = $sql->fetchAll();
      
    }
     public function cargarTareasDiarias($idHorario) {
         $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `tareasDiariaClase` left join tm_horarioGrupo ON tareasDiariaClase.idHorarioTareas = tm_horarioGrupo.idHorario WHERE `idHorarioTareas` = $idHorario;";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
      
    }
    public function cargarTareasDiaAnterior($idCurso_horario, $diaInicio_horario, $horaInicio_horario) {
        $conectar = parent::conexion();
        parent::set_names();

        $sql1 = "SELECT * FROM tm_horarioGrupo WHERE idCurso_horario = '$idCurso_horario' AND (diaInicio_horario < '$diaInicio_horario' OR (diaInicio_horario = '$diaInicio_horario' AND horaInicio_horario < '$horaInicio_horario')) ORDER BY diaInicio_horario DESC, horaInicio_horario DESC LIMIT 1;";
       
        $stmt1 = $conectar->prepare($sql1);
        $stmt1->execute();
        $resultado = $stmt1->fetch(PDO::FETCH_ASSOC);
       
        if ($resultado) {
            $idHorario = $resultado['idHorario'];

            $sql2 = "SELECT * FROM tareasDiariaClase LEFT JOIN tm_personal ON tareasDiariaClase.idProfesorTareas = tm_personal.`idPersonal` LEFT JOIN tm_horarioGrupo ON tareasDiariaClase.idHorarioTareas = tm_horarioGrupo.idHorario WHERE idHorarioTareas = $idHorario ;";
            $json_string = json_encode($sql2);
            $file = 'U8.json';
            file_put_contents($file, $json_string);
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->execute();

            return $stmt2->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

}
<?php

class Grupos extends Conectar
{

    public function listarAlumnosNuevos($idDepartamento, $fechaInicio, $fechaFin)
    {
        
        $conectar = parent::conexion();
        parent::set_names();
  
       /* LE DA IGUAL QEU SE REPITA $sql = "SELECT 
        tm_llegadas_edu.id_llegada, 
        tm_llegadas_edu.grupoAmigos, 
        tm_llegadas_edu.nivelasignado_llegadas, 
        tm_prescriptores.nomPrescripcion, 
        tm_prescriptores.apePrescripcion, 
        tm_prescriptores.tokenPrescriptores, 
        ruta_completo.codIdioma, 
        ruta_completo.codTipo, 
        ruta_completo.codNivel,
        MIN(tm_matriculacionllegadas_edu.fechaInicioMatriculacion) AS fechaInicioMatriculacion
        FROM tm_llegadas_edu 
        LEFT JOIN tm_prescriptores 
            ON tm_llegadas_edu.idprescriptor_llegadas = tm_prescriptores.idPrescripcion 
        LEFT JOIN ruta_completo 
            ON ruta_completo.id_ruta = tm_llegadas_edu.nivelasignado_llegadas 
        LEFT JOIN tm_matriculacionllegadas_edu 
            ON tm_llegadas_edu.id_llegada = tm_matriculacionllegadas_edu.idLlegada_matriculacion WHERE estMatricula IN (1, 2)  AND iddepartamento_llegadas = $idDepartamento AND fechaInicioMatriculacion BETWEEN '$fechaInicio' AND '$fechaFin'
        GROUP BY tm_llegadas_edu.id_llegada;"; */
       
        $sql = "SELECT
        tm_llegadas_edu.id_llegada,
        tm_llegadas_edu.grupoAmigos,
        tm_llegadas_edu.nivelasignado_llegadas,
        tm_prescriptores.nomPrescripcion,
        tm_prescriptores.apePrescripcion,
        tm_prescriptores.tokenPrescriptores,
        ruta_completo.codIdioma,
        ruta_completo.codTipo,
        ruta_completo.codNivel,
        MIN(tm_matriculacionllegadas_edu.fechaInicioMatriculacion) AS fechaInicioMatriculacion
        FROM tm_llegadas_edu
        LEFT JOIN tm_prescriptores
            ON tm_llegadas_edu.idprescriptor_llegadas = tm_prescriptores.idPrescripcion
        LEFT JOIN ruta_completo
            ON ruta_completo.id_ruta = tm_llegadas_edu.nivelasignado_llegadas
        LEFT JOIN tm_matriculacionllegadas_edu
            ON tm_llegadas_edu.id_llegada = tm_matriculacionllegadas_edu.idLlegada_matriculacion
        WHERE estMatricula IN (1, 2)
            AND iddepartamento_llegadas = '$idDepartamento'
            AND fechaInicioMatriculacion BETWEEN '$fechaInicio' AND '$fechaFin'
            AND NOT EXISTS (
                SELECT 1
                FROM cursos
                WHERE cursos.idLlegada_cursos = tm_llegadas_edu.id_llegada
            )
        GROUP BY tm_llegadas_edu.id_llegada;";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarAulas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_aulas WHERE estAula = 1;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerGrupoAmigos($nombreGrupos,$depaSelect)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_alumno_edu LEFT JOIN tm_llegadas_edu ON tm_alumno_edu.idAlumno = tm_llegadas_edu.idprescriptor_llegadas LEFT JOIN tm_prescriptores ON tm_llegadas_edu.idprescriptor_llegadas = tm_prescriptores.idPrescripcion WHERE grupoAmigos = '$nombreGrupos' AND estLlegada = 1 AND iddepartamento_llegadas = '$depaSelect';";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarAulaGrupo($aulaSeleccionada,$grupoSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // ELIMINAR CLASES DEL GRUPO ANTES
        $sql1 = "UPDATE `asignacionAulasGrupo` SET estAulasAsignacion = 0 WHERE idGrupoAsignacion = '$grupoSeleccionado'";
       
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();

        // AÑADIR CLASE A GRUPO
        $sql = "INSERT INTO `asignacionAulasGrupo`(`idGrupoAsignacion`, `idAulasAsignacion`, `idHorariosAsignacion`, `estAulasAsignacion`) VALUES ('$grupoSeleccionado','$aulaSeleccionada','0','1')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    
    public function cargarAulasGrupo($codSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM asignacionAulasGrupo left join tm_aulas ON asignacionAulasGrupo.idAulasAsignacion = tm_aulas.idAula WHERE idGrupoAsignacion = '$codSeleccionado' AND estAulasAsignacion = '1';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerAlumnosCurso($codSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM cursos LEFT JOIN tm_alumno_edu ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno WHERE cursos.codGrupo = '$codSeleccionado';";

        $sql = $conectar->prepare($sql);

        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarGruposXRuta($idAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_llegadas_edu LEFT JOIN tm_prescriptores ON tm_llegadas_edu.idprescriptor_llegadas = tm_prescriptores.idPrescripcion LEFT JOIN ruta_completo ON ruta_completo.id_ruta = tm_llegadas_edu.nivelasignado_llegadas WHERE id_llegada = $idAlumno;";

        $sql = $conectar->prepare($sql);
        $sql->execute(); // Ejecuta la consulta
     
        $resultado = $sql->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un array asociativo
        $codIdiomaSq =  $resultado['codIdioma'];
        $codTipoSq = $resultado['codTipo'];
        $sql = "SELECT c.idGrupo, c.codGrupo, COUNT(c.idCurso) AS total_alumnos, MAX(c.fechaCrea_cursos) AS ultima_fecha, r.* FROM cursos c LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta WHERE c.est_cursos = 1 and  codIdioma = '$codIdiomaSq' AND codTipo = '$codTipoSq' GROUP BY c.codGrupo, c.idGrupo, r.id_ruta;";
               $json_string = json_encode($sql);
       $file = 'KETAPASANDO1.json';
       file_put_contents($file, $json_string);
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarGruposTodosCalendar()
    {
        $conectar = parent::conexion();
        parent::set_names();
      
    
        $sql = "SELECT 
            c.idGrupo, 
            c.codGrupo, 
            c.est_cursos,
            COUNT(c.idCurso) AS total_alumnos, 
            MAX(c.fechaCrea_cursos) AS ultima_fecha, 
            r.*,
            COALESCE(ea.estado_actual, 'Sin asignar') AS semana_actual,
            COALESCE(es.estado_siguiente, 'Sin asignar') AS semana_siguiente

        FROM 
            cursos c
        LEFT JOIN 
            ruta_completo r ON c.idRuta_cursos = r.id_ruta
        LEFT JOIN (
            SELECT 
                h.idCurso_horario,
                CASE 
                    WHEN COUNT(h.publicadoHorario) = 0 THEN NULL
                    WHEN SUM(h.publicadoHorario = 1) >= SUM(h.publicadoHorario = 0) THEN 'Publicado'
                    ELSE 'Provisional'
                END AS estado_actual
            FROM 
                tm_horarioGrupo h
            WHERE 
                YEARWEEK(h.diaInicio_horario, 1) = YEARWEEK(CURDATE(), 1)
            GROUP BY 
                h.idCurso_horario
        ) ea ON c.codGrupo = ea.idCurso_horario
        LEFT JOIN (
            SELECT 
                h.idCurso_horario,
                CASE 
                    WHEN COUNT(h.publicadoHorario) = 0 THEN NULL
                    WHEN SUM(h.publicadoHorario = 1) >= SUM(h.publicadoHorario = 0) THEN 'Publicado'
                    ELSE 'Provisional'
                END AS estado_siguiente
            FROM 
                tm_horarioGrupo h
            WHERE 
                YEARWEEK(h.diaInicio_horario, 1) = YEARWEEK(DATE_ADD(CURDATE(), INTERVAL 1 WEEK), 1)
            GROUP BY 
                h.idCurso_horario
        ) es ON c.codGrupo = es.idCurso_horario

        GROUP BY 
            c.codGrupo, c.idGrupo,c.est_cursos, r.id_ruta, ea.estado_actual, es.estado_siguiente  
        ORDER BY `c`.`est_cursos` DESC";

     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     public function listarGruposTodos()
    {
        $conectar = parent::conexion();
        parent::set_names();
      
    
        $sql = "SELECT c.idGrupo, c.codGrupo, COUNT(c.idCurso) AS total_alumnos, MAX(c.fechaCrea_cursos) AS ultima_fecha, r.* FROM cursos c LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta WHERE c.est_cursos = 1  GROUP BY c.codGrupo, c.idGrupo, r.id_ruta;";

     
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarGruposTodosRight($idRuta,$codGrupo,$codIdioma,$codTipoCurso)
    {
        $conectar = parent::conexion();
        parent::set_names();
      
    
        $sql = "SELECT c.idGrupo, c.codGrupo, COUNT(c.idCurso) AS total_alumnos, MAX(c.fechaCrea_cursos) AS ultima_fecha, r.* FROM cursos c LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta WHERE c.est_cursos = 1 and c.codGrupo <> '$codGrupo' AND codIdioma = '$codIdioma' AND codTipo = '$codTipoCurso' GROUP BY c.codGrupo, c.idGrupo, r.id_ruta;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function listarGruposGeneral($idioma,$cursos)
    {
        $conectar = parent::conexion();
        parent::set_names();
      
    
        $sql = "SELECT c.idGrupo, c.codGrupo, COUNT(c.idCurso) AS total_alumnos, MAX(c.fechaCrea_cursos) AS ultima_fecha, r.* FROM cursos c LEFT JOIN ruta_completo r ON c.idRuta_cursos = r.id_ruta WHERE c.est_cursos = 1 and idiomaId_ruta = '$idioma' AND tipoId_ruta = '$cursos' GROUP BY c.codGrupo, c.idGrupo, r.id_ruta;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
    public function mostrarAlumnoXId($idAlumno)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_alumno_edu LEFT JOIN tm_llegadas_edu ON tm_alumno_edu.idAlumno = tm_llegadas_edu.idprescriptor_llegadas LEFT JOIN tm_usuario ON tm_alumno_edu.idAlumno = tm_usuario.idInscripcion_tmusuario LEFT JOIN tm_prescriptores ON tm_alumno_edu.idInscripcion_tmAlumno = tm_prescriptores.idPrescripcion  LEFT JOIN ruta_completo ON tm_llegadas_edu.nivelasignado_llegadas = ruta_completo.id_ruta LEFT JOIN cursos ON tm_llegadas_edu.id_llegada = cursos.idLlegada_cursos WHERE tm_llegadas_edu.id_llegada = $idAlumno";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function crearAlumnosCurso($idAlumno, $nivelAsig, $idLlegada, $fechaActual, $codNivel)
    {
        $conectar = parent::conexion();
        parent::set_names();
        // COMPROBAMOS SI EXISTE UN PRIMER CURSO CREADO SUMANDOLE +1 POR LA CODIFICACION
   
        // Consulta para obtener el mayor idGrupo del codGrupo dado
        $sql = "SELECT MAX(idGrupo) AS max_idGrupo FROM cursos WHERE  codGrupo LIKE '%$codNivel%' AND est_cursos = 1;";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['max_idGrupo'] !== null) {
            
            $cantidadGrupo = $resultado['max_idGrupo'] + 1; // Se obtiene el mayor idGrupo y se le suma 1
            $codNivel = $codNivel.$cantidadGrupo;
            $sql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`) VALUES ('$idAlumno','$nivelAsig','$fechaActual',1,'$idLlegada','$cantidadGrupo','$codNivel')";
        
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        } else {
            $codNivel = $codNivel.'1';

            $sql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`) VALUES ('$idAlumno','$nivelAsig','$fechaActual',1,'$idLlegada',1,'$codNivel')";
          
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        // Ahora $idGrupo contiene el valor más alto +1, puedes usarlo en lo que necesites
        return $idGrupo;
    }

    public function insertarAlumnosCurso($idAlumno,$nivelAsig,$idLlegada,$fechaActual,$cantidadSeleccionado,$codGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $fechaActual = date("Y-m-d", strtotime($fechaActual));

        $sql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`) VALUES ('$idAlumno','$nivelAsig','$fechaActual',1,'$idLlegada','$cantidadSeleccionado','$codGrupo')";
   
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
   
    public function recogerLlegadasID($idLlegada)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_matriculacionllegadas_edu` WHERE idLlegada_matriculacion = $idLlegada and estMatriculacion_llegadas IN (1, 2) ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
     
    public function listarPersonalTodos($idRuta)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql1 = "SELECT * FROM `tm_ruta` WHERE id_ruta = $idRuta";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute(); // EJECUTA la consulta
        $row = $sql1->fetch(PDO::FETCH_ASSOC); // Obtiene la primera fila como un array asociativo
       
        // Extraer variables individuales
        $idiomaId_ruta = $row['idiomaId_ruta'];
        $tipoId_ruta = $row['tipoId_ruta'];
        $nivelId_ruta = $row['nivelId_ruta'];
        $peso_ruta = $row['peso_ruta'];

        
        $sql = "SELECT * FROM rutasPersonal left join tm_personal ON rutasPersonal.id_personalRPersonal = tm_personal.idPersonal WHERE rutasPersonal.idIdioma_RPersonal = $idiomaId_ruta and rutasPersonal.idtipo_RPersonal = $tipoId_ruta AND $nivelId_ruta BETWEEN nivelDesde_RPersonal AND nivelHasta_RPersonal;";
 
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function insertarProfesorGrupo($idProfesorSeleccionado,$grupoSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // ELIMINAR CLASES DEL GRUPO ANTES
        $sql1 = "UPDATE `asignacionProfesorGrupo` SET estAsignacionProfe = 0 WHERE idGrupoAsignacionProfe = '$grupoSeleccionado'";
       
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();

        // AÑADIR CLASE A GRUPO
        $sql = "INSERT INTO `asignacionProfesorGrupo`(`idGrupoAsignacionProfe`, `idProfeAsignacionProfe`, `idHorariosAsignacionProfe`, `estAsignacionProfe`) 
        VALUES ('$grupoSeleccionado','$idProfesorSeleccionado',0,'1')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function cargarProfeGrupo($codSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM asignacionProfesorGrupo left join tm_personal ON asignacionProfesorGrupo.idProfeAsignacionProfe = tm_personal.idPersonal  WHERE idGrupoAsignacionProfe = '$codSeleccionado' AND estAsignacionProfe = '1';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarAlumnosCodGrupo($codSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT cursos.*, tm_alumno_edu.* FROM `cursos` LEFT JOIN tm_alumno_edu ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno WHERE cursos.est_cursos = 1 AND cursos.codGrupo = '$codSeleccionado';";
        // SE QUITA ID CURSO SELECT cursos.idCurso, tm_alumno_edu.*  PARA TENER MAS DATOS
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function mostrarAlumnosCodGrupoRight($codSeleccionado)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT cursos.*, tm_alumno_edu.* FROM `cursos` LEFT JOIN tm_alumno_edu ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno WHERE cursos.est_cursos = 1 AND cursos.codGrupo = '$codSeleccionado';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    // GESTIÓN NUEVOS GRUPOS //
    public function actualizarGruposAlumnos($codGrupoTabla1,$identificadorTabla1,$addListaIzquierda,$eliminadosListaIzquierda,$codGrupoTabla2,$identificadorTabla2,$addListaDerecha,$eliminadosListaDerecha)
    {
        $conectar = parent::conexion();
        parent::set_names();


        //=============================//
        //  ELIMINACION y ADD TABLA 1  //
        //=============================//
        // SI LA LISTA ESTA VACIA, NO PODEMOS LOCALIZAR EL ALUMNO, CON LO CUAL DESACTIVAMOS TODOS.
        if (empty($eliminadosListaIzquierda)) {
              
            
                // DESACTIVAMOS EL CURSO AL COMPLETO//
                $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE codGrupo = '$codGrupoTabla2';";
            
                $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
                $desactivarCursoUsuario->execute();  
                


        }else{

            foreach ($eliminadosListaIzquierda as $infoAlumno) {
                
                $idCurso = $infoAlumno['idCurso'];  // Acceder a la clave 'idCurso'

                $recogemosDatosUsuarioSql = "SELECT * FROM `cursos` WHERE idCurso = $idCurso";
                
                $recogemosDatosUsuario = $conectar->prepare($recogemosDatosUsuarioSql);
                $recogemosDatosUsuario->execute();  
                $fila = $recogemosDatosUsuario->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila

                if ($fila) {
                    // DATOS DE EL CURSO IZQ
                    $idAlumno = $fila['idAlumno_cursos'];
                    $nivelAsig = $fila['idRuta_cursos'];
                    $fechaCrea_cursos = $fila['fechaCrea_cursos'];
                    $idLlegada = $fila['idLlegada_cursos'];
                    $cantidadSeleccionado2 = $identificadorTabla2;
                    $codGrupo = $codGrupoTabla2;

            
                    // DESACTIVAMOS EL CURSO //
                    $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE idCurso = $idCurso;";
                    $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
                    $desactivarCursoUsuario->execute();  
                    

                    // SQL CURSO AL QUE VA  A PASAR 
                    $cursoQuePasaSQL2 = "SELECT * FROM cursos WHERE codGrupo = '$codGrupoTabla2';";
                    $cursoQuePasa2 = $conectar->prepare($cursoQuePasaSQL2);
                    $cursoQuePasa2->execute();  
                    $filaCursoQuePasa2 = $cursoQuePasa2->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila
                    
                    $nivelNew2 = $filaCursoQuePasa2['idRuta_cursos'];

                    $fechaCrea_cursos2 = $filaCursoQuePasa2['fechaCrea_cursos'];
                    $cantidadSeleccionado2 = $filaCursoQuePasa2['idGrupo'];

                // PASAMOS A NUEVO CURSO //
                    $pasarCursoUsuarioSql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`,`fechaNuevaCursos`) VALUES 
                    ('$idAlumno','$nivelNew2','$fechaCrea_cursos2',1,'$idLlegada','$cantidadSeleccionado2','$codGrupo',now())";
                  
                    $pasarCursoUsuario = $conectar->prepare($pasarCursoUsuarioSql);
                    $pasarCursoUsuario->execute();  
    
                }
                    
            }
        }
    
        
        //=============================//
        //  ELIMINACION y ADD TABLA 2  //
        //=============================//
        if (empty($eliminadosListaDerecha)) {
              
            
            // DESACTIVAMOS EL CURSO AL COMPLETO//
            $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE codGrupo = '$codGrupoTabla1';";
            $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
            $desactivarCursoUsuario->execute();  


        }else{

            foreach ($eliminadosListaDerecha as $infoAlumnoD) {
                $idCursoD = $infoAlumnoD['idCurso'];  // Acceder a la clave 'idCurso'
    
                $recogemosDatosUsuarioSql = "SELECT * FROM `cursos` WHERE idCurso = $idCursoD";
                $recogemosDatosUsuario = $conectar->prepare($recogemosDatosUsuarioSql);
                $recogemosDatosUsuario->execute();  
                $fila = $recogemosDatosUsuario->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila
    
                if ($fila) {
                    // DATOS DE EL CURSO IZQ
                    $idAlumno = $fila['idAlumno_cursos'];
                    $nivelAsig = $fila['idRuta_cursos'];
                    $fechaCrea_cursos = $fila['fechaCrea_cursos'];
                    $idLlegada = $fila['idLlegada_cursos'];
                    $cantidadSeleccionado1 = $identificadorTabla1;
                    $codGrupo1 = $codGrupoTabla1;
    
             
                    // DESACTIVAMOS EL CURSO //
                    $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE idCurso = $idCurso;";
                    $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
                    $desactivarCursoUsuario->execute();  
                    
    
                    // SQL CURSO AL QUE VA  A PASAR 
                    $cursoQuePasaSQL1 = "SELECT * FROM cursos WHERE codGrupo = '$codGrupoTabla1';";
                   
                    $cursoQuePasa1 = $conectar->prepare($cursoQuePasaSQL1);
                    $cursoQuePasa1->execute();  
                    $filaCursoQuePasa1 = $cursoQuePasa1->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila
    
                    $fechaCrea_cursos1 = $filaCursoQuePasa1['fechaCrea_cursos'];
                    $cantidadSeleccionado1 = $filaCursoQuePasa1['idGrupo'];
                    $nivelNew1 = $filaCursoQuePasa1['idRuta_cursos'];

                   // PASAMOS A NUEVO CURSO //
                    $pasarCursoUsuarioSql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`,`fechaNuevaCursos`) VALUES 
                    ('$idAlumno','$nivelNew1','$fechaCrea_cursos1',1,'$idLlegada','$cantidadSeleccionado1','$codGrupo1',now())";
                    
                    $pasarCursoUsuario = $conectar->prepare($pasarCursoUsuarioSql);
                    $pasarCursoUsuario->execute();  
      
                }
                    
            }

        }
      
    }
    // GESTION GRUPOS POR RUTAS //
    public function crearGruposAlumnosRuta($codGrupoTabla1,$identificadorTabla1,$alumnosTraspaso,$codNivel,$fechaActual,$idRT)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // COMPROBAMOS SI EXISTE UN PRIMER CURSO CREADO SUMANDOLE +1 POR LA CODIFICACION
   
        // Consulta para obtener el mayor idGrupo del codGrupo dado
        $sql = "SELECT MAX(idGrupo) AS max_idGrupo FROM cursos WHERE  codGrupo LIKE '%$codNivel%' AND est_cursos = 1;";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['max_idGrupo'] !== null) {
            
            $cantidadGrupo = $resultado['max_idGrupo'] + 1; // Se obtiene el mayor idGrupo y se le suma 1
          
            $codNivel = $codNivel.$cantidadGrupo;
            
            // SE RECORRE LA LISTA

            //=============================//
            //  ELIMINACION y ADD TABLA 1  //
            //=============================//
            foreach ($alumnosTraspaso as $infoAlumno) {
                $idCurso = $infoAlumno['idCurso'];  // Acceder a la clave 'idCurso'

                $recogemosDatosUsuarioSql = "SELECT * FROM `cursos` WHERE idCurso = $idCurso";
                $recogemosDatosUsuario = $conectar->prepare($recogemosDatosUsuarioSql);
                $recogemosDatosUsuario->execute();  
                $fila = $recogemosDatosUsuario->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila

              
                if ($fila) {
                    // DATOS DE EL CURSO IZQ
                    $idAlumno = $fila['idAlumno_cursos'];
                    $nivelAsig = $fila['idRuta_cursos'];
                    $fechaCrea_cursos = $fila['fechaCrea_cursos'];
                    $idLlegada = $fila['idLlegada_cursos'];
                    
                
            
                    // DESACTIVAMOS EL CURSO //
                    $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE idCurso = $idCurso;";
               
            
                    $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
                    $desactivarCursoUsuario->execute();  
                    
                     // se inserta por alumno
                    $sql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`) VALUES ('$idAlumno','$idRT','$fechaActual',1,'$idLlegada','$cantidadGrupo','$codNivel')";
                  
                    $sql = $conectar->prepare($sql);
                    $sql->execute();
    
                 
    
                }
                    

            }

        } else {
            $codNivel = $codNivel.'1';
          
            foreach ($alumnosTraspaso as $infoAlumno) {
                $idCurso = $infoAlumno['idCurso'];  // Acceder a la clave 'idCurso'

                $recogemosDatosUsuarioSql = "SELECT * FROM `cursos` WHERE idCurso = $idCurso";
                $recogemosDatosUsuario = $conectar->prepare($recogemosDatosUsuarioSql);
                $recogemosDatosUsuario->execute();  
                $fila = $recogemosDatosUsuario->fetch(PDO::FETCH_ASSOC); // Obtener solo una fila

       
                if ($fila) {
                    // DATOS DE EL CURSO IZQ
                    $idAlumno = $fila['idAlumno_cursos'];
                    $nivelAsig = $fila['idRuta_cursos'];
                    $fechaCrea_cursos = $fila['fechaCrea_cursos'];
                    $idLlegada = $fila['idLlegada_cursos'];
           
            
                    // DESACTIVAMOS EL CURSO //
                    $desactivarCursoUsuarioSql = "UPDATE `cursos` SET `est_cursos`= 0, `fecFinCurso` = NOW() WHERE idCurso = $idCurso;";
              
            
                    $desactivarCursoUsuario = $conectar->prepare($desactivarCursoUsuarioSql);
                    $desactivarCursoUsuario->execute();  
                    
                    // se inserta por alumno
                    $sql = "INSERT INTO `cursos`(`idAlumno_cursos`, `idRuta_cursos`, `fechaCrea_cursos`, `est_cursos`, `idLlegada_cursos`,`idGrupo`,`codGrupo`) VALUES ('$idAlumno','$idRT','$fechaActual',1,'$idLlegada',1,'$codNivel')";
                   
                    $sql = $conectar->prepare($sql);
                    $sql->execute();
                 
    
                }
                    

            }

          
        }

      
       
    }
    public function recogerAlumnoXidGrupo($idGrupo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `cursos` WHERE idCurso = $idGrupo;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerAlumnosClase($codGrupo)
    {
       
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `cursos` LEFT JOIN tm_alumno_edu ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno LEFT JOIN tm_usuario ON tm_usuario.idUsu = tm_alumno_edu.idUsuario_tmalumno WHERE cursos.est_cursos = 1 AND codGrupo = '$codGrupo';";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function recogerAlumnosClaseTabla($codGrupo,$idHorario)
    {
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
        cursos.*, 
        tm_alumno_edu.*, 
        tm_usuario.*, 
        listaDiariaClase.* 
        FROM cursos 
        LEFT JOIN tm_alumno_edu 
        ON cursos.idAlumno_cursos = tm_alumno_edu.idAlumno 
        LEFT JOIN tm_usuario 
        ON tm_usuario.idUsu = tm_alumno_edu.idUsuario_tmalumno 
        LEFT JOIN listaDiariaClase 
        ON listaDiariaClase.idAlumnoLista = cursos.idAlumno_cursos 
        AND listaDiariaClase.idHorarioLista = '$idHorario'
        WHERE cursos.codGrupo = '$codGrupo';";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    // SABER SI UN ALUMNO TIENE CURSO
    public function alumnoEnCurso($idLlegada,$idDepartamento)
    {
    
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `cursos`
        LEFT JOIN tm_llegadas_edu 
        ON `cursos`.`idLlegada_cursos` = `tm_llegadas_edu`.`id_llegada`
        WHERE `cursos`.idLlegada_cursos = '$idLlegada'
        AND `cursos`.est_cursos = '1'
        AND tm_llegadas_edu.iddepartamento_llegadas = $idDepartamento;";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultado) > 0) {
            return 1; // Sí hay resultados
        } else {
            return 0; // No hay resultados
        }
    }

    
}

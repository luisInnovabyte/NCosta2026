##########################################################
##      POSIBLES ESTADOS DE LAS ACTIVIDADES             ##
##    0 - No activa (ya finalizada)                     ##
##    1 - Activa (permite apuntarse, etc..)             ##
##    2 - Cancelada (llega fin de solicitud y no hay    ## 
##                   suficientes alumnos)               ##
##    3 - Finalizada solicitud espera de inicio         ##
##        (No permite apuntarse)                         ##
##########################################################
DROP PROCEDURE IF EXISTS actualizar_estado_actividad;
DROP PROCEDURE IF EXISTS actualizar_estado_actividades;
DROP PROCEDURE IF EXISTS actualizar_estado_actividad_program;
DROP PROCEDURE IF EXISTS actualizar_estado_actividades_program;

############################################################################
##  Procedimiento para finalizar una actividad después                   ###
##   de que (fecActHasta) sea menor que la fecha actual                  ###
##   tabla: tm_actividad_edu                                             ###
##   va a recoger las: Activas (1) y las que están a la espera (3)       ###
##   omitirá las Canceladas (2) y las No activas (0)                     ###
############################################################################
DELIMITER $$
CREATE PROCEDURE actualizar_estado_actividad()
BEGIN
    -- Poner estAct en 0 cuando la fecha actual supere fecActHasta
    UPDATE tm_actividad_edu 
    SET estadoAct = 0 
    WHERE DATE(fecActHasta) < CURDATE() 
        AND (estadoAct != 0 or estadoAct != 2);
END$$
DELIMITER ;


#############################################################################
##  El mismo procedimiento anterior, pero para llamarlo desde el programa ###
#############################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estado_actividad_program(
IN idAct_param INT
)
BEGIN
    -- Poner estAct en 0 cuando la fecha actual supere fecActHasta
    UPDATE tm_actividad_edu 
    SET estadoAct = 0 
    WHERE DATE(fecActHasta) < CURDATE() 
        AND (estadoAct != 2) AND
        idAct = idAct_param;
END$$
DELIMITER ;




############################################################################
##  Procedimiento para una vez finalizada la fecha máxima de inscripción ###
##  el sistema calcule si el estado de la misma es                      ###
##  estadoAct = 2 --> Cancelada por no haber suficientes alumno          ###
##  estadoAct = 3 --> A la espera que se inicie la actividad             ###
############################################################################

##############################################################################################
##  Campos y tablas afectados                                                             ###
##  tm_actividad_edu.estadoAct = 2 --> Cancelada por no haber suficientes alumno          ###
##  tm_actividad_edu.estadoAct = 3 --> A la espera que se inicie la actividad             ###
##  tm_actividad_edu.minAlumAct --> mínimo de alumnos para realizar la actividad          ###
##  De la tabla td_usuarioact_edu                                                         ###
##   Contar los alumnos que en el campo idAct_UsuarioAct la actividad que vamos a comprobar #
##    y ese contador debemos comprarlo con el campo minAlumAct de la tabla tm_actividad_edu #
##    Si el contador es menor el campo estadoAct = 2, en caso si es superior estadoAct = 3  #
#############################################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estado_actividades()
BEGIN
    -- Actualizar estadoAct basado en el número de alumnos inscritos
    UPDATE tm_actividad_edu AS act
    SET estadoAct = 
        CASE 
            WHEN (SELECT COUNT(*) FROM td_usuarioact_edu WHERE idAct_usuarioAct = act.idAct) < act.minAlumAct THEN 2
            ELSE 3
        END
    WHERE estadoAct = 1 and DATE(fecActFinSolicitud) >= curdate();
END$$
DELIMITER ;


#############################################################################
##  El mismo procedimiento anterior, pero para llamarlo desde el programa ###
#############################################################################
DELIMITER $$
CREATE PROCEDURE actualizar_estado_actividades_program(
   IN idAct_param INT
)
BEGIN
    -- Actualizar estadoAct basado en el número de alumnos inscritos
    UPDATE tm_actividad_edu AS act
    SET estadoAct = 
        CASE 
            WHEN (SELECT COUNT(*) FROM td_usuarioact_edu WHERE idAct_usuarioAct = act.idAct) < act.minAlumAct THEN 2
            ELSE 3
        END
    WHERE estadoAct = 1 
    and DATE(fecActFinSolicitud) >= curdate()
    and idAct = idAct_param;
END$$
DELIMITER ;
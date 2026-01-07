## El campo de fecha de fin se encuentra en: 
## tm_alojamientosllegadas_edu.fechaFinAlojamientos
## El campo de fecha de inicio se encuentra en: 
## tm_alojamientosllegadas_edu.fechaInicioAlojamientos
## esta tabla se une con tm_llegadas_edu.id_llegada por el campo tm_alojamientosllegadas_edu.idLlegada_alojamientos
## El campo a actualizar es tm_llegadas_edu.estLlegada
## en la tabla tm_alojamientosllegadas_edu tenemos el campo estAlojamientos_llegadas

DROP FUNCTION IF EXISTS estado_alojamientos;
DROP PROCEDURE IF EXISTS actualizar_estAlojamiento;
DROP PROCEDURE IF EXISTS actualizar_estAlojamientoxidLlegada;
DROP PROCEDURE IF EXISTS actualizar_estLlegada_alojamiento;
DROP PROCEDURE IF EXISTS actualizar_estLlegada_alojamiento_xidllegada;


###############################################################################
##   ESTADOS DE LAS LINEAS de ALOJAMIENTOS  (estAlojamientos_llegadas)     ####
##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)          #### 
##     1 = ACTIVO ENTRE LAS FECHAS DE LA ALOJAMIENTO                       ####
##     2 - ESPERANDO INICIO DEL ALOJAMIENTO                                ####
##     3 - FINALIZADO EL ALOJAMIENTO                                       ####
##     4 - NO TIENE ALOJAMIENTO                                            ####
###############################################################################

############################################################################
##  FUNCION QUE SE LLAMARA DESDE LE PROCEDIMIENTO                      #####
##  COMPRUEBA x id_llegada                                             #####
##   1.- Si tiene alguna alojamiento - Si no tiene devuelve un 4       #####
##   2.- Si tiene alojamientos consulta si las tiene alguna a 1        #####
##       Si tiene al menos 1 la función devuelve un 1, en caso contrario ###
##       Devuelve un O
############################################################################
## Si la todos los alojamientos de la llegada están caducadas devolverá = 0, Si hay algún alojamiento activo devolverá 1.
## Hay otros disparadores que supervisan en el estado de cada  alojamiento (cada línea), con tres eventos para hacerlo a distintas horas.
## Si no tiene alojamientos (solo tiene matriculas  o visado), devolverá 0. 
## Se llama estado_alojamiento(27) - Siendo el 27 el id de la llegada (cabecera)

DELIMITER $$
CREATE FUNCTION estado_alojamiento(id_llegada_param INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE resultado INT DEFAULT 0;

    -- Verificar si LA LLEGADA no tiene matriculaciones registradas
    IF (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param) = 0 THEN
        SET resultado = 4; -- No tiene alojamientos, 
        ## 4 - En la cabecera significa que no tiene alojamientos
    ELSE
        ## SI TODOS HAN FINALIZADO
        IF (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param AND DATE(fechaFinAlojamientos) < CURDATE()) =  
        (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param )
        THEN
            SET resultado = 3; -- Todos los alojamientos han finalizado
        ELSEIF (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param AND DATE(fechaInicioAlojamientos) > CURDATE()) = 
        (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param)
        THEN
            SET resultado = 2; -- Todas los alojamientos aún no han iniciado
        ELSEIF (SELECT COUNT(*) FROM tm_alojamientosllegadas_edu WHERE idLlegada_alojamientos = id_llegada_param AND CURDATE() BETWEEN DATE(fechaInicioAlojamientos) AND DATE(fechaFinAlojamientos)) > 0 THEN
            SET resultado = 1; -- Hay al menos un alojamiento activo
		END IF;
    END IF;

    RETURN resultado;
END$$
DELIMITER ;

#########################################################################################################
##  PROCEDIMIENTO GENERAL                                                                           #####
##  REALIZA                                                                                         #####
##   1.- Recoje de la cabecera solo aquellos que tienen en la cabecera estMatricula DISTINTO a 0    #####
##   2.- hace un bucle con todos ellos: Llama a la función estado_alojamiento(id_llegada_param INT) ###
##   3.- Actualiza el campo estMatricula (de la cabecera) con el valor de la funcion                #####
#########################################################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estAlojamiento()
BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0;
    DECLARE v_id_llegada INT;

    -- Declarar un cursor para recorrer los registros (id_llegada) que no estén cancelados
    DECLARE cur CURSOR FOR
        SELECT id_llegada
        FROM tm_llegadas_edu
        WHERE estLlegada != 0;

    -- Manejar el final del cursor
    ## si llega la final se actualiza el valor de done a 1
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Abrir el cursor
    OPEN cur;

    read_loop: LOOP
        -- Leer el siguiente registro
        FETCH cur INTO v_id_llegada;

        -- Verificar si se alcanzó el final
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Actualizar el campo estMatricula con el resultado de la función
        UPDATE tm_llegadas_edu
        SET estAlojamiento = estado_alojamiento(v_id_llegada)
        WHERE id_llegada = v_id_llegada;
    END LOOP;
    -- Cerrar el cursor
    CLOSE cur;
END$$
DELIMITER ;

#########################################################################################################
##  PROCEDIMIENTO ESPECIFICO PARA UNA LLEGADA                                                       #####
##  REALIZA                                                                                         #####
##    3.- Actualiza el campo estAlojamiento (de la cabecera) con el valor de la funcion             #####
##    PARA EL PROGRAMA                                                                              #####
#########################################################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estAlojamientoxidLlegada(
    IN idLlegada_param INT)
BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0;
    DECLARE v_id_llegada INT;

    -- Declarar un cursor para recorrer los registros que no estén cancelados
    DECLARE cur CURSOR FOR
        SELECT id_llegada
        FROM tm_llegadas_edu
        WHERE id_llegada=idLlegada_param;

    -- Manejar el final del cursor
    ## si llega la final se actualiza el valor de done a 1
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    -- Abrir el cursor
    OPEN cur;

    read_loop: LOOP
        -- Leer el siguiente registro
        FETCH cur INTO v_id_llegada;

        -- Verificar si se alcanzó el final
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Actualizar el campo estMatricula con el resultado de la función
        UPDATE tm_llegadas_edu
        SET estAlojamiento = estado_Alojamiento(v_id_llegada)
        WHERE id_llegada = v_id_llegada;
    END LOOP;
    -- Cerrar el cursor
    CLOSE cur;
END$$
DELIMITER ;


############################################################################
## PROCEDIMIENTO PARA ACTUALIZAR EL ESTADO DE CADA LINEA DE ALOJAMIENTO   ##
##            DEPENDIENDO DE LAS FECHA DE INICIO Y DE FIN                 ##
############################################################################
DELIMITER $$
CREATE PROCEDURE actualizar_estLlegada_alojamiento()
BEGIN
     ## pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya ha finalizado el curso).
     UPDATE tm_alojamientosllegadas_edu SET estAlojamientos_llegadas=3  where DATE(fechaFinAlojamientos)<CURDATE();
    
    ## pongo el estado de la linea de matriculacion a 2 cuando la fecha actual es anterior a la fecha de inicio (todavía no ha iniciado el curso)
     UPDATE tm_alojamientosllegadas_edu SET estAlojamientos_llegadas=2  where DATE(fechaInicioAlojamientos)>CURDATE();
    
    ## pongo el estado de la linea de matriculacion a 1 cuando la fecha actual se encuentra mayor o igual a la fecha de inicio y menor o igual a la fecha de final
     UPDATE tm_alojamientosllegadas_edu SET estAlojamientos_llegadas=1  where CURDATE()>=DATE(fechaInicioAlojamientos) and CURDATE()<=DATE(fechaFinAlojamientos);
    
    ## Vamos a ver si se ha cancelado la llegada en cuyo caso se colocará un 0 en el estado de la linea.
     UPDATE tm_alojamientosllegadas_edu SET estAlojamientos_llegadas=0  where  idLlegada_alojamientos in (select id_llegada from tm_llegadas_edu where estLlegada=0);
     ### RESERVAREMOS EL 4 EN LA CABECERA PARA CUANDO NO TIENE MATRICULACIONES, SOLO EL VISADO O ALOJAMIENTO.
    
    ################### AÑADIR TODOS LOS DE ALOJAMIENTO  #############################
     ###################################################################################
END$$
DELIMITER ;


############################################################################
## PROCEDIMIENTO PARA ACTUALIZAR EL ESTADO DE CADA LINEA DE MATRICULACION ##
##  DEPENDIENDO DE LAS FECHA DE INICIO Y DE FIN y de la ID de la LLEGADA  ##
##           PARA UTILIZARLO DENTRO DEL PROGRAMA                          ##
############################################################################
DELIMITER $$
CREATE PROCEDURE actualizar_estLlegada_alojamiento_xidllegada(
    IN idLlegada_alojamiento_param INT
)
BEGIN
    -- Pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya hafinalizado el curso)
    UPDATE tm_alojamimentosllegadas_edu 
    SET estAlojamientos_llegadas = 3
    WHERE DATE(fechaFinAlojamientos) < CURDATE() 
    AND idLlegada_alojamientos = idLlegada_alojamiento_param;

    -- Pongo el estado de la línea de matriculación a 2 cuando la fecha actual es anterior a la fecha de inicio (todavía no ha comenzado el curso)
    UPDATE tm_alojamientosllegadas_edu
    SET estAlojamientos_llegadas = 2  
    WHERE DATE(fechaInicioAlojamientos) > CURDATE() 
    AND idLlegada_alojamientos = idLlegada_alojamiento_param;

    -- Pongo el estado de la línea de matriculación a 1 cuando está a 0 y la fecha actual está en el rango válido
    UPDATE tm_alojamientosllegadas_edu
    SET estAlojamientos_llegadas = 1  
    WHERE CURDATE() >= DATE(fechaInicioAlojamientos) 
        AND CURDATE() <= DATE(fechaFinAlojamientos) 
        AND idLlegada_alojamientos = idLlegada_alojamiento_param;

    -- Pongo el estado de la línea de matriculación a 0 cuando en la cabecera se ha cancelado la llegada o el visado ha sido denegado.
    UPDATE tm_alojamientosllegadas_edu
    SET estAlojamientos_llegadas = 0  
    WHERE idLlegada_matriculacion in (select id_llegada from tm_llegadas_edu where estLlegada=0)
    AND idLlegada_alojamientos = idLlegada_alojamiento_param;

     ### RESERVAREMOS EL 4 PARA CUANDO NO TIENE MATRICULACIONES, SOLO EL VISADO O ALOJAMIENTO.
 
END$$
DELIMITER ;
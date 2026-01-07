## El campo de fecha de fin se encuentra en: 
## tm_matriculacionllegadas_edu.fechaFinMatriculación
## esta tabla se une con tm_llegadas_edu.id_llegada por el campo tm_matriculacionllegadas_edu.idLlegada_matriculacion
## El campo a actualizar es tm_llegadas_edu.estLlegada
DROP FUNCTION IF EXISTS estado_matriculacion;
DROP PROCEDURE IF EXISTS actualizar_estMatricula;
DROP PROCEDURE IF EXISTS actualizar_estLlegada_matriculacion;
DROP PROCEDURE IF EXISTS actualizar_estMatriculaxidLlegada;
DROP PROCEDURE IF EXISTS actualizar_estLlegada_matriculacion_xidllegada;
DROP EVENT IF EXISTS actualizar_estLlegada_evento_12_01;
DROP EVENT IF EXISTS actualizar_estLlegada_evento_08_00;
DROP EVENT IF EXISTS actualizar_estLlegada_evento_16_00;
DROP TRIGGER IF EXISTS trg_before_update_estLlegada;
DROP TRIGGER IF EXISTS trg_before_insert_estLlegada;


###############################################################################
##   ESTADOS DE LAS LINEAS de MATRICULACION  (estMatriculacion_llegadas)   ####
##     0 = CANCELADO O NO VISADO (SE HA CANCELADO EN LA CABECERA)          #### 
##     1 = ACTIVO ENTRE LAS FECHAS DE LA MATRICULACION                     ####
##     2 - ESPERANDO INICIO DE LA MATRICULACION                            ####
##     3 - FINALIZADA LA MATRICULACIÓN                                     ####
##     4 - NO TIENE MATRICULACIÓN                                          ####
###############################################################################

############################################################################
##  FUNCION QUE SE LLAMARA DESDE LE PROCEDIMIENTO                      #####
##  COMPRUEBA x id_llegada                                             #####
##   1.- Si tiene alguna matriculacion - Si no tiene devuelve un 4    #####
##   2.- Si tiene matriculaciones consulta si las tiene alguna a 1     #####
##       Si tiene al menos 1 la función devuelve un 1, en caso contrario ###
##       Devuelve un O
############################################################################
## Si la todas las matriculas de la llegada están caducadas devolverá = 0, Si hay alguna matricula activa devolverá 1.
## Hay otros disparadores quue supervisan en el estado de cada matrícula (cada línea), con tres eventos para hacerlo a distintas horas.
## Si no tiene matriculas (solo ha alquilado o visado), devolverá 0. 
## Se llama estado_matriculacion(27) - Siendo el 27 el id de la llegada (cabecera)

DELIMITER $$
CREATE FUNCTION estado_matriculacion(id_llegada_param INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE resultado INT DEFAULT 0;

    -- Verificar si LA LLEGADA no tiene matriculaciones registradas
    IF (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param) = 0 THEN
        SET resultado = 4; -- No tiene matriculaciones, devolver -1, para el caso de que solo tenga alojamiento y/o visado.
        ## 4 - En la linea y el cabecera significa que no tiene matriculaciones
    ELSE
        ## SI TODAS HAN FINALIZADO
        IF (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param AND DATE(fechaFinMatriculacion) < CURDATE()) =  
        (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param )
        THEN
            SET resultado = 3; -- Todas las matriculaciones han finalizado
        ELSEIF (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param AND DATE(fechaInicioMatriculacion) > CURDATE()) = 
        (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param)
        THEN
            SET resultado = 2; -- Todas las matriculaciones aún no han iniciado
        ELSEIF (SELECT COUNT(*) FROM tm_matriculacionllegadas_edu WHERE idLlegada_matriculacion = id_llegada_param AND CURDATE() BETWEEN DATE(fechaInicioMatriculacion) AND DATE(fechaFinMatriculacion)) > 0 THEN
            SET resultado = 1; -- Hay al menos una matrícula activa
		END IF;

    END IF;

    RETURN resultado;
END$$
DELIMITER ;

#########################################################################################################
##  PROCEDIMIENTO GENERAL                                                                           #####
##  REALIZA                                                                                         #####
##   1.- Recoje de la cabecera solo aquellos que tienen en la cabecera estMatricula DISTINTO a 0    #####
##   2.- hace un bucle con todos ellos: Llama a la función estado_matriculacion(id_llegada_param INT) ###
##   3.- Actualiza el campo estMatricula (de la cabecera) con el valor de la funcion                #####
#########################################################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estMatricula()
BEGIN
    -- Declarar variables necesarias
    ## Esta marca el final del bucle
    DECLARE done INT DEFAULT 0;
    DECLARE v_id_llegada INT;

    -- Declarar un cursor para recorrer los registros que no estén cancelados
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
        SET estMatricula = estado_matriculacion(v_id_llegada)
        WHERE id_llegada = v_id_llegada;
    END LOOP;
    -- Cerrar el cursor
    CLOSE cur;
END$$
DELIMITER ;

#########################################################################################################
##  PROCEDIMIENTO ESPECIFICO PARA UNA LLEGADA                                                       #####
##  REALIZA                                                                                         #####
##    3.- Actualiza el campo estMatricula (de la cabecera) con el valor de la funcion               #####
##    PARA EL PROGRAMA                                                                              #####
#########################################################################################################

DELIMITER $$
CREATE PROCEDURE actualizar_estMatriculaxidLlegada(
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
        SET estMatricula = estado_matriculacion(v_id_llegada)
        WHERE id_llegada = v_id_llegada;
    END LOOP;
    -- Cerrar el cursor
    CLOSE cur;
END$$
DELIMITER ;


############################################################################
## PROCEDIMIENTO PARA ACTUALIZAR EL ESTADO DE CADA LINEA DE MATRICULACION ##
##            DEPENDIENDO DE LAS FECHA DE INICIO Y DE FIN                 ##
############################################################################
DELIMITER $$
CREATE PROCEDURE actualizar_estLlegada_matriculacion()
BEGIN
     ## pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya ha finalizado el curso).
     UPDATE tm_matriculacionllegadas_edu SET estMatriculacion_llegadas=3  where DATE(fechaFinMatriculacion)<CURDATE();
    
    ## pongo el estado de la linea de matriculacion a 2 cuando la fecha actual es anterior a la fecha de inicio (todavía no ha iniciado el curso)
     UPDATE tm_matriculacionllegadas_edu SET estMatriculacion_llegadas=2  where DATE(fechaInicioMatriculacion)>CURDATE();
    
    ## pongo el estado de la linea de matriculacion a 1 cuando la fecha actual se encuentra mayor o igual a la fecha de inicio y menor o igual a la fecha de final
     UPDATE tm_matriculacionllegadas_edu SET estMatriculacion_llegadas=1  where CURDATE()>=DATE(fechaInicioMatriculacion) and CURDATE()<=DATE(fechaFinMatriculacion);
    
    ## Vamos a ver si se ha cancelado la llegada en cuyo caso se colocará un 0 en el estado de la linea.
     UPDATE tm_matriculacionllegadas_edu SET estMatriculacion_llegadas=0  where  idLlegada_matriculacion in (select id_llegada from tm_llegadas_edu where estLlegada=0);
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
CREATE PROCEDURE actualizar_estLlegada_matriculacion_xidllegada(
    IN idLlegada_matriculacion_param INT
)
BEGIN
    -- Pongo el estado de las matriculaciones a 3 cuando la fecha actual es superior a la fecha de finalización (ya hafinalizado el curso)
    UPDATE tm_matriculacionllegadas_edu 
    SET estMatriculacion_llegadas = 3
    WHERE DATE(fechaFinMatriculacion) < CURDATE() 
    AND idLlegada_matriculacion = idLlegada_matriculacion_param;

    -- Pongo el estado de la línea de matriculación a 2 cuando la fecha actual es anterior a la fecha de inicio (todavía no ha comenzado el curso)
    UPDATE tm_matriculacionllegadas_edu 
    SET estMatriculacion_llegadas = 2  
    WHERE DATE(fechaInicioMatriculacion) > CURDATE() 
    AND idLlegada_matriculacion = idLlegada_matriculacion_param;

    -- Pongo el estado de la línea de matriculación a 1 cuando está a 0 y la fecha actual está en el rango válido
    UPDATE tm_matriculacionllegadas_edu 
    SET estMatriculacion_llegadas = 1  
    WHERE CURDATE() >= DATE(fechaInicioMatriculacion) 
        AND CURDATE() <= DATE(fechaFinMatriculacion) 
        AND idLlegada_matriculacion = idLlegada_matriculacion_param;

    -- Pongo el estado de la línea de matriculación a 0 cuando en la cabecera se ha cancelado la llegada o el visado ha sido denegado.
    UPDATE tm_matriculacionllegadas_edu 
    SET estMatriculacion_llegadas = 0  
    WHERE idLlegada_matriculacion in (select id_llegada from tm_llegadas_edu where estLlegada=0)
    AND idLlegada_matriculacion = idLlegada_matriculacion_param;

     ### RESERVAREMOS EL 4 PARA CUANDO NO TIENE MATRICULACIONES, SOLO EL VISADO O ALOJAMIENTO.
 
END$$
DELIMITER ;


## Vamos a actualizar el campo de estLlegada con las combinaciones de los valores de estMatricula y EstAlojamiento

##EstMatricula	EstAlojamiento		R = Estllegada						
##  1					1					1						
##  2					1					1						
##  3					1					1						
##  4					1					1						
##  1					2					1						
##  2					2					2						
##  3					2					2						
##  4					2					2						
##  1					3					1						
##  2					3					2						
##  3					3					3						
##  4					3					3						
##  1					4					1						
##  2					4					2						
##  3					4					3						
##  4					4					4						
							
									
##Siempre que haya un 1=>estLlegada=1				
##Siempre que hay un 4 en cualquier columna=>estLlegada es el valor de la otra columna				
##Siempre que haya el mismo valor en las dos columnas=>estLlegada es el valor de las columnas				
##Siempre que hay un 3=>estLlegada es el valor de la otra columna que no tenga el 3				

DELIMITER //

CREATE TRIGGER trg_before_insert_estLlegada
BEFORE INSERT ON tm_llegadas_edu
FOR EACH ROW
BEGIN
    DECLARE nuevo_valor INT;

    -- Si alguna columna tiene 1, estLlegada será 1
    IF NEW.estMatricula = 1 OR NEW.estAlojamiento = 1 THEN
        SET nuevo_valor = 1;

    -- Si ambas columnas tienen el mismo valor, estLlegada toma ese valor
    ELSEIF NEW.estMatricula = NEW.estAlojamiento THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 4, estLlegada toma el valor de la otra (salvo si ambas son 4)
    ELSEIF NEW.estMatricula = 4 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 4 THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 3, estLlegada toma el valor de la otra (salvo si ambas son 3)
    ELSEIF NEW.estMatricula = 3 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 3 THEN
        SET nuevo_valor = NEW.estMatricula;
    END IF;

    -- Asignar el nuevo valor a estLlegada
    SET NEW.estLlegada = nuevo_valor;
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER trg_before_update_estLlegada
BEFORE UPDATE ON tm_llegadas_edu
FOR EACH ROW
BEGIN
    DECLARE nuevo_valor INT;

    -- Si alguna columna tiene 1, estLlegada será 1
    IF NEW.estMatricula = 1 OR NEW.estAlojamiento = 1 THEN
        SET nuevo_valor = 1;

    -- Si ambas columnas tienen el mismo valor, estLlegada toma ese valor
    ELSEIF NEW.estMatricula = NEW.estAlojamiento THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 4, estLlegada toma el valor de la otra (salvo si ambas son 4)
    ELSEIF NEW.estMatricula = 4 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 4 THEN
        SET nuevo_valor = NEW.estMatricula;

    -- Si alguna columna tiene 3, estLlegada toma el valor de la otra (salvo si ambas son 3)
    ELSEIF NEW.estMatricula = 3 THEN
        SET nuevo_valor = NEW.estAlojamiento;
    ELSEIF NEW.estAlojamiento = 3 THEN
        SET nuevo_valor = NEW.estMatricula;
    END IF;
    -- Asignar el nuevo valor a estLlegada
    SET NEW.estLlegada = nuevo_valor;
END //
DELIMITER ;


########################################################################
##  VAMOS A CREAR UN EVENTO PARA QUE SE LANCE A LAS 12.01 DE CADA DIA ##
########################################################################
DELIMITER $$
CREATE EVENT actualizar_estLlegada_evento_12_01
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_DATE + INTERVAL 1 MINUTE
DO
 # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$

########################################################################
##  VAMOS A CREAR UN EVENTO PARA QUE SE LANCE A LAS 08.00 DE CADA DIA ##
########################################################################
DELIMITER $$
CREATE EVENT actualizar_estLlegada_evento_08_00
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_DATE + INTERVAL 8 HOUR
DO
 # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$
 

########################################################################
##  VAMOS A CREAR UN EVENTO PARA QUE SE LANCE A LAS 16.00 DE CADA DIA ##
########################################################################
DELIMITER $$
CREATE EVENT actualizar_estLlegada_evento_16_00
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_DATE + INTERVAL 16 HOUR
DO
 # POR SI HACE FALTA METER MAS DE UNA LINEA
 BEGIN
    CALL actualizar_estMatricula();
    CALL actualizar_estLlegada_matriculacion();
    
    CALL actualizar_estAlojamiento();
    CALL actualizar_estLlegada_alojamiento();
    
    CALL actualizar_estado_actividad();
    CALL actualizar_estado_actividades();
 END$$

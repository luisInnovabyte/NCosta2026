### RESETEA TODOS LOS VALORES PARA 
update tm_llegadas_edu set 
   fechacancelacion_llegadas = NULL, 
   denegacionFecha = NULL,
   estLlegada = 1,
   motivocancelacion_llegadas = '',
   denegacionMotivo = ''
 where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## update en cancelacion
update tm_llegadas_edu set fechacancelacion_llegadas = "2025-01-01", motivocancelacion_llegadas ="Prueba de cancelación" where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## QUITO LA cancelacion
update tm_llegadas_edu set fechacancelacion_llegadas = NULL where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## update en denegacion del VISADO
update tm_llegadas_edu set  denegacionFecha= "2025-01-01", denegacionMotivo ="Prueba de cancelación del visado" where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## QUITO en denegacion del VISADO
update tm_llegadas_edu set  denegacionFecha= null where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## update en denegacion del VISADO y ademas cancela
update tm_llegadas_edu set  
    denegacionFecha= "2025-01-01", 
	denegacionMotivo ="Prueba de cancelación del visado", 
    fechacancelacion_llegadas = "2025-01-02", 
    motivocancelacion_llegadas ="Prueba de cancelación" where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;

## QUITO LAS DOS en denegacion del VISADO y ademas cancela
update tm_llegadas_edu set  
    denegacionFecha= null, 
    fechacancelacion_llegadas = null
    where id_llegada = 27;
select id_llegada, denegacionFecha, fechacancelacion_llegadas, estLlegada, motivocancelacion_llegadas, denegacionMotivo from tm_llegadas_edu where id_llegada = 27;
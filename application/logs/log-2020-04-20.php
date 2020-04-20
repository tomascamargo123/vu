<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-20 08:10:39 --> Query error: Unknown column 'aviso.estados' in 'field list' - Invalid query: SELECT `aviso`.`id`, `aviso`.`mensaje`, `aviso`.`usuario`, (CASE aviso.estados
			WHEN 0 THEN 'Pendiente' 
			WHEN 1 THEN 'En proceso' 
			WHEN 2 THEN 'Realizado' 
			ELSE 'Rechazado' END) as estado, (CASE aviso.importancia 
			WHEN 0 THEN 'Baja' 
			WHEN 1 THEN 'Moderada' 
			ELSE 'Alta' END) as importancia, `aviso`.`audi_fecha`, `aviso`.`solicitante`
FROM `sigmu`.`aviso`
ORDER BY `audi_fecha` DESC
 LIMIT 10

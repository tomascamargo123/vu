<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-15 10:27:15 --> Query error: Unknown column 'aviwso.id' in 'field list' - Invalid query: SELECT `aviwso`.`id`, `aviso`.`mensaje`, `aviso`.`usuario`, (CASE aviso.estado 
			WHEN 0 THEN 'Pendiente' 
			WHEN 1 THEN 'En proceso' 
			WHEN 2 THEN 'Realizado' 
			ELSE 'Rechazado' END) as estado, (CASE aviso.importancia 
			WHEN 0 THEN 'Baja' 
			WHEN 1 THEN 'Moderada' 
			ELSE 'Alta' END) as importancia, `aviso`.`oficina_id`, (COALESCE(oficina.nombre, 'Todas las oficinas')) as oficina
FROM `sigmu`.`aviso`
LEFT JOIN `sigmu`.`oficina` ON `oficina`.`id` = `aviso`.`oficina_id`
ORDER BY `mensaje` ASC
 LIMIT 10
ERROR - 2020-04-15 10:38:44 --> Query error: Unknown column 'aviwso.id' in 'field list' - Invalid query: SELECT `aviwso`.`id`, `aviso`.`mensaje`, `aviso`.`usuario`, (CASE aviso.estado 
			WHEN 0 THEN 'Pendiente' 
			WHEN 1 THEN 'En proceso' 
			WHEN 2 THEN 'Realizado' 
			ELSE 'Rechazado' END) as estado, (CASE aviso.importancia 
			WHEN 0 THEN 'Baja' 
			WHEN 1 THEN 'Moderada' 
			ELSE 'Alta' END) as importancia, `aviso`.`oficina_id`, (COALESCE(oficina.nombre, 'Todas las oficinas')) as oficina
FROM `sigmu`.`aviso`
LEFT JOIN `sigmu`.`oficina` ON `oficina`.`id` = `aviso`.`oficina_id`
ORDER BY `mensaje` ASC
 LIMIT 10
ERROR - 2020-04-15 13:02:33 --> Query error: Unknown column 'edit' in 'order clause' - Invalid query: SELECT `aviso`.`id`, `aviso`.`mensaje`, `aviso`.`usuario`, (CASE aviso.estado 
			WHEN 0 THEN 'Pendiente' 
			WHEN 1 THEN 'En proceso' 
			WHEN 2 THEN 'Realizado' 
			ELSE 'Rechazado' END) as estado, (CASE aviso.importancia 
			WHEN 0 THEN 'Baja' 
			WHEN 1 THEN 'Moderada' 
			ELSE 'Alta' END) as importancia, `aviso`.`audi_fecha`
FROM `sigmu`.`aviso`
ORDER BY `edit` DESC
 LIMIT 10

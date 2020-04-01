<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-30 12:03:29 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%d%' OR `oficina`.`nombre` LIKE '%d%' OR `ticket`.`fecha` LIKE '%d%' OR COUNT(pase.id) LIKE '%d%' OR `ticket`.`usuario` LIKE '%d%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-30 12:03:32 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%de%' OR `oficina`.`nombre` LIKE '%de%' OR `ticket`.`fecha` LIKE '%de%' OR COUNT(pase.id) LIKE '%de%' OR `ticket`.`usuario` LIKE '%de%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-17 09:16:44 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%5%' OR `oficina`.`nombre` LIKE '%5%' OR `ticket`.`fecha` LIKE '%5%' OR COUNT(pase.id) LIKE '%5%' OR `ticket`.`usuario` LIKE '%5%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-17 11:21:34 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%5%' OR `oficina`.`nombre` LIKE '%5%' OR `ticket`.`fecha` LIKE '%5%' OR COUNT(pase.id) LIKE '%5%' OR `ticket`.`usuario` LIKE '%5%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-17 11:21:38 --> Query error: Unknown column 'ticsket.id' in 'field list' - Invalid query: SELECT ticsket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-17 11:21:46 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%5%' OR `oficina`.`nombre` LIKE '%5%' OR `ticket`.`fecha` LIKE '%5%' OR COUNT(pase.id) LIKE '%5%' OR `ticket`.`usuario` LIKE '%5%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-17 11:21:56 --> Query error: Unknown column 'ticsket.id' in 'field list' - Invalid query: SELECT ticsket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-17 11:38:42 --> Severity: Parsing Error --> syntax error, unexpected 'input' (T_STRING) C:\wamp\www\vu\application\helpers\datatables_helper.php 110
ERROR - 2019-12-17 11:38:44 --> Severity: Parsing Error --> syntax error, unexpected 'input' (T_STRING) C:\wamp\www\vu\application\helpers\datatables_helper.php 110

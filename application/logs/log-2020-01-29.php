<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-29 11:12:27 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%l%' OR `oficina`.`nombre` LIKE '%l%' OR `ticket`.`fecha` LIKE '%l%' OR COUNT(pase.id) LIKE '%l%' OR `ticket`.`usuario` LIKE '%l%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-29 11:12:28 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%ll%' OR `oficina`.`nombre` LIKE '%ll%' OR `ticket`.`fecha` LIKE '%ll%' OR COUNT(pase.id) LIKE '%ll%' OR `ticket`.`usuario` LIKE '%ll%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-29 11:12:28 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%l%' OR `oficina`.`nombre` LIKE '%l%' OR `ticket`.`fecha` LIKE '%l%' OR COUNT(pase.id) LIKE '%l%' OR `ticket`.`usuario` LIKE '%l%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-29 11:13:04 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2020-01-29 11:16:04 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%s%' OR `oficina`.`nombre` LIKE '%s%' OR `ticket`.`fecha` LIKE '%s%' OR COUNT(pase.id) LIKE '%s%' OR `ticket`.`usuario` LIKE '%s%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-29 11:23:02 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%s%' OR `oficina`.`nombre` LIKE '%s%' OR `ticket`.`fecha` LIKE '%s%' OR COUNT(pase.id) LIKE '%s%' OR `ticket`.`usuario` LIKE '%s%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10

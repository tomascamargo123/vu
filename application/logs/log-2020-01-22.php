<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-22 09:14:44 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:14:50 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:14:50 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:20:04 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:21:15 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:21:18 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:21:18 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:22:35 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:22:39 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:22:39 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:29:28 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:29:32 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:29:32 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:30:04 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:30:29 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:43:46 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:43:51 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:43:51 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:07 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:10 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:10 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:15 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:15 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:45:15 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:46:34 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:52:21 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:52:24 --> 404 Page Not Found: /index
ERROR - 2020-01-22 09:52:24 --> 404 Page Not Found: /index
ERROR - 2020-01-22 10:11:43 --> Query error: Unknown column 'sigmu.pase.ticdket_id' in 'group statement' - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '205'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticdket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-22 10:11:49 --> Query error: Unknown column 'sigmu.pase.ticdket_id' in 'group statement' - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '205'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticdket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-01-22 11:08:13 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:36:29 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:01 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:01 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:19 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:19 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:22 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:22 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:37:22 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:39:41 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:40:45 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:40:48 --> 404 Page Not Found: /index
ERROR - 2020-01-22 11:40:48 --> 404 Page Not Found: /index

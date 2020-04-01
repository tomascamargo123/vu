<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-16 08:33:22 --> 404 Page Not Found: /index
ERROR - 2019-12-16 08:33:23 --> 404 Page Not Found: /index
ERROR - 2019-12-16 09:01:44 --> Query error: Table 'expedientes.firmas_circuitos' doesn't exist - Invalid query: SELECT `id`, `descripcion`
FROM `cargos`
WHERE `id` NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.informe_infogov=2)
ORDER BY `id`
ERROR - 2019-12-16 09:26:53 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%9%' OR `oficina`.`nombre` LIKE '%9%' OR `ticket`.`fecha` LIKE '%9%' OR COUNT(pase.id) LIKE '%9%' OR `ticket`.`usuario` LIKE '%9%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 09:26:58 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%92%' OR `oficina`.`nombre` LIKE '%92%' OR `ticket`.`fecha` LIKE '%92%' OR COUNT(pase.id) LIKE '%92%' OR `ticket`.`usuario` LIKE '%92%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 09:33:58 --> Query error: Unknown column 'pase.respuestsa' in 'where clause' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente", "display:none;", "") as btn_hide_btn_others, IF(pase.revision_id > 0, "", "display:none;") as btn_show_button, revision_id
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE (`expediente`.`digital` >0)
AND `pase`.`origen` = '862'
AND (`pase`.`respuestsa` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR `pase`.`respuesta` = 'firma pendiente' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-16 09:34:10 --> Query error: Unknown column 'pase.respuestsa' in 'where clause' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente", "display:none;", "") as btn_hide_btn_others, IF(pase.revision_id > 0, "", "display:none;") as btn_show_button, revision_id
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE (`expediente`.`digital` >0)
AND `pase`.`origen` = '862'
AND (`pase`.`respuestsa` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR `pase`.`respuesta` = 'firma pendiente' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-16 09:49:18 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%t%' OR `oficina`.`nombre` LIKE '%t%' OR `ticket`.`fecha` LIKE '%t%' OR COUNT(pase.id) LIKE '%t%' OR `ticket`.`usuario` LIKE '%t%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:05:02 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%a%' OR `oficina`.`nombre` LIKE '%a%' OR `ticket`.`fecha` LIKE '%a%' OR COUNT(pase.id) LIKE '%a%' OR `ticket`.`usuario` LIKE '%a%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:05:05 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%ar%' OR `oficina`.`nombre` LIKE '%ar%' OR `ticket`.`fecha` LIKE '%ar%' OR COUNT(pase.id) LIKE '%ar%' OR `ticket`.`usuario` LIKE '%ar%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:05:35 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%a%' OR `oficina`.`nombre` LIKE '%a%' OR `ticket`.`fecha` LIKE '%a%' OR COUNT(pase.id) LIKE '%a%' OR `ticket`.`usuario` LIKE '%a%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:10:05 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 10:10:09 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%9%' OR `oficina`.`nombre` LIKE '%9%' OR `ticket`.`fecha` LIKE '%9%' OR COUNT(pase.id) LIKE '%9%' OR `ticket`.`usuario` LIKE '%9%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:14:05 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%a%' OR `oficina`.`nombre` LIKE '%a%' OR `ticket`.`fecha` LIKE '%a%' OR COUNT(pase.id) LIKE '%a%' OR `ticket`.`usuario` LIKE '%a%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:29:05 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%a%' OR `oficina`.`nombre` LIKE '%a%' OR `ticket`.`fecha` LIKE '%a%' OR COUNT(pase.id) LIKE '%a%' OR `ticket`.`usuario` LIKE '%a%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:40:13 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%1%' OR `oficina`.`nombre` LIKE '%1%' OR `ticket`.`fecha` LIKE '%1%' OR COUNT(pase.id) LIKE '%1%' OR `ticket`.`usuario` LIKE '%1%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:41:24 --> Query error: Table 'sigsmu.oficina' doesn't exist - Invalid query: SELECT ticket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigsmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:41:31 --> Query error: Table 'sigsmu.oficina' doesn't exist - Invalid query: SELECT ticket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigsmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
AND (`ticket`.`id` LIKE '%5%' OR `oficina`.`nombre` LIKE '%5%' OR `ticket`.`fecha` LIKE '%5%' OR `ticket`.`cantexpe` LIKE '%5%' OR `ticket`.`usuario` LIKE '%5%')
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:42:24 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 10:45:11 --> Query error: Unknown column 'ticsket.id' in 'field list' - Invalid query: SELECT ticsket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:50:23 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 10:52:52 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%2%' OR `oficina`.`nombre` LIKE '%2%' OR `ticket`.`fecha` LIKE '%2%' OR COUNT(pase.id) LIKE '%2%' OR `ticket`.`usuario` LIKE '%2%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 10:52:55 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%26%' OR `oficina`.`nombre` LIKE '%26%' OR `ticket`.`fecha` LIKE '%26%' OR COUNT(pase.id) LIKE '%26%' OR `ticket`.`usuario` LIKE '%26%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 11:01:10 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 11:03:31 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 11:57:32 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%3%' OR `oficina`.`nombre` LIKE '%3%' OR `ticket`.`fecha` LIKE '%3%' OR COUNT(pase.id) LIKE '%3%' OR `ticket`.`usuario` LIKE '%3%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 11:57:46 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%3%' OR `oficina`.`nombre` LIKE '%3%' OR `ticket`.`fecha` LIKE '%3%' OR COUNT(pase.id) LIKE '%3%' OR `ticket`.`usuario` LIKE '%3%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 12:04:57 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 12:15:34 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 12:24:06 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 12:32:01 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-16 12:42:29 --> Query error: Unknown column 'tickset.id' in 'field list' - Invalid query: SELECT tickset.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 13:00:21 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%4%' OR `oficina`.`nombre` LIKE '%4%' OR `ticket`.`fecha` LIKE '%4%' OR COUNT(pase.id) LIKE '%4%' OR `ticket`.`usuario` LIKE '%4%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 13:01:24 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1759
ERROR - 2019-12-16 13:02:41 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%9%' OR `oficina`.`nombre` LIKE '%9%' OR `ticket`.`fecha` LIKE '%9%' OR COUNT(pase.id) LIKE '%9%' OR `ticket`.`usuario` LIKE '%9%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 13:10:27 --> Query error: Unknown column 'ticsket.id' in 'field list' - Invalid query: SELECT ticsket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-16 13:10:30 --> Query error: Unknown column 'ticsket.id' in 'field list' - Invalid query: SELECT ticsket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `ticket`.`oficina_receptora` = `oficina`.`id`
WHERE `ticket`.`oficina_receptora` = '862'
AND (`ticsket`.`id` LIKE '%9%' OR `oficina`.`nombre` LIKE '%9%' OR `ticket`.`fecha` LIKE '%9%' OR `ticket`.`cantexpe` LIKE '%9%' OR `ticket`.`usuario` LIKE '%9%')
ORDER BY `id` DESC
 LIMIT 10

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-27 10:44:52 --> 404 Page Not Found: 
ERROR - 2019-11-27 10:44:52 --> 404 Page Not Found: 
ERROR - 2019-11-27 10:44:53 --> 404 Page Not Found: 
ERROR - 2019-11-27 10:45:19 --> 404 Page Not Found: 
ERROR - 2019-11-27 10:45:19 --> 404 Page Not Found: Usuarios/plugins
ERROR - 2019-11-27 10:45:19 --> 404 Page Not Found: Usuarios/apple-touch-icon.png
ERROR - 2019-11-27 10:59:04 --> Query error: Unknown column 'tickets.id' in 'field list' - Invalid query: SELECT `tickets`.`id`, `ticket`.`cantexpe`, `ticket`.`fecha`, `ticket`.`usuario`, `ticket`.`oficina_receptora`, `oficina`.`nombre` as `oficina_nombre`
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `oficina`.`id`=`ticket`.`oficina_receptora`
WHERE `ticket`.`id` = 9383
ERROR - 2019-11-27 10:59:55 --> Query error: Unknown column 'tickets.id' in 'field list' - Invalid query: SELECT `tickets`.`id`, `ticket`.`cantexpe`, `ticket`.`fecha`, `ticket`.`usuario`, `ticket`.`oficina_receptora`, `oficina`.`nombre` as `oficina_nombre`
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` ON `oficina`.`id`=`ticket`.`oficina_receptora`
WHERE `ticket`.`id` = 9383
ERROR - 2019-11-27 11:00:06 --> Query error: Unknown column 'e.nsumero' in 'field list' - Invalid query: SELECT `e`.`nsumero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`ticket_id`=`ticket`.`id`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id` = 9383
ERROR - 2019-11-27 11:06:11 --> Severity: Parsing Error --> syntax error, unexpected ';', expecting ')' C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1737
ERROR - 2019-11-27 11:06:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id' at line 4 - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`origen`=
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id` = 9383
ERROR - 2019-11-27 11:06:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id' at line 4 - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`ticket_id`=`ticket`.`id` AND `p`.`origen`=
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id` = 9383
ERROR - 2019-11-27 11:08:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`NULL`' at line 5 - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`ticket_id`=`ticket`.`id`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expediente`
WHERE `ticket`.`id` = `9383AND p`.`origen IS` `NULL`
ERROR - 2019-11-27 11:08:56 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 33
ERROR - 2019-11-27 11:10:25 --> Query error: Unknown column 'p.id_expedsiente' in 'on clause' - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`ticket_id`=`ticket`.`id`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expedsiente`
WHERE `ticket`.`id` = 9383 AND `p`.`origen` IS NULL
ERROR - 2019-11-27 11:11:27 --> Query error: Unknown column 'p.id_expedsiente' in 'on clause' - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`ticket`
LEFT JOIN `sigmu`.`pase` `p` ON `p`.`ticket_id`=`ticket`.`id`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`p`.`id_expedsiente`
WHERE `ticket`.`id` = 9383 AND `p`.`origen` IS NULL
ERROR - 2019-11-27 11:16:07 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-11-27 11:16:13 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%93%' OR `oficina`.`nombre` LIKE '%93%' OR `ticket`.`fecha` LIKE '%93%' OR COUNT(pase.id) LIKE '%93%' OR `ticket`.`usuario` LIKE '%93%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-11-27 11:16:18 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%93%' OR `oficina`.`nombre` LIKE '%93%' OR `ticket`.`fecha` LIKE '%93%' OR COUNT(pase.id) LIKE '%93%' OR `ticket`.`usuario` LIKE '%93%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 40, 10
ERROR - 2019-11-27 11:16:28 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-11-27 11:16:32 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%9%' OR `oficina`.`nombre` LIKE '%9%' OR `ticket`.`fecha` LIKE '%9%' OR COUNT(pase.id) LIKE '%9%' OR `ticket`.`usuario` LIKE '%9%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 50, 10
ERROR - 2019-11-27 11:34:51 --> Severity: Parsing Error --> syntax error, unexpected '}' C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1754
ERROR - 2019-11-27 11:35:27 --> 404 Page Not Found: 
ERROR - 2019-11-27 11:36:13 --> 404 Page Not Found: 
ERROR - 2019-11-27 11:36:36 --> 404 Page Not Found: 
ERROR - 2019-11-27 11:36:37 --> 404 Page Not Found: 
ERROR - 2019-11-27 11:36:46 --> Severity: Warning --> Missing argument 2 for Pases::generar_pdf(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php on line 1762 and defined C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1717
ERROR - 2019-11-27 11:36:46 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1719
ERROR - 2019-11-27 11:36:46 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1721
ERROR - 2019-11-27 11:36:46 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1738
ERROR - 2019-11-27 11:37:51 --> 404 Page Not Found: 
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 9
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 16
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 19
ERROR - 2019-11-27 11:40:02 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 22
ERROR - 2019-11-27 11:40:06 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php:1752) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 9404
ERROR - 2019-11-27 11:40:06 --> Severity: error --> Exception: Some data has already been output to browser, can't send PDF file C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 9406
ERROR - 2019-11-27 11:40:06 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php:1752) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 9
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 16
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 19
ERROR - 2019-11-27 11:40:25 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 22
ERROR - 2019-11-27 11:40:29 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php:1752) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 9404
ERROR - 2019-11-27 11:40:29 --> Severity: error --> Exception: Some data has already been output to browser, can't send PDF file C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 9406
ERROR - 2019-11-27 11:40:29 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php:1752) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 9
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 16
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 19
ERROR - 2019-11-27 11:40:32 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 22
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 9
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 13
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 16
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 19
ERROR - 2019-11-27 11:42:21 --> Severity: Notice --> Trying to get property of non-object C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 22
ERROR - 2019-11-27 11:50:30 --> Severity: Warning --> Missing argument 2 for Pases::pdf_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1756
ERROR - 2019-11-27 11:50:30 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1762
ERROR - 2019-11-27 11:51:00 --> Severity: Warning --> Missing argument 2 for Pases::pdf_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1756
ERROR - 2019-11-27 11:51:00 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1762
ERROR - 2019-11-27 11:55:00 --> Severity: Warning --> Missing argument 2 for Pases::generar_pdf(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php on line 1762 and defined C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1717
ERROR - 2019-11-27 11:55:00 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1719
ERROR - 2019-11-27 11:55:00 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1721
ERROR - 2019-11-27 11:55:00 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1738
ERROR - 2019-11-27 12:04:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar_tickets
ERROR - 2019-11-27 12:04:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-27 12:04:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/apple-touch-icon.png
ERROR - 2019-11-27 12:04:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar
ERROR - 2019-11-27 12:04:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-27 12:04:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/apple-touch-icon.png
ERROR - 2019-11-27 12:04:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar
ERROR - 2019-11-27 12:04:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-27 12:04:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar
ERROR - 2019-11-27 12:04:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-27 12:38:47 --> Query error: Unknown column 'p.tsicket_id' in 'where clause' - Invalid query: SELECT `e`.`numero`, `e`.`ano`, `e`.`anexo`
FROM `sigmu`.`pase` `p`
JOIN `sigmu`.`expediente` `e` ON `e`.`id` = `p`.`id_expediente`
WHERE `p`.`ticket_id` = '9623'
AND `p`.`origen` = '862'
AND `p`.`tsicket_id` >0
ORDER BY `p`.`id` ASC
ERROR - 2019-11-27 12:53:46 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%8%' OR `oficina`.`nombre` LIKE '%8%' OR `ticket`.`fecha` LIKE '%8%' OR COUNT(pase.id) LIKE '%8%' OR `ticket`.`usuario` LIKE '%8%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-11-27 13:07:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/pdf_ticket
ERROR - 2019-11-27 13:07:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/pdf_ticket
ERROR - 2019-11-27 13:07:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/pdf_ticket
ERROR - 2019-11-27 13:07:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/pdf_ticket
ERROR - 2019-11-27 13:07:25 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\views\pases\pdf_ticket.php 33
ERROR - 2019-11-27 13:12:59 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:12:59 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748
ERROR - 2019-11-27 13:13:44 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:13:44 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748
ERROR - 2019-11-27 13:14:28 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:14:28 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748
ERROR - 2019-11-27 13:14:28 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:14:28 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748
ERROR - 2019-11-27 13:14:42 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:14:42 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748
ERROR - 2019-11-27 13:15:32 --> Severity: Warning --> Missing argument 2 for Pases::detalle_ticket() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1744
ERROR - 2019-11-27 13:15:32 --> Severity: Notice --> Undefined variable: emitido C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1748

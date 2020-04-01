<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-13 08:54:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 08:54:22 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 256 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-13 09:22:11 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-13 09:22:14 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
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
ERROR - 2019-12-13 09:22:17 --> Query error: Invalid use of group function - Invalid query: SELECT ticket.id, COUNT(pase.id) AS cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora
FROM `sigmu`.`ticket`
JOIN `sigmu`.`pase` ON `ticket`.`id` = `pase`.`ticket_id`
JOIN `sigmu`.`oficina` ON `pase`.`destino` = `oficina`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND (`ticket`.`id` LIKE '%arv%' OR `oficina`.`nombre` LIKE '%arv%' OR `ticket`.`fecha` LIKE '%arv%' OR COUNT(pase.id) LIKE '%arv%' OR `ticket`.`usuario` LIKE '%arv%')
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2019-12-13 09:46:55 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:46:55 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:46:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '" = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10' at line 3 - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE " = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 09:46:55 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:46:55 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:46:55 --> Query error: Unknown column '{' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `{` = '{'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 09:47:16 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:47:16 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:47:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '" = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10' at line 3 - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE " = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 09:47:16 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:47:16 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 62
ERROR - 2019-12-13 09:47:16 --> Query error: Unknown column '{' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `{` = '{'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 09:56:36 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 63
ERROR - 2019-12-13 09:56:36 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 63
ERROR - 2019-12-13 09:56:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '" = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10' at line 3 - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE " = '\"'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 09:56:36 --> Severity: Warning --> Illegal string offset 'name' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 63
ERROR - 2019-12-13 09:56:36 --> Severity: Warning --> Illegal string offset 'value' C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 63
ERROR - 2019-12-13 09:56:36 --> Query error: Unknown column '{' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `{` = '{'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 10:09:57 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:10:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:10:57 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:15:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:15:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:24:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:25:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:38:35 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:39:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:39:49 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-13 10:39:51 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:39:51 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:40:19 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:40:19 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:40:50 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:40:50 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:41:49 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:41:49 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:42:10 --> 404 Page Not Found: /index
ERROR - 2019-12-13 10:42:10 --> 404 Page Not Found: /index
ERROR - 2019-12-13 11:04:33 --> 404 Page Not Found: /index
ERROR - 2019-12-13 11:04:33 --> 404 Page Not Found: /index
ERROR - 2019-12-13 11:28:10 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `undefined` = '400'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 12:14:22 --> Query error: Unknown column 'oficina.dni' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `oficina`.`dni` = '763'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 12:16:25 --> Query error: Unknown column 'oficina.dni' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `oficina`.`dni` = '763'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 12:17:32 --> Query error: Unknown column 'oficina.dni' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `oficina`.`dni` = '763'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 12:18:17 --> Query error: Unknown column 'oficina.dni' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `oficina`.`dni` = '2'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 12:20:20 --> Query error: Unknown column 'oficina.dni' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `oficina`.`dni` = '2'
AND `id` >0
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2019-12-13 13:19:12 --> 404 Page Not Found: /index
ERROR - 2019-12-13 13:19:13 --> 404 Page Not Found: /index
ERROR - 2019-12-13 13:19:14 --> 404 Page Not Found: /index
ERROR - 2019-12-13 13:19:14 --> 404 Page Not Found: /index

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-22 08:30:28 --> Severity: error --> Exception: This document (C:\wamp\tmp\php95FC.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-22 11:08:46 --> Query error: Unknown column 'tramite.sid' in 'on clause' - Invalid query: SELECT `expediente`.`id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`acumulado`, `pase`.`id` as `pase_id`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`sid` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `pase`.`origen` = '1'
AND `users`.`organigrama` = 20000
AND `pase`.`destino` = '-1'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-05-22 11:08:46 --> Query error: Unknown column 'tramite.sid' in 'on clause' - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`sid` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `pase`.`origen` = '1'
AND `users`.`organigrama` = 20000
AND `pase`.`destino` = '-1'
 LIMIT 10) SqueryAux
ERROR - 2020-05-22 11:08:46 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551
ERROR - 2020-05-22 11:10:33 --> Query error: Unknown column 'tramite.sid' in 'on clause' - Invalid query: SELECT `expediente`.`id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`acumulado`, `pase`.`id` as `pase_id`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`sid` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `pase`.`origen` = '1'
AND `users`.`organigrama` = 20000
AND `pase`.`destino` = '-1'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-05-22 11:10:33 --> Query error: Unknown column 'tramite.sid' in 'on clause' - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`sid` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `pase`.`origen` = '1'
AND `users`.`organigrama` = 20000
AND `pase`.`destino` = '-1'
 LIMIT 10) SqueryAux
ERROR - 2020-05-22 11:10:33 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-08 09:48:03 --> Query error: Unknown column 'pase.motivo_resolucion' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-08 09:48:03 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-08 09:48:25 --> Query error: Unknown column 'pase.motivo_resolucion' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ERROR - 2020-06-08 09:48:25 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-08 09:49:44 --> Query error: Unknown column 'pase.motivo_resolucion' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ERROR - 2020-06-08 09:49:44 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-08 09:49:52 --> Query error: Unknown column 'pase.motivo_resolucion' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ERROR - 2020-06-08 09:49:52 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-08 12:41:40 --> Query error: Column 'nombre' in where clause is ambiguous - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, CONCAT(UCASE(users.first_name), " ", UCASE(users.last_name)) AS nombre, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `expedientes`.`users` ON `pase`.`usuario_derivado` = `users`.`id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
AND  `nombre` LIKE '%Di%' ESCAPE '!'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-08 12:41:40 --> Query error: Column 'nombre' in where clause is ambiguous - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `expedientes`.`users` ON `pase`.`usuario_derivado` = `users`.`id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
AND  `nombre` LIKE '%Di%' ESCAPE '!') SqueryAux
ERROR - 2020-06-08 12:41:40 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551

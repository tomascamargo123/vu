<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-29 10:23:52 --> Severity: Warning --> array_push() expects at least 2 parameters, 1 given C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 79
ERROR - 2020-06-29 10:23:52 --> Severity: Warning --> array_push() expects at least 2 parameters, 1 given C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 79
ERROR - 2020-06-29 10:24:15 --> Severity: Warning --> array_push() expects at least 2 parameters, 1 given C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 80
ERROR - 2020-06-29 10:24:15 --> Severity: Warning --> array_push() expects at least 2 parameters, 1 given C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 80
ERROR - 2020-06-29 11:54:49 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 11:54:49 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 11:55:35 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '400'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 11:55:35 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 11:55:42 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '400'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 11:55:42 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:22:27 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:22:28 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:37:08 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:37:09 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:37:28 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:37:28 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:48:50 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '846'
AND `pase`.`usuario_derivado` = 'evelarde'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:48:51 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:49:01 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '846'
AND `pase`.`usuario_derivado` = 'evelarde'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:49:01 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:49:31 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '846'
AND `pase`.`usuario_derivado` = 'evelarde'
AND `pase`.`numero` = '4166'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:49:32 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-29 12:52:52 --> Query error: Unknown column 'pase.motivo' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `pase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-29 12:52:52 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448

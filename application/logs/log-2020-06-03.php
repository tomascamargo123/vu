<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-03 09:36:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`num' at line 1 - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "display: `none;"`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 09:36:04 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 09:37:02 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`num' at line 1 - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "display: `none;"`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 09:37:02 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 09:39:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`num' at line 1 - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "display: `none;"`, "") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 09:39:35 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 09:53:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`, "") as btn_disabled
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `ofic' at line 1 - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`, IF(expediente.firma_pendiente = 1, "display: `none;"`, "") as btn_disabled
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 09:53:30 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 09:56:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
I' at line 1 - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`, IF(expediente.firma_pendiente = 1, "/display: `none;"/`, "") as btn_disabled
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 09:56:34 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 10:00:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`, "") as btn_disabled
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `ofic' at line 1 - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn, `pase`.`motivo_resolucion`, IF(expediente.firma_pendiente = 1, "display: `none;"`, "") as btn_disabled
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'aresolver'
AND `pase`.`origen` = '862'
ORDER BY `codigo` DESC
 LIMIT 10
ERROR - 2020-06-03 10:00:03 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-03 10:06:30 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:06:32 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:08:44 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:08:46 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:09:17 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:09:19 --> 404 Page Not Found: 
ERROR - 2020-06-03 10:41:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar
ERROR - 2020-06-03 10:41:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2020-06-03 10:54:48 --> Query error: Unknown column 'pase.id_expeddiente' in 'on clause' - Invalid query: SELECT `sigmu`.`pase`.`id`, `sigmu`.`pase`.`id_expediente`, `sigmu`.`pase`.`ano`, `sigmu`.`pase`.`numero`, `sigmu`.`pase`.`anexo`, `sigmu`.`pase`.`fecha`, `sigmu`.`pase`.`origen`, `sigmu`.`pase`.`destino`, `sigmu`.`pase`.`respuesta`, `sigmu`.`pase`.`fojas`, `sigmu`.`pase`.`marca`, `sigmu`.`pase`.`impreso`, `sigmu`.`pase`.`usuario_emisor`, `sigmu`.`pase`.`usuario_receptor`, `sigmu`.`pase`.`usuario`, `sigmu`.`pase`.`terminal`, `sigmu`.`pase`.`fecha_usuario`, `sigmu`.`pase`.`proceso_usuario`, `sigmu`.`pase`.`nota_pase_id`, `sigmu`.`pase`.`ticket_id`, `sigmu`.`pase`.`etapa_circuito`, `sigmu`.`pase`.`motivo_resolucion`, `e`.`fojas` as `fojas_expediente`, `e`.`ano` as `ano_expediente`, `e`.`numero` as `numero_expediente`, `e`.`anexo` as `anexo_expediente`, CONCAT(oo.id, " - ", oo.nombre) as oficina_origen, `od`.`id` as `oficina_id`, `od`.`nombre` as `oficina`, `np`.`contenido` as `observaciones`
FROM `sigmu`.`pase`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`pase`.`id_expeddiente`
JOIN `sigmu`.`oficina` `oo` ON `oo`.`id`=`pase`.`origen`
JOIN `sigmu`.`oficina` `od` ON `od`.`id`=`pase`.`destino`
LEFT JOIN `sigmu`.`notapase` `np` ON `np`.`id`=`pase`.`nota_pase_id`
WHERE `sigmu`.`pase`.`id` = '1792725'
ERROR - 2020-06-03 10:54:48 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-06-03 10:57:39 --> Query error: Unknown column 'pase.id_expeddiente' in 'on clause' - Invalid query: SELECT `sigmu`.`pase`.`id`, `sigmu`.`pase`.`id_expediente`, `sigmu`.`pase`.`ano`, `sigmu`.`pase`.`numero`, `sigmu`.`pase`.`anexo`, `sigmu`.`pase`.`fecha`, `sigmu`.`pase`.`origen`, `sigmu`.`pase`.`destino`, `sigmu`.`pase`.`respuesta`, `sigmu`.`pase`.`fojas`, `sigmu`.`pase`.`marca`, `sigmu`.`pase`.`impreso`, `sigmu`.`pase`.`usuario_emisor`, `sigmu`.`pase`.`usuario_receptor`, `sigmu`.`pase`.`usuario`, `sigmu`.`pase`.`terminal`, `sigmu`.`pase`.`fecha_usuario`, `sigmu`.`pase`.`proceso_usuario`, `sigmu`.`pase`.`nota_pase_id`, `sigmu`.`pase`.`ticket_id`, `sigmu`.`pase`.`etapa_circuito`, `sigmu`.`pase`.`motivo_resolucion`, `e`.`fojas` as `fojas_expediente`, `e`.`ano` as `ano_expediente`, `e`.`numero` as `numero_expediente`, `e`.`anexo` as `anexo_expediente`, CONCAT(oo.id, " - ", oo.nombre) as oficina_origen, `od`.`id` as `oficina_id`, `od`.`nombre` as `oficina`, `np`.`contenido` as `observaciones`
FROM `sigmu`.`pase`
LEFT JOIN `sigmu`.`expediente` `e` ON `e`.`id`=`pase`.`id_expeddiente`
JOIN `sigmu`.`oficina` `oo` ON `oo`.`id`=`pase`.`origen`
JOIN `sigmu`.`oficina` `od` ON `od`.`id`=`pase`.`destino`
LEFT JOIN `sigmu`.`notapase` `np` ON `np`.`id`=`pase`.`nota_pase_id`
WHERE `sigmu`.`pase`.`id` = '1792729'
ERROR - 2020-06-03 10:57:39 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-06-03 13:31:23 --> Severity: error --> Exception: Unable to find "startxref" keyword. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-06-03 13:31:31 --> Severity: error --> Exception: Unable to find "startxref" keyword. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-19 09:05:57 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2019-12-19 09:05:57 --> Unable to connect to the database
ERROR - 2019-12-19 09:56:37 --> Query error: Unknown column 'esxpediente.id' in 'field list' - Invalid query: SELECT `esxpediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-19 09:56:44 --> Query error: Unknown column 'esxpediente.id' in 'field list' - Invalid query: SELECT `esxpediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-19 10:20:28 --> Query error: Unknown column 'expesdiente.id' in 'field list' - Invalid query: SELECT `expesdiente`.`id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`acumulado`, `pase`.`id` as `pase_id`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
WHERE `pase`.`origen` = '1'
AND `pase`.`destino` = '-1'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-19 10:37:29 --> Query error: Unknown column 'pases.id' in 'field list' - Invalid query: SELECT `pases`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-19 10:38:49 --> Query error: Unknown column 'pases.id' in 'field list' - Invalid query: SELECT `pases`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-19 10:59:42 --> Query error: Unknown column 'sexpediente.id' in 'field list' - Invalid query: SELECT `sexpediente`.`id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`acumulado`, `pase`.`id` as `pase_id`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
WHERE `pase`.`origen` = '1'
AND `pase`.`destino` = '-1'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-19 10:59:47 --> Query error: Unknown column 'sexpediente.id' in 'field list' - Invalid query: SELECT `sexpediente`.`id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`acumulado`, `pase`.`id` as `pase_id`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `sigmu`.`pase` ON `pase`.`id_expediente` = `expediente`.`id`
WHERE `pase`.`origen` = '1'
AND `pase`.`destino` = '-1'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-19 11:28:00 --> 404 Page Not Found: ../modules/expedientes/controllers/Oficinas/editar
ERROR - 2019-12-19 11:28:00 --> 404 Page Not Found: ../modules/expedientes/controllers/Oficinas/editar
ERROR - 2019-12-19 11:28:00 --> 404 Page Not Found: ../modules/expedientes/controllers/Oficinas/editar
ERROR - 2019-12-19 11:41:50 --> Severity: Error --> Call to a member function get() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 184
ERROR - 2019-12-19 11:41:57 --> Severity: Error --> Call to a member function get() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 184
ERROR - 2019-12-19 11:42:38 --> Severity: Error --> Call to a member function get() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 184
ERROR - 2019-12-19 11:42:44 --> Severity: Error --> Call to a member function get() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 184
ERROR - 2019-12-19 12:40:21 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 175 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:40:21 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:40:22 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 175 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:40:22 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:40:32 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 175 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:40:32 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:41:51 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 176 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:41:51 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:41:52 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 176 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:41:52 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:45:32 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 176 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:45:32 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 12:46:08 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php on line 176 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2019-12-19 12:46:08 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2019-12-19 13:17:15 --> Query error: Column 'inicia_expediente' cannot be null - Invalid query: INSERT INTO `sigmu`.`oficina` (`id`, `nombre`, `inicia_expediente`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES ('901', 'prueba', NULL, '261', '2019/12/19 13:17:15', 'I')
ERROR - 2019-12-19 13:21:44 --> Query error: Column 'inicia_expediente' cannot be null - Invalid query: INSERT INTO `sigmu`.`oficina` (`id`, `nombre`, `inicia_expediente`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES ('901', 'prueba', NULL, '261', '2019/12/19 13:21:44', 'I')
ERROR - 2019-12-19 13:23:04 --> Query error: Column 'inicia_expediente' cannot be null - Invalid query: INSERT INTO `sigmu`.`oficina` (`id`, `nombre`, `emisora_pase`, `receptora_pase`, `inicia_expediente`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES ('901', 'PRUEBA', '1', '1', NULL, '261', '2019/12/19 13:23:04', 'I')

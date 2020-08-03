<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-17 08:52:29 --> Query error: Table 'sigmu.spase' doesn't exist - Invalid query: SELECT `id`
FROM `sigmu`.`spase`
WHERE `origen` = 862
AND `id_expediente` = 294048
AND `respuesta` = "pendiente" OR `respuesta` = "aresolver"
ORDER BY `id` DESC
 LIMIT 1
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:17 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:18 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:22 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:22 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:22 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:27 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:27 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:00:27 --> 404 Page Not Found: /index
ERROR - 2020-07-17 09:35:50 --> Query error: Unknown column 'faa.ususario_id' in 'where clause' - Invalid query: SELECT `faa`.`id`, `faa`.`archivo_adjunto_id`, `faa`.`solicitante_id`, `faa`.`fecha_solicitud`, `aa`.`nombre`, `aa`.`tamanio`, `aa`.`tipodecontenido`, `aa`.`id_expediente`, `aa`.`descripcion`, `aa`.`fecha`, `e`.`ano`, `e`.`numero`, `e`.`anexo`, `e`.`fojas`, `e`.`caratula` as `caratula`, `e`.`objeto` as `objeto`, `u`.`CodiUsua`
FROM `firmas_archivos_adjuntos` `faa`
JOIN `sigmu`.`archivoadjunto` `aa` ON `faa`.`archivo_adjunto_id`=`aa`.`id`
JOIN `sigmu`.`expediente` `e` ON `aa`.`id_expediente`=`e`.`id`
JOIN `users` `u` ON `faa`.`solicitante_id`=`u`.`id`
WHERE `faa`.`ususario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
ORDER BY `fecha` ASC
 LIMIT 10
ERROR - 2020-07-17 09:35:58 --> Query error: Unknown column 'faa.ususario_id' in 'where clause' - Invalid query: SELECT `faa`.`id`, `faa`.`archivo_adjunto_id`, `faa`.`solicitante_id`, `faa`.`fecha_solicitud`, `aa`.`nombre`, `aa`.`tamanio`, `aa`.`tipodecontenido`, `aa`.`id_expediente`, `aa`.`descripcion`, `aa`.`fecha`, `e`.`ano`, `e`.`numero`, `e`.`anexo`, `e`.`fojas`, `e`.`caratula` as `caratula`, `e`.`objeto` as `objeto`, `u`.`CodiUsua`
FROM `firmas_archivos_adjuntos` `faa`
JOIN `sigmu`.`archivoadjunto` `aa` ON `faa`.`archivo_adjunto_id`=`aa`.`id`
JOIN `sigmu`.`expediente` `e` ON `aa`.`id_expediente`=`e`.`id`
JOIN `users` `u` ON `faa`.`solicitante_id`=`u`.`id`
WHERE `faa`.`ususario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
ORDER BY `fecha` ASC
 LIMIT 10
ERROR - 2020-07-17 10:53:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Firmas/revison_archivos
ERROR - 2020-07-17 10:53:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Firmas/plugins

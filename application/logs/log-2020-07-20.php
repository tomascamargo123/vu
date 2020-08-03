<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-20 09:12:07 --> Query error: Unknown column 'usr.username' in 'field list' - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username` `revisor`, `usf`.`username` `firmante`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `sigmu`.`expediente` `e` ON `aa`.`id_expediente`=`e`.`id`
JOIN `users` `u` ON `faa`.`solicitante_id`=`u`.`id`
WHERE `faa`.`usuario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
ORDER BY `fecha` ASC
 LIMIT 10
ERROR - 2020-07-20 09:12:34 --> Query error: Unknown column 'usr.username' in 'field list' - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username` `revisor`, `usf`.`username` `firmante`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `sigmu`.`expediente` `e` ON `aa`.`id_expediente`=`e`.`id`
JOIN `users` `u` ON `faa`.`solicitante_id`=`u`.`id`
WHERE `faa`.`usuario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
ORDER BY `fecha` ASC
 LIMIT 10
ERROR - 2020-07-20 09:28:43 --> Severity: Error --> Call to undefined method Datatables::unset() C:\wamp\www\vu-master\application\modules\expedientes\controllers\Firmas.php 326
ERROR - 2020-07-20 09:42:26 --> Severity: Error --> Call to undefined method Datatables::unset() C:\wamp\www\vu-master\application\modules\expedientes\controllers\Firmas.php 326
ERROR - 2020-07-20 09:47:49 --> Query error: Table 'sigsmu.expediente' doesn't exist - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username` `revisor`, `usf`.`username` `firmante`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `expedientes`.`users` `usf` ON `sr`.`id_firmante` = `usf`.`id`
JOIN `expedientes`.`users` `usr` ON `sr`.`id_revisor` = `usr`.`id`
JOIN `sigsmu`.`expediente` `ex` ON `aa`.`id_expediente` = `ex`.`id`
WHERE `estado` = '0'
AND `id_revisor` IS NULL
ORDER BY `revisor` ASC
 LIMIT 10
ERROR - 2020-07-20 09:50:17 --> Query error: Table 'sigsmu.expediente' doesn't exist - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username` `revisor`, `usf`.`username` `firmante`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `expedientes`.`users` `usf` ON `sr`.`id_firmante` = `usf`.`id`
JOIN `expedientes`.`users` `usr` ON `sr`.`id_revisor` = `usr`.`id`
JOIN `sigsmu`.`expediente` `ex` ON `aa`.`id_expediente` = `ex`.`id`
WHERE `estado` = '0'
AND `id_revisor` = '263'
ORDER BY `revisor` ASC
 LIMIT 10
ERROR - 2020-07-20 10:22:53 --> Query error: Column 'username' in order clause is ambiguous - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username`, `usf`.`username`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `expedientes`.`users` `usf` ON `sr`.`id_firmante` = `usf`.`id`
JOIN `expedientes`.`users` `usr` ON `sr`.`id_revisor` = `usr`.`id`
JOIN `sigmu`.`expediente` `ex` ON `aa`.`id_expediente` = `ex`.`id`
WHERE `estado` = '0'
AND `id_revisor` = '263'
ORDER BY `username` ASC
 LIMIT 10
ERROR - 2020-07-20 10:23:13 --> Query error: Column 'username' in order clause is ambiguous - Invalid query: SELECT `sr`.`id`, `aa`.`nombre`, `usr`.`username`, `usf`.`username`, `ex`.`ano`, `ex`.`numero`, `ex`.`anexo`
FROM `expedientes`.`solicitud_revision` `sr`
JOIN `sigmu`.`archivoadjunto` `aa` ON `sr`.`archivo_adjunto_id` = `aa`.`id`
JOIN `expedientes`.`users` `usf` ON `sr`.`id_firmante` = `usf`.`id`
JOIN `expedientes`.`users` `usr` ON `sr`.`id_revisor` = `usr`.`id`
JOIN `sigmu`.`expediente` `ex` ON `aa`.`id_expediente` = `ex`.`id`
WHERE `estado` = '0'
AND `id_revisor` = '263'
ORDER BY `username` ASC
 LIMIT 10
ERROR - 2020-07-20 13:08:30 --> 404 Page Not Found: /index
ERROR - 2020-07-20 13:08:30 --> 404 Page Not Found: /index
ERROR - 2020-07-20 13:08:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Firmas/solucitud_revision
ERROR - 2020-07-20 13:08:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Firmas/plugins

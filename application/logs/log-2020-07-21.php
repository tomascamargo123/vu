<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-21 10:15:32 --> Query error: Unknown column 'revisor' in 'order clause' - Invalid query: SELECT `firmas_archivos_adjuntos`.`archivo_adjunto_id`, `firmas_archivos_adjuntos`.`id`, `archivoadjunto`.`id_expediente`, `archivoadjunto`.`nombre`, `users`.`username`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`
FROM `expedientes`.`firmas_archivos_adjuntos`
JOIN `sigmu`.`archivoadjunto` ON `firmas_archivos_adjuntos`.`archivo_adjunto_id` = `archivoadjunto`.`id`
JOIN `expedientes`.`users` ON `firmas_archivos_adjuntos`.`id_revisor` = `users`.`id`
JOIN `sigmu`.`expediente` ON `archivoadjunto`.`id_expediente` = `expediente`.`id`
WHERE `firmas_archivos_adjuntos`.`estado_revision` = '0'
AND `firmas_archivos_adjuntos`.`id_revisor` = '263'
ORDER BY `revisor` ASC
 LIMIT 10
ERROR - 2020-07-21 10:17:40 --> Query error: Unknown column 'revisor' in 'order clause' - Invalid query: SELECT `firmas_archivos_adjuntos`.`id`, `archivoadjunto`.`id_expediente`, `archivoadjunto`.`nombre`, `users`.`username`, `firmas_archivos_adjuntos`.`archivo_adjunto_id`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`
FROM `expedientes`.`firmas_archivos_adjuntos`
JOIN `sigmu`.`archivoadjunto` ON `firmas_archivos_adjuntos`.`archivo_adjunto_id` = `archivoadjunto`.`id`
JOIN `expedientes`.`users` ON `firmas_archivos_adjuntos`.`id_revisor` = `users`.`id`
JOIN `sigmu`.`expediente` ON `archivoadjunto`.`id_expediente` = `expediente`.`id`
WHERE `firmas_archivos_adjuntos`.`estado_revision` = '0'
AND `firmas_archivos_adjuntos`.`id_revisor` = '263'
ORDER BY `revisor` ASC
 LIMIT 10
ERROR - 2020-07-21 12:06:56 --> Severity: Warning --> Missing argument 1 for MY_Controller::set_model_validation_rules(), called in C:\wamp\www\vu-master\application\modules\expedientes\controllers\Archivos_adjuntos.php on line 856 and defined C:\wamp\www\vu-master\application\core\MY_Controller.php 94
ERROR - 2020-07-21 12:06:56 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu-master\application\core\MY_Controller.php 96
ERROR - 2020-07-21 12:26:49 --> Severity: Warning --> Missing argument 1 for MY_Controller::set_model_validation_rules(), called in C:\wamp\www\vu-master\application\modules\expedientes\controllers\Archivos_adjuntos.php on line 856 and defined C:\wamp\www\vu-master\application\core\MY_Controller.php 94
ERROR - 2020-07-21 12:26:49 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu-master\application\core\MY_Controller.php 96

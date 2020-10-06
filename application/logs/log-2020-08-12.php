<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-12 09:16:15 --> Query error: Unknown column 'faa.estado_revision' in 'where clause' - Invalid query: SELECT COUNT(1) as cantidad
FROM `firmas_archivos_adjuntos` `faa`
WHERE `faa`.`usuario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
AND `faa`.`estado_revision` = '1'
ERROR - 2020-08-12 09:16:15 --> Severity: Error --> Call to a member function row() on a non-object C:\wamp\www\vu\application\models\Alertas_model.php 39
ERROR - 2020-08-12 09:16:19 --> Query error: Unknown column 'faa.estado_revision' in 'where clause' - Invalid query: SELECT COUNT(1) as cantidad
FROM `firmas_archivos_adjuntos` `faa`
WHERE `faa`.`usuario_id` = '263'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
AND `faa`.`estado_revision` = '1'
ERROR - 2020-08-12 09:16:19 --> Severity: Error --> Call to a member function row() on a non-object C:\wamp\www\vu\application\models\Alertas_model.php 39
ERROR - 2020-08-12 10:33:11 --> Query error: Table 'expedientes.distritos' doesn't exist - Invalid query: SELECT `distritos`.`id`, `distritos`.`nombre`, `distritos`.`codigo_postal`
FROM `distritos`
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2020-08-12 10:33:11 --> Query error: Table 'expedientes.distritos' doesn't exist - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `distritos`) SqueryAux
ERROR - 2020-08-12 10:33:11 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551
ERROR - 2020-08-12 12:51:29 --> Severity: Warning --> strtoupper() expects parameter 1 to be string, array given C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 3038
ERROR - 2020-08-12 12:51:29 --> Severity: Warning --> strtoupper() expects parameter 1 to be string, array given C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 3038
ERROR - 2020-08-12 12:51:29 --> Severity: Warning --> strtoupper() expects parameter 1 to be string, array given C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 3038
ERROR - 2020-08-12 12:51:29 --> Severity: Warning --> strtoupper() expects parameter 1 to be string, array given C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 3038

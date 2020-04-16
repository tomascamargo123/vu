<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-06 07:46:50 --> 404 Page Not Found: 
ERROR - 2020-04-06 08:12:30 --> Severity: Warning --> Missing argument 3 for Archivos_adjuntos::rechazar_firma() C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 505
ERROR - 2020-04-06 08:16:26 --> Severity: Warning --> Missing argument 3 for Archivos_adjuntos::rechazar_firma() C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 505
ERROR - 2020-04-06 08:17:18 --> Severity: error --> Exception: Unable to find "startxref" keyword. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-04-06 08:17:25 --> Severity: error --> Exception: Unable to find "startxref" keyword. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-04-06 08:21:15 --> Query error: Unknown column 'archisvoadjunto.id' in 'field list' - Invalid query: SELECT `archisvoadjunto`.`id`, `archivoadjunto`.`nombre`, `archivoadjunto`.`tamanio`, `archivoadjunto`.`tipodecontenido`, `archivoadjunto`.`fecha`, IF(firmas_archivos_adjuntos.estado IS NULL, 0, IF(firmas_archivos_adjuntos.estado = "Rechazada", 0, 1)) AS firma_pendiente, `archivoadjunto`.`pase_id`, `archivoadjunto`.`id_expediente`
FROM `sigmu`.`archivoadjunto`
LEFT JOIN `expedientes`.`firmas_archivos_adjuntos` ON `archivoadjunto`.`id` = `firmas_archivos_adjuntos`.`archivo_adjunto_id`
WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '293913'
ORDER BY `fecha` DESC
ERROR - 2020-04-06 12:04:05 --> Query error: Unknown column 'archisvoadjunto.id' in 'field list' - Invalid query: SELECT `archisvoadjunto`.`id`, `archivoadjunto`.`nombre`, `archivoadjunto`.`tamanio`, `archivoadjunto`.`tipodecontenido`, `archivoadjunto`.`fecha`, IF(firmas_archivos_adjuntos.estado IS NULL, 0, IF(firmas_archivos_adjuntos.estado = "Rechazada", 0, 1)) AS firma_pendiente, `archivoadjunto`.`pase_id`, `archivoadjunto`.`id_expediente`
FROM `sigmu`.`archivoadjunto`
LEFT JOIN `expedientes`.`firmas_archivos_adjuntos` ON `archivoadjunto`.`id` = `firmas_archivos_adjuntos`.`archivo_adjunto_id`
WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '293913'
ORDER BY `fecha` DESC

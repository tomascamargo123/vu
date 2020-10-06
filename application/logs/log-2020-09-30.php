<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-30 11:38:47 --> Severity: Warning --> ftp_login() expects parameter 1 to be resource, boolean given C:\wamp64\www\vu\application\helpers\ftp_helper.php 10
ERROR - 2020-09-30 11:54:50 --> Severity: error --> Exception: File is encrypted! C:\wamp64\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-09-30 11:59:44 --> Severity: error --> Exception: File is encrypted! C:\wamp64\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-09-30 12:00:39 --> Query error: Unknown column 'archivoadjunto.id' in 'on clause' - Invalid query: SELECT COALESCE(MAX(foja_hasta), 0)+1 as foja_desde
FROM `sigmu`.`archivoadjunto_alt`
JOIN `fojas_archivos_adjuntos` ON `fojas_archivos_adjuntos`.`archivo_adjunto_id`=`archivoadjunto`.`id`
WHERE `sigmu`.`archivoadjunto_alt`.`id_expediente` = '294123'

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-18 07:52:30 --> Severity: error --> Exception: This document (C:\wamp\tmp\php645A.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-18 07:53:04 --> Severity: error --> Exception: This document (C:\wamp\tmp\phpEDA4.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-18 07:55:10 --> Severity: error --> Exception: This document (C:\wamp\tmp\phpDAC5.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-18 07:56:00 --> Severity: error --> Exception: This document (C:\wamp\tmp\php9F6D.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-18 07:56:36 --> Severity: error --> Exception: This document (C:\wamp\tmp\php2A1A.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-05-18 09:14:37 --> Query error: Unknown column 'archisvoadjunto.pase_id' in 'field list' - Invalid query: SELECT
            `archivoadjunto`.`id`,
            `archivoadjunto`.`nombre`,
            `archivoadjunto`.`tamanio`,
            `archivoadjunto`.`tipodecontenido`,
            `archisvoadjunto`.`pase_id`,
            `archivoadjunto`.`id_expediente`,
            `archivoadjunto`.`fecha`,
            firmas_archivos_adjuntos.estado,
            CASE 
            WHEN estado = 'Solicitada' THEN 1
            ELSE 0
            END AS firma_pendiente
          FROM `sigmu`.`archivoadjunto`
            LEFT JOIN `expedientes`.`firmas_archivos_adjuntos`
              ON `archivoadjunto`.`id` = `firmas_archivos_adjuntos`.`archivo_adjunto_id`
          WHERE firmas_archivos_adjuntos.id IN (SELECT
            MAX(firmas_archivos_adjuntos.id)
          FROM expedientes.firmas_archivos_adjuntos 
          RIGHT JOIN sigmu.archivoadjunto 
          ON firmas_archivos_adjuntos.archivo_adjunto_id = archivoadjunto.id
          WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '293976'
          GROUP BY nombre) OR (firmas_archivos_adjuntos.id IS NULL AND 
          `sigmu`.`archivoadjunto`.`id_expediente` = '293976')
          ORDER BY firmas_archivos_adjuntos.id DESC
ERROR - 2020-05-18 09:14:38 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Archivos_adjuntos_model.php 118

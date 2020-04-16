<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:01:01 --> 404 Page Not Found: /index
ERROR - 2020-04-07 08:14:18 --> Query error: Unknown column 'archivoadsjunto.id' in 'field list' - Invalid query: SELECT `archivoadsjunto`.`id`, `archivoadjunto`.`nombre`, `archivoadjunto`.`tamanio`, `archivoadjunto`.`tipodecontenido`, `archivoadjunto`.`fecha`, IF(firmas_archivos_adjuntos.estado IS NULL, 0, IF(firmas_archivos_adjuntos.estado = "Rechazada", 0, 1)) AS firma_pendiente, `archivoadjunto`.`pase_id`, `archivoadjunto`.`id_expediente`
FROM `sigmu`.`archivoadjunto`
LEFT JOIN `expedientes`.`firmas_archivos_adjuntos` ON `archivoadjunto`.`id` = `firmas_archivos_adjuntos`.`archivo_adjunto_id`
WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '293913'
ORDER BY `fecha` DESC
ERROR - 2020-04-07 11:29:45 --> Query error: Not unique table/alias: 'archivoadjunto' - Invalid query: SELECT MAX(firmas_archivos_adjuntos.id), `archivoadjunto`.`id` AS `id_adjuntos`, `archivoadjunto`.`nombre`, `archivoadjunto`.`tamanio`, `archivoadjunto`.`tipodecontenido`, `archivoadjunto`.`pase_id`, `archivoadjunto`.`id_expediente`, `archivoadjunto`.`fecha`, `firmas_archivos_adjuntos`.`estado`, `CASE WHEN estado = "Realizada" THEN 1 WHEN estado = "Solicitada" THEN 1 ELSE 0 END` AS `firma_pendiente`
FROM `sigmu`.`archivoadjunto`
RIGHT JOIN `sigmu`.`archivoadjunto` ON `firmas_archivos_adjuntos`.`archivo_adjunto_id` = `archivoadjunto`.`id`
WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '293913'
GROUP BY `archivoadjunto`.`nombre`
ORDER BY `fecha` DESC
ERROR - 2020-04-07 11:54:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\core\MY_Model.php 61
ERROR - 2020-04-07 11:54:34 --> Query error: Not unique table/alias: 'archivoadjunto' - Invalid query: SELECT MAX(firmas_archivos_adjuntos.id), `archivoadjunto`.`id` AS `id_adjuntos`, `archivoadjunto`.`nombre`, `archivoadjunto`.`tamanio`, `archivoadjunto`.`tipodecontenido`, `archivoadjunto`.`pase_id`, `archivoadjunto`.`id_expediente`, `archivoadjunto`.`fecha`, `firmas_archivos_adjuntos`.`estado`, `CASE WHEN estado = "Realizada" THEN 1 WHEN estado = "Solicitada" THEN 1 ELSE 0 END` AS `firma_pendiente`
FROM `sigmu`.`archivoadjunto`
RIGHT JOIN `sigmu`.`archivoadjunto` ON `firmas_archivos_adjuntos`.`archivo_adjunto_id` = `archivoadjunto`.`id`
ORDER BY `fecha` DESC
ERROR - 2020-04-07 12:22:42 --> Severity: Parsing Error --> syntax error, unexpected ',' C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1224
ERROR - 2020-04-07 12:52:16 --> Query error: Unknown column 'archivoDadjunto.tamanio' in 'field list' - Invalid query: SELECT
            firmas_archivos_adjuntos.id,
            `archivoadjunto`.`id` AS id_adjuntos,
            `archivoadjunto`.`nombre`,
            `archivoDadjunto`.`tamanio`,
            `archivoadjunto`.`tipodecontenido`,
            `archivoadjunto`.`pase_id`,
            `archivoadjunto`.`id_expediente`,
            `archivoadjunto`.`fecha`,
            firmas_archivos_adjuntos.estado,
            CASE 
            WHEN estado = 'Realizada' THEN 1
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
          WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '292014'
          GROUP BY nombre)
          ORDER BY firmas_archivos_adjuntos.id DESC
ERROR - 2020-04-07 13:15:35 --> 404 Page Not Found: 

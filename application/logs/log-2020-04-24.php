<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-24 08:35:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIKE '%w%' OR  LIKE '%w%' OR `aviso`.`usuario` LIKE '%w%' OR `aviso`.`audi_fecha' at line 10 - Invalid query: SELECT `aviso`.`id`, `aviso`.`mensaje`, `aviso`.`usuario`, (CASE aviso.estado 
			WHEN 0 THEN 'Pendiente' 
			WHEN 1 THEN 'En proceso' 
			WHEN 2 THEN 'Resuelto' 
			ELSE 'Rechazado' END) as estado, (CASE aviso.importancia 
			WHEN 0 THEN 'Baja' 
			WHEN 1 THEN 'Moderada' 
			ELSE 'Alta' END) as importancia, `aviso`.`audi_fecha`, `aviso`.`solicitante`
FROM `sigmu`.`aviso`
WHERE (`aviso`.`id` LIKE '%w%' OR `aviso`.`mensaje` LIKE '%w%' OR  LIKE '%w%' OR  LIKE '%w%' OR `aviso`.`usuario` LIKE '%w%' OR `aviso`.`audi_fecha` LIKE '%w%' OR `aviso`.`solicitante` LIKE '%w%')
ORDER BY `id` DESC
 LIMIT 10
ERROR - 2020-04-24 08:35:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'LIKE '%w%' OR  LIKE '%w%' OR `aviso`.`usuario` LIKE '%w%' OR `aviso`.`audi_fecha' at line 3 - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`aviso`
WHERE (`aviso`.`id` LIKE '%w%' OR `aviso`.`mensaje` LIKE '%w%' OR  LIKE '%w%' OR  LIKE '%w%' OR `aviso`.`usuario` LIKE '%w%' OR `aviso`.`audi_fecha` LIKE '%w%' OR `aviso`.`solicitante` LIKE '%w%')) SqueryAux
ERROR - 2020-04-24 08:35:09 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:19:56 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:20:10 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:20:10 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:20:10 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:21:05 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:21:05 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:21:05 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:40 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:41 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:58 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:58 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:58 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:58 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:50:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:51:07 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:51:07 --> 404 Page Not Found: /index
ERROR - 2020-04-24 10:51:07 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:04:22 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:33 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:33 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:33 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:07:55 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:08:02 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:08:02 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:08:02 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:08:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND archivo_adjunto_id = 214' at line 1 - Invalid query: SELECT pase_id  FROM expedientes.firmas_archivos_adjuntos WHERE id =  AND archivo_adjunto_id = 214;
ERROR - 2020-04-24 11:08:05 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Service.php 219
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:49 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:12:59 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:13:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND archivo_adjunto_id = 214' at line 1 - Invalid query: SELECT pase_id  FROM expedientes.firmas_archivos_adjuntos WHERE id =  AND archivo_adjunto_id = 214;
ERROR - 2020-04-24 11:13:01 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Service.php 219
ERROR - 2020-04-24 11:31:28 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:28 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:29 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:36 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:36 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:36 --> 404 Page Not Found: /index
ERROR - 2020-04-24 11:31:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND archivo_adjunto_id = 214' at line 1 - Invalid query: SELECT pase_id  FROM expedientes.firmas_archivos_adjuntos WHERE id =  AND archivo_adjunto_id = 214;
ERROR - 2020-04-24 11:31:38 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Service.php 219
ERROR - 2020-04-24 12:51:53 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:53 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:51:54 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:04 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:04 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:04 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:11 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:12 --> 404 Page Not Found: /index
ERROR - 2020-04-24 12:52:12 --> 404 Page Not Found: /index

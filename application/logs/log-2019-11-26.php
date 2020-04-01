<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-26 09:26:47 --> Severity: Error --> Call to undefined function generarPDF() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1755
ERROR - 2019-11-26 09:27:46 --> Severity: Notice --> Undefined offset: 0 C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1755
ERROR - 2019-11-26 09:27:50 --> Severity: Notice --> Undefined offset: 0 C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1756
ERROR - 2019-11-26 09:27:50 --> 404 Page Not Found: 
ERROR - 2019-11-26 10:19:48 --> Severity: Error --> Class 'Mpdf\Output\Destination' not found C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1772
ERROR - 2019-11-26 10:20:50 --> Severity: Error --> Class 'Mpdf\Output\Destination' not found C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1772
ERROR - 2019-11-26 10:27:36 --> Severity: error --> Exception: Incorrect output destination: STRING_RETURN C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 9452
ERROR - 2019-11-26 10:28:06 --> Severity: Error --> Class 'Destination' not found C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1772
ERROR - 2019-11-26 10:57:40 --> Severity: Parsing Error --> syntax error, unexpected ')' C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1772
ERROR - 2019-11-26 11:10:00 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-26 11:10:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-26 11:10:00 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-26 11:10:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-26 11:10:00 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-26 11:10:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-26 11:10:00 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-26 11:12:31 --> Severity: Error --> Call to undefined method Datatables::order_by() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1692
ERROR - 2019-11-26 11:12:41 --> Severity: Error --> Call to undefined method Datatables::order_by() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1692
ERROR - 2019-11-26 11:13:28 --> Severity: Error --> Call to undefined method Datatables::order_by() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1692
ERROR - 2019-11-26 11:26:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '`id`
ORDER BY `oficina_receptora` DESC
 LIMIT 10' at line 4 - Invalid query: SELECT id, cantexpe, fecha, usuario as usuario_receptor, oficina_receptora
FROM `sigmu`.`ticket`
WHERE `oficina_receptora` = '862'
GROUP BY `id ORDER BY` `id`
ORDER BY `oficina_receptora` DESC
 LIMIT 10
ERROR - 2019-11-26 11:30:12 --> Severity: Error --> Call to undefined method Datatables::order_by() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 1692
ERROR - 2019-11-26 11:54:10 --> Query error: Unknown column 'tickeet.id' in 'field list' - Invalid query: SELECT tickeet.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`
ORDER BY `oficina_receptora` DESC
 LIMIT 10
ERROR - 2019-11-26 11:54:15 --> Query error: Unknown column 'tickeet.id' in 'field list' - Invalid query: SELECT tickeet.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`

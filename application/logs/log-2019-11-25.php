<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-25 10:14:56 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-25 10:31:52 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-25 10:31:52 --> Query error: Table 'sigmu.passe' doesn't exist - Invalid query: SELECT ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM `sigmu`.`ticket`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`passe` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`
ERROR - 2019-11-25 10:37:31 --> Severity: error --> Exception: WriteHTML() requires $html be an integer, float, string, boolean or an object with the __toString() magic method. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 15887
ERROR - 2019-11-25 11:47:39 --> 404 Page Not Found: 
ERROR - 2019-11-25 11:49:16 --> 404 Page Not Found: 
ERROR - 2019-11-25 12:07:10 --> Query error: Column 'plantilla_origen' cannot be null - Invalid query: REPLACE INTO `sigmu`.`datos_elements_form` (`form_element_id`, `formulario_id`, `element_id`, `tramite_id`, `plantilla_origen`, `alias_origen`) VALUES ('1', '10', '9', 1000, NULL, NULL)
ERROR - 2019-11-25 12:07:29 --> 404 Page Not Found: /index
ERROR - 2019-11-25 13:14:40 --> Severity: Error --> Cannot use object of type CI_DB_mysqli_result as array C:\wamp\www\vu\application\modules\expedientes\models\Expedientes_model.php 187
ERROR - 2019-11-25 13:14:45 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:15:18 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:15:52 --> Severity: Error --> Cannot use object of type CI_DB_mysqli_result as array C:\wamp\www\vu\application\modules\expedientes\models\Expedientes_model.php 187
ERROR - 2019-11-25 13:17:35 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1402
ERROR - 2019-11-25 13:17:59 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:18:10 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:18:15 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:18:35 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:18:46 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:18:59 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:19:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/expedientesver
ERROR - 2019-11-25 13:19:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/expedientesver
ERROR - 2019-11-25 13:19:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/expedientesver
ERROR - 2019-11-25 13:19:31 --> 404 Page Not Found: 
ERROR - 2019-11-25 13:19:56 --> 404 Page Not Found: 

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-21 08:12:04 --> Query error: Table 'sigmu.usuasrio_oficina' doesn't exist - Invalid query: SELECT `sigmu`.`oficina`.`id`, `sigmu`.`oficina`.`nombre`, `sigmu`.`oficina`.`organigrama`, `sigmu`.`oficina`.`emisora_pase`, `sigmu`.`oficina`.`receptora_pase`, `sigmu`.`oficina`.`usuario`, `sigmu`.`oficina`.`terminal`, `sigmu`.`oficina`.`fecha_usuario`, `sigmu`.`oficina`.`proceso_usuario`, `sigmu`.`oficina`.`inicia_expediente`
FROM `sigmu`.`oficina`
JOIN `sigmu`.`usuasrio_oficina` ON `usuario_oficina`.`ID_OFICINA`=`oficina`.`id`
WHERE `usuario_oficina`.`ID_USUARIO` = 'tcamargo'
AND `oficina`.`organigrama` IS NULL
ORDER BY `sigmu`.`usuario_oficina`.`ORDEN`
ERROR - 2020-05-21 08:12:04 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-05-21 08:32:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `usuario_oficina`.`ID_USUARIO` = 'tcamargo'
ORDER BY `ORDEN`' at line 4 - Invalid query: SELECT `sigmu`.`oficina`.`id`, `sigmu`.`oficina`.`nombre`, `sigmu`.`oficina`.`organigrama`, `sigmu`.`oficina`.`emisora_pase`, `sigmu`.`oficina`.`receptora_pase`, `sigmu`.`oficina`.`usuario`, `sigmu`.`oficina`.`terminal`, `sigmu`.`oficina`.`fecha_usuario`, `sigmu`.`oficina`.`proceso_usuario`, `sigmu`.`oficina`.`inicia_expediente`
FROM `sigmu`.`oficina`
JOIN `sigmu`.`usuario_oficina` ON `usuario_oficina`.`ID_OFICINA` = `oficina`.`id` AND `oficina` = 
WHERE `usuario_oficina`.`ID_USUARIO` = 'tcamargo'
ORDER BY `ORDEN`
ERROR - 2020-05-21 08:32:54 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-05-21 08:40:12 --> Query error: Unknown column 'oficina.orginigrama' in 'where clause' - Invalid query: SELECT `sigmu`.`oficina`.`id`, `sigmu`.`oficina`.`nombre`, `sigmu`.`oficina`.`organigrama`, `sigmu`.`oficina`.`emisora_pase`, `sigmu`.`oficina`.`receptora_pase`, `sigmu`.`oficina`.`usuario`, `sigmu`.`oficina`.`terminal`, `sigmu`.`oficina`.`fecha_usuario`, `sigmu`.`oficina`.`proceso_usuario`, `sigmu`.`oficina`.`inicia_expediente`
FROM `sigmu`.`oficina`
JOIN `sigmu`.`usuario_oficina` ON `usuario_oficina`.`ID_OFICINA` = `oficina`.`id`
WHERE `usuario_oficina`.`ID_USUARIO` = 'tcamargo'
AND `oficina`.`orginigrama` IS NULL
ORDER BY `ORDEN`
ERROR - 2020-05-21 08:40:12 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-05-21 08:57:26 --> Query error: Unknown column 'expsediente.id' in 'field list' - Invalid query: SELECT `expsediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-05-21 08:57:27 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-05-21 09:08:36 --> Query error: Unknown column 'expsediente.id' in 'field list' - Invalid query: SELECT `expsediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-05-21 09:08:36 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-05-21 12:39:41 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:39:51 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:39:58 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:46:42 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:46:54 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:50:05 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 12:50:29 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:02:36 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:02:44 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:04:02 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:19:14 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:20:35 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66
ERROR - 2020-05-21 13:21:21 --> Severity: Warning --> array_key_exists() expects parameter 2 to be array, null given C:\wamp\www\vu\application\core\MY_Controller.php 66

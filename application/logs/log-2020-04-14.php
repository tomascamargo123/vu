<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-14 10:11:37 --> Query error: Unknown column 'avisso.estado' in 'field list' - Invalid query: SELECT `aviso`.`id`, `aviso`.`mensaje`, `avisso`.`estado`, `aviso`.`importancia`, `usuario`.`DetaUsua`, (CASE aviso.activo WHEN 0 THEN 'Inactivo' ELSE 'Activo' END) as activo, `aviso`.`oficina_id`, (COALESCE(oficina.nombre, 'Todas las oficinas')) as oficina
FROM `sigmu`.`aviso`
LEFT JOIN `sigmu`.`oficina` ON `oficina`.`id` = `aviso`.`oficina_id`
INNER JOIN `sigmu`.`usuario` ON `aviso`.`usuario` = `usuario`.`CodiUsua`
ORDER BY `mensaje` ASC
 LIMIT 10
ERROR - 2020-04-14 13:05:23 --> Severity: Warning --> Illegal string offset:  -2 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:05:23 --> Severity: Warning --> Illegal string offset:  -1 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:05:39 --> Severity: Warning --> Illegal string offset:  -2 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:05:39 --> Severity: Warning --> Illegal string offset:  -1 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:05:52 --> Severity: Warning --> Illegal string offset:  -2 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:05:52 --> Severity: Warning --> Illegal string offset:  -1 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:06:04 --> Severity: Warning --> Illegal string offset:  -2 C:\wamp\www\vu\application\core\MY_Controller.php 88
ERROR - 2020-04-14 13:06:04 --> Severity: Warning --> Illegal string offset:  -1 C:\wamp\www\vu\application\core\MY_Controller.php 88

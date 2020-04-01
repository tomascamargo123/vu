<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-10 11:41:17 --> Severity: Compile Error --> Only variables can be passed by reference C:\wamp\www\vu\application\helpers\datatables_helper.php 112
ERROR - 2019-12-10 11:41:19 --> Severity: Compile Error --> Only variables can be passed by reference C:\wamp\www\vu\application\helpers\datatables_helper.php 112
ERROR - 2019-12-10 13:12:55 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:12:57 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:12:58 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:12:58 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:13:00 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:13:01 --> Query error: No tables used - Invalid query: SELECT *
ERROR - 2019-12-10 13:18:45 --> Severity: Error --> Cannot use object of type stdClass as array C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 122
ERROR - 2019-12-10 13:19:12 --> Severity: Error --> Cannot use object of type stdClass as array C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 122
ERROR - 2019-12-10 13:21:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'IS NULL' at line 4 - Invalid query: SELECT `expediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE  IS NULL
ERROR - 2019-12-10 13:22:33 --> Severity: Error --> Cannot use object of type stdClass as array C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 122

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-12 08:43:58 --> Query error: Unknown column 'expediente.id' in 'field list' - Invalid query: SELECT `expediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente_listar`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `numero` = '12'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-12 09:14:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 09:17:57 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-12 09:18:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 111
ERROR - 2019-12-12 09:29:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 09:29:13 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 76 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:29:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 09:29:37 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 76 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:31:43 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 113
ERROR - 2019-12-12 09:31:50 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 70 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:33:29 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 113
ERROR - 2019-12-12 09:33:36 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 76 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:33:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 113
ERROR - 2019-12-12 09:33:45 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 76 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:37:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 113
ERROR - 2019-12-12 09:37:52 --> Severity: Error --> Call to a member function add_column() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 119
ERROR - 2019-12-12 09:38:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 113
ERROR - 2019-12-12 09:38:14 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 32 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:38:46 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 09:38:52 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 32 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 09:39:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 09:39:30 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 32 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 10:32:06 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:35:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:35:26 --> Severity: Error --> Call to a member function add_column() on a non-object C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 118
ERROR - 2019-12-12 10:47:54 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:47:54 --> Severity: Error --> Cannot access empty property C:\wamp\www\vu\application\libraries\Datatables.php 733
ERROR - 2019-12-12 10:49:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:49:28 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 117
ERROR - 2019-12-12 10:49:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:49:40 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 117
ERROR - 2019-12-12 10:49:55 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:50:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:56:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:57:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:57:02 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 117
ERROR - 2019-12-12 10:57:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:57:31 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 117
ERROR - 2019-12-12 10:58:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 10:58:11 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 120
ERROR - 2019-12-12 11:00:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 11:01:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 11:01:47 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 11:01:54 --> Severity: Error --> Allowed memory size of 536870912 bytes exhausted (tried to allocate 32 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_result.php 183
ERROR - 2019-12-12 11:02:09 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 11:05:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 112
ERROR - 2019-12-12 11:29:14 --> Query error: Unknown column 'codigo' in 'where clause' - Invalid query: SELECT `expediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `codigo` = '29163'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-12 11:29:45 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `expediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `id` = '29123'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-12 11:57:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 11:58:06 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 11:59:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 11:59:17 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:02:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:02:17 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:02:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:02:21 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:02:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\views\general_header.php 13
ERROR - 2019-12-12 12:49:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 12:49:58 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 12:50:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 12:50:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:02:36 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:06:22 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:08:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:08:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:15:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:15:17 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:15:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:15:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:16:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:16:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:16:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:16:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116
ERROR - 2019-12-12 13:24:21 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 116

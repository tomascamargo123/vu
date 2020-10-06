<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-23 08:53:41 --> Query error: Unknown column 'expediente.isd' in 'field list' - Invalid query: SELECT `expediente`.`isd`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `expediente`.`numero` = '8584'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-09-23 10:21:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp64\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 78
ERROR - 2020-09-23 11:46:29 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:31 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:34 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:36 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:41 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:44 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:44 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:49 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:46:55 --> Severity: Compile Warning --> Unterminated comment starting line 120 C:\wamp64\www\vu\application\config\database.php 120
ERROR - 2020-09-23 11:47:14 --> 404 Page Not Found: 

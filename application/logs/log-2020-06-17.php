<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-17 09:38:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND orden = 0' at line 1 - Invalid query: SELECT COUNT(*) as cant FROM archivoadjunto WHERE id_expediente =  AND orden = 0;
ERROR - 2020-06-17 09:38:17 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Archivos_adjuntos_model.php 137
ERROR - 2020-06-17 09:42:46 --> Query error: Table 'expedientes.archivoadjunto' doesn't exist - Invalid query: SELECT COUNT(*) as cant FROM archivoadjunto WHERE id_expediente = 293976 AND orden = 0;
ERROR - 2020-06-17 09:42:46 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Archivos_adjuntos_model.php 137
ERROR - 2020-06-17 12:10:40 --> Query error: Unknown column 'expeddiente.id' in 'field list' - Invalid query: SELECT `expediente`.`id`, `expeddiente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `expediente`.`ano` = '2020'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-17 12:10:40 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-17 12:12:23 --> Query error: Unknown column 'expeddiente.id' in 'field list' - Invalid query: SELECT `expediente`.`id`, `expeddiente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
JOIN `expedientes`.`users` ON `expediente`.`usuario` = `users`.`username`
WHERE `expediente`.`numero` = '3389'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-06-17 12:12:23 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448

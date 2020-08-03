<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-26 08:44:57 --> Query error: Unknown column 'sigmu.usuario.CsodiUsua' in 'field list' - Invalid query: SELECT `sigmu`.`usuario`.`CsodiUsua`, `username`, `first_name`, `last_name`, `email`, group_concat(groups.name separator ' - ') as grupos, (CASE active WHEN 1 THEN "Activo" WHEN 2 THEN "Inactivo" END) as active, FROM_UNIXTIME(last_login, "%d/%m/%Y %H:%i") as last_login
FROM `sigmu`.`usuario`
LEFT JOIN `users` ON `sigmu`.`usuario`.`CodiUsua` = `users`.`CodiUsua`
LEFT JOIN `users_groups` ON `users_groups`.`user_id` = `users`.`id`
LEFT JOIN `groups` ON `groups`.`id` = `users_groups`.`group_id`
WHERE `users`.`organigrama` = '10000'
GROUP BY `usuario`.`CodiUsua`
ORDER BY `CodiUsua` ASC
 LIMIT 10
ERROR - 2020-06-26 08:44:57 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448
ERROR - 2020-06-26 10:00:36 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\controllers\Revisor_firmante.php 108
ERROR - 2020-06-26 10:00:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\controllers\Revisor_firmante.php 108

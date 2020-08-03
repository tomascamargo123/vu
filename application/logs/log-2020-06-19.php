<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-19 10:45:14 --> Query error: Column 'id' in order clause is ambiguous - Invalid query: SELECT `users_firmante`.`username` AS `firmante`, `users_revisor`.`username` AS `revisor`
FROM `revisor_firmante`
INNER JOIN `users` AS `users_firmante` ON `revisor_firmante`.`id_firmante` = `users_firmante`.`id`
INNER JOIN `users` AS `users_revisor` ON `revisor_firmante`.`id_revisor` = `users_revisor`.`id`
ORDER BY `id` ASC
 LIMIT 10
ERROR - 2020-06-19 10:45:14 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448

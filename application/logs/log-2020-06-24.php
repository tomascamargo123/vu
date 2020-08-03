<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-24 07:55:32 --> Query error: Unknown column 'audi_accion' in 'field list' - Invalid query: INSERT INTO `revisor_firmante` (`id_revisor`, `id_firmante`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES ('39', '97', '263', '2020/06/24 07:55:32', 'I')
ERROR - 2020-06-24 08:13:24 --> Query error: Unknown column 'revisosr_firmante.id' in 'field list' - Invalid query: SELECT `revisosr_firmante`.`id`, `users_firmante`.`username` AS `firmante`, `users_revisor`.`username` AS `revisor`
FROM `revisor_firmante`
INNER JOIN `users` AS `users_firmante` ON `revisor_firmante`.`id_firmante` = `users_firmante`.`id`
INNER JOIN `users` AS `users_revisor` ON `revisor_firmante`.`id_revisor` = `users_revisor`.`id`
ORDER BY `firmante` ASC
 LIMIT 10
ERROR - 2020-06-24 08:13:24 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 448

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-04 08:49:18 --> 404 Page Not Found: 
ERROR - 2019-12-04 09:06:32 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF) C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 713
ERROR - 2019-12-04 09:06:35 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF) C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 713
ERROR - 2019-12-04 09:06:42 --> Severity: Parsing Error --> syntax error, unexpected 'if' (T_IF) C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 713
ERROR - 2019-12-04 09:08:51 --> 404 Page Not Found: 
ERROR - 2019-12-04 09:09:37 --> 404 Page Not Found: 
ERROR - 2019-12-04 09:41:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:41:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:41:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:42:44 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:42:44 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:42:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 09:42:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/exportar
ERROR - 2019-12-04 10:39:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:39:58 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:40:06 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:40:06 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:40:06 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:46 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:53 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:53 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:53 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 10:50:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 11:24:07 --> Query error: Cannot delete or update a parent row: a foreign key constraint fails (`sigmu`.`formulario_consulta`, CONSTRAINT `FK_consulta_formulario` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`id`)) - Invalid query: DELETE FROM sigmu.consulta WHERE id = 21;
ERROR - 2019-12-04 11:29:08 --> Query error: Cannot delete or update a parent row: a foreign key constraint fails (`sigmu`.`formulario_consulta`, CONSTRAINT `FK_consulta_formulario` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`id`)) - Invalid query: DELETE FROM sigmu.consulta WHERE id = 21;
ERROR - 2019-12-04 11:33:16 --> 404 Page Not Found: 
ERROR - 2019-12-04 11:52:25 --> Query error: Table 'expedientes.expediente' doesn't exist - Invalid query: SELECT
  expediente.id AS idexp,
  expediente.ano,
  expediente.numero,
  expediente.inicio,
  expediente.caratula,
  pase.id AS idpase,
  pase.origen,
  pase.destino,
  pase.respuesta
FROM expediente
INNER JOIN pase
ON expediente.id = pase.id_expediente
GROUP BY expediente.id
ORDER BY pase.id DESC;
ERROR - 2019-12-04 11:52:25 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-04 11:52:30 --> 404 Page Not Found: /index
ERROR - 2019-12-04 11:52:53 --> Query error: Table 'expedientes.pase' doesn't exist - Invalid query: SELECT
  expediente.id AS idexp,
  expediente.ano,
  expediente.numero,
  expediente.inicio,
  expediente.caratula,
  pase.id AS idpase,
  pase.origen,
  pase.destino,
  pase.respuesta
FROM sigmu.expediente
INNER JOIN pase
ON expediente.id = pase.id_expediente
GROUP BY expediente.id
ORDER BY pase.id DESC;
ERROR - 2019-12-04 11:52:53 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-04 11:54:06 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:00:42 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:05:28 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:07:43 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:07:43 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:09:17 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:10:52 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:12:27 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:12:51 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:14:44 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:15:37 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:15:47 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:15:49 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/consulstas
ERROR - 2019-12-04 12:16:14 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:17:05 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:19:52 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:20:07 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:20:07 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:21:41 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:21:56 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:21:56 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:22:17 --> Query error: Table 'expedientes.expediente' doesn't exist - Invalid query: SELECT expediente.id AS idexp, expediente.ano AS ano, expediente.numero AS numero, expediente.inicio AS inicio, expediente.caratula AS caratula, pase.id AS idpase, pase.origen AS origen, pase.destino AS destino, pase.respuesta AS respuesta FROM expediente INNER JOIN pase ON expediente.id = pase.id_expediente;
ERROR - 2019-12-04 12:22:40 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:24:09 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:24:34 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:24:34 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:25:33 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:25:51 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:26:23 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:26:59 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:28:11 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:28:32 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:31:58 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:36:50 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:37:10 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:49:57 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:50:15 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:51:18 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:54:29 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:54:45 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:55:36 --> 404 Page Not Found: /index
ERROR - 2019-12-04 12:55:49 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 12:56:34 --> 404 Page Not Found: /index
ERROR - 2019-12-04 13:01:18 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 13:03:40 --> 404 Page Not Found: /index
ERROR - 2019-12-04 13:04:03 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 13:11:12 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-12-04 13:11:25 --> Severity: Error --> Allowed memory size of 134217728 bytes exhausted (tried to allocate 127476656 bytes) C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305

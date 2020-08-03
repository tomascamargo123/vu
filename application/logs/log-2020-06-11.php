<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-11 08:33:08 --> Query error: Table 'expedientes.pase' doesn't exist - Invalid query: SELECT `id`
FROM `pase`
WHERE `id_expediente` = 293999
ORDER BY `id` desc
 LIMIT 2
ERROR - 2020-06-11 08:33:08 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-06-11 09:54:56 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\wamp\www\vu\application\modules\expedientes\models\Pases_model.php 164
ERROR - 2020-06-11 09:54:56 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\wamp\www\vu\application\modules\expedientes\models\Pases_model.php 165
ERROR - 2020-06-11 09:54:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>id' at line 1 - Invalid query: DELETE FROM pase WHERE id = ->id
ERROR - 2020-06-11 09:54:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>id' at line 1 - Invalid query: UPDATE pase SET destino = -1, respuesta = 'pendiente' WHERE id = ->id
ERROR - 2020-06-11 09:54:56 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/listar_pendientes_ee
ERROR - 2020-06-11 09:54:56 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/plugins
ERROR - 2020-06-11 09:56:38 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\wamp\www\vu\application\modules\expedientes\models\Pases_model.php 164
ERROR - 2020-06-11 09:56:38 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\wamp\www\vu\application\modules\expedientes\models\Pases_model.php 165
ERROR - 2020-06-11 09:56:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>id' at line 1 - Invalid query: DELETE FROM pase WHERE id = ->id
ERROR - 2020-06-11 09:56:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '>id' at line 1 - Invalid query: UPDATE pase SET destino = -1, respuesta = 'pendiente' WHERE id = ->id
ERROR - 2020-06-11 10:00:45 --> Query error: Table 'expedientes.pase' doesn't exist - Invalid query: DELETE FROM pase WHERE id = 1792731
ERROR - 2020-06-11 10:00:45 --> Query error: Table 'expedientes.pase' doesn't exist - Invalid query: UPDATE pase SET destino = -1, respuesta = 'pendiente' WHERE id = 1792730
ERROR - 2020-06-11 12:11:39 --> Severity: error --> Exception: Unable to find "startxref" keyword. C:\wamp\www\vu\application\third_party\mpdf\mpdf.php 31371

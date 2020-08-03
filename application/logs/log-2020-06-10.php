<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-10 08:18:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\helpers\datatables_helper.php 145
ERROR - 2020-06-10 13:00:28 --> Query error: Table 'expedientes.pase' doesn't exist - Invalid query: SELECT COUNT(*)
FROM `sigmu`.`archivoadjunto`
WHERE pase_id = (SELECT
                   id
                 FROM pase
                 WHERE id_expediente = 293989
                 ORDER BY id DESC
                 LIMIT 1)
ERROR - 2020-06-10 13:00:29 --> Severity: Error --> Call to a member function num_rows() on a non-object C:\wamp\www\vu\application\core\MY_Model.php 151
ERROR - 2020-06-10 13:02:20 --> Severity: Error --> Cannot use object of type stdClass as array C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1343

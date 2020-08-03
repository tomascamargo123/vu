<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-24 09:28:28 --> Severity: Warning --> mysqli::real_connect():  C:\wamp\www\vu-master\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2020-07-24 09:28:28 --> Unable to connect to the database
ERROR - 2020-07-24 09:28:32 --> Severity: Warning --> mysqli::real_connect():  C:\wamp\www\vu-master\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2020-07-24 09:28:32 --> Unable to connect to the database
ERROR - 2020-07-24 09:40:49 --> Severity: error --> Exception: This document (C:\wamp\tmp\phpD563.tmp) probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) C:\wamp\www\vu-master\application\third_party\mpdf\mpdf.php 31371
ERROR - 2020-07-24 10:02:09 --> Query error: Table 'expedisentes.users' doesn't exist - Invalid query: SELECT
        users.id,
        users.username,
        CONCAT(users.username, ' - ', UCASE(users.first_name),' ', UCASE(users.last_name)) AS nombre
        FROM sigmu.usuario_oficina
        JOIN expedisentes.users
        ON usuario_oficina.ID_USUARIO = users.username
        WHERE id_oficina = 862 
        GROUP BY users.id 
        ORDER BY nombre ASC;
ERROR - 2020-07-24 10:03:23 --> Query error: Table 'expedisentes.users' doesn't exist - Invalid query: SELECT
        users.id,
        users.username,
        CONCAT(users.username, ' - ', UCASE(users.first_name),' ', UCASE(users.last_name)) AS nombre
        FROM sigmu.usuario_oficina
        JOIN expedisentes.users
        ON usuario_oficina.ID_USUARIO = users.username
        WHERE id_oficina = 862 
        GROUP BY users.id 
        ORDER BY nombre ASC;
ERROR - 2020-07-24 10:04:00 --> Query error: Table 'expedisentes.users' doesn't exist - Invalid query: SELECT
        users.id,
        users.username,
        CONCAT(users.username, ' - ', UCASE(users.first_name),' ', UCASE(users.last_name)) AS nombre
        FROM sigmu.usuario_oficina
        JOIN expedisentes.users
        ON usuario_oficina.ID_USUARIO = users.username
        WHERE id_oficina = 862 AND users.id != 263
        GROUP BY users.id 
        ORDER BY nombre ASC;

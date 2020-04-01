<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-02-20 09:46:32 --> 404 Page Not Found: 
ERROR - 2020-02-20 10:26:29 --> 404 Page Not Found: 
ERROR - 2020-02-20 12:26:19 --> Query error: Table 'expedientes.detadifu' doesn't exist - Invalid query: SELECT detadifu.CodiDifu, detadifu.DetaDedi, detadifu.AnioDedi, detadifu.FefaDedi, detadifu.FealDedi,
tiposepu.DetaTise, difunto.SeccDifu, difunto.NumeDifu, difunto.FilaDifu, cementerio.DetaCeme
FROM detadifu 
INNER JOIN difunto
ON detadifu.CodiDifu = difunto.CodiDifu
INNER JOIN tiposepu
ON difunto.CodiTise = tiposepu.CodiTise
INNER JOIN cementerio	
ON difunto.CodiCeme = cementerio.CodiCeme
WHERE detadifu.DetaDedi LIKE '%%'
OR detadifu.CodiDifu LIKE '%%'
ORDER BY FealDedi DESC;
ERROR - 2020-02-20 12:26:37 --> Query error: Table 'expedientes.difunto' doesn't exist - Invalid query: SELECT detadifu.CodiDifu, detadifu.DetaDedi, detadifu.AnioDedi, detadifu.FefaDedi, detadifu.FealDedi,
tiposepu.DetaTise, difunto.SeccDifu, difunto.NumeDifu, difunto.FilaDifu, cementerio.DetaCeme
FROM recaudacion.detadifu 
INNER JOIN difunto
ON detadifu.CodiDifu = difunto.CodiDifu
INNER JOIN tiposepu
ON difunto.CodiTise = tiposepu.CodiTise
INNER JOIN cementerio	
ON difunto.CodiCeme = cementerio.CodiCeme
WHERE detadifu.DetaDedi LIKE '%%'
OR detadifu.CodiDifu LIKE '%%'
ORDER BY FealDedi DESC;
ERROR - 2020-02-20 12:26:48 --> 404 Page Not Found: /index
ERROR - 2020-02-20 12:27:05 --> Query error: Table 'expedientes.difunto' doesn't exist - Invalid query: SELECT detadifu.CodiDifu, detadifu.DetaDedi, detadifu.AnioDedi, detadifu.FefaDedi, detadifu.FealDedi,
tiposepu.DetaTise, difunto.SeccDifu, difunto.NumeDifu, difunto.FilaDifu, cementerio.DetaCeme
FROM recaudacion.detadifu 
INNER JOIN difunto
ON detadifu.CodiDifu = difunto.CodiDifu
INNER JOIN tiposepu
ON difunto.CodiTise = tiposepu.CodiTise
INNER JOIN cementerio	
ON difunto.CodiCeme = cementerio.CodiCeme
WHERE detadifu.DetaDedi LIKE '%%'
OR detadifu.CodiDifu LIKE '%%'
ORDER BY FealDedi DESC;
ERROR - 2020-02-20 12:27:05 --> 404 Page Not Found: /index

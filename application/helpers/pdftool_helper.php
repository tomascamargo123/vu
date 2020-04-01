<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Datatables Helper
 *
 * @package    CodeIgniter
 * @subpackage helpers
 * @category   helper
 * @version    1.1.4
 * @author     ZettaSys <info@zettasys.com.ar>
 *
 */
if (!function_exists('numeroPaginasPdf')) {

    function numeroPaginasPdf($content) {
        //$stream = fopen($archivoPDF, "r");
        //$content = fread($stream, filesize($archivoPDF));

        if (!$content)
            return 0;

        $count = 0;
        $regex = "/\/Count\s+(\d+)/";
        $regex2 = "/\/Page\W*(\d+)/";
        $regex3 = "/\/N\s+(\d+)/";

        if (preg_match_all($regex, $content, $matches)){
            $count = max($matches);
        }
        return $count[0];
    }

}
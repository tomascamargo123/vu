<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nusoap_lib {

    function Nusoap_lib() {
        require_once('nusoap/nusoap.php'); //Por si estamos ejecutando este script en un servidor Windows
    }

}

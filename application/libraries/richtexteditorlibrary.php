<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RichtexteditorLibrary {

    function RichtexteditorLibrary() {
        require_once('richtexteditor/include_rte.php'); //Por si estamos ejecutando este script en un servidor Windows
    }

}

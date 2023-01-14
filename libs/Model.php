<?php

class Model {

    function __construct() {
        $this->db = new Database();
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/robust.php')) {
            $this->osDB = new OpenSimDB();
        }
    }

}

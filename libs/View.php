<?php

class View {

    public $_VERSION = "OSP (S) v1.0.0 (Build 20230202) | BETA";
    public $_VERSION_SRC = "1.0.0.20230202";

    function __construct() {
        // no
    }

    public function render($name, $noInclude = false) {
        if ($noInclude == true) {
            $this->version = $this->_VERSION;
            $this->otserv = $this->_VERSION_SRC; 
            require 'views/header_dash.php';
            require 'views/sidebar.php';
            require 'views/' . $name . '.php';
            require 'views/footer_dash.php';
        } else {
            $this->version = $this->_VERSION;
            require 'views/header.php';
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
    }

}

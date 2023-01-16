<?php

class View {

    public $_VERSION = "OTWI v1.0.0 (Build 20230116) | Alpha";
    public $_VERSION_SRC = "1.0.0.20230116";

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

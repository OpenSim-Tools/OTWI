<?php

class Bootstrap {

    
    
    function __construct() {

        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $locale = "de_DE";

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $locale); // Linux
            bindtextdomain("messages", $_SERVER['DOCUMENT_ROOT'] . '/lang');
        } else {
            putenv("LC_ALL={$locale}"); // Windows
            bindtextdomain("messages", $_SERVER['DOCUMENT_ROOT'] . "\lang");
            textdomain("messages");
        }

        if (empty($url[0])) {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';
        if (file_exists($file)) {
            
            require $file;
        } else {
            $this->errors();
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        // calling methods
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->errors();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    $this->errors();
                }
            } else {
                $controller->index();
            }
        }
    }

    function errors() {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }

}

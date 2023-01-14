<?php

class account extends controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->PageTitle = "OTWI | Login";
        $this->view->render('index/index');
    }

    function run() {
        $this->model->run();
    }

}

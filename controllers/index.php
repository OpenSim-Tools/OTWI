<?php

class Index extends Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
            header('Location: /account');
		
	}
	
}

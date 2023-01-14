<?php

class OpenSimDB extends PDO
{
	
	public function __construct()
	{
		parent::__construct(OSDB_TYPE.':host='.OSDB_HOST.';dbname='.OSDB_NAME, OSDB_USER, OSDB_PASS);
	}
	
	
}
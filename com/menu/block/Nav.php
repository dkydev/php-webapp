<?php

require_once DKY_PATH_LIB . "/dky/Block.php";

class Menu_Block_Nav extends DKY_Block 
{	
	public function __construct()
	{
	    parent::__construct($request);
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";		
		$this->template = "nav.html.php";
	}
}

?>
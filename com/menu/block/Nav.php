<?php

require_once PATH_LIB . "/block.php";

class Menu_Block_Nav extends Block 
{	
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
		
		$this->template = "nav.html.php";
		
		include $this->templateDirectory . $this->template;
	}
}

?>
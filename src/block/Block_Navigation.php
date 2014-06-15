<?php

class Block_Navigation {
	
	function __construct() {
	
		$this->defaultCommand = "cmd_view";
	
	}
	
	public function cmd_view() {
		
		$this->template = "template_navigation.php";
		
	}
	
}
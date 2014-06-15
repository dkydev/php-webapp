<?php

define("MSG_TYPE_SUCCESS", 	"success");
define("MSG_TYPE_INFO", 	"info");
define("MSG_TYPE_WARNING", 	"warning");
define("MSG_TYPE_DANGER", 	"danger");

class Output {
	
	public $page;
	public $aMessage;
	
	public function __construct($aGlobalConfig) {
		
		foreach ($this as $key => $value) {
			if (!empty($aGlobalConfig[$key])) {
				$this->$key = $aGlobalConfig[$key]; 
			}
		}
		
	}
	
	public function raiseMessage($strMessage, $type = MSG_TYPE_INFO) {
		
		$_SESSION["aMessage"][$type][] = $strMessage;
		
	}
	
	public function display() {
		
		if (!empty($_SESSION["aMessage"])) {
			$this->aMessage = $_SESSION["aMessage"];
			//
		}
		
		header('Content-Type: text/html');
		
		include $this->page->template;
		
		unset($_SESSION["aMessage"]);
		
	}
	
}

?>
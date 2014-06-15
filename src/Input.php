<?php

class Input {
	
	public $aRequest;
	
	public function __construct($aGlobalConfig) {
		
		foreach ($this as $key => $value) {
			if (!empty($aGlobalConfig[$key])) {
				$this->$key = $aGlobalConfig[$key];
			}
		}
		
		$this->aRequest = array_merge($_POST, $_GET);
		$this->aRequest["aFiles"] = $_FILES;		
		
		$aURI = explode("/", str_replace("/web_framework", "", $_SERVER["REQUEST_URI"]));
		array_shift($aURI);
		
		if (!empty($aURI[0])) {			
			$this->aRequest["page"] = array_shift($aURI);
		} else {			
			$this->aRequest["page"] = $aGlobalConfig["defaultPage"];			
		}		
		if (!empty($aURI[0])) {		
			$this->aRequest["command"] = "cmd_" . array_shift($aURI);		
		} else if (!empty($this->aRequest["command"])) { // command may be set in $_POST
			$this->aRequest["command"] = "cmd_" . $this->aRequest["command"];
		} else {
			$this->aRequest["command"] = "cmd_" . $aGlobalConfig["defaultCommand"];
		}
		
		for ($i = 0; $i < count($aURI); $i++) {
			if (!empty($aURI[$i + 1])) {
				$this->aRequest[$aURI[$i]] = $aURI[++$i];
			}
		}
				
	}
	
}

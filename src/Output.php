<?php

define("MSG_TYPE_SUCCESS", 	"success");
define("MSG_TYPE_INFO", 	"info");
define("MSG_TYPE_WARNING", 	"warning");
define("MSG_TYPE_DANGER", 	"danger");

class Output {
	
	public $page;
	public $aMessage;
	public $aRequest;
	
	public function __construct($aGlobalConfig) {
		
		foreach ($this as $key => $value) {
			if (!empty($aGlobalConfig[$key])) {
				$this->$key = $aGlobalConfig[$key]; 
			}
		}
		
		// request data		
		foreach ($this as $key => $value) {
			if (!empty($aGlobalConfig[$key])) {
				$this->$key = $aGlobalConfig[$key];
			}
		}		
		$this->aRequest = array_merge($_POST, $_GET);
		$this->aRequest["aFiles"] = $_FILES;
		
		// parse URI
		$aURI = explode("/", str_replace("/web_framework", "", $_SERVER["REQUEST_URI"]));
		array_shift($aURI);
		
		if (!empty($aURI[0])) {
			$this->aRequest["alias"] = array_shift($aURI);
		} else {
			$this->aRequest["alias"] = $aGlobalConfig["defaultAlias"];
			$this->aRequest["command"] = $aGlobalConfig["defaultCommand"];
		}
		if (!empty($aURI[0])) {
			$this->aRequest["command"] = "cmd_" . array_shift($aURI);
		} else if (!empty($this->aRequest["command"])) { // command may be set in $_POST
			$this->aRequest["command"] = "cmd_" . $this->aRequest["command"];
		}
		
		for ($i = 0; $i < count($aURI); $i++) {
			if (!empty($aURI[$i + 1])) {
				$this->aRequest[$aURI[$i]] = $aURI[++$i];
			}
		}
		
		// block commands
		if (!empty($this->aRequest["block"])) {
			foreach ($this->aRequest["block"] as $blockPageId => &$aBlock) {
				$aBlock["command"] = "cmd_" . $aBlock["command"];
			}
		}
		
		$this->alias = $this->aRequest["alias"];
		
	}
	
	public function makeSelect($aOptions, $textKey, $valueKey = null, $aSelectedValue = null) {
		
		
		$strOptions = "";
		
		if (!empty($aSelectedValue) && !is_array($aSelectedValue)) {
			$aSelectedValue = array($aSelectedValue);
		}
		
		$valueKey = empty($valueKey) ? $textKey : $valueKey;
		
		foreach ($aOptions as $option) {			
			$strOptions .= "<option "; 		
			if (!empty($aSelectedValue) && in_array($option[$valueKey], $aSelectedValue)) {				
				$strOptions .= "selected ";
			}
			$strOptions .= "value='" . $option[$valueKey] . "'";
			$strOptions .= ">" . $option[$textKey] . "</option>";
		}
		
		return $strOptions;
		
	}
	public function makeURL($alias) {
		
		return "http://" . NDD_WEB_ROOT . "/" . $alias;
		
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
	
	public static function raiseMessage($strMessage, $type = MSG_TYPE_INFO) {
	
		$_SESSION["aMessage"][$type][] = $strMessage;
	
	}
	
}

?>
<?php

require_once PATH_LIB . "/block.php";

class User_Block_Login extends Block 
{
    public function init()
    {
        $this->aMessages = Output::getMessages();
    }    
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
		
		$this->component = "user";
		if (empty($_SESSION["user_id"])) {
			$this->template = "login.html.php";
			$this->action = "login";
		} else {
			$this->template = "logout.html.php";
			$this->username = $_SESSION["username"];
			$this->action = "logout";
		}
		
		include $this->templateDirectory . $this->template;
	}
}

?>
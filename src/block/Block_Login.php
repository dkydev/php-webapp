<?php

require_once NDD_PATH_SRC . "/DAO/DAO_User.php";

class Block_Login extends Block {	
	
	function __construct() {
	
		$this->defaultCommand = "cmd_view";
	
	}
	
	function cmd_view() {
		
		if (empty($_SESSION["userId"])) {
			$this->template = "template_login.php";
			$this->pageTitle = "Login";
		} else {
			$this->template = "template_logout.php";
			$this->pageTitle = "Logout";
			$this->username = $_SESSION["username"];
		}
	}
	
	function cmd_login() {
	
		//login
		//DB::debug(true);
		if (!empty($this->aRequest["username"]) && !empty($this->aRequest["password"])) {
						
			$DAO_User = new DAO_User();
			$do_user = $DAO_User->login($this->aRequest["username"], $this->aRequest["password"]);
			
			if (!empty($do_user["user_id"])) {
				
				$_SESSION["userId"] 	= $do_user["user_id"];
				$_SESSION["username"] 	= $do_user["username"];
				$_SESSION["aGroup"] 	= $DAO_User->getUserGroups($do_user["user_id"]);
				
				//$output->raiseMessage("You are now logged in as " . $do_user["username"] . ".", MSG_TYPE_SUCCESS);
			
			} else {
				
				//$output->raiseMessage("Username or password incorrect.", MSG_TYPE_DANGER);
				
			}
			
		}
		
		header("Location: /" . $this->aRequest["alias"]);
		exit();
		
	}
	
	function cmd_logout() {
		
		//logout
		
		session_destroy();
		session_start();
		//$output->raiseMessage("You are now logged out.", "success");
	
		header("Location: /" . $this->aRequest["alias"]);
		exit();
		
	}
	
}

?>
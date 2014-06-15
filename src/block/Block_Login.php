<?php

require_once NDD_PATH_SRC . "/DAO/DAO_User.php";

class Block_Login extends Block {	
	
	function __construct() {
	
		$this->defaultCommand = "cmd_view";
	
	}
	
	function cmd_view(&$input, &$output) {
			
		if (empty($_SESSION["userId"])) {
			$this->template = "template_login.php";
			$output->pageTitle = "Login";
		} else {
			$this->template = "template_logout.php";
			$output->pageTitle = "Logout";
			$output->username = $_SESSION["username"];
		}
	}
	
	function cmd_login(&$input, &$output) {
	
		//login
		DB::debug(true);
		if (!empty($input->aRequest["username"]) && !empty($input->aRequest["password"])) {
						
			$DAO_User = new DAO_User();
			$do_user = $DAO_User->login($input->aRequest["username"], $input->aRequest["password"]);
			
			if (!empty($do_user)) {
				$_SESSION["userId"] = $do_user["user_id"];
				$_SESSION["username"] = $do_user["username"];
				$_SESSION["aGroup"] = $DAO_User->getUserGroups($do_user["user_id"]);
				$output->raiseMessage("You are now logged in as " . $do_user["username"] . "." . "<pre>" . print_r($_SESSION["aGroup"]) . "</pre>", MSG_TYPE_SUCCESS);
			} else {
				$output->raiseMessage("Username or password incorrect.", MSG_TYPE_DANGER);
			}
			
		}
		
		header("Location: " . $_SERVER["REQUEST_URI"]);
	
	}
	
	function cmd_logout(&$input, &$output) {
	
		//logout
		
		session_destroy();
		session_start();
		$output->raiseMessage("You are now logged out.", "success");
	
		header("Location: " . $_SERVER["REQUEST_URI"]);
	
	}
	
}

?>
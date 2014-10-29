<?php

require_once PATH_LIB . "/Controller.php";
require_once PATH_COM . "/user/model/User.php";

class User_Controller extends Controller
{
	public function action_login($request)
	{
	    $username = $request->get("username");
	    $password = $request->get("password");
		if (empty($username) || empty($password)) {
			Output::raiseMessage("Email and Password are required.", MSG_TYPE_ERROR);
			return;
		}
		$UserModel = new User_Model();
		$aUser = $UserModel->login($username, $password);
		if (!empty($aUser["user_id"])) {
			$_SESSION["user_id"] 	= $aUser["user_id"];
			$_SESSION["username"] 	= $aUser["username"];
			$_SESSION["aGroupId"] 	= implode(",", $UserModel->getUserGroupIds($aUser["user_id"]));
			Output::raiseMessage("You are now logged in as " . $aUser["username"] . ".", MSG_TYPE_SUCCESS);
		} else {
			Output::raiseMessage("Email or Password incorrect.", MSG_TYPE_ERROR);
		}
	}
	public function action_logout($request)
	{
		Session::destroy();
		Session::init();
		Output::raiseMessage("You are now logged out.", MSG_TYPE_SUCCESS);
		header("Location: /"); exit();
	}
	public function action_insert($request)
	{
	    
	}
	public function action_update($request)
	{
	    
	}
	public function action_delete($request)
	{
	    
	}
}

?>
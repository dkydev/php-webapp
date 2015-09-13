<?php

require_once DKY_PATH_LIB . "/dky/HTTP.php";
require_once DKY_PATH_LIB . "/dky/Component.php";
require_once DKY_PATH_COM . "/user/model/User.php";
require_once DKY_PATH_COM . "/user/block/Login.php";
require_once DKY_PATH_COM . "/user/block/Logout.php";

class User_Component extends DKY_Component
{
    public function __construct()
    {
        parent::__construct();
        $this->_defaultAction = "view_login";
    }
    
    public function action_view_login($request)
    {
        $output = new DKY_Output();
        $output->template = DKY_PATH_ROOT . "/template/login.html.php";
        
        if (empty($_SESSION["user_id"])) {
            $loginBlock = new User_Block_Login($request);
            $output->addBlock($loginBlock, "main");
        } else {
            $logoutBlock = new User_Block_Logout($request);
            $output->addBlock($logoutBlock, "main");
        }
        
        $output->processRequest($request);
        $output->display();
    }
    
    public function action_login($request)
    {
        $username = $request->get("username");
        $password = $request->get("password");
        if (empty($username) || empty($password)) {
            DKY_Output::raiseMessage("Email and Password are required.", DKY_MSG_ERROR);
            DKY_HTTP::redirect("/");
        }
        $UserModel = new User_Model();
        $aUser = $UserModel->login($username, $password);
        if (!empty($aUser["user_id"])) {
            $_SESSION["user_id"] = $aUser["user_id"];
            $_SESSION["username"] = $aUser["username"];
            $_SESSION["aGroupId"] = implode(",", $UserModel->getUserGroupIds($aUser["user_id"]));
            DKY_Output::raiseMessage("You are now logged in as " . $aUser["username"] . ".", DKY_MSG_SUCCESS);
        } else {
            DKY_Output::raiseMessage("Email or Password incorrect.", DKY_MSG_ERROR);
        }
        DKY_HTTP::redirect("/");
    }
    
    public function action_logout($request)
    {
        DKY_SessionHandler::destroySession();
        DKY_SessionHandler::startSession();
        DKY_Output::raiseMessage("You are now logged out.", DKY_MSG_SUCCESS);
        DKY_HTTP::redirect("/");
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
<?php

require_once DKY_PATH_LIB . "/dky/Output.php";
require_once DKY_PATH_LIB . "/dky/Block.php";

class User_Block_Login extends DKY_Block
{
    public function __construct($request)
    {
        parent::__construct($request);
        $this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
        $this->template = "login.html.php";
        $this->component = "user";
        $this->action = "login";
        $this->aMessages = DKY_Output::getMessages();        
    }
}

?>
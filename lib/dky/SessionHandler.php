<?php

class DKY_SessionHandler // implements SessionHandlerInterface
{
    public static function startSession()
    {
        session_start();
    }
    
    public static function destroySession()
    {
        session_destroy();
    }
    
    public static function cachePermissions()
    {
        if (empty($_SESSION["user_id"])) {
            $_SESSION["aGroupId"] = "2"; // public
        }
    }
}

?>
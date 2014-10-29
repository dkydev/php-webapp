<?php

class Session 
{    
    public static function init()
    {
        session_start();
        if (empty($_SESSION["user_id"])) {
            $_SESSION["aGroupId"] = "2"; // public
        }
    }
    public static function destroy()
    {
        session_destroy();
    }
}

?>
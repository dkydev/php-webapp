<?php

require_once "Define.php";
require_once "Config.php";
require_once "db/DB.php";
require_once "Log.php";
require_once "SessionHandler.php";
require_once "RequestHandler.php";
require_once "ComponentHandler.php";
require_once "Output.php";

require_once DKY_PATH_LIB . "/HexDump.php";

class DKY_FrontController
{
    public static function run()
    {
        // TODO: Filters.. exceptions..?
        if ($_SERVER["REQUEST_URI"] == "/favicon.ico") {
            DKY_HTTP::redirect("/www/favicon.ico");
        }
        
        DKY_Config::initialize();
        DKY_DB::initialize(array(
                "host" => DKY_Config::get("db_host"),
                "database" => DKY_Config::get("db_database"),
                "username" => DKY_Config::get("db_username"),
                "password" => DKY_Config::get("db_password") 
        ));
        DKY_Log::initialize(array(
                "path" => DKY_Config::get("log_path") 
        ));
        
        DKY_Log::i("REQUEST: " . $_SERVER["REQUEST_URI"]);
        
        DKY_SessionHandler::startSession();
        DKY_SessionHandler::cachePermissions();
        
        //$strLogTail = "<div style='font:10px sans-serif;height:100px;overflow:auto;'>" . implode("<br />", DKY_Log::tail(20)) . "</div>";
        //DKY_Output::raiseMessage($strLogTail, DKY_MSG_INFO);
        
        DKY_RequestHandler::process();
    
    }
}

?>
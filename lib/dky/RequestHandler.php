<?php

require_once "Request.php";
require_once "HTTP.php";

class DKY_RequestHandler
{
    private static $_request;
    
    public static function process()
    {
        $request = DKY_RequestHandler::getRequest();
        $component = DKY_ComponentHandler::getComponent($request->componentName);
        if (!empty($component)) {
            $component->run($request->actionName, $request);
        } else {
            header("HTTP/1.0 404 Not Found");
            DKY_HTTP::redirect("/" . DKY_Config::get("404_path"));
        }
    }
    
    public static function getRequest()
    {
        if (empty($request = DKY_RequestHandler::$_request)) {
            $request = new DKY_Request();
        }
        
        return $request;
    }
    
}

?>
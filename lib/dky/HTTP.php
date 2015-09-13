<?php

class DKY_HTTP
{
    public static function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
    
    public static function redirectParams($aParams)
    {
        // TODO: Build redirect url from parameters.
    }
    
    public static function makeURL($path, $component, $action, $aParams = null)
    {        
        $scheme = "http";
        $host = $_SERVER["HTTP_HOST"];
        $path = trim($path, "/");
        
        if (empty($aParams)) {
            $aParams = array();
        }
        if (!empty($action)) {
            $aParams = array("action" => $action) + $aParams;
        }
        if (!empty($component)) {
            $aParams = array("component" => $component) + $aParams;
        }
        
        return $scheme . "://" . $host . "/" . $path . "?" . http_build_query($aParams);
    }
}

?>
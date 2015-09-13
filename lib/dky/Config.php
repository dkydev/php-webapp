<?php

class DKY_Config
{
    private static $_aConfig;
    
    public static function initialize() 
    {
        DKY_Config::$_aConfig = array();
        require_once DKY_PATH_VAR . "/Config.php";
    }
    
    public static function get($key) 
    {
        return empty(DKY_Config::$_aConfig[$key]) ? null : DKY_Config::$_aConfig[$key];
    }
    
    public static function set($key, $value) 
    {
        DKY_Config::$_aConfig[$key] = $value;
    }
    
    public static function save() 
    {
        // save the config to a file
    }
}

?>
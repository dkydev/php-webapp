<?php

class Config {
    
    private static $aConfig;
    
    public static function init() 
    {        
        Config::$aConfig = array();
        require_once PATH_VAR . "/Configuration.php";
    }
    
    public static function get($key) 
    {        
        return empty(Config::$aConfig[$key]) ? null : Config::$aConfig[$key];        
    }
    
    public static function set($key, $value) 
    {        
        Config::$aConfig[$key] = $value;        
    }
    
    public static function save() 
    {        
        // save the config to a file        
    }    
}

?>
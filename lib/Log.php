<?php

class Log {
    
    private static $_path;
    
    public static function init() 
    {
        if (Config::get("log_enabled")) {            
            Log::$_path = Config::get("log_path");
            
            if (!file_exists(Log::$_path)) {
                $logFile = fopen(Log::$_path, 'w');
                fclose($logFile);
            }            
        }
    }
    
    public static function l($message, $type) 
    {
        $message = "[" . $type . "] (" . time() . ") " . date("d-m-Y H:i:s", time()) . " :: " . $message . "\n";        
        file_put_contents(LOG::$_path, $message, FILE_APPEND);
    }
    
    public static function d($message)
    {
        Log::l($message, LOG_TYPE_DEBUG);
    }
    
}

?>
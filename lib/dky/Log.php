<?php

require_once DKY_PATH_LIB . "/HexDump.php";

class DKY_Log
{
    private static $_bInitialized;
    private static $_path;
    
    /**
     * Initialize the log handler.
     *
     * @param array $aParams
     *            An array of log handler parameters.
     */
    public static function initialize($aParams)
    {
        DKY_Log::$_path = $aParams["path"];
        
        set_error_handler("DKY_Log::_errorHandler");
        
        if (!empty(DKY_Log::$_path)) {
            if (!file_exists(DKY_Log::$_path)) {
                $logFile = fopen(DKY_Log::$_path, 'w');
                fclose($logFile);
            }
            DKY_Log::$_bInitialized = true;
        }
    }
    
    /**
     * Append a message to the system log.
     *
     * @param string $message
     *            The string to append to the system log.
     * @param string $type
     *            The type of message to log, for filtering purposes.
     */
    public static function l($message, $type = DKY_MSG_INFO)
    {
        if (DKY_Log::$_bInitialized) {
            if (is_array($message)) {
                ob_start();
                print_r($message);
                $message = ob_get_clean();
            }            
            $message = "[" . $type . "] (" . time() . ") " . date("d-m-Y H:i:s", time()) . " :: " . $message . PHP_EOL;
            file_put_contents(DKY_Log::$_path, $message, FILE_APPEND);
        }
    }
    
    /**
     * Short-hand function to log a debug message to the system log.
     *
     * @param string $message            
     */
    public static function d($message)
    {
        DKY_Log::l($message, DKY_LOG_DEBUG);
    }
    
    /**
     * Short-hand function to log an error message to the system log.
     *
     * @param string $message            
     */
    public static function e($message)
    {
        DKY_Log::l($message, DKY_LOG_ERROR);
    }
    
    /**
     * Short-hand function to log a info message to the system log.
     *
     * @param string $message            
     */
    public static function i($message)
    {
        DKY_Log::l($message, DKY_LOG_INFO);
    }
    
    public static function tail($lines = 10)
    {
        $aLines = array();
        $logFile = fopen(DKY_LOG::$_path, "r");
        $cursor = -2;
        for($i = 0; $i < $lines; $i++) {
            $line = "";
            while (fseek($logFile, $cursor--, SEEK_END) !== -1) {
                $char = fgetc($logFile);
                if ($char == "\n")
                    break;
                $line = $char . $line;
            }
            $aLines[] = $line;
        }
        fclose($logFile);
        return $aLines;
    }
    
    public static function clear()
    {
        $logFile = fopen(DKY_Log::$_path, 'w');
        fclose($logFile);
    }
    
    public static function _errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        DKY_Log::l($errfile . " " . $errstr . " (line " . $errline . ")", DKY_LOG_ERROR);
    }
}

?>
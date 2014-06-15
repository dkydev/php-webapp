<?php 

define("NDD_LOG_DEBUG", 		"debug");
define("NDD_LOG_WARNING", 		"warning");
define("NDD_LOG_INFO", 			"info");
define("NDD_LOG_ERROR", 		"error");

class LOG {
	
	public static $logFilePath;
	
	public static function init($aGlobalConfig) {
		
		if ($aGlobalConfig["logEnabled"]) {
			
			LOG::$logFilePath = NDD_PATH_ROOT . "/" . $aGlobalConfig["logFilePath"];
			
			if (!file_exists(LOG::$logFilePath)) {
				$logFile = fopen(LOG::$logFilePath, 'w');
				fclose($logFile);	
			}
			
		}
		
	}
	
	public static function appendLog($message, $type = NDD_LOG_DEBUG) {
		
		$message = "[" . $type . "] (" . time() . ") " . date("d-m-Y H:i:s", time()) . " :: " . $message . "\n";
		
		file_put_contents(LOG::$logFilePath, $message, FILE_APPEND);
		
	}
	
}

?>
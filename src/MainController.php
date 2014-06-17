<?php

require_once NDD_PATH_SRC . "/DB.php";
require_once NDD_PATH_SRC . "/LOG.php";
require_once NDD_PATH_SRC . "/Output.php";
require_once NDD_PATH_SRC . "/Page.php";

class MainController {
	
	public static function run() {
	    
		session_start();
		
		$aGlobalConfig = array(
					
				"logEnabled"				=> "1",
				"logFilePath"				=> "var/log.txt",
					
				"defaultAlias" 				=> "login",
				"defaultCommand" 			=> "view",
					
		);
		
		DB::init($aGlobalConfig);
		LOG::init($aGlobalConfig);		
			
		$output = new Output($aGlobalConfig);
		
		$output->page = Page::getPage($output);		
		
		$output->display();
		
	}
	
}


?>
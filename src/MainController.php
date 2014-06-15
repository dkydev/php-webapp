<?php

require_once NDD_PATH_SRC . "/DB.php";
require_once NDD_PATH_SRC . "/LOG.php";
require_once NDD_PATH_SRC . "/Input.php";
require_once NDD_PATH_SRC . "/Output.php";
require_once NDD_PATH_SRC . "/Page.php";

class MainController {
	
	public static function run() {
	    
		session_start();
		
		$aGlobalConfig = array(
					
				"logEnabled"				=> "1",
				"logFilePath"				=> "var/log.txt",
					
				// input
				"defaultPage" 				=> "login",
				"defaultCommand" 			=> "view",
				
				// output
					
		);
		
		DB::init($aGlobalConfig);
		LOG::init($aGlobalConfig);
		
		
		$input = new Input($aGlobalConfig);		
		$output = new Output($aGlobalConfig);
		
		$output->page = Page::getPage($input, $output);
		//$module->executeCommand($input, $output);		
		
		$output->display();
		
	}
	
}


?>
<?php
	
	define("NDD_PATH_ROOT", realpath(__DIR__ . "/.."));
	define("NDD_PATH_SRC", NDD_PATH_ROOT . "/src");
	define("NDD_PATH_WWW", NDD_PATH_ROOT . "/www");
	
	define("NDD_WEB_ROOT", $_SERVER["SERVER_NAME"]);

	require_once NDD_PATH_SRC . '/MainController.php';
	
	MainController::run();
	

?>
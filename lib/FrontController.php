<?php

require_once 'Define.php';
require_once 'Session.php';
require_once "Config.php";
require_once "DB.php";
require_once "Log.php";
require_once "Request.php";
require_once "Output.php";

class FrontController {
    
    public static function run() 
    {        
        Session     ::init();
        Config      ::init();
        DB          ::init();
        Log         ::init();
                
        $request = new Request();
        $request->process();
        
        $output = new Output($request);
        $output->display();
    }    
}

?>
<?php

require_once DKY_PATH_LIB . "/dky/HTTP.php";
require_once DKY_PATH_LIB . "/dky/Component.php";
require_once DKY_PATH_COM . "/static/model/Static.php";
require_once DKY_PATH_COM . "/static/block/Static.php";

class Static_Component extends DKY_Component
{
    public function __construct()
    {
        parent::__construct();
        $this->_defaultAction = "view";
    }
    
    public function action_view($request)
    {
        $output = new DKY_Output();
        $output->template = DKY_PATH_ROOT . "/template/master.html.php";

        $staticBlock = new Static_Block($request);
        $output->addBlock($staticBlock, "main");
        
        $output->processRequest($request);
        $output->display();
    }    
}

?>
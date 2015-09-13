<?php

require_once DKY_PATH_LIB . "/dky/Block.php";

class Static_Block extends DKY_Block
{
    public function __construct($request)
    {
        parent::__construct($request);
        $this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
        $this->template = "blank.html.php";
    }
}

?>
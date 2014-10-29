<?php

class Block {
    
    // block
    public $block_id;
    public $component_name;
    public $block_name;
    public $block_title;
    public $block_description;
    public $position;
    public $order;
    public $exclusive;
    //
    
    public $template;
    public $action;
    
    public $request;
    
    public function __construct($aBlock, $request)
    {
        foreach ($aBlock as $key => $value) {
            $this->$key = $value;
        }
        $this->request = $request;
        $this->init();
    }
    public function init()
    {
        
    }
    public function render()
    {
        include $this->template;    
    }
}

?>
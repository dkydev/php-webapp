<?php

class DKY_Block
{
    public $block_id;
    public $component_name;
    public $block_name;
    public $block_title;
    public $description;
    public $position;
    public $order;
    public $item_exclusive;
    public $group_exclusive;
    
    public $templateDirectory;
    public $template;
    
    public function __construct($request)
    {
    }
    
    public function setFrom($aBlock)
    {
        foreach ($aBlock as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function render()
    {
        include $this->templateDirectory . $this->template;
    }
}

?>
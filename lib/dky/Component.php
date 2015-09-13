<?php

class DKY_Component
{
    protected $_defaultAction;
    
    public $aErrors;
    
    public function __construct()
    {
        $this->_defaultAction = "list";
        
        $this->aErrors = array();
    }
    
    public function run($action, $request)
    {
        if (empty($action)) {
            $action = $this->_defaultAction;
        }
        $action = "action_" . $action;
        $this->$action($request);
    }
}

?>
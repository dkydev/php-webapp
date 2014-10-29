<?php

class Request {
    
    public $aParams;    
    public $aFile;
    public $aURL;
    
    public $component;
    public $action;
    
    public function __construct() { }
    
    public function process() 
    {        
        $this->aParams = array_merge($_POST, $_GET);
        $this->aFile   = $_FILES;
        
        $this->aURL = parse_url($_SERVER["REQUEST_URI"]);
        
        $this->aURL["path"] = trim($this->aURL["path"], "/");
        if (empty($this->aURL["path"])) {
            $this->aURL["path"] = Config::get("default_page");
        }
         
        $this->controller   = $this->get("component");
        $this->action       = $this->get("action");
         
        if (!empty($this->controller) && !empty($this->action)) {
            $controllerName         = ucfirst($this->controller);
            $controllerClass         = $controllerName . "_Controller";
            $controllerAction         = "action_" . $this->action;
            require_once PATH_COM . "/" . $this->controller . "/controller/" . $controllerName . ".php";
            $controller = new $controllerClass();
            if ($controller->validate($this)) {
                $controller->$controllerAction($this);
                header("Location: /" . $this->aURL["path"]);
                exit();
            }
         }
         //$this->aPage = preg_split("@/@", $path, NULL, PREG_SPLIT_NO_EMPTY);        
    }
    public function get($key)
    {
        return empty($this->aParams[$key]) ? null : $this->aParams[$key];
    }
    
}
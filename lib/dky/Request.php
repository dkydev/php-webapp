<?php

require_once "Item.php";

class DKY_Request
{
    public $requestPath;
    public $aURL;
    public $aParams;
    
    public $componentName;
    public $actionName;
    public $aFile;
    
    public $item;
    
    public function __construct()
    {
        $this->aParams = array_merge($_GET, $_POST);
        $this->aFile = $_FILES;
        $this->aURL = parse_url($_SERVER["REQUEST_URI"]);
        
        // Strip slashes from path.
        $this->aURL["path"] = trim($this->aURL["path"], "/");
        
        // Use default path if not specified.
        if (empty($this->aURL["path"])) {
            $this->aURL["path"] = DKY_Config::get("default_path");
        }
        
        // Get item from request path.
        $this->item = DKY_Item::getItemByPath($this->aURL["path"]);
        // TODO: Handle no item..?
        
        // Get component from POST/GET.
        $this->componentName = $this->get("component");
        $this->actionName = $this->get("action");
        
        // Use item component/action if not specified in request.
        if (empty($this->componentName)) {
            $this->componentName = $this->item["component"];
        }
        if (empty($this->actionName)) {
            $this->actionName = $this->item["action"];
        }
    }
    
    /**
     * Get the request parameter associated with the specified key.
     *
     * @param string $key            
     * @return The value of the parameter if the key exists. Otherwise NULL is returned.
     */
    public function get($key)
    {
        return empty($this->aParams[$key]) ? null : $this->aParams[$key];
    }

}

?>
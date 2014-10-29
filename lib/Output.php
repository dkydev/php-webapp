<?php

require_once "Block.php";

class Output 
{    
    public $request;
    public $aPosition;
    public $aBlocks;
    public $aPage;
    public $template;
    public $pageTitle;
    
    public function __construct($request)
    {
        if (empty($request)) return;
        
        $this->request = $request;
        
        $this->aPage = $this->getPageByPath($this->request->aURL["path"]);
        $this->aBlocks = $this->getBlocks($this->aPage["page_id"]);
        
        if (!empty($this->aPage["page_id"])) {
            $this->template = PATH_ROOT . "/template/" . $this->aPage["template"] . ".html.php";
            $this->pageTitle = $this->aPage["title"];
        } else {
            Output::raiseMessage("Page Not Found", MSG_TYPE_ERROR);
            $this->template = PATH_ROOT . "/template/master.html.php";
            $this->pageTitle = "Page Not Found";
        }
    }
    
    public function getPageByPath($strPath)
    {
        $sql = "SELECT * FROM `page`
                LEFT JOIN `page_group`    ON `page_group`.`page_id` = `page`.`page_id`
                WHERE `page`.`path` = :path AND `page_group`.`group_id` IN (:aGroupId)";
        $sth = DB::query($sql);
        $sth->bind("path", $strPath);
        $sth->bind("aGroupId", $_SESSION["aGroupId"]);
        $sth->execute();
        return $sth->fetch();
    }
    
    public function getBlocks($pageId)
    {
        $sql = "SELECT * FROM `block`
                LEFT JOIN `block_page`     ON `block_page`.`block_id`      = `block`.`block_id`
                LEFT JOIN `block_group` ON `block_group`.`block_id`     = `block`.`block_id`
                WHERE ((`block`.`exclusive` = 0 AND `block_page`.`page_id` = :page_id) OR (`block`.`exclusive` = 1 AND `block_page`.`page_id` IS NULL))
                AND `block_group`.`group_id` IN (:aGroupId);";
        $sth = DB::query($sql);
        $sth->bind("page_id", $pageId);
        $sth->bind("aGroupId", $_SESSION["aGroupId"]);
        $sth->execute();
        
        $aBlocks = array();
        while ($aBlock = $sth->fetch()) {
            // Construct blocks.
            $aBlocks[] = $aBlock;
            $componentName = $aBlock["component_name"];
            $blockName = $aBlock["block_name"];
            require_once PATH_COM . "/" . $componentName . "/block/" . ucfirst($blockName) . ".php";
            $blockClass = ucfirst($componentName) . "_Block_" . ucfirst($blockName);
            $block = new $blockClass($aBlock, $this->request);
            $this->aPosition[$block->position][] = $block;
        }
        return $aBlocks;
    }
    
    public function display()
    {    
        header('Content-Type: text/html');                
        include $this->template;
    }
    
    public static function makeLink($url, $blockPageId, $key, $value)
    {
        return $url . "/?b[" . $blockPageId . "][" . $key . "]=" . $value;
    }
    
    public static function makeSelect($aValues, $aSelectedValues = null)
    {
        $strOptions = "";
        
        if (!empty($aSelectedValues) && !is_array($aSelectedValues)) {
            $aSelectedValues = array($aSelectedValues);
        }
        
        foreach ($aValues as $key => $label) {
            $strOptions .= "<option ";
            if (!empty($aSelectedValues) && in_array($key, $aSelectedValues)) {
                $strOptions .= "selected ";
            }
            $strOptions .= "value='" . $key . "'";
            $strOptions .= ">" . $label . "</option>";
        }
        
        echo $strOptions;
    }
    
    public static function makeURL($alias = "", $action = "", $aBlockParams = null, $blockPageId = null)
    {
        if (empty($alias)) {
            $alias = Output::$instance->request->alias;
        }
        if (empty($action)) {
            $action = Output::$instance->request->action;
        }
        $strBlockParam = "";
        foreach (Output::$instance->request->aURIParams as $key => $value) {
            $strBlockParam .= $key . "/" . $value . "/";
        }
        if (!empty($aBlockParams) && !empty($blockPageId)) {
            if ($blockPageId == Output::$instance->aPage["main_block_page_id"]) {
                foreach ($aBlockParams as $key => $value) {
                    $strBlockParam .= $key . "/" . $value . "/";
                }
            } else {
                $strBlockParam .= "?d=" . base64_encode(serialize(array($blockPageId => $aBlockParams)));
            }
        }
        
        return "http://" . WEB_ROOT . "/" . $alias . "/" . $action . "/" . $strBlockParam;
    }
    
    public static function raiseMessage($strMessage, $type = MSG_TYPE_INFO)
    {
        $_SESSION["aMessages"][$type][] = $strMessage;
    }
    
    public static function getMessages()
    {
        $aMessages = array();
        if (!empty($_SESSION["aMessages"])) {
            $aMessages =  $_SESSION["aMessages"];
            unset($_SESSION["aMessages"]);
        }        
        return $aMessages;
    }
}

?>

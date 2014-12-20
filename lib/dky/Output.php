<?php

require_once "Block.php";

class DKY_Output
{
    private $aBlocks;
    public $template;
    public $item;
    public $pageTitle;
    
    public function __construct()
    {
    }
    
    /**
     *
     * @param request $request            
     */
    public function processRequest($request)
    {
        if (!empty($request->item)) {
            // TODO: load item blocks
        }
        
        if (empty($this->pageTitle) && !empty($request->item->title)) {
            $this->pageTitle = $request->item->title;
        }
        
        /*
         * DKY_Output::raiseMessage("Page Not Found", DKY_MSG_ERROR); $this->template = DKY_PATH_ROOT . "/template/master.html.php"; $this->pageTitle = "Page Not Found";
         */
    }
    
    public function addBlock($block, $position)
    {
        if (empty($this->aBlocks[$position])) {
            $this->aBlocks[$position] = array();
        }
        $this->aBlocks[$position][] = $block;
    }
    
    private function loadBlocks($itemId)
    {
        $sql = "SELECT * FROM block
                LEFT JOIN `block_item` ON `block_item`.`block_id` = block.`block_id`
                LEFT JOIN `block_group` ON `block_group`.`block_id` = block.`block_id`
                WHERE
                ((`block`.`item_exclusive` = 0 AND `block_item`.`item_id` = :itemId)
                OR
                (`block`.`item_exclusive` = 1 AND `block_item`.`item_id` IS NULL))
                AND
                ((`block`.`group_exclusive` = 0 AND `block_group`.`group_id` IN (:aGroupId))
                OR
                (`block`.`group_exclusive` = 1 AND (`block_group`.`group_id` IS NULL OR `block_group`.`group_id` NOT IN (:aGroupId))))
                GROUP BY `block`.`block_id`;";
        $sth = DKY_DB::query($sql);
        $sth->bind("itemId", $itemId);
        $sth->bind("aGroupId", $_SESSION["aGroupId"]);
        $sth->execute();
        
        while ($aBlock = $sth->fetch()) {
            $block = $this->getBlock($aBlock["block_name"], $aBlock["component_name"]);
            if (!empty($block)) {
                $block->init($aBlock, $this->_request);
                $this->aBlocks[$block->position][] = $block;
            }
        }
    }
    
    private function getBlock($block, $component)
    {
        $block = ucfirst($block);
        $blockClass = ucfirst($component) . "_Block_" . $block;
        if (@include_once (PATH_COM . "/" . $component . "/block/" . $block . ".php")) {
            return new $blockClass();
        } else {
            return null;
        }
    }
    
    public function display()
    {
        header('Content-Type: text/html');
        include $this->template;
    }
    
    public static function getSelectOptions($aValues, $aSelectedValues = null)
    {
        $strOptions = "";
        
        if (!empty($aSelectedValues) && !is_array($aSelectedValues)) {
            $aSelectedValues = array(
                    $aSelectedValues 
            );
        }
        
        foreach ($aValues as $key => $label) {
            $strOptions .= "<option ";
            if (!empty($aSelectedValues) && in_array($key, $aSelectedValues)) {
                $strOptions .= "selected ";
            }
            $strOptions .= "value='" . $key . "'";
            $strOptions .= ">" . $label . "</option>";
        }
        
        return $strOptions;
    }
    
    public static function makeSelect($aValues, $aSelectedValues = null)
    {
        echo DKY_Output::getSelectOptions($aValues, $aSelectedValues);
    }
    
    public static function raiseMessage($strMessage, $type = DKY_MSG_INFO)
    {
        $_SESSION["aMessages"][$type][] = $strMessage;
    }
    
    public static function getMessages()
    {
        $aMessages = array();
        if (!empty($_SESSION["aMessages"])) {
            $aMessages = $_SESSION["aMessages"];
            unset($_SESSION["aMessages"]);
        }
        return $aMessages;
    }
}

?>

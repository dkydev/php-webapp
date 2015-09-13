<?php

require_once DKY_PATH_LIB . "/dky/Block.php";
require_once DKY_PATH_LIB . "/dky/Item.php";
require_once DKY_PATH_COM . "/user/model/User.php";

class Menu_Block_ItemEdit extends DKY_Block
{
    public function __construct($request)
    {
        parent::__construct($request);
        $this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
        $this->template = "itemEdit.html.php";
        
        $UserModel = new User_Model();
        
        $this->component = "menu";
        $itemId = $request->get("itemId");
        if (empty($itemId)) {
            $this->action = "insert";
        } else {
            $this->action = "update";
        }
        
        $this->aItemSelect = DKY_Item::getItems(null, true);
        
        if (empty($itemId) && !empty($_SESSION["aBlock"][$this->block_id]["itemId"])) {
            $itemId = $_SESSION["aBlock"][$this->block_id]["itemId"];
        }
        if (empty($itemId) || $this->action == "insert") {
            $this->action = "insert";
            $this->aItem = null;
            unset($_SESSION["aBlock"][$this->block_id]["itemId"]);
        } else {
            $_SESSION["aBlock"][$this->block_id]["itemId"] = $itemId;
            $this->aItem = DKY_Item::getItemById($itemId);
            $this->action = "update";
            unset($this->aItemSelect[$itemId]); // Can't select itself as a parent.
        }
        
        $this->aGroups = $UserModel->getGroups(true);
        
        $this->getItemsURL = DKY_HTTP::makeURL($request->aURL["path"], "menu", "get_items");
        $this->cancelURL = DKY_HTTP::makeURL($request->aURL["path"], "menu", "list_items");
    }
}

?>
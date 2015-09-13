<?php

require_once DKY_PATH_LIB . "/dky/Block.php";
require_once DKY_PATH_LIB . "/dky/Pager.php";
require_once DKY_PATH_LIB . "/dky/Item.php";

class Menu_Block_ItemList extends DKY_Block
{
    public function __construct($request)
    {
        parent::__construct($request);
        $this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
        
        $this->template = "itemList.html.php";
        
        $pageNum = $request->get("page");
        if (empty($pageNum)) {
            if (!empty($_SESSION["aBlock"][$this->block_id]["page"])) {
                $pageNum = $_SESSION["aBlock"][$this->block_id]["page"];
            } else {
                $pageNum = 1;
            }
        }
        $_SESSION["aBlock"][$this->block_id]["page"] = $pageNum;
        
        $sth = DKY_Item::buildItemQuery();
        $this->aPagedData = DKY_Pager::getPagedData($sth, $pageNum, 10, 3);
        
        $this->editURL = DKY_HTTP::makeURL($request->aURL["path"], "menu", "edit_item");
        $this->deleteURL = DKY_HTTP::makeURL($request->aURL["path"], "menu", "delete_item");
    }
}

?>
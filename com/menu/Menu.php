<?php

require_once DKY_PATH_LIB . "/dky/Component.php";
require_once DKY_PATH_LIB . "/dky/item.php";
require_once DKY_PATH_COM . "/menu/block/ItemEdit.php";
require_once DKY_PATH_COM . "/menu/block/ItemList.php";

class Menu_Component extends DKY_Component
{
    public function __construct()
    {
        parent::__construct();
        $this->_defaultAction = "list_items";
    }
    
    public function action_list_items($request)
    {
        $output = new DKY_Output();
        $output->template = DKY_PATH_ROOT . "/template/master.html.php";
        $output->pageTitle = "Item List";
        
        $listBlock = new Menu_Block_ItemList($request);
        
        if (!empty($request->get("itemId"))) {
            $editBlock = new Menu_Block_ItemEdit($request);
            $output->addBlock($listBlock, "left");
            $output->addBlock($editBlock, "main");
        } else {
            $output->addBlock($listBlock, "main");
        }
        
        $output->processRequest($request);
        $output->display();
    }
    
    public function action_add_item($request)
    {
        $output = new DKY_Output();
        $output->template = DKY_PATH_ROOT . "/template/master.html.php";
        
        $editBlock = new Menu_Block_ItemEdit($request);
        $output->addBlock($editBlock, "main");
        
        $output->processRequest($request);
        $output->display();
    }
    
    public function action_edit_item($request)
    {
        $this->action_list_items($request);
    }
    
    public function action_insert_item($request)
    {
        $aItem = $request->get("item");
        $itemId = DKY_Item::insertitem($aItem);
        
        if (!empty($itemId)) {
            DKY_Output::raiseMessage("Item added successfully.", DKY_MSG_SUCCESS);
        } else {
            DKY_Output::raiseMessage("Item NOT added.", DKY_MSG_ERROR);
        }
        header("Location: ?itemId=" . $itemId);
        exit();
    }
    
    public function action_update_item($request)
    {
        $aItem = $request->get("item");
        $result = DKY_Item::updateitem($aItem);
        if (!empty($result)) {
            DKY_Output::raiseMessage("Item updated successfully.", DKY_MSG_SUCCESS);
        } else {
            DKY_Output::raiseMessage("Item NOT updated.", DKY_MSG_ERROR);
        }
        header("Location: ?itemId=" . $aItem["item_id"]);
        exit();
    }
    
    public function action_delete_item($request)
    {
        $itemId = $request->get("itemId");
        $result = DKY_Item::deleteitem($itemId);
        if (!empty($result)) {
            DKY_Output::raiseMessage("Item deleted successfully.", DKY_MSG_SUCCESS);
        } else {
            DKY_Output::raiseMessage("Item NOT deleted.", DKY_MSG_ERROR);
        }
        DKY_HTTP::redirect(DKY_HTTP::makeURL($request->aURL["path"], "menu", "list_items"));
    }
    
    public function action_get_items($request)
    {
        $aItems = DKY_Item::getItems(array(
                "parent_id" => $request->get("parentId") 
        ), true);
        $strOptions = DKY_Output::getSelectOptions($aItems);
        echo trim($strOptions);
        die();
        // hexdump($strOptions);
    }
}

?>
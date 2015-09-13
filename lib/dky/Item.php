<?php

require_once "db/DB.php";
require_once "NestedSet.php";

class DKY_Item
{
    public static function buildItemQuery($aQueryParams = null)
    {
        $do_item = DKY_DB::build("item");
        if (!empty($aQueryParams) && array_key_exists("parent_id", $aQueryParams)) {
            if (!empty($aQueryParams["parent_id"])) {
                $do_item->where("`parent_id` = :parentId", "parentId", $aQueryParams["parent_id"]);
            } else {
                $do_item->where("`parent_id` IS NULL");
            }
        }
        $do_item->orderBy("left_id");
        
        return $do_item;
    }
    
    public static function getItems($aQueryParams = null, $bShort = false, $key = "item_id")
    {
        $aItems = array();
        $do_item = DKY_Item::buildItemQuery($aQueryParams);
        $do_item->find();
        while ($aItem = $do_item->fetch()) {
            if ($bShort) {
                $aItems[$aItem[$key]] = $aItem["name"];
            } else {
                $aItems[$aItem[$key]] = $aItem;
            }
        }
        
        return $aItems;
    }
    
    public static function getItemByPath($path)
    {
        $aItem = DKY_DB::get("item", "path", $path);
        if (!empty($aItem) && is_array($aItem)) {
            $aItem["aGroupIds"] = DKY_Item::getItemGroupsById($aItem["item_id"]);
        }
        
        return $aItem;
    }
    
    public static function getItemById($itemId)
    {
        $aItem = DKY_DB::get("item", "item_id", $itemId);
        if (!empty($aItem) && is_array($aItem)) {
            $aItem["aGroupIds"] = DKY_Item::getItemGroupsById($itemId);
        }
        
        return $aItem;
    }
    
    public static function getItemGroupsById($itemId)
    {
        $aGroupIds = array();
        
        $do_item_group = DKY_DB::build("item_group");
        $do_item_group->where("`item_id` = :itemId", "itemId", $itemId);
        $do_item_group->find();
        while ($aGroupItem = $do_item_group->fetch()) {
            $aGroupIds[] = $aGroupItem["group_id"];
        }
        
        return $aGroupIds;
    }
    
    public static function insertItem($aItem)
    {
        $aGroupIds = $aItem["aGroupIds"];
        unset($aItem["aGroupIds"]);
        
        $itemSet = new DKY_NestedSet("item", "item_id");
        $itemId = $itemSet->insertNode($aItem);
        
        if (!empty($itemId)) {
            if (!empty($aGroupIds)) {
                DKY_Item::insertItemGroups($itemId, $aGroupIds);
            }
        }
        
        return $itemId;
    }
    
    public static function updateItem($aItem)
    {
        if (empty($aItem["item_id"]))
            return false;
        
        $aGroupIds = $aItem["aGroupIds"];
        unset($aItem["aGroupIds"]);
        
        $itemSet = new DKY_NestedSet("item", "item_id");
        $success = $itemSet->updateNode($aItem);
        
        if (!empty($success)) {
            if (!empty($aGroupIds)) {
                DKY_Item::deleteItemGroups($aItem["item_id"]);
                DKY_Item::insertItemGroups($aItem["item_id"], $aGroupIds);
            }
        }
        
        return $success;
    }
    
    public static function insertItemGroups($itemId, $aGroupIds)
    {
        foreach ($aGroupIds as $groupId) {
            $do_item_group = DKY_DB::build("item_group");
            $do_item_group->insert(array(
                    "group_id" => $groupId,
                    "item_id" => $itemId
            ));
        }
        
        return true;
    }
    
    public static function deleteItem($itemId)
    {        
        $itemSet = new DKY_NestedSet("item", "item_id");
        
        $success = $itemSet->deleteNode($itemId);
        
        if (!empty($success)) {
            DKY_Item::deleteItemGroups($itemId);
        }
        
        return $success;
    }
    
    public static function deleteItemGroups($itemId)
    {
        $do_item_group = DKY_DB::build("item_group");
        $do_item_group->where("`item_id` = :itemId", "itemId", $itemId);
        
        return $do_item_group->delete();
    }
}

?>
<?php

require_once PATH_LIB . "/NestedSet.php";

class Menu_Model
{
    public function buildMenuItemQuery($aQueryParams = null)
    {
        $sth = DB::query("SELECT * FROM `menu_item`;");
        return $sth;
    }	
	public function getMenuItemById($menuItemId)
	{
	    $aMenuItem = DB::get("menu_item", "menu_item_id", $menuItemId);
	    $sth = DB::query("SELECT * FROM `menu_item_group` WHERE `menu_item_id` = :menuItemId;");
	    $sth->bind("menuItemId", $menuItemId);
	    $sth->execute();
	    $aMenuItem["aGroupIds"] = array();
	    while ($aGroup = $sth->fetch()) {
	        $aMenuItem["aGroupIds"][] = $aGroup["group_id"];
	    }
	    return $aMenuItem;
	}
	public function getMenuItems($bShort = false)
	{
		$aMenuItems = array();
		$sth = $this->buildMenuItemQuery();
		$sth->execute();
		while ($aMenuItem = $sth->fetch()) {
		    $aMenuItems[$aMenuItem["menu_item_id"]] = $aMenuItem["name"];
		}
		return $aMenuItems;
	}	
	public function insertMenuItem($aMenuItem)
	{
	    $aGroupIds = $aMenuItem["aGroupIds"];
	    unset($aMenuItem["aGroupIds"]);
	    $menuItemSet = new NestedSet("menu_item","menu_item_id");
	    $menuItemId = $menuItemSet->insertNode($aMenuItem);
	    $this->updateMenuItemGroups($menuItemId, $aGroupIds);
	    return $menuItemId;
	}
	public function updateMenuItem($aMenuItem)
	{
	    $this->updateMenuItemGroups($aMenuItem["menu_item_id"], $aMenuItem["aGroupIds"]);
	    unset($aMenuItem["aGroupIds"]);
	    // Update menu_item as nested set node.
	    $menuItemSet = new NestedSet("menu_item", "menu_item_id");
	    return $menuItemSet->updateNode($aMenuItem);
	}
	public function updateMenuItemGroups($menuItemId, $aGroupIds) {
	    // Delete all old menu_item groups.
	    $sth = DB::query("DELETE FROM `menu_item_group` WHERE `menu_item_id` = :menuItemId;");
	    $sth->bind("menuItemId", $menuItemId);
	    $sth->execute();
	    // Insert all new menu_item groups.
	    foreach ($aGroupIds as $groupId) {
	        DB::insert("menu_item_group", array(
	            "group_id"     => $groupId,
	            "menu_item_id" => $menuItemId,
	        ));
	    }
	}
	public function deleteMenuItem($menuItemId)
	{
	    $menuItemSet = new NestedSet(array(
	        "table"    => "menu_item",
	        "node_id"  => "menu_item_id",
	    ));
	    return $menuItemSet->deleteNode($menuItemId);
	}
}

?>
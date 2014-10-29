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
	    return DB::get("menu_item", "menu_item_id", $menuItemId);    
	}	
	public function getMenuItems($bShort = false)
	{
		$aMenuItems = array();
		$sth = $this->buildMenuItemQuery();
		$sth->execute();
		while ($aMenuItem = $sth->fetch()) {
		    $aMenuItems[$aMenuItem["menu_item_id"]] = $aMenuItem["label"];
		}
		return $aMenuItems;
	}	
	public function insertMenuItem($aMenuItem)
	{
	    $menuItemSet = new NestedSet(array(
	        "table"    => "menu_item",
	        "node_id"  => "menu_item_id",
	    ));
	    return $menuItemSet->insertNode($aMenuItem);
	}
	public function updateMenuItem($aMenuItem)
	{
	    $menuItemSet = new NestedSet(array(
	            "table"    => "menu_item",
	            "node_id"  => "menu_item_id",
	    ));
	    return $menuItemSet->updateNode($aMenuItem);
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
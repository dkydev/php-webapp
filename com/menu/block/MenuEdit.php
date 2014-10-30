<?php

require_once PATH_LIB . "/block.php";
require_once PATH_COM . "/menu/model/Menu.php";
require_once PATH_COM . "/user/model/User.php";

class Menu_Block_MenuEdit extends Block 
{	
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
		
		$MenuModel = new Menu_Model();
		$UserModel = new User_Model();
		
		$this->template = "menuEdit.html.php";
		
		$this->component = "menu";
		
        $menuItemId = $this->request->get("menuItemId");
		$this->action = $this->request->get("action");
		
		$this->aMenuItemSelect = $MenuModel->getMenuItems(true);
		
		if (empty($menuItemId) && !empty($_SESSION["aBlock"][$this->block_page_id]["menuItemId"])) {
		    $menuId = $_SESSION["aBlock"][$this->block_page_id]["menuItemId"];
		}
		if (empty($menuItemId) || $this->action == "insert") {
			$this->action = "insert";
			$this->aMenuItem = null;
			unset($_SESSION["aBlock"][$this->block_page_id]["menuItemId"]);
		} else {
		    $_SESSION["aBlock"][$this->block_page_id]["menuItemId"] = $menuItemId;
			$this->aMenuItem = $MenuModel->getMenuItemById($menuItemId);
			$this->action = "update";
			unset($this->aMenuItemSelect[$menuItemId]); // Can't select own as a parent.
		}
		
		$this->aGroups = $UserModel->getGroups();
		
		include $this->templateDirectory . $this->template;
	}
}

?>
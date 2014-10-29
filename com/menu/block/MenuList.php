<?php

require_once PATH_LIB . "/block.php";
require_once PATH_LIB . "/Pager.php";
require_once PATH_COM . "/menu/model/Menu.php";

class Menu_Block_MenuList extends Block 
{	
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
		
		$MenuModel = new Menu_Model();
		$this->template = "menuList.html.php";
		
		$pageNum = $this->request->get("page");
		if (empty($pageNum)) {
		    if (!empty($_SESSION["aBlock"][$this->block_page_id]["page"])) {
		        $pageNum = $_SESSION["aBlock"][$this->block_page_id]["page"];
		    } else {
		        $pageNum = 1;
		    }
		}
		$_SESSION["aBlock"][$this->block_page_id]["page"] = $pageNum;
		
		$this->aPagedData = Pager::getPagedData(array(
	        "sth"        => $MenuModel->buildMenuItemQuery(),
	        "pageNum"    => $pageNum,
	        "pageLimit"  => 10,
	        "pageDelta"  => 2,
		));
		
		include $this->templateDirectory . $this->template;
	}
}

?>
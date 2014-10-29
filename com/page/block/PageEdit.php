<?php

require_once PATH_LIB . "/block.php";
require_once PATH_COM . "/page/model/Page.php";

class Page_Block_PageEdit extends Block 
{	
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../template") . "/";
		
		$this->template = "pageEdit.html.php";
		
		$this->component = "page";
		
		$pageId = $this->request->get("pageId");
		$this->action = $this->request->get("action");
		
		if (empty($pageId) && !empty($_SESSION["aBlock"][$this->block_page_id]["pageId"])) {
		    $pageId = $_SESSION["aBlock"][$this->block_page_id]["pageId"];
		}
		if (empty($pageId) || $this->action == "insert") {
			$this->action = "insert";
			$this->aPage = null;
			unset($_SESSION["aBlock"][$this->block_page_id]["pageId"]);
		} else {
		    $_SESSION["aBlock"][$this->block_page_id]["pageId"] = $pageId;
			$PageModel = new Page_Model();
			$this->aPage = $PageModel->getPageById($pageId);
			$this->action = "update";
		}
		
		include $this->templateDirectory . $this->template;
	}
}

?>
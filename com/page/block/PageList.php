<?php

require_once PATH_LIB . "/block.php";
require_once PATH_LIB . "/Pager.php";
require_once PATH_COM . "/page/model/Page.php";

class Page_Block_PageList extends Block 
{	
	public function render()
	{
		$this->templateDirectory = realpath(dirname(__FILE__) . "/../" . "template") . "/";
		
		$PageModel = new Page_Model();
		$this->template = "pageList.html.php";
		
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
		    "sth"        => $PageModel->buildPageQuery(),
			"pageNum"    => $pageNum,
	        "pageLimit"  => 10,
	        "pageDelta"  => 2,
		));
		
		include $this->templateDirectory . $this->template;
	}
}

?>
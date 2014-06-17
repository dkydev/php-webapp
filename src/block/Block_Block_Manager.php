<?php

require_once NDD_PATH_SRC . "/DAO/DAO_Block.php";
require_once NDD_PATH_SRC . "/DAO/DAO_Page.php";
require_once NDD_PATH_SRC . "/DAO/DAO_Pagination.php";

class Block_Block_Manager extends Block {	
	
	function __construct() {
		
		$this->defaultCommand = "cmd_list";
		
	}
	
	function cmd_list(&$output) {
		
		//$DAO_Page = new DAO_Page();
		
		// get page list for select
		$DAO_Page = new DAO_Page();
		$output->aPage = $DAO_Page->getPages();
		
		// get block list for select
		$DAO_Block = new DAO_Block();
		$output->aBlock = $DAO_Block->getBlocks();
		
		// get paginated blocks
		$limit = 10;
		$pageNum = 1;
		
		$aSQLParams = array();
		$where = "";
		if (!empty($output->aRequest["pageId"])) {
			$where = "WHERE `page`.`page_id` = :pageId";
			$aSQLParams[] = array(":pageId", $output->aRequest["pageId"]);
		}
	
		$aParams = array(
			"select" 	=> "*",
			"table" 	=> "`block_page`",
			"join"		=> "
				LEFT JOIN `page` ON `page`.`page_id` = `block_page`.`page_id`
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`",
			"where"		=> $where,
			"groupBy" 	=> "",
			"orderBy"	=> "ORDER BY `page`.`page_id`",
			"pageLimit" => $limit,
			"pageNum"	=> $pageNum,
			"aSQLParams" => $aSQLParams,
		);
		
		$DAO_Pagination = new DAO_Pagination();
		$output->aPagedData = $DAO_Pagination->getPagedData($aParams);
		
		$this->template = "template_block_manager_list.php";
		$output->pageTitle = "Block Manager - List";
		
	}
	
	function cmd_add(&$output) {
		
		$this->template = "template_page_manager_edit.php";
		
	}
	
	function cmd_edit(&$output) {
		
		$this->template = "template_page_manager_edit.php";
		
	}
	
	function cmd_update(&$output) {
		
		// update
		
		header("Location: /" . $output->aRequest["page"]);
		exit();
		
	}
	
}

?>
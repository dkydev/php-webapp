<?php

require_once NDD_PATH_SRC . "/DAO/DAO_User.php";
require_once NDD_PATH_SRC . "/DAO/DAO_Page.php";
require_once NDD_PATH_SRC . "/DAO/DAO_Pagination.php";

class Block_Page_Manager extends Block {	
	
	function __construct() {
		
		$this->defaultCommand = "cmd_list";
		
	}
	
	function cmd_list() {
		
		//$DAO_Page = new DAO_Page();
		
		// get block list for select
		$DAO_Page = new DAO_Page();
		$this->aPageBlocks = $DAO_Page->getAllPageBlocks();
		
		$limit = 10;
		$pageNum = 1;
	
		$aParams = array(
			"select" 	=> "*, `page`.`page_id`",
			"table" 	=> "`page`",
			"join"		=> "
				LEFT JOIN `block_page` ON `block_page`.`block_id` = `page`.`main_block_page_id` 
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`",
			"where"		=> "WHERE `page`.`page_id` = `block_page`.`page_id` OR `block_page`.`page_id` IS NULL",
			"groupBy" 	=> "",
			"orderBy"	=> "ORDER BY `page`.`page_id`",
			"pageLimit" => $limit,
			"pageNum"	=> $pageNum,
			"aSQLParams" => array(),
		);
		
		$DAO_Pagination = new DAO_Pagination();
		$this->aPagedData = $DAO_Pagination->getPagedData($aParams);
		
		$this->template = "template_page_list.php";
		$this->pageTitle = "Page Manager - List";
		
	}
	
	function cmd_update_pages() {
		
		$DAO_Page = new DAO_Page();
		$DAO_Page->updatePages($this->aRequest["aPages"]);
		
		Output::raiseMessage("Pages updated successfully.");
		
		header("Location: /" . $this->aRequest["alias"] . "/list");
		exit();
	}
	
	function cmd_add() {
		
		$this->template = "template_page_edit.php";
		
	}
	
	function cmd_edit() {
		
		$this->template = "template_page_edit.php";
		
	}
	
	function cmd_update() {
		
		// update
		
		header("Location: /" . $this->aRequest["alias"]);
		exit();
		
	}
	
}

?>
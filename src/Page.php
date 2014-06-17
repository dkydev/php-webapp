<?php 

require_once NDD_PATH_SRC . '/block/Block.php';

class Page {
	
	public $template;
	public $pageTitle;
	public $aPosition;
	
	public static function getPage(&$output) {
		
		$sql = "SELECT * FROM `block_page`
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`
				LEFT JOIN `page` ON `page`.`page_id` = `block_page`.`page_id`
				WHERE `page`.`alias` = :alias;";
		$sth = DB::query($sql, array(array(":alias", $output->aRequest["alias"])));
		
		$page = new Page();
		
		while ($do_block_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			
			$page->template 	= "template/" . $do_block_page["template"] . ".php";
			$page->pageTitle 	= $do_block_page["title"];
			
			$block = $page->aPosition[$do_block_page["position"]][$do_block_page["block_page_id"]] = Block::getBlock($do_block_page);
			
			if (!empty($output->aRequest["block"][$block->block_page_id])) {
				$block->aRequest = $output->aRequest["block"][$block->block_page_id];
			}
			
			$block->aRequest["alias"] = $output->aRequest["alias"];
			
			if (!empty($output->aRequest["block"][$block->block_page_id]["command"])) {
				$command = $output->aRequest["block"][$block->block_page_id]["command"]; // get block command from $output
			} else if ($do_block_page["main_block_page_id"] == $block->block_page_id && !empty($output->aRequest["command"])) {
				$command = $output->aRequest["command"]; // get command from URI for main block
			} else {
				$command = $block->defaultCommand; // use default command for block
			}
			
			$block->$command();
			
		}
		
		return $page;
		
	}
	
	
}

?>
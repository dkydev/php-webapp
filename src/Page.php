<?php 

require_once NDD_PATH_SRC . '/block/Block.php';

class Page {
	
	public $template;
	public $aPosition;
	
	public static function getPage(&$input, &$output) {
		
		$sql = "SELECT * FROM `block_page`
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`
				LEFT JOIN `page` ON `page`.`page_id` = `block_page`.`page_id`
				WHERE `page`.`alias` = :alias;";
		$aParam = array(
			array(":alias", $input->aRequest["page"]),
		);
		$sth = DB::query($sql, $aParam);
		
		//$do_page = $sth->fetch();
		
		$page = new Page();
		
		while ($do_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			
			$page->template = "template/" . $do_page["template"] . ".php";
			$page->aPosition[$do_page["position"]][] = Block::getBlock($do_page, $input, $output);
		}
		
		return $page;
		
	}
	
	
}

?>
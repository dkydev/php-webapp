<?php

class DAO_Page {
	
	public function getPages() {
		
		$aPage = array();
		
		$sql = "SELECT * FROM `page`;";		
		$sth = DB::query($sql);
		
		while ($do_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aPage[] = $do_page;
		}
		
		return $aPage;
		
	}
	
	public function getAllPageBlocks() {
		
		$aPageBlocks = array();
		
		$sql = "SELECT * FROM `block_page`
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`;";
		$sth = DB::query($sql);
		
		while ($do_block_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aPageBlocks[$do_block_page["page_id"]][] = $do_block_page;
		}
		
		return $aPageBlocks;
		
	}
	
	public function updatePages($aPages) {
		
		foreach ($aPages as $aPage) {
			
			$sql = "UPDATE `page` SET			
				`alias` = :alias,
				`title` = :title,
				`template` = :template";
			
			$aParams = array(
				array(":alias", $aPage["alias"]),
				array(":title", $aPage["title"]),
				array(":template", $aPage["template"]),
			);
			
			if (!empty($aPage["main_block_page_id"])) {
				$sql .= ", `main_block_page_id` = :mainBlockPageId";
				$aParams[] = array(":mainBlockPageId", $aPage["main_block_page_id"]);
			}
			
			$sql .= " WHERE `page_id` = :pageId;";
			$aParams[] = array(":pageId", $aPage["page_id"], PDO::PARAM_INT);
			
			$sth = DB::query($sql, $aParams);
			
		}
		
	}
	
	public function insertPage($aPage) {
		
	}
	
	public function updatePage($aPage) {
	
	}
	
	public function deletePage($aPage) {
	
	}
	
}
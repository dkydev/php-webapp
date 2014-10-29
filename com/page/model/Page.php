<?php

class Page_Model
{
    public function buildPageQuery($aQueryParams = null)
    {
        $sth = DB::query("SELECT * FROM `page`;");
        return $sth;
    }
	
	public function getPageById($pageId)
	{
		$sql = "SELECT * FROM `page` WHERE `page`.`page_id` = :pageId;";
		$sth = DB::query($sql);
		$sth->bind("pageId", $pageId);
		$sth->execute();
		return $sth->fetch();
	}
	
	public function getPages()
	{
		$aPage = array();
		$sql = "SELECT * FROM `page`;";
		$sth = DB::query($sql);
		while ($do_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aPage[] = $do_page;
		}
		return $aPage;
	}
	
	public function getAllPageBlocks()
	{
		$aPageBlocks = array();
		$sql = "SELECT * FROM `block_page`
				LEFT JOIN `block` ON `block`.`block_id` = `block_page`.`block_id`;";
		$sth = DB::query($sql);
		while ($do_block_page = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aPageBlocks[$do_block_page["page_id"]][] = $do_block_page;
		}
		return $aPageBlocks;
	}
	
	public function updatePages($aPages)
	{
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
	
	public function insertPage($aPage)
	{
	    
	}
	
	public function updatePage($aPage)
	{
	    
	}
	
	public function deletePage($aPage)
	{
	    
	}
	
	public function getBlocks()
	{
		$aBlock = array();
		$sql = "SELECT * FROM `block`;";
		$sth = DB::query($sql);
		while ($do_block = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aBlock[] = $do_block;
		}
		return $aBlock;	
	}
	
	public function insertBlock($aBlock)
	{
	    
	}
	
	public function updateBlock($aBlock)
	{
	    
	}
	
	public function deleteBlock($aBlock)
	{
	    
	}
}

?>
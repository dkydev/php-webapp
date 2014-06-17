<?php

class DAO_Block {
	
	public function getBlocks() {
	
		$aBlock = array();
	
		$sql = "SELECT * FROM `block`;";
		$sth = DB::query($sql);
	
		while ($do_block = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aBlock[] = $do_block;
		}
	
		return $aBlock;
	
	}
	
	public function insertBlock($aBlock) {
		
	}
	
	public function updateBlock($aBlock) {
	
	}
	
	public function deleteBlock($aBlock) {
	
	}
	
}
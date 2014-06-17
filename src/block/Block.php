<?php

class Block {
	
	public $aRequest;
	
	public $template;
	public $blockPageId;
	public $position;
	public $order;
	public $blockId;
	public $blockName;
	
	public $bi;
	public $bn;
	
	public static function getBlock($do_block_page) {
		
		$blockName = 'Block_' . $do_block_page["block_name"];
		
		require_once $blockName . ".php";

		$block = new $blockName();		
		$block->block_page_id 	= $do_block_page["block_page_id"];
		$block->position 		= $do_block_page["position"];
		$block->order 			= $do_block_page["order"];
		$block->block_id 		= $do_block_page["block_id"];
		$block->block_name 		= $do_block_page["block_name"];

		$block->bi = "block-".$block->block_page_id;
		$block->bn = "block[".$block->block_page_id."]";
		
		return $block;
		
	}
	
}
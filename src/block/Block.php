<?php

class Block {
	
	public $template;
	
	public static function getBlock($do_page, &$input, &$output) {
		
		$blockName = 'Block_' . $do_page["block_name"];
		require_once $blockName . ".php";
		$block = new $blockName();
		
		if ($do_page["main_block_page_id"] == $do_page["block_page_id"] && !empty($input->aRequest["command"])) {
			// get command from URI for main block
			$command = $input->aRequest["command"];
		} else if (!empty($input->aRequest["aBlockCommand"][$do_page["block_page_id"]])) {
			// get block command from $input
			$command = $input["aBlockCommand"][$do_page["block_page_id"]];
		} else {
			// use default command for block
			$command = $block->defaultCommand;
		}		
		
		$block->$command($input, $output);
		return $block;
		
	}
	
}
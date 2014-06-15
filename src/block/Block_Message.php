<?php

class Block_Message extends Block {

	function __construct() {

		$this->defaultCommand = "cmd_view";

	}

	function cmd_view(&$input, &$output) {

		$this->template = "template_message.php";
		
	}

}

?>
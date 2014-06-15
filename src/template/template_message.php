<?php 

if (!empty($this->aMessage)) {
	foreach ($this->aMessage as $type => $aMessage) {
	
		foreach ($aMessage as $message) {
			echo "<div class='alert alert-" . $type . "'>" . $message . "</div>";
		}
		
	}
}

?>
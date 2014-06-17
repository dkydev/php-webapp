<!DOCTYPE html>
<html lang="en">

  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo $this->page->pageTitle; ?></title>

    <link href="/www/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/www/css/custom.css" rel="stylesheet" type="text/css">
    <link href="/www/js/jquery/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css">
	
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="/www/js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="/www/js/jquery/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
    <script src="/www/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    
    <link href="/www/js/select2/select2.css" rel="stylesheet" type="text/css">
    <link href="/www/js/select2/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <script src="/www/js/select2/select2.min.js" type="text/javascript"></script>
    <script type="text/javascript">$(document).ready(function(){$(".select2").select2();});</script>
    
  </head>
  
  <body>
        
        <?php 
        
        // NAVIGATION
        
        if (!empty($this->page->aPosition["navigation"])) {
	        foreach ($this->page->aPosition["navigation"] as $b) {        
	        	include $b->template;        
	        }
        }
        
        ?>
        
        <?php 
        
        // MESSAGE
        
        if (!empty($this->aMessage)) {
			echo "<div class='container-fluid'>";
        	foreach ($this->aMessage as $type => $aMessage) {
        
        		foreach ($aMessage as $message) {
        			echo "<div class='alert alert-" . $type . "'>" . $message . "</div>";
        		}
        
        	}
        	echo "</div>";
        }
        
        
        ?>
        
        <?php 
        
        // TOP
        
        if (!empty($this->page->aPosition["top"])) {        
        	echo "<div class='container-fluid'>";        	     	
	        foreach ($this->page->aPosition["top"] as $b) {        
	        	include $b->template;        
	        }
        	echo "</div>";
        }
        
        ?>
        
        <div class="container-fluid">
        
	        <div class="row">
	        <?php 
	        
	        // LEFT
	        
			if (!empty($this->page->aPosition["left"])) {
	        	echo "<div class='col-md-3'>";
		        foreach ($this->page->aPosition["left"] as $b) {		        	 
		        	include $b->template;		        	 
		        }
	        	echo "</div>";
	        }
	        
	        // MAIN
	        
	        if (!empty($this->page->aPosition["main"])) {
				if (!empty($this->page->aPosition["left"])) {
					if (!empty($this->page->aPosition["right"])) {
						echo "<div class='col-md-6'>";
					} else {
						echo "<div class='col-md-9'>";
					}
				} else {
					echo "<div class='col-md-12'>";
				}	        
		        foreach ($this->page->aPosition["main"] as $b) {		
		        	include $b->template;		        	
		        }
	        	echo "</div>";
	        }
	        
	        // RIGHT
	        
	        if (!empty($this->page->aPosition["right"])) {
	        	echo "<div class='col-md-3'>";
		        foreach ($this->page->aPosition["right"] as $b) {		        	 
		        	include $b->template;		        	 
		        }
	        	echo "</div>";
	        }
	        
	        ?>
	        
	        </div>
        
        </div>

  </body>
  
</html>
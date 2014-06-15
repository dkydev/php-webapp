<!DOCTYPE html>
<html lang="en">

  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo $this->pageTitle; ?></title>

    <link href="/www/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="/www/js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="/www/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    
  </head>
  
  <body>
        
        <?php 
        
        // NAVIGATION
        
        if (!empty($this->page->aPosition["navigation"])) {
	        foreach ($this->page->aPosition["navigation"] as $block) {        
	        	include $block->template;        
	        }
        }
        
        ?>
        
        <?php 
        
        // TOP
        
        if (!empty($this->page->aPosition["top"])) {        
        	echo "<div class='container-fluid'>";        	     	
	        foreach ($this->page->aPosition["top"] as $block) {        
	        	include $block->template;        
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
		        foreach ($this->page->aPosition["left"] as $block) {		        	 
		        	include $block->template;		        	 
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
		        foreach ($this->page->aPosition["main"] as $block) {		
		        	include $block->template;		        	
		        }
	        	echo "</div>";
	        }
	        
	        // RIGHT
	        
	        if (!empty($this->page->aPosition["right"])) {
	        	echo "<div class='col-md-3'>";
		        foreach ($this->page->aPosition["right"] as $block) {		        	 
		        	include $block->template;		        	 
		        }
	        	echo "</div>";
	        }
	        
	        ?>
	        
	        </div>
        
        </div>

  </body>
  
</html>
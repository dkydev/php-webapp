<!DOCTYPE html>
<html lang="en">
  <head>  
    <?php include "header.html.php"; ?>  
  </head>
  <body>
    <div id="wrapper">
        
        <?php if (!empty($this->aPosition["navigation"])): ?>
          <?php foreach ($this->aPosition["navigation"] as $block): ?>
            <?=$block->render()?>
          <?php endforeach; ?>
        <?php endif; ?>
        
        <div id="page-wrapper">
		
		<div class="row">
          <div class="col-lg-12">
            <h1 class="page-header"><?=$this->pageTitle?></h1>
          </div>
        </div>
		
		<?php foreach (Output::getMessages() as $type => $aMessages): ?>
		  <?php foreach ($aMessages as $message): ?>
            <div class='alert alert-dismissible alert-<?=$type?>'>
			  <button type='button' class='close' data-dismiss='alert'>
			  <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
			  </button>
			  <?=$message?>
			</div>
		  <?php endforeach; ?>
	    <?php endforeach; ?>
		
        <?php if (!empty($this->aPosition["top"])): ?>
          <div class='container-fluid'>
            <?php foreach ($this->aPosition["top"] as $block): ?>
              <?=$block->render()?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
            
	        <div class="row">
	        
    	      <?php if (!empty($this->aPosition["left"])): ?>
                <div class='col-lg-4'>
                <?php foreach ($this->aPosition["left"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
	        
    	      <?php if (!empty($this->aPosition["left"])): ?>
    	        <?php if (!empty($this->aPosition["right"])): ?>
    	          <div class='col-lg-4'>
    	        <?php else: ?>
    	          <div class='col-lg-8'>
    	        <?php endif; ?>
    	      <?php else: ?>
    	        <div class='col-lg-12'>
    	      <?php endif; ?>
	        
	          <?php if (!empty($this->aPosition["main"])): ?>
                <?php foreach ($this->aPosition["main"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
              <?php endif; ?>
	        
	          </div>
	        
              <?php if (!empty($this->aPosition["right"])): ?>
                <div class='col-lg-4'>
                <?php foreach ($this->aPosition["right"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
	        
	        </div> 
        
        </div>
        
    </div>
  </body>  
</html>
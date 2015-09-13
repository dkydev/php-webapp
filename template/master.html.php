<!DOCTYPE html>
<html lang="en">
  <head>  
    <?php include "header.html.php"; ?>  
  </head>
  <body>
    <div id="wrapper">
        
        <?php if (!empty($this->aBlocks["navigation"])): ?>
          <?php foreach ($this->aBlocks["navigation"] as $block): ?>
            <?=$block->render()?>
          <?php endforeach; ?>
        <?php endif; ?>
        
        <div id="page-wrapper">
		
		<div class="row">
          <div class="col-lg-12">
            <h1 class="page-header"><?=$this->pageTitle?></h1>
          </div>
        </div>
		
		<?php foreach (DKY_Output::getMessages() as $type => $aMessages): ?>
		  <?php foreach ($aMessages as $message): ?>
            <div class='alert alert-dismissible alert-<?=$type?>'>
			  <button type='button' class='close' data-dismiss='alert'>
			  <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
			  </button>
			  <?=$message?>
			</div>
		  <?php endforeach; ?>
	    <?php endforeach; ?>
		
        <?php if (!empty($this->aBlocks["top"])): ?>
          <div class='container-fluid' id="top">
            <?php foreach ($this->aBlocks["top"] as $block): ?>
              <?=$block->render()?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
            
	        <div class="row">
	        
    	      <?php if (!empty($this->aBlocks["left"])): ?>
                <div class='col-lg-4' id="left">
                <?php foreach ($this->aBlocks["left"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
	        
    	      <?php if (!empty($this->aBlocks["left"]) || !empty($this->aBlocks["right"])): ?>
    	        <?php if (!empty($this->aBlocks["left"]) && !empty($this->aBlocks["right"])): ?>
    	          <div class='col-lg-4' id="main">
    	        <?php else: ?>
    	          <div class='col-lg-8' id="main">
    	        <?php endif; ?>
    	      <?php else: ?>
    	        <div class='col-lg-12' id="main">
    	      <?php endif; ?>
	        
	          <?php if (!empty($this->aBlocks["main"])): ?>
                <?php foreach ($this->aBlocks["main"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
              <?php endif; ?>
	        
	          </div>
	        
              <?php if (!empty($this->aBlocks["right"])): ?>
                <div class='col-lg-4' id="right">
                <?php foreach ($this->aBlocks["right"] as $block): ?>
                  <?=$block->render()?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
	        
	        </div> 
        
        </div>
        
    </div>
  </body>  
</html>
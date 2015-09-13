<!DOCTYPE html>
<html lang="en">
  <head>  
    <?php include "header.html.php"; ?>  
  </head>
  <body>
    <div id="wrapper">
		
        <?php if (!empty($this->aBlocks["main"])): ?>
          <div class='container-fluid' id="main">
            <?php foreach ($this->aBlocks["main"] as $block): ?>
              <?=$block->render()?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        
    </div>
  </body>  
</html>
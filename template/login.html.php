<!DOCTYPE html>
<html lang="en">
  <head>  
    <?php include "header.html.php"; ?>  
  </head>
  <body>
    <div id="wrapper">
		
        <?php if (!empty($this->aPosition["top"])): ?>
          <div class='container-fluid'>
            <?php foreach ($this->aPosition["top"] as $block): ?>
              <?=$block->render()?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        
    </div>
  </body>  
</html>
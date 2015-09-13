<div class="text-center">
  <ul class="pagination" style="margin:0px;">
	<?php
	
	$pageLimit 		= $this->aPagedData['pageDelta'];
	$delta 			= floor($pageLimit * 0.5);
	$currentPage 	= $this->aPagedData["pageNum"];
	$totalPages 	= $this->aPagedData["totalPages"];
	$prevPage 		= $this->aPagedData["pageNum"]-1;
	$nextPage 		= $this->aPagedData["pageNum"]+1;
	
	if ($this->aPagedData["pagesBefore"] > 0) {
		echo "<li><a href='?page=" . $prevPage . "'>&laquo;</a></li>";
	}
	
	for ($i = 0; $i < min(array($totalPages, $pageLimit)); $i++) {		
		$pageNum = $i + 1 + min(array(max(array(0, $currentPage - ($delta + 1))), max(array($totalPages - $pageLimit, 0)))); // magic		
		$active = $pageNum == $this->aPagedData["pageNum"] ? "active" : "";				
		echo "<li class='" . $active . "'><a href='?page=" . $pageNum . "'>" . $pageNum . "</a></li>";		
	}
		
	if ($this->aPagedData["pagesAfter"] > 0) {
		echo "<li><a href='?page=" . $nextPage . "'>&raquo;</a></li>";
	}
	
	?>
  </ul>
</div>
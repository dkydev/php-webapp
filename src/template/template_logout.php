
<p>You are logged in as <?php echo $b->username; ?>.</p>

<form method="post" role="form">

	<?php echo "<input type='hidden' name='{$b->bn}[command]' value='logout' />"; ?>
  
  	<button type="submit" class="btn btn-default">Logout</button>
  	
</form>
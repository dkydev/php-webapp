<div class="col-md-4 col-md-offset-4">
  <div class="login-panel panel panel-default">
  <div class="panel-heading">
    <p>You are logged in as <strong><?php echo $this->username; ?></strong>.</p>
  </div>
  <div class="panel-body">
  
  <?php foreach ($this->aMessages as $type => $aMessages): ?>
    <?php foreach ($aMessages as $message): ?>
	  <div class='alert alert-<?=$type?> alert-dismissible'>
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <?=$message?>
	  </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
  
    <form role="form" method="post">
    <input type="hidden" name="component" value="<?=$this->component?>" />
    <input type="hidden" name="action" value="<?=$this->action?>" />
        <fieldset>
            <button type="submit" class="btn btn-lg btn-default btn-block">Logout</button>
        </fieldset>
    </form>
</div>
</div>
<div class="col-md-4 col-md-offset-4">
  <div class="login-panel panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Please Sign In</h3>
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
            <div class="form-group">
                <input class="form-control" placeholder="E-mail" name="username" autofocus>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Password" name="password" type="password" value="">
            </div>
            <div class="checkbox">
                <label>
                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                </label>
            </div>
            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
        </fieldset>
    </form>
</div>
</div>
</div>
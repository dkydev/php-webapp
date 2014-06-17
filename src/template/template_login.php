<form method="post" role="form">

  <?php echo "<input type='hidden' name='{$b->bn}[command]' value='login' />"; ?>
  
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" name="<?="{$b->bn}[username]"?>" class="form-control" id="username" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="<?="{$b->bn}[password]"?>" class="form-control" id="password" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-default">Login</button>
</form>
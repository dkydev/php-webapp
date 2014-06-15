
<p>You are logged in as <?php echo $this->username; ?>.</p>

<form method="post" role="form">
  <input type="hidden" name="command" value="logout" />
  <button type="submit" class="btn btn-default">Logout</button>
</form>
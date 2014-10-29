<script type="text/javascript">
  $(document).ready(function() {
	  $("#menu-parent").select2({ "width" : "100%", "allowClear" : "true" });
  });
</script>

<div class="panel panel-default">
<form class="form-horizontal" method="post" role="form">
  <div class="panel-body">  
	  <input type="hidden" name="component" value="<?=$this->component?>" />
	  <input type="hidden" name="action" value="<?=$this->action?>" />
	  <?php if (!empty($this->aMenuItem["menu_item_id"])): ?>
	  <input type="hidden" name="menuItem[menu_item_id]" value="<?=$this->aMenuItem["menu_item_id"]?>" />
	  <?php endif; ?>
	  
	  <div class="form-group">
	    <label for="menu-parent" class="col-sm-2 control-label">Parent Menu Item</label>
	    <div class="col-sm-10">
	      <select name="menuItem[parent_id]" type="text" class="form-control" id="menu-parent" data-placeholder="Parent Menu Item">
	      <option></option>
	      <?php Output::makeSelect($this->aMenuItemSelect, $this->aMenuItem["parent_id"])?>
	      </select>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="menu-label" class="col-sm-2 control-label">Title</label>
	    <div class="col-sm-10">
	      <input name="menuItem[label]" type="text" class="form-control" id="menu-label" placeholder="Label" value="<?=$this->aMenuItem["label"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="menu-target" class="col-sm-2 control-label">Target</label>
	    <div class="col-sm-10">
	      <input name="menuItem[target]" type="text" class="form-control" id="menu-target" placeholder="Target" value="<?=$this->aMenuItem["target"]?>" />
	    </div>
	  </div>
	  
  </div>
<div class="panel-footer clearfix">
    <div class="form-group" style="margin-bottom:0px">
    <div class="col-sm-offset-2 col-sm-10">
      <?php if ($this->action == "update"): ?>
      <button type="submit" class="btn btn-primary">Update</button>
      <?php else: ?>
      <button type="submit" class="btn btn-primary">Add</button>
      <?php endif; ?>
    </div>
    </div>
</div>
</form>
</div>
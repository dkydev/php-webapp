<div class="panel panel-default">
<form class="form-horizontal" method="post" role="form">
  <div class="panel-body">  
	  <input type="hidden" name="component" value="<?=$this->component?>" />
	  <input type="hidden" name="action" value="<?=$this->action?>" />		
	  <div class="form-group">
	    <label for="page-title" class="col-sm-2 control-label">Title</label>
	    <div class="col-sm-10">
	      <input name="page[title]" type="text" class="form-control" id="page-title" placeholder="Title" value="<?=$this->aPage["title"]?>" />
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="page-path" class="col-sm-2 control-label">Path</label>
	    <div class="col-sm-10">
	      <input name="page[path]" type="text" class="form-control" id="page-path" placeholder="Path" value="<?=$this->aPage["path"]?>" />
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="page-template" class="col-sm-2 control-label">Template</label>
	    <div class="col-sm-10">
	      <input name="page[template]" type="text" class="form-control" id="page-template" placeholder="Template" value="<?=$this->aPage["template"]?>" />
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
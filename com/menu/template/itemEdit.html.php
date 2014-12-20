<script type="text/javascript">
var a;
  $(document).ready(function() {
	  $("#item-parent").select2({ "width" : "100%", "allowClear" : true});
	  $("#item-parent").on("change", function(e) {
	      $("#item-order").select2("enable", false);
	      $.ajax({
		      url : "<?=$this->getItemsURL?>&parentId=" + e.val, 
	          success : function(data) {
		          a = data;
	              $("#item-order").html("<option>- first -</option>" + data);
	              $("#item-order").select2();
		          if (data != "\r\n") {		              
	                  $("#item-order").select2("enable", true);
		          }
	          },
		  });
	  });
	  $("#item-order").select2({ "width" : "100%", "allowClear" : true });
	  $("#item-groups").select2({ "width" : "100%" });
  });
</script>

<div class="panel panel-default">
<form class="form-horizontal" method="post" role="form">
  <div class="panel-body">  
	  <input type="hidden" name="component" value="<?=$this->component?>" />
	  <input type="hidden" name="action" value="<?=$this->action?>" />
	  <?php if (!empty($this->aItem["item_id"])): ?>
	  <input type="hidden" name="item[item_id]" value="<?=$this->aItem["item_id"]?>" />
	  <?php endif; ?>
	  
	  <div class="form-group">
	    <label for="item-parent" class="col-sm-2 control-label">Parent Item</label>
	    <div class="col-sm-10">
	      <select name="item[parent_id]" class="form-control" id="item-parent" data-placeholder="Parent Item">
	      <option></option>
	      <?php DKY_Output::makeSelect($this->aItemSelect, $this->aItem["parent_id"])?>
	      </select>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-order" class="col-sm-2 control-label">Order</label>
	    <div class="col-sm-10">
	      <select name="item[order]" class="form-control" id="item-order" data-placeholder="Order">
	        <option>- first -</option>
	        <?php DKY_Output::makeSelect($this->aChildItems, $this->orderItemId)?>
	      </select>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-name" class="col-sm-2 control-label">Name</label>
	    <div class="col-sm-10">
	      <input name="item[name]" type="text" class="form-control" id="item-name" placeholder="Name" value="<?=$this->aItem["name"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-title" class="col-sm-2 control-label">Item Title</label>
	    <div class="col-sm-10">
	      <input name="item[title]" type="text" class="form-control" id="item-title" placeholder="Item Title" value="<?=$this->aItem["title"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-url" class="col-sm-2 control-label">External URL</label>
	    <div class="col-sm-10">
	      <input name="item[url]" type="text" class="form-control" id="item-url" placeholder="http://www.example.com" value="<?=$this->aItem["url"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-component" class="col-sm-2 control-label">Component</label>
	    <div class="col-sm-10">
	      <input name="item[component]" type="text" class="form-control" id="item-component" placeholder="Component" value="<?=$this->aItem["component"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-action" class="col-sm-2 control-label">Action</label>
	    <div class="col-sm-10">
	      <input name="item[action]" type="text" class="form-control" id="item-action" placeholder="Action" value="<?=$this->aItem["action"]?>" />
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="item-groups" class="col-sm-2 control-label">Group Access</label>
	    <div class="col-sm-10">	
          <?php if (!isset($this->aItem["group_exclusive"]) || $this->aItem["group_exclusive"] == 1): ?>
          
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-default btn-xs active">
                <input type="radio" name="item[group_exclusive]" autocomplete="off" value="1" checked> All Except Selected Groups
              </label>
              <label class="btn btn-default btn-xs">
                <input type="radio" name="item[group_exclusive]" autocomplete="off" value="0"> Only Selected Groups
              </label>
            </div>
            
          <?php else: ?>
          
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-default btn-xs">
                <input type="radio" name="item[group_exclusive]" autocomplete="off" value="1"> All Except Selected Groups
              </label>
              <label class="btn btn-default btn-xs active">
                <input type="radio" name="item[group_exclusive]" autocomplete="off" value="0" checked> Only Selected Groups
              </label>
            </div>
          
          <?php endif; ?>          
	      <select style="margin-top:5px;" name="item[aGroupIds][]" multiple class="form-control" id="item-groups" data-placeholder="Group Access">
	        <?php DKY_Output::makeSelect($this->aGroups, $this->aItem["aGroupIds"])?>
	      </select>	      
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
      <?php if (!empty($this->cancelURL)): ?>
      <a href="<?=$this->cancelURL?>" class="btn btn-default">Cancel</a>
      <?php endif; ?>
    </div>
    </div>
</div>
</form>
</div>
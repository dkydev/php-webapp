<h3><?php echo $this->pageTitle; ?></h3>

<form method="post">

<input type="hidden" name="aBlockCommand[<?php echo $block->blockPageId; ?>]" value="update_blocks" />

<table id="block-table" class="table table-condensed table-bordered table-striped table-hover">
<thead>
<tr>
  <th></th>
  <th>Block Type</th>
  <th>Page</th>
  <th>Position</th>
  <th>Order</th>
</tr>
</thead>
<tbody>
<?php 
	
	$rowNum = 0;

	if (!empty($this->aPagedData["aRow"])) {
		foreach ($this->aPagedData["aRow"] as $row) {
		
			echo "
			<tr id='row-$rowNum' class='item-row'>
				<td class='center'><input class='item-checkbox' type='checkbox' value='{$row["block_page_id"]}' /></td>
				<td>
				  <input type='hidden' name='aBlock[$rowNum][block_page_id]' value='{$row["block_page_id"]}' />
				  <select class='form-control select2' name='aBlock[$rowNum][block_id]'>{$this->makeSelect($this->aBlock, "block_name", "block_id", $row["block_id"])}</select>
				</td>
				<td><select class='form-control select2' name='aBlock[$rowNum][page_id]'>{$this->makeSelect($this->aPage, "alias", "page_id", $row["page_id"])}</select></td>
				<td><input class='form-control' type='text' name='aBlock[$rowNum][position]' value='{$row["position"]}' /></td>
				<td>
				  <input class='form-control' type='number' name='aBlock[$rowNum][order]' value='{$row["order"]}' />
				</td>
			</tr>";
		
			$rowNum ++;
			
		}
	}

?>
</tbody>
<tfoot>
<tr id="add-block-row">
  <th colspan="6">    
    <a class="btn btn-default pull-right" onclick="addRow()">Add Block</a>
  	
  	<a class="btn btn-default" onclick="selectAll()">Select All</a>
  	<a class="btn btn-default" onclick="selectNone()">Select None</a>
  	<a class="btn btn-danger" onclick="deleteSelected()">Delete Selected Blocks</a>
  </th>
</tr>
</tfoot>
</table>

<input class="btn btn-primary pull-right" type="submit" value="Save Changes" />

</form>

<script type="text/javascript">

	var rowNum = <?php echo $rowNum; ?>;
	var blockSelect = "<?php echo $this->makeSelect($this->aBlock, "block_name", "block_id"); ?>";
	var pageSelect = "<?php echo $this->makeSelect($this->aPage, "alias", "page_id"); ?>";

	function addRow() {

		$("#block-table tbody").append(
			"<tr>" +
			"<td class='center'><input class='block-checkbox' style='margin:0px;' type='checkbox' /></td>" +
			"<td><select id='block-select-" + rowNum + "' class='form-control select2' 	name='aBlock[" + rowNum + "][block_id]'>" + blockSelect + "</select></td>" +
			"<td><select id='page-select-" + rowNum + "' class='form-control select2' name='aBlock[" + rowNum + "][page_id]'>" + pageSelect + "</select></td>" +
			"<td><input class='form-control' type='text' name='aBlock[" + rowNum + "][position]' value='' /></td>" +
			"<td><input class='form-control' type='text' name='aBlock[" + rowNum + "][order]' value='' /></td>" +
			"</tr>"
		);

		$("#page-select-" + rowNum).select2();
		$("#block-select-" + rowNum).select2();
		
		rowNum++;
		
	}

	function selectAll() {
		$(".item-checkbox").prop("checked", true);
	}

	function selectNone() {
		$(".item-checkbox").prop("checked", false);
	}

	/*
	$("#block-table tbody").sortable({
		
	    helper: function(e, tr) {
		    var $originals 	= tr.children();
		    var $helper 	= tr.clone();
		    $helper.children().each(function(index) {
		      $(this).width($originals.eq(index).width())
		    });
		    return $helper;
		},

		change: function(e, ui) {
			
		},
    
	}).disableSelection();
	*/
	
</script>
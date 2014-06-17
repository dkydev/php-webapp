<form role="form" method="post">

<?php echo "<input type='hidden' name='{$b->bn}[command]' value='update_pages' />"; ?>

<table id="<?php echo $b->bi; ?>-page-table" class="table table-condensed table-bordered table-striped">

<thead>
<tr>
  <th></th>
  <th>Alias</th>
  <th>Title</th>
  <th>Template</th>
  <th>Main Block</th>
  <th></th>
</tr>
</thead>

<tbody>
<?php

	if (!empty($b->aPagedData["aRow"])) {
		foreach ($b->aPagedData["aRow"] as $row) {
			
			echo
			 
			"<tr>
				<td class='center'>
				  <input class='{$b->bi}-page-checkbox' type='checkbox'		name='{$b->bn}[aPages][{$row["page_id"]}][delete]'  												/>
				  <input type='hidden' 										name='{$b->bn}[aPages][{$row["page_id"]}][page_id]' 	value='{$row["page_id"]}' type='checkbox' 	/>
				</td>
				<td><input class='form-control'  							name='{$b->bn}[aPages][{$row["page_id"]}][alias]' 		value='{$row["alias"]}' 	type='text' 	/></td>
				<td><input class='form-control' 							name='{$b->bn}[aPages][{$row["page_id"]}][title]' 		value='{$row["title"]}' 	type='text' 	/></td>
				<td><input class='form-control' 							name='{$b->bn}[aPages][{$row["page_id"]}][template]' 	value='{$row["template"]}' 	type='text' 	/></td>";
			
			if (!empty($b->aPageBlocks[$row["page_id"]])) {
				echo "<td><select class='select2 form-control' 					name='{$b->bn}[aPages][{$row["page_id"]}][main_block_page_id]'>{$this->makeSelect($b->aPageBlocks[$row["page_id"]], "block_name", "block_page_id", $row["block_page_id"])}</select></td>";
			} else {
				echo "<td><input type='text' class='form-control' disabled placeholder='No blocks assigned to page' /></td>";
			}
			
			echo 
			
				"<td><a class='btn btn-default' href='{$this->makeURL("block")}/list/pageId/{$row["page_id"]}'><span class='glyphicon glyphicon-pencil'></span>&nbsp;Edit</a></td>
			</tr>";
			
		}
	}

?>
</tbody>

<tfoot>
<tr>
  <th colspan="6">
    <div class="pull-right">
      <a class="btn btn-default" href="<?=$this->makeURL("page")?>/add"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Page</a>
      <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-ok"></span>&nbsp;Save Changes</button>
    </div>
    <a class="btn btn-default" onclick="selectAll()">Select All</a>
  	<a class="btn btn-default" onclick="selectNone()">Select None</a>
  	<a class="btn btn-danger" onclick="deleteSelected()"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete Selected Blocks</a>
  </th>
</tr>
</tfoot>

</table>




</form>

<script type="text/javascript">

	var bi = "<?php echo $b->bi; ?>";

	function selectAll() {
		$("." + bi + "-page-checkbox").prop("checked", true);
	}

	function selectNone() {
		$("." + bi + "-page-checkbox").prop("checked", false);
	}

	function deleteSelected() {

	}
	
</script>
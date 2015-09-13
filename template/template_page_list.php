<table id="page-list-table" class="table table-condensed table-bordered table-striped">
  <thead>
    <tr>
      <th>Alias</th>
      <th>Title</th>
      <th>Template</th>
      <th>Main Block</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
	<?php	
		if (!empty($this->aPagedData["aRow"])) {
			foreach ($this->aPagedData["aRow"] as $row) {				
				echo				 
				"<tr>
					<td>{$row["alias"]}</td>
					<td>{$row["title"]}</td>
					<td>{$row["template"]}</td>
					<td>{$row["block_name"]}</td>
					<td>
					<div class='btn-group'>
					  <a class='btn btn-default' href='edit/pageId/{$row['page_id']}'>Edit</a>
					  <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
					    <span class='caret'></span>
					    <span class='sr-only'>Toggle Dropdown</span>
					  </button>
					  <ul class='dropdown-menu' role='menu'>
					    <li><a href='#'>Delete</a></li>
					  </ul>
					</div>
					</td>
				</tr>";				
			}
		}
	?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="6">
  	    <div class="pull-right">
          <a class="btn btn-default" href="<?=Output::makeURL()?>/add"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Page</a>
        </div>
        <?php include PATH_ROOT . "/template/pager.html.php"; ?>
      </td>
    </tr>
  </tfoot>
</table>
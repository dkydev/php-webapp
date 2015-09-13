<div class="panel panel-default">
<div class="panel-heading">
  <div class="pull-right clearfix"> 
    <a href="?action=add_item" class="btn btn-xs btn-default"><i class="fa fa-plus fa-fw"></i>&nbsp;Add Menu Item</a>
  </div>
  <i class="fa fa-sitemap fa-fw"></i>
  Items
</div>

<div class="table-responsive">
<table id="page-list-table" class="table table-condensed table-bordered table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Path</th>
      <th>Parent ID</th>
      <th>Root ID</th>
      <th>Left ID</th>
      <th>Right ID</th>
      <th>Level ID</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
	<?php foreach ($this->aPagedData["aData"] as $key => $aValue):	?>
		<tr>
			<td><a href="<?=$this->editURL?>&itemId=<?=$aValue["item_id"]?>"><?=$aValue["name"]?> <i class="fa fa-pencil-square-o"></i></a></td>
			<td><?=$aValue["path"]?></td>
			<td><?=$aValue["parent_id"]?></td>
			<td><?=$aValue["root_id"]?></td>
			<td><?=$aValue["left_id"]?></td>
			<td><?=$aValue["right_id"]?></td>
			<td><?=$aValue["level_id"]?></td>
			<td>
			  <a class="btn btn-xs btn-danger" href="<?=$this->deleteURL?>&itemId=<?=$aValue["item_id"]?>"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>

<div class="panel-footer">	
	<?php include DKY_PATH_ROOT . "/template/pager.html.php"; ?>	
</div>
</div>
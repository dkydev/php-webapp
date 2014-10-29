<div class="panel panel-default">
<div class="panel-heading">
  <div class="pull-right clearfix"> 
    <a href="?action=insert" class="btn btn-xs btn-default"><i class="fa fa-plus fa-fw"></i>&nbsp;Add Menu Item</a>
  </div>
  <i class="fa fa-sitemap fa-fw"></i>
  Menu Items
</div>

<div class="table-responsive">
<table id="page-list-table" class="table table-condensed table-bordered table-striped">
  <thead>
    <tr>
      <th>Menu ID</th>
      <th>Label</th>
      <th>Target</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
	<?php foreach ($this->aPagedData["aData"] as $key => $aValue):	?>
		<tr>
			<td><?=$aValue["menu_item_id"]?></td>
			<td><?=$aValue["label"]?></td>
			<td><?=$aValue["target"]?></td>
			<td>
			  <a class="btn btn-xs btn-primary" href="?menuItemId=<?=$aValue["menu_item_id"]?>"><i class="fa fa-pencil-square-o"></i></a>
			  <a class="btn btn-xs btn-danger" href="?component=menu&action=delete&menuItemId=<?=$aValue["menu_item_id"]?>"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>

<div class="panel-footer">	
	<?php include PATH_ROOT . "/template/pager.html.php"; ?>	
</div>
</div>
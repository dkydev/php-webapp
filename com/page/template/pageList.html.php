<div class="panel panel-default">
<div class="panel-heading clearfix">
  <div class="pull-right"> 
    <a href="?action=insert" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Page</a>
  </div>
</div>

<div class="table-responsive">
<table id="page-list-table" class="table table-condensed table-bordered table-striped">
  <thead>
    <tr>
      <th>Page ID</th>
      <th>Title</th>
      <th>Path</th>
      <th>Template</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach ($this->aPagedData["aData"] as $key => $aValue):	?>
		<tr>
			<td><?=$aValue["page_id"]?></td>
			<td><a href='?pageId=<?=$aValue['page_id']?>'><?=$aValue["title"]?></a></td>
			<td><?=$aValue["path"]?></td>
			<td><?=$aValue["template"]?></td>
		</tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>

<div class="panel-footer">
	<?php include PATH_ROOT . "/template/pager.html.php"; ?>
</div>
</div>
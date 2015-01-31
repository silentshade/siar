<?php

$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Бекапы бд сайта',
);

$this->widget('MGridView',array(
	'id' => 'grid',
	'dataProvider' => $arrayDataProvider,
	'columns' => array(
		array(
			'name' => 'file',
			'header' => 'Файл',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data["file"]), "/admin/database/GetFile?file=".CHtml::encode($data["file"]))',
		),
		array(
			'header' => 'Восстановить',
			'type' => 'raw',
			'value' => 'CHtml::link("Восстановить", "/admin/database/importSqlDump?file=".CHtml::encode($data["file"]),array("onclick"=>"if(!confirm(\'Восстановить?\')) return false;"))',
		),
	),
));
?>


<form name="form" method="post" action="/admin/database/importSqlDumpForm" enctype="multipart/form-data">
	<a href="/admin/database/DbBackup" class="btn">Создать бекап</a>

	<input type="file" name="file" />&nbsp;
	<input type="submit" value="Импорт" class="btn btn-primary"/>
</form>
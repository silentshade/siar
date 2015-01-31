<?
$module=Yii::app()->getModule($model->module);
?>
<h1><?=$module->name;?></h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array('name'=>'images','header'=>'<span style="font-size: smaller;">Фото</span>','type'=>'raw','value'=>'"<img style=\'max-width:88px;\' src=\'/images/staff/admin/".SiteHelper::returnOneImages($data->images)."?m=".$data->modified."\' />"','htmlOptions'=>array('style'=>'font-size: smaller;width:88px;max-width:88px;text-align:center;'),'filter'=>false),
		'name',
		'job',
		array(
			'name' => 'published',
			'type'=>'raw',
			'value'=>'$data->published==1 ? "Опубликован" : "Не опубликован"',
			'htmlOptions'=>array('style'=>'width:140px;'),
			'filter'=>SiteHelper::$yes_no,
		),
		array(
			'header' => '<span rel=tooltip title="Действие"></span>',
			'class'=>'EButtonColumnWithClearFilters',
			'template' => '{update} {delete}',
			'htmlOptions'=>array('style'=>'text-align:center;')
		)
	)
));
?>
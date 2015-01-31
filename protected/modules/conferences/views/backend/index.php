<?
$module=Yii::app()->getModule($model->module);
?>
<h1><?=$module->name;?></h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array(
			'name'=>'name',
			'header'=>'Название',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))',
			'htmlOptions'=>array('class'=>'')
		),
		array(
			'name'=>'begin_conf',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:mm", $data->begin_conf)',
		),
		array(
			'name'=>'end_conf',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:mm", $data->end_conf)',
		),
		array(
			'name' => 'published',
			'type'=>'raw',
			'value'=>'$data->published==1 ? "Опубликована" : "Не опубликована"',
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
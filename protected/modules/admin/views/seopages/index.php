<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Seo других страниц',
);
?>

<h1>Seo других страниц</h1>


<?
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'template'=>"{items} {summary} {pager}",
	'summaryText'=>'{start}-{end} из {count}',
	'enableSorting'=>false,
	'filter' => $model,
	'columns'=>array(
		array('name'=>'name','header'=>'Название','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))','htmlOptions'=>array('class'=>'')),
		array('name'=>'modified','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:ss", $data->modified)','htmlOptions'=>array('style'=>'width:190px;')),
	),
	'pager'=>array(
		'firstPageLabel'=>'<<',
		'lastPageLabel'=>'>>',
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast'=>true
	)
));
?>

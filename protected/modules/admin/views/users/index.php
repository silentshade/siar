<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Пользователи',
);
?>

<?
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'template'=>"{items} <div class='pull-right'>{pager}{summary}</div>",
	'summaryText'=>'{start}-{end} из {count}',
	'filter' => $model,
	'afterAjaxUpdate'=>'js:function(){processGrid();}',
	'columns'=>array(
		array('name'=>'images','type'=>'raw','value'=>'"<a href=/admin/users/update/id/".$data->id."><img style=max-width:50px; src=/images/avatar/mini/".SiteHelper::returnOneImages($data->images)." /></a>"','htmlOptions'=>array('style'=>'max-width:50px;'),'filter'=>false),
		array('name'=>'name','header'=>'ФИО','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))','htmlOptions'=>array('style'=>'width:340px;')),
		array('name'=>'email','type'=>'raw'),
		array('name'=>'admin','type'=>'raw','value'=>'SiteHelper::$yes_no[$data->admin]','filter'=>SiteHelper::$yes_no),
		//array('name'=>'created','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd.MM.yyyy HH:mm", $data->created)','htmlOptions'=>array('style'=>'width:120px;')),
		//array('name'=>'lastlogin','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd.MM.yyyy HH:mm", $data->lastlogin)','htmlOptions'=>array('style'=>'width:120px;')),
		array(
			'class'=>'EButtonColumnWithClearFilters',
			'template' => '{update} {delete}',
			'htmlOptions'=>array('style'=>'width: 30px;text-align:center;')
		)
	),
	'pager'=>array(
		'firstPageLabel'=>'<<',
		'lastPageLabel'=>'>>',
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast'=>true
	)
));
?>
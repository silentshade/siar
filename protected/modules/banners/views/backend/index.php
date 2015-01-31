<?
$module=Yii::app()->getModule($model->module);
?>
<h1><?=$module->name;?></h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array('name'=>'images','header'=>'<span style="font-size: smaller;">Баннер</span>','type'=>'raw','value'=>'"<img style=\'max-width:88px;\' src=\'/images/banners/admin/".SiteHelper::returnOneImages($data->images)."?m=".$data->modified."\' />"','htmlOptions'=>array('style'=>'font-size: smaller;width:88px;max-width:88px;text-align:center;'),'filter'=>false),
		array(
			'name'=>'name',
			'header'=>'Название',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))',
			'htmlOptions'=>array('class'=>'')
		),
		//'views',
		//'clicked',
		array(
			'name' => 'place',
			'type'=>'raw',
			'value'=>'$data->getPlaces()[$data->place]',
			'htmlOptions'=>array('style'=>'width:140px;'),
			'filter'=>$model->getPlaces(),
		),
		array(
			'name'=>'created',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy", $data->created)',
		),
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
<?
$module=Yii::app()->getModule($model->module);
?>
<h1><?=$module->name;?></h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		'name_conf',
		'name_thesis',
		array(
			'name'=>'user_id',
			'type'=>'raw',
			'value'=>'$data->user->firstname." ".$data->user->midname." ".$data->user->lastname',
			'filter'=>  CHtml::listData(
					User::model()->findAll(
						array(
							'join'=>'inner join thesises on thesises.user_id=t.id',
							'group'=>'t.id',
							'select'=>'t.id, CONCAT(t.firstname," ", t.midname, " ", t.lastname) as firstname'
						)
					), 'id', 'firstname'
			),
		),
		array(
			'name'=>'created',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:mm", $data->created)',
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
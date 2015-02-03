<h1>Рассылки</h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::encode($data->name)',
			'htmlOptions'=>array('class'=>'')
		),
		array(
			'name' => 'sented',
			'type'=>'raw',
			'value'=>'$data->sented==1 ? "Отправлена" : "Не отправлена"',
			'htmlOptions'=>array('style'=>'width:140px;'),
			'filter'=>SiteHelper::$yes_no,
		),
		array(
			'name'=>'created',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:mm:ss", $data->created)',
			'htmlOptions'=>array('style'=>'width:200px;')
		),
		array(
			'name'=>'modified',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:mm:ss", $data->modified)',
			'htmlOptions'=>array('style'=>'width:200px;')
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
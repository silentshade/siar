<h1>Акции</h1>

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
			'template' => '{delete}',
			'htmlOptions'=>array('style'=>'text-align:center;')
		)
	)
));
?>
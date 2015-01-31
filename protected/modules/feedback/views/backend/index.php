<h1>Обратная связь</h1>

<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array('name'=>'id','type'=>'raw','value'=>'$data->id','htmlOptions'=>array('style'=>'width:40px;text-align:center;')),
		'name',
		'email',
		'theme',
		array('name'=>'created','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd.MM.yyyy - HH:mm", $data->created)','htmlOptions'=>array('style'=>'width:130px;')),
		array('header' => '',
				'class'=>'EButtonColumnWithClearFilters',
				//'class' => 'bootstrap.widgets.TbButtonColumn',
				'template' => '{view} {delete}',
				'htmlOptions'=>array('style'=>'text-align:center;width:70px;')
		)
	)
));
?>
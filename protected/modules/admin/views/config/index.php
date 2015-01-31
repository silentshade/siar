<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Настройки сайта',
);
?>

<h1>Настройки сайта</h1>


<?
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'template'=>"{items} {summary} {pager}",
	'summaryText'=>'{start}-{end} из {count}',
	//'enableSorting'=>false,
	'filter' => $model,
	'columns'=>array(
		array('name'=>'section','filter'=>  CHtml::listData(Config::model()->findAll(array('group'=>'section','select'=>'section','condition'=>'visible=1 and section<>""')), 'section', 'section')),
		array('name'=>'label','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->label), array("update", "id"=>$data->id))'),
		array('name'=>'value'),
		array(
			//'header' => '<span rel=tooltip title="Действие">А</span>',
				'class'=>'EButtonColumnWithClearFilters',
				//'class' => 'bootstrap.widgets.TbButtonColumn',
				'template' => '{update} '.(isset($_COOKIE['dev_mode_root']) ? '{delete}' : ''),
				'buttons'=>array
				(
					'delete' => array
					(
						//'url'=>'Yii::app()->createUrl("#")',
						'click'=>"function(){
							if(!confirm('Удалить?'))
								return false;
						}",
					),
				),
				'htmlOptions'=>array('style'=>'text-align:center;')
		)
	),
	'pager'=>array(
		'firstPageLabel'=>'<<',
		//'prevPageLabel'=>'<',
		//'nextPageLabel'=>'>',
		'lastPageLabel'=>'>>',
		//'cssFile'=>false,
		//'header'=>false
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast'=>true
	)
));
?>

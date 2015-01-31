<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array('name'=>'images','type'=>'raw','value'=>'"<a href=/admin/users/update?id=".$data->id."><img style=max-width:50px; src=/images/users/admin/".SiteHelper::returnOneImages($data->images)."?m=".$data->modified." /></a>"','htmlOptions'=>array('style'=>'max-width:50px;width:50px;'),'filter'=>false),
		array('name'=>'lastname','type'=>'raw'),
		array('name'=>'firstname','type'=>'raw'),
		array('name'=>'midname','type'=>'raw'),
		array('name'=>'email','type'=>'raw'),
		//array('name'=>'blocked','type'=>'raw','value'=>'SiteHelper::$yes_no[$data->blocked]','filter'=>SiteHelper::$yes_no),
		//array('name'=>'created','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd.MM.yyyy HH:mm", $data->created)','htmlOptions'=>array('style'=>'width:120px;')),
		//array('name'=>'lastlogin','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd.MM.yyyy HH:mm", $data->lastlogin)','htmlOptions'=>array('style'=>'width:120px;')),
		array(
			'class'=>'EButtonColumnWithClearFilters',
			'template' => '{update} {delete}',
			'htmlOptions'=>array('style'=>'width: 30px;text-align:center;')
		)
	)
));
?>
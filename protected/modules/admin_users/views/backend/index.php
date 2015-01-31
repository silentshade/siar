<?php $this->widget('MGridView',array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'columns'=>array(
		array('name'=>'images','type'=>'raw','value'=>'"<a href=/admin/admin_users/update?id=".$data->id."><img style=max-width:50px; src=/images/admin_users/admin/".SiteHelper::returnOneImages($data->images)."?m=".$data->modified." /></a>"','htmlOptions'=>array('style'=>'max-width:50px;width:50px;'),'filter'=>false),
		array('name'=>'login','type'=>'raw'),
		array('name'=>'email','type'=>'raw'),
		array('name'=>'name','header'=>'ФИО','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))','htmlOptions'=>array('style'=>'width:340px;')),
		//array('name'=>'admin','type'=>'raw','value'=>'SiteHelper::$yes_no[$data->admin]','filter'=>SiteHelper::$yes_no),
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
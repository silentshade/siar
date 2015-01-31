<?php
$module=Yii::app()->getModule($model->module);
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	$module->name=>array('index'),
	$model->name_conf,
	'Редактирование',
);
?>

<h1>Редактирование</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'seo'=>$seo)); ?>
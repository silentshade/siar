<?php
$module=Yii::app()->getModule($model->module);
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	$module->name=>array('index'),
	'Добавить',
);
?>

<h1>Добавить</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
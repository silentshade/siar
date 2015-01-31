<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Модули'=>array('index'),
	$model->name,
	'Редактирование',
);
?>

<h2>Редактирование модуля "<?php echo $model->name; ?>"</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model,'params'=>$params,'sizes'=>$sizes)); ?>
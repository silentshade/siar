<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Настройки сайта'=>array('index'),
	$model->label,
	'Редактирование',
);
?>

<h5>Редактирование <?php echo $model->label; ?></h5>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
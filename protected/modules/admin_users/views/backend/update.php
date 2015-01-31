<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Администраторы'=>array('index'),
	$model->name,
	'Редактирование',
);
?>

<h1>Редактировать <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'seo'=>$seo)); ?>
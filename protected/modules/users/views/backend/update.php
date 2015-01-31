<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Пользователи'=>array('index'),
	$model->lastname.' '.$model->firstname.' '.$model->midname,
	'Редактирование',
);
?>

<h1>Пользователь - <?php echo $model->lastname.' '.$model->firstname.' '.$model->midname; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
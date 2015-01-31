<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Пользователи'=>array('index'),
	'Добавление',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
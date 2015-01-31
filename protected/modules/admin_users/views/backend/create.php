<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Администраторы'=>array('index'),
	'Добавить',
);
?>

<h1>Добавить</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
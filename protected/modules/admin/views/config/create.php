<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Настройки сайта'=>array('index'),
	'Добавление',
);
?>

<h1>Добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'seo'=>$seo)); ?>
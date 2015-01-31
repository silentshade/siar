<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Страницы сайта'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
);
?>

<h1>Редактирование <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'seo'=>$seo)); ?>
<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Пользователи'=>array('index'),
	'Редактирование '.  CHtml::encode($model->name),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
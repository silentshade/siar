<?php
$this->breadcrumbs=array(
	'Панель администратора'=>array('/admin'),
	'Обратная связь'=>array('/admin/feedback'),
	'#'.$model->id,
);
?>

<h4><?=CHtml::encode($model->name);?> (<?=CHtml::encode($model->email);?>)</h4>
<h4><?=$model->theme;?></h4>

<?=$model->text;?>

<h5>Отправлено: <?php echo Yii::app()->dateFormatter->format("dd.MM.yyyy - HH:mm", $model->created); ?></h5>

<div style="margin-top: 50px;">
	<a href="/admin/feedback" class="btn btn-primary">Вернуться назад</a>
</div>
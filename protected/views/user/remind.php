<?php
$this->pageTitle='';
?>

<h1>Восстановление пароля</h1>
<hr>

<div class="form" style="width: 400px;margin-left: 400px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-registration-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Напомнить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
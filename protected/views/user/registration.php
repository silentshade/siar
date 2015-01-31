<?php
$this->pageTitle='Регистрация';
?>

<h1>Регистрация</h1>
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
		<?php echo $form->textField($model,'email',array('style'=>'width:300px;')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('style'=>'width:300px;')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<input type="hidden" name="field">


	<div class="row buttons">
		<?php echo CHtml::submitButton('Зарегистрироваться'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
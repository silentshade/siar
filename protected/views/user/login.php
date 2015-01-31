<?php
$this->pageTitle='Вход';
?>

<h1>Вход</h1>
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

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Войти'); ?>

<!--		<a href="/users/remind">Напомнить пароль</a>-->
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
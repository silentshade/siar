<?php
$this->pageTitle=Yii::app()->params['siteName'] . ' - Вход';
$this->breadcrumbs=array(
	'Вход',
);
?>

<h1>Вход</h1>

<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php echo $form->textFieldRow($model,'username'); ?>
	<?php echo $form->passwordFieldRow($model,'password'); ?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Вход')); ?>
	</div>

<?php $this->endWidget(); ?>
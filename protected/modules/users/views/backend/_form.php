<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
		'autocomplete'=>'off',
	),
)); ?>
	<? $this->beginClip('base'); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email'); ?>
	<?php echo $form->textFieldRow($model,'lastname'); ?>
	<?php echo $form->textFieldRow($model,'firstname'); ?>
	<?php echo $form->textFieldRow($model,'midname'); ?>
	<?php echo $form->textFieldRow($model,'workplace'); ?>
	<?php echo $form->textFieldRow($model,'job'); ?>
	<?php echo $form->textFieldRow($model,'birthday'); ?>


	<? echo $form->hiddenField($model,'id'); ?>
	<input type="hidden" id="Model_id" value="<?=($model->id ? $model->id : '');?>">
	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload',array('form'=>$form, 'model'=>$model, 'field'=>'images', 'module_sizes'=>true, 'path'=>'admin/', 'many'=>false)); ?>

	<? $this->endClip(); ?>


	<? $this->beginClip('rights'); ?>
		<?php echo $form->toggleButtonRow($model, 'blocked',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>
	<? $this->endClip(); ?>

	<? $this->beginClip('password'); ?>
		<?php echo $form->passwordFieldRow($model,'password'); ?>
		<?php echo $form->passwordFieldRow($model,'repeat_password',array('maxlength'=>40)); ?>
	<? $this->endClip(); ?>

	<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Основные', 'content'=>$this->clips['base'], 'active'=>true),
			//array('label'=>'Права', 'content'=>$this->clips['rights']),
			array('label'=>'Пароль', 'content'=>$this->clips['password']),
		),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link','type' => 'default', 'label'=>'К списку', 'url'=>'/admin/'.Yii::app()->controller->id)); ?>
	</div>

<?php $this->endWidget(); ?>
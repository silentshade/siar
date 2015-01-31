<?php
$this->breadcrumbs=array(
	'Панель администратора'=>array('/admin'),
	'Смена пароля'
);
?>
<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'user-form',
			'enableClientValidation'=>true,
			'enableAjaxValidation'=>false,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions'=>array(
				'autocomplete'=>'off'
			),
			'type'=>'horizontal',
		)); ?>
	<fieldset>
		<legend>Изменение пароля</legend>

		<div class="control-group">
			<label for="User_password" class="control-label">Текущий пароль<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->passwordField($model,'password',array('maxlength'=>40)); ?>
                <?php echo $form->error($model,'password'); ?>
			</div>
		</div>


		<div class="control-group">
			<label for="User_repeat_password" class="control-label">Новый пароль<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->passwordField($model,'repeat_password',array('maxlength'=>40)); ?>
				<?php echo $form->error($model,'repeat_password'); ?>
			</div>
		</div>

	</fieldset>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
	</div>
<?php $this->endWidget(); ?>
<h2>Установка</h2>

<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
		<legend>Настройки базы данных</legend>

		<?php echo $form->textFieldRow($model,'db_host',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'db_port',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'db_user',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'db_password',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'db_name',array('class'=>'span4','maxlength'=>255)); ?>
	</fieldset>

	<fieldset>
		<legend>Данные администратора</legend>

		<?php echo $form->emailFieldRow($model,'admin_email',array('class'=>'span4','maxlength'=>255)); ?>
		<?php echo $form->textFieldRow($model,'admin_password',array('class'=>'span4','maxlength'=>255)); ?>
	</fieldset>

	<fieldset>
		<legend>Модули</legend>

		<?php
		if($modules){
			foreach ($modules as $name=>$module) {
				$disabled=$module->not_menu || !$module->delete;
				if($disabled)
					$disabled_modules.='<div class="control-group">'
					. '<label for="Module_'.$name.'" class="control-label required">'.$module->name.($disabled ? ' <span class="required">*</span>' : '').'</label>'
					. '<div class="controls">'
						. CHtml::checkBox('Module['.$name.']', $disabled, array(($disabled ? 'disabled' : 'class')=>($disabled ? 'disabled' : 'class')))
					. '</div>'
				. '</div>';
				else
					$not_disabled_modules.='<div class="control-group">'
					. '<label for="Module_'.$name.'" class="control-label required">'.$module->name.($disabled ? ' <span class="required">*</span>' : '').'</label>'
					. '<div class="controls">'
						. CHtml::checkBox('Module['.$name.']', $disabled || isset($_POST['Module'][$name]), array(($disabled ? 'disabled' : 'class')=>($disabled ? 'disabled' : 'class')))
					. '</div>'
				. '</div>';

			}
			echo $disabled_modules;
			echo $not_disabled_modules;
		}
		?>
	</fieldset>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Установить')); ?>
	</div>

<?php $this->endWidget(); ?>
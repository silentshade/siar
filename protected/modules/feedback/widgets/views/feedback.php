<div class="page-content"> <!-- Page content text -->
	<h3 class="h3">Свяжитсь с нами</h3>
	<p class="forms__attention">Все поля являются обязательными к заполнению</p>
	<?
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'feedback-form',
		'action'=>'/feedback/main/send',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<label class="forms__label">
			<span class="forms__label-text">Ваше имя:</span>
			<?php echo $form->textField($model,'name', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Ваш электронный адрес:</span>
			<?php echo $form->emailField($model,'email', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Тема:</span>
			<?php echo $form->dropDownList($model,'theme', $model->getTheme(), array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Сообщение:</span>
			<?php echo $form->textArea($model,'text', array('class'=>'forms__input forms__input--textarea', 'required'=>'required', 'cols'=>30, 'rows'=>10)); ?>
		</label>

		<input type="submit" class="forms__submit" value="Отправить">
	<?php $this->endWidget(); ?>
</div>
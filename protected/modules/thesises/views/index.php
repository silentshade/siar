<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red">Отправка тезисов</h2>
	<hr class="page-lead__hr">
</div>

<div class="page-content">
	<p class="profile__welcome profile__welcome--centered">Здравствуйте, <?=$user->firstname;?> <?=$user->midname;?> (<?=$user->login;?>)</p>
	<p class="profile__welcome2">Используйте эту форму для отправки тезисов</p>
</div>

<div class="page-content"> <!-- Page content text -->
	<?
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'thesises-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data'
		)
	)); ?> <!-- Send tesis form -->
		<label class="forms__label">
			<span class="forms__label-text">Название конференции</span>
			<?php echo $form->textField($model,'name_conf', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Название тезиса</span>
			<?php echo $form->textField($model,'name_thesis', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Комментарий к тезису</span>
			<?php echo $form->textArea($model,'text', array('class'=>'forms__input forms__input--textarea', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Сопровождающий документ</span>
			<?php echo $form->fileField($model,'file', array('class'=>'forms__input')); ?>
			<?php echo $form->error($model,'file'); ?>
		</label>

		<input type="submit" class="forms__submit" value="Отправить">
	<?php $this->endWidget(); ?>
</div>
<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red">Восстановление пароля</h2>
	<hr class="page-lead__hr">
</div>

<div class="page-content"> <!-- Page content text -->
	<p class="forms__attention">Ссылка для восстановления придет на вашу почту</p>

	<?
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'registation-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'afterValidate'=>new CJavaScriptExpression('function(form, data, hasError) {'
						. 'if(hasError){'
						. ' $(".error").removeClass("error");
							$("#RemindForm_username").addClass("error");'
						. '}else{ $(".error").removeClass("error");'
					. '}'
					. 'return !hasError; }')
		)
	)); ?> <!-- Registration form -->


	<label class="forms__label">
		<span class="forms__label-text">Логин или email:</span>
		<?php echo $form->textField($model,'username', array('class'=>'forms__input', 'required'=>'required')); ?>
		<?php echo $form->error($model,'username'); ?>
	</label>


	<input type="submit" class="forms__submit" value="Напомнить">

<?php $this->endWidget(); ?>

</div><!-- form -->
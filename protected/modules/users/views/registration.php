<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red">Регистрация в РАСХИ</h2>
	<hr class="page-lead__hr">
</div>

<div class="page-content"> <!-- Page content text -->
	<p class="forms__attention">Все поля являются обязательными к заполнению</p>

	<?
	$form = $this->beginWidget('CActiveForm', array(
		'id'=>'registation-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data'
		)
	)); ?> <!-- Registration form -->

		<label class="forms__label">
			<span class="forms__label-text">Фамилия:</span>
			<?php echo $form->textField($model,'lastname', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Имя:</span>
			<?php echo $form->textField($model,'firstname', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Отчество:</span>
			<?php echo $form->textField($model,'midname', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>


		<label class="forms__label">
			<span class="forms__label-text">Дата рождения:</span>
			<?
			$date=explode('-', $model->birthday);
			?>
			<select class="forms__input forms__input--date" required name="day">
				<? for ($index = 1; $index <= 31; $index++) {
					 echo '<option value="'.sprintf("%02d", $index).'"'.($date[2]==sprintf("%02d", $index) ? ' selected' : '').'>'.sprintf("%02d", $index).'</option>';
				 } ?>
			</select>

			<select class="forms__input forms__input--date" required name="month">
				<option value="01"<? if($date[1]=='01') echo ' selected'; ?>>январь</option>
				<option value="02"<? if($date[1]=='02') echo ' selected'; ?>>февраль</option>
				<option value="03"<? if($date[1]=='03') echo ' selected'; ?>>март</option>
				<option value="04"<? if($date[1]=='04') echo ' selected'; ?>>апрель</option>
				<option value="05"<? if($date[1]=='05') echo ' selected'; ?>>май</option>
				<option value="06"<? if($date[1]=='06') echo ' selected'; ?>>июнь</option>
				<option value="07"<? if($date[1]=='07') echo ' selected'; ?>>июль</option>
				<option value="08"<? if($date[1]=='08') echo ' selected'; ?>>август</option>
				<option value="09"<? if($date[1]=='09') echo ' selected'; ?>>сентябрь</option>
				<option value="10"<? if($date[1]=='10') echo ' selected'; ?>>октябрь</option>
				<option value="11"<? if($date[1]=='11') echo ' selected'; ?>>ноябрь</option>
				<option value="12"<? if($date[1]=='12') echo ' selected'; ?>>декабрь</option>
			</select>

			<select class="forms__input forms__input--date" required name="year">
				<? for ($index = 1900; $index <= date('Y'); $index++) {
					 echo '<option value="'.$index.'"'.($date[0]==$index ? ' selected' : '').'>'.$index.'</option>';
				 } ?>
			</select>

		</label>

		<label class="forms__label">
			<span class="forms__label-text">Место работы:</span>
			<?php echo $form->textField($model,'workplace', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Занимаемая должность:</span>
			<?php echo $form->textField($model,'job', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<span class="forms__label-text">Адрес электронной почты (email):</span>
			<?php echo $form->emailField($model,'email', array('class'=>'forms__input', 'required'=>'required')); ?>
		</label>

		<label class="forms__label">
			<? if(empty($model->images)): ?>
			<img src="/img/default-avatar.jpg" alt="" class="forms__avatar">
			<? else: ?>
			<img src="/images/users/small/<?=$model->images;?>" alt="" class="forms__avatar">
			<? endif; ?>
			<div class="forms__img-text">
				<span class="forms__label-text">Фотография</span>
				<span class="forms__sub-text">необязательно</span>
				<p class="forms__sub-text-2">Не более <?=Yii::app()->params['users_size'];?>kb. Изображение будет уменьшено до 100 x 100.</p>
				<?php echo $form->fileField($model,'image', array('class'=>'forms__input')); ?>
				<?php echo $form->error($model,'image'); ?>
			</div>
		</label>


		<input id="phone_text" class="forms__input" type="text" name="phone" maxlength="100">

		<input type="submit" class="forms__submit" value="Отправить">

	<?php $this->endWidget(); ?>

</div>
<?
$htmlOptions=array();
if($model->sented)
	$htmlOptions['onsubmit']='return false;';

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
	'htmlOptions'=>$htmlOptions,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>

	<?php
	$emails=AdminHelper::getUsersEmails();
	if(empty($model->email)){
		//$model->email=$emails;
	}
	//echo CHtml::hiddenField('emails_all', $emails);
	//echo $form->textAreaRow($model,'email',array('class'=>'span6','rows'=>5, 'readonly'=>'readonly'));
	?>


	<div class="control-group">
		<label for="Mailing_email" class="control-label required">Email <span class="required">*</span></label>
		<div class="controls">
			<?

			$users_array=User::model()->findAll(array(
							'select'=>'CONCAT(t.firstname," ", t.lastname, "(",t.email,")") as lastname, t.email',
							'condition'=>'t.blocked=0',
				//'limit'=>5,
							'order'=>'t.lastname'
							));
			if($users_array){
				foreach ($users_array as $value) {
					$sel2arr[]=array('id'=>$value->email,'text'=>$value->lastname);
					$sel2arr_email[]=$value->email;
				}
			}

			$this->widget(
				'bootstrap.widgets.TbSelect2',
				array(
					'asDropDownList' => false,
					'model' => $model,
					'attribute' => 'email',
					'options' => array(
						'placeholder' => 'Начните вводить или выберите из списка',
						'width' => '100%',
						'tags' => $sel2arr,
						'multiple' => true,
						//'tokenSeparators' => array(',', ' ')
					),
					'htmlOptions'=>array(

					)
				)
			);
			?>
			<br><br>
			<button class="btn" type="button" onclick="$('#Mailing_email').val(<?=CJavaScript::encode($sel2arr_email);?>).trigger('change');">Выбрать всех пользователей</button>
			<?php echo $form->error($model, 'email'); ?>
		</div>
	</div>

	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_text" class="control-label required">Текст  <span class="required">*</span></label>
		<div class="controls">
			<? $this->widget('ext.redactor.ERedactorWidget',array(
				'model'=>$model,
				'attribute'=>'text',
				'options'=>array(
					'buttons'=>array('bold', 'italic', 'deleted', '|',
					'unorderedlist', 'orderedlist', '|',
					 'link', '|',
					 'alignment'),
					'minHeight'=> 150,
					'lang'=>'ru',
				),
			)); ?>
			<?php echo $form->error($model,'text'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php
		if($model->sented)
			echo 'Рассылка уже отправлена';
		else
		$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
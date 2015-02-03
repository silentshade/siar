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
	if(empty($model->email))
		$model->email=AdminHelper::getUsersEmails();

	echo $form->textAreaRow($model,'email',array('class'=>'span6','rows'=>5, 'readonly'=>'readonly')); ?>

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
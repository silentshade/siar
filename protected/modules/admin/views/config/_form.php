<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'label',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'param',array('class'=>'span5')); ?>
	<?php
	if($model->type=='text')
		echo $form->textAreaRow($model,'value',array('class'=>'span5','rows'=>5));
	elseif($model->type=='bool')
		echo $form->toggleButtonRow($model, 'value',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',));
	elseif($model->type=='html'){
	?>
		<div class="control-group ">
			<label for="Config_value" class="control-label required">Текст</label>
			<div class="controls">
			<? $this->widget('ext.redactor.ERedactorWidget',array(
					'model'=>$model,
					'attribute'=>'value',
					'options'=>array(
						'formattingTags'=>array('p','h1', 'h2'),
						'buttons'=>array('html',  'bold'),
						'minHeight'=> 150,
						'lang'=>'ru',
					),
				)); ?>
			<?php echo $form->error($model,'value'); ?>
			</div>
		</div>
<?
	}else
		echo $form->textFieldRow($model,'value',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'section',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>
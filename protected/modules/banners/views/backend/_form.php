<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	),
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textAreaRow($model,'text',array('class'=>'span4','rows'=>2)); ?>

	<?php echo $form->dropDownListRow($model,'place', $model->getPlaces(),array('class'=>'span4')); ?>

	<? echo $form->hiddenField($model,'id'); ?>
	<input type="hidden" id="Model_id" value="<?=($model->id ? $model->id : '');?>">

	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload',array('form'=>$form, 'model'=>$model, 'field'=>'images', 'module_sizes'=>true, 'path'=>'admin/')); ?>

	<?php echo $form->textFieldRow($model,'sort',array('class'=>'span4','maxlength'=>6)); ?>

	<?php echo $form->toggleButtonRow($model, 'published',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
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

	<?php echo $form->textFieldRow($model,'tom',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->dropDownListRow($model,'type', array('Номер'=>'Номер', 'Приложение'=>'Приложение'),array('class'=>'span4')); ?>
	<?php echo $form->textFieldRow($model,'nomer',array('class'=>'span4','maxlength'=>255)); ?>

	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_date_published" class="control-label required">Дата публикации </label>
		<div class="controls">
			<?php
			/*if($model->isNewRecord && empty($model->date_published))
				$model->date_published=date('Y-m-j');*/
			?>
			 <? $this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'date_published',
					'language'=>'ru',
					'options'=>array(
						'dateFormat'=>'yy-mm-dd',
						'showButtonPanel' => true,
						'showOn' => 'both',
					),
				));
			?>
			<?php echo $form->error($model,'date_published'); ?>
		</div>
	</div>

	<? echo $form->hiddenField($model,'id'); ?>
	<input type="hidden" id="Model_id" value="<?=($model->id ? $model->id : '');?>">

	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload',array('form'=>$form, 'model'=>$model, 'field'=>'images', 'module_sizes'=>true, 'path'=>'admin/')); ?>

	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload_file',array('form'=>$form, 'model'=>$model, 'field'=>'file', 'module_sizes'=>false, 'path'=>'admin/')); ?>

	<?php echo $form->toggleButtonRow($model, 'published',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
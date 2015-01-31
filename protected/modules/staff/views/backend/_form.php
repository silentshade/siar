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

	<?php echo $form->textFieldRow($model,'job',array('class'=>'span4','maxlength'=>255)); ?>

	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_text" class="control-label required">Текст  <span class="required">*</span></label>
		<div class="controls">
			<? $this->widget('ext.redactor.ERedactorWidget',array(
				'model'=>$model,
				'attribute'=>'text',
				'options'=>array(
					'formattingTags'=>array('p','h1', 'h2'),
					'buttons'=>array('html', '|', '|', 'bold', 'italic', 'deleted', '|',
					'unorderedlist', 'orderedlist', '|',
					'fontcolor', 'backcolor', '|', 'alignment'),
					'minHeight'=> 150,
					'lang'=>'ru',
				),
				'plugins'=> array(
					'fontsize' => array(
						'js' => array('fontsize.js',),
					),
					'fontfamily' => array(
						'js' => array('fontfamily.js',),
					),
					'fontcolor' => array(
						'js' => array('fontcolor.js',),
					),
				),
			)); ?>
			<?php echo $form->error($model,'text'); ?>
		</div>
	</div>

	<? echo $form->hiddenField($model,'id'); ?>
	<input type="hidden" id="Model_id" value="<?=($model->id ? $model->id : '');?>">

	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload',array('form'=>$form, 'model'=>$model, 'field'=>'images', 'module_sizes'=>true, 'path'=>'admin/')); ?>

	<?php echo $form->textFieldRow($model,'sort',array('class'=>'span4','maxlength'=>6)); ?>

	<?php echo $form->toggleButtonRow($model, 'all_row',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>
	<?php echo $form->toggleButtonRow($model, 'published',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
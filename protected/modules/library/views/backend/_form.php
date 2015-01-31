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

	<?php echo $form->textFieldRow($model,'author',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'publisher',array('class'=>'span4','maxlength'=>255)); ?>

	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_text" class="control-label required">Текст  <span class="required">*</span></label>
		<div class="controls">
			<? $this->widget('ext.redactor.ERedactorWidget',array(
				'model'=>$model,
				'attribute'=>'text',
				'options'=>array(
					'formattingTags'=>array('p','h1', 'h2'),
					'buttons'=>array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
					'unorderedlist', 'orderedlist', '|',
					'image', 'video', 'file', 'table', 'link', '|',
					'fontcolor', 'backcolor', '|', 'alignment'),
					'minHeight'=> 150,
					'lang'=>'ru',
					'fileUpload'=>Yii::app()->createUrl('admin/'.$this->module->getName().'/fileUpload').'?attr='.$attribute,
					'fileUploadErrorCallback'=>new CJavaScriptExpression(
						'function(obj,json) { alert(json.error); }'
					),
					'imageUpload'=>Yii::app()->createUrl('admin/'.$this->module->getName().'/imageUpload').'?attr='.$attribute,
					'imageGetJson'=>Yii::app()->createUrl('admin/'.$this->module->getName().'/imageList').'?attr='.$attribute,
					'imageUploadErrorCallback'=>new CJavaScriptExpression(
						'function(obj,json) { alert(json.error); }'
					),
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
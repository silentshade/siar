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
	<? $this->beginClip('base'); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>


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
		<label for="<?=$model->getModelName();?>_begin_conf" class="control-label required">Начало конференции </label>
		<div class="controls">
			<?php
			/*if($model->isNewRecord && empty($model->dt))
				$model->date_begin=date('Y-m-d');		*/
			?>
			<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'begin_conf', //attribute name
					'mode'=>'datetime', //use "time","date" or "datetime" (default)
					'options'=>array(
						'dateFormat'=>'yy-mm-dd',
						'timeFormat'=>'hh:mm:ss',
					),
					'htmlOptions'=>array('autocomplete'=>'off'),
                   'language'=>'ru'
				));
			?>
			<?php echo $form->error($model,'begin_conf'); ?>
		</div>
	</div>

	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_end_conf" class="control-label required">Конец конференции </label>
		<div class="controls">
			<?php
			/*if($model->isNewRecord && empty($model->dt))
				$model->date_begin=date('Y-m-d');		*/
			?>
			<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'end_conf', //attribute name
					'mode'=>'datetime', //use "time","date" or "datetime" (default)
					'options'=>array(
						'dateFormat'=>'yy-mm-dd',
						'timeFormat'=>'hh:mm:ss',
					),
					'htmlOptions'=>array('autocomplete'=>'off'),
                   'language'=>'ru'
				));
			?>
			<?php echo $form->error($model,'end_conf'); ?>
		</div>
	</div>

	<?php echo $form->toggleButtonRow($model, 'published',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>
	<? $this->endClip(); ?>


	<? $this->beginClip('seo'); ?>
		<? $this->widget('admin.widgets.seoWidget',array('seo'=>$seo)) ?>
	<? $this->endClip(); ?>

	<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Основные', 'content'=>$this->clips['base'], 'active'=>true),
			array('label'=>'SEO', 'content'=>$this->clips['seo']),
		),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
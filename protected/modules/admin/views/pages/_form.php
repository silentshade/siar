<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'pages-form',
	'enableClientValidation'=>false,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
)); ?>
	<? $this->beginClip('base'); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('size'=>60,'maxlength'=>255)); ?>

	<div class="control-group ">
		<label for="Pages_text" class="control-label required">Текст  <span class="required">*</span></label>
		<div class="controls">
		<? $this->widget('ext.redactor.ERedactorWidget',array(
				'model'=>$model,
				'attribute'=>'text',
				'options'=>array(
					'formattingTags'=>array('p','h1', 'h2'),
					'buttons'=>array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
					'unorderedlist', 'orderedlist', '|',
					'image', 'video', 'file', 'table', 'link', '|',
					'fontcolor', 'backcolor', '|', 'alignment', 'horizontalrule'),
					'minHeight'=> 150,
					'pastePlainText'=> true,
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
					/*'fontcolor' => array(
						'js' => array('fontcolor.js',),
					),*/
				),
			)); ?>
		<?php echo $form->error($model,'text'); ?>
		</div>
	</div>

	<?php //echo $form->textFieldRow($model,'order',array('size'=>60,'maxlength'=>255)); ?>

	<?php// echo $form->toggleButtonRow($model, 'header',array('enabledLabel'=>'Да','disabledLabel'=>'Нет')); ?>
	<?php //echo $form->toggleButtonRow($model, 'footer',array('enabledLabel'=>'Да','disabledLabel'=>'Нет')); ?>

	<? $this->endClip(); ?>

	<? $this->beginClip('seo'); ?>
		<? $this->renderPartial('/layouts/blocks/seo',array('seo'=>$seo)) ?>
	<? $this->endClip(); ?>

	<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Основные', 'content'=>$this->clips['base'], 'active'=>true),
			array('label'=>'SEO', 'content'=>$this->clips['seo']),
			//array('label'=>'Блок товаров', 'content'=>$this->clips['items'],'visible'=>$model->id==10),
		),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>
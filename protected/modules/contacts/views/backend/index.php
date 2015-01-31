<h1>Контакты</h1>

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


	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>


	<div class="control-group ">
		<label for="<?=$model->getModelName();?>_text" class="control-label required">Текст *</label>
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
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>
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

	<?php echo $form->textFieldRow($model,'name',array('readonly'=>'readonly')); ?>

	<? $this->endClip(); ?>

	<? $this->beginClip('seo'); ?>
		<? $this->renderPartial('/layouts/blocks/seo',array('seo'=>$seo)) ?>
	<? $this->endClip(); ?>

	<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Основные', 'content'=>$this->clips['base']),
			array('label'=>'SEO', 'content'=>$this->clips['seo'], 'active'=>true),
		),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>
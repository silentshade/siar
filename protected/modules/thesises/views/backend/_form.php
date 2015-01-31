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

	<?php echo $form->textFieldRow($model,'name_conf',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'name_thesis',array('class'=>'span4','maxlength'=>255)); ?>

	<?php echo $form->dropDownListRow($model,'user_id', CHtml::listData(
					User::model()->findAll(
						array(
							'join'=>'inner join thesises on thesises.user_id=t.id',
							'group'=>'t.id',
							'select'=>'t.id, CONCAT(t.firstname," ", t.midname, " ", t.lastname, "(", t.email, ")") as firstname'
						)
					), 'id', 'firstname'
			),array('class'=>'span5')); ?>

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

	<? $this->renderPartial('admin.views.layouts.blocks.jqfileupload_file',array('form'=>$form, 'model'=>$model, 'field'=>'file', 'module_sizes'=>false, 'path'=>'admin/')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>
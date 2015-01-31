<script>
	jQuery(function($) {
		$('#Rights_wrapper_1, #Rights_wrapper_2, #Rights_wrapper_3, #Rights_wrapper_4, #Rights_wrapper_5, #Rights_wrapper_6').toggleButtons({'onChange':$.noop,'width':100,'height':25,'animated':true,'label':{'enabled':'Да','disabled':'Нет'},'style':{'enabled':'primary'}});
	});
</script>
<?
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery.ui');
?>
<script type="text/javascript">
	$(function(){
		$(".photo").sortable({
			placeholder: "ui-state-highlight",
			scrollSpeed: 0,
			cursor: "move",
			delay: 0,
			cancel: "a,label,.item-td,button",
			handle: ".icon-move",
			stop : function(){
				rebuildImages();
			}
		});
	});

function rebuildImages(){
	var s=[];
	$(".photo span button").each(function(indx, element){
		s.push($(element).attr("data-id"));
	});
	$('#User_images').val(s.join(";"));
}
</script>
<style>
	.photo span{
		display:inline-block;
		margin-right: 10px;
	}

	.photo span i{
		position:relative;
		top:20px;
		right: -13px;
		cursor: move;
	}

	.photo span button,.photo span i{
		visibility: hidden;
	}

	.photo span:hover button,.photo span:hover i{
		visibility: visible;
	}

	.photo{
		margin-bottom: 10px;
		clear: both;
	}

	#image-inputs .btn{
		visibility: hidden;
	}

	#image-inputs:hover .btn{
		visibility: visible;
	}
</style>
<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
		'autocomplete'=>'off',
	),
	'type'=>'horizontal',
)); ?>
<? $this->beginClip('base'); ?>
	<?php echo $form->textFieldRow($model,'email'); ?>
	<?php echo $form->textFieldRow($model,'name'); ?>


	<div class="control-group ">
		<label class="control-label">Загрузить фото</label>
		<div class="controls"  id="image-inputs">
			<?php echo $form->fileField($model, 'image[]', array('size' => '51','multiple'=>true)); ?>
			<?php echo $form->error($model, 'images'); ?>
		</div>
	</div>

	<div class="control-group ">
		<div class="controls">
			<div class="photo">
				<?php
				if (!$model->isNewRecord) {
					echo $model->GetItemImagesWithCheckbox('small');
				}
				?>
			</div>
			<? echo $form->hiddenField($model,'images'); ?>
		</div>
	</div>
<? $this->endClip(); ?>

<? $this->beginClip('rights'); ?>
	<?php echo $form->toggleButtonRow($model, 'admin',array('enabledLabel'=>'Да','disabledLabel'=>'Нет',)); ?>
<? $this->endClip(); ?>

<? $this->beginClip('password'); ?>
	<?php echo $form->passwordFieldRow($model,'password'); ?>
	<?php echo $form->passwordFieldRow($model,'repeat_password',array('maxlength'=>40)); ?>
<? $this->endClip(); ?>


<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Основные', 'content'=>$this->clips['base'], 'active'=>true),
			array('label'=>'Права', 'content'=>$this->clips['rights']),
			array('label'=>'Пароль', 'content'=>$this->clips['password']),
		),
	)); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Сохранить')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link','type' => 'default', 'label'=>'К списку','url'=>'/admin/'.Yii::app()->controller->id)); ?>

	</div>

<?php $this->endWidget(); ?>
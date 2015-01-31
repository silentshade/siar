<script>
	jQuery(function($) {
		$('#add_image_size').live('click',function(){
			$('#add-size-dialog').dialog('open');
		});

		$('#form-sizes').live('submit',function(){
			if(!$('#form-sizes .control-group.error').length && !$('#form-sizes').attr('sent')){
				$.ajax({
					type: 'post',
					url: $('#form-sizes').attr('action'),
					data: $('#form-sizes').serialize(),
					beforeSend: function(){
						$('#form-sizes').attr('sent',true);
					},
					error: function(){
						$('#form-sizes').removeAttr('sent');
					},
					success: function (html) {
						if(!html){
							$.fn.yiiGridView.update('grid');
							$('#add-size-dialog').dialog('close');
						}else{
							alert(html);
						}
						$('#form-sizes').removeAttr('sent');
					},
				});
			}
			return false;
		});
	});
</script>
<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'form',
	'enableClientValidation'=>false,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'type'=>'horizontal',
)); ?>
<? $this->beginClip('params'); ?>
	<?
	if($params): ?>
		<? foreach ($params as $v): ?>
		<div class="control-group ">
			<label for="Config_<?=$v->id;?>" class="control-label"><?=$v->label;?></label>
			<div class="controls">
				<?php
				if($v->type=='text')
					echo $form->textArea($v,'value',array('class'=>'span5','rows'=>5,'name'=>'Config['.$v->id.']'));
				elseif($v->type=='bool')
					echo $form->toggleButtonRow($v, 'value',array('enabledLabel'=>'Да','disabledLabel'=>'Нет','name'=>'Config['.$v->id.']'));
				elseif($v->type=='int')
					echo $form->numberField($v,'value',array('class'=>'span2','min'=>1,'name'=>'Config['.$v->id.']'));
				elseif($v->type=='email')
					echo $form->emailField($v,'value',array('class'=>'span3'));
				elseif($v->type=='html'){
				?>

				<? $this->widget('ext.redactor.ERedactorWidget',array(
						'model'=>$v,
						'attribute'=>'value',
						'options'=>array(
							'formattingTags'=>array('p','h1', 'h2'),
							'buttons'=>array('html',  'bold'),
							'minHeight'=> 150,
							'lang'=>'ru',
						),
						'htmlOptions'=>array(
							'name'=>'Config['.$v->id.']'
						)
					)); ?>
			<?
				}else
					echo $form->textField($v,'value',array('class'=>'span5')); ?>
				<?php echo $form->error($v,'value'); ?>
				<p class="help-block"><?=$v->help;?></p>
			</div>
		</div>
		<? endforeach;
	endif;
	?>
<? $this->endClip(); ?>

<? $this->beginClip('images'); ?>
	<? if($sizes): ?>
		<?
		$this->widget('bootstrap.widgets.TbGridView', array(
			'id'=>'grid',
			'type'=>'bordered condensed',
			'htmlOptions'=>array('class'=>'grid-view module-grid'),
			'dataProvider'=>$sizes->search(),
			'template'=>"{items} {summary} <button class='btn btn-small pull-right btn-primary' type=button onclick=$.fn.yiiGridView.update('grid')>Обновить</button> {pager}",
			'summaryText'=>'{start}-{end} из {count}',
			//'enableSorting'=>false,
			'filter' => $sizes,
			'columns'=>array(
				array(
					'class' => 'bootstrap.widgets.TbEditableColumn',
					'name' => 'size',
					'editable' => array(
						'title'      => 'Введите размер',
						'url' => $this->createUrl('/admin/modules/editable'),
						'placement' => 'right',
						'inputclass' => 'span2'
					)
				),
				array(
					'class' => 'bootstrap.widgets.TbEditableColumn',
					'name' => 'width',
					'editable' => array(
						'title'      => 'Введите ширину',
						'url' => $this->createUrl('/admin/modules/editable'),
						'placement' => 'right',
						'inputclass' => 'span2'
					)
				),
				array(
					'class' => 'bootstrap.widgets.TbEditableColumn',
					'name' => 'heigth',
					'editable' => array(
						'title'      => 'Введите высоту',
						'url' => $this->createUrl('/admin/modules/editable'),
						'placement' => 'right',
						'inputclass' => 'span2'
					)
				),
				array(
					'class' => 'bootstrap.widgets.TbEditableColumn',
					'name' => 'method',
					//'header'=>'||',
					'value'=>'AdminImagesSizes::model()->method_array[$data->method]',
					'filter'=>AdminImagesSizes::model()->method_array,
					'editable' => array(
						'type'      => 'select',
						'title'      => 'Выберите метод',
						'source'    => AdminImagesSizes::model()->method_array,
						'url' => $this->createUrl('/admin/modules/editable'),
						//'placement' => 'top',
						'inputclass' => 'span2'
					),
					//'headerHtmlOptions'=>array('style'=>'width:90px;')
				),
				array('header' => '<span rel=tooltip title="Действие"></span>',
						'class'=>'bootstrap.widgets.TbButtonColumn',
						'deleteButtonUrl'=>'Yii::app()->controller->createUrl("delete_size",array("id"=>$data->primaryKey))',
						//'class' => 'bootstrap.widgets.TbButtonColumn',
						'template' => '{delete}',
						'htmlOptions'=>array('style'=>'text-align:center;')
				)
				/*array(
					'name' => 'state',
					'type'=>'raw',
					'value'=>'$data->state==1 ? "Установлен" : "Не установлен"',
					'htmlOptions'=>array('style'=>'width:140px;'),
					'filter'=>SiteHelper::$yes_no,
				),*/
			),
		));
		?>
		<button class="btn btn-success btn-small" id="add_image_size" type="button">Добавить размер</button>

	<? endif; ?>
<? $this->endClip(); ?>
	<?
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs',
		'tabs'=>array(
			array('label'=>'Параметры', 'content'=>$this->clips['params'], 'active'=>true),
			array('label'=>'Изображения', 'content'=>$this->clips['images'],'visible'=>$sizes && $sizes->search()->getTotalItemCount()),
		),
	)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>($model->isNewRecord ? 'Добавить новость' : 'Сохранить'))); ?>
	</div>

<?php $this->endWidget(); ?>

<div style="display: none;">
<?
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'add-size-dialog',
	'options'=>array(
	'title'=>'Добавление размера',
	'autoOpen'=>false,
	'resizable'=>false,
	'height'=>'400',
	'width'=>'400',
	'closeOnEscape'=>true,
	'modal'=>true,
	'open' =>'js:function(event, ui) { $("#form-sizes").trigger("reset"); }',
	//'close' =>'js:function(event, ui) { $("#item-block-id").removeAttr("data-id"); }',
	'buttons' => array(
		array('text'=>'Сохранить','click'=> 'js:function(){$("#form-sizes").submit()}','class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'),
		array('text'=>'Закрыть','click'=> 'js:function(){$(this).dialog("close");}','class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only'),
	),
	),
	)); ?>
		<? $form_sizes = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'form-sizes',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'action'=>'/admin/modules/create_size',
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'type'=>'horizontal',
	));
		$admin_size=new AdminImagesSizes(); ?>
		<? echo $form_sizes->textFieldRow($admin_size,'size',array('class'=>'span2')); ?>
		<? echo $form_sizes->hiddenField($admin_size,'module',array('value'=>$model->module)); ?>
		<? echo $form_sizes->numberFieldRow($admin_size,'width',array('class'=>'span2','min'=>1)); ?>
		<? echo $form_sizes->numberFieldRow($admin_size,'heigth',array('class'=>'span2','min'=>1)); ?>
		<? echo $form_sizes->dropDownListRow($admin_size,'method',AdminImagesSizes::model()->method_array,array('class'=>'span2')); ?>

		<?php $this->endWidget(); ?>

<? $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
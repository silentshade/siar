<?
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery.ui');
?>
<div class="control-group ">
	<? echo $form->labelEx($model, $field, array('class'=>'control-label')); ?>
	<? if($crop): ?>
	<input type="hidden" name="<?=$model->getModelName();?>[<?=$field;?>_][crop]" value="<?=$crop;?>">
	<? endif;?>
	<? if($resize): ?>
	<input type="hidden" name="<?=$model->getModelName();?>[<?=$field;?>_][resize]" value="<?=$resize;?>">
	<? endif;?>
	<? if($path): ?>
	<input type="hidden" name="<?=$model->getModelName();?>[<?=$field;?>_][path]" value="<?=$path;?>">
	<? endif;?>
	<? if($module_sizes): ?>
	<input type="hidden" name="<?=$model->getModelName();?>[<?=$field;?>_][module_sizes]" value="<?=$module_sizes;?>">
	<? endif;?>
	<div class="controls">
		<div class="row-i row-file">
			<div class="preview_container logo <?=$model->getModelName().'_'.$field;?>">
				<div class="progress">
					<div class="progress_bar">
						<div class="bar"></div>
					</div>
				</div>
				<div class="img-jqupload-body ijb-<?=$field;?>" data-field="<?=$field;?>" data-model="<?=$model->getModelName();?>">
				<?php
					if ($model->$field) {
						$images=SiteHelper::returnImagesArray($model->$field, true);
						if($images){
							foreach ($images as $value) {
								echo CHtml::openTag('div', array('class' => 'preview'));
									echo CHtml::openTag('div', array('class' => 'panel'));
										echo CHtml::link('','#', array(
											'class' => 'delete delete-jqupload', 'data-id'=>$value
										));
									echo CHtml::closeTag('div');

									echo '<img src="/images/'.$this->module->path_images.'/'.$path.$value.'?m='.$model->modified.'">';
								echo CHtml::closeTag('div');
							}
						}
					}
				?>
				</div>
			</div>
		</div>
		<div class="file_upload">
			<a href="javascript:void(0);" class="btn-light-blue btn btn-success">Загрузить</a>
			<?php
				$this->widget('ext.JQFileUpload.JQFileUpload', array(
					'model' => $model,
					'attribute' => $field,
					'url' => '/admin/'.$this->module->getName().'/JUpload',
					'options' => array(
						'dataType' => 'json',
						'maxFileSize'=>'12000000',
						'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i',
						'progress' => 'js:function(e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$(".preview_container.'.$model->getModelName().'_'.$field.' > .progress").show()
								.find(".progress_bar > .bar")
								.css("width", progress + "%");
						}',
						'processalways' => 'js:function(e, data) {
							var index = data.index,
								file = data.files[index];

							if (file.error) {
								alert(file.error);
							}
						}',
						'done' => 'js:function(e, data) {
							if (data.result.error === false) {
								'.($many ? '$(".preview_container.'.$model->getModelName().'_'.$field.' .img-jqupload-body").append(
										$("<div/>").attr("class", "preview").append(
											$("<div/>").attr("class", "panel").append(
												$("<a/>").attr({
													"href": "#",
													"data-id": data.result.image.id,
													"class": "delete delete-jqupload",
												})
											),
											$("<img/>").attr({"src": data.result.image.src})
										)
									);
									rebuildImagesJQUpload("'.$model->getModelName().'","'.$field.'"); ' : ''
								. '$(".preview_container.'.$model->getModelName().'_'.$field.' .preview").remove();
									$(".preview_container.'.$model->getModelName().'_'.$field.' .img-jqupload-body").append(
										$("<div/>").attr("class", "preview").append(
											$("<div/>").attr("class", "panel").append(
												$("<a/>").attr({
													"href": "#",
													"data-id": data.result.image.id,
													"class": "delete delete-jqupload",
												})
											),
											$("<img/>").attr({"src": data.result.image.src})
										)
									);
									rebuildImagesJQUpload("'.$model->getModelName().'","'.$field.'");').'
							} else {
								alert(data.result.message);
							}
						}',
						'stop' => 'js:function(e) {
							$(".preview_container.'.$model->getModelName().'_'.$field.' > .progress").hide();
						}'
					),
				));
			?>
		</div>
	</div>
</div>
<?
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery.ui');
?>
<div class="control-group ">
	<? echo $form->labelEx($model, $field, array('class'=>'control-label')); ?>
	<div class="controls">
		<div class="row-i row-file">
			<div class="preview_container logo <?=$model->getModelName().'_'.$field;?> preview_container_files">
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

									echo '<a href="/uploads/'.$this->module->getName().'/'.$value.'" target="_blank">Скачать</a>';
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
					'url' => '/admin/'.$this->module->getName().'/JUploadFile',
					'options' => array(
						'dataType' => 'json',
						'maxFileSize'=>'12000000',
						'acceptFileTypes' => 'js:/(\.|\/)(.+)$/i',
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
											$("<a/>").attr({"href": data.result.image.src, "target": "_blank"}).text("Скачать")
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
											$("<a/>").attr({"href": data.result.image.src, "target": "_blank"}).text("Скачать")
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
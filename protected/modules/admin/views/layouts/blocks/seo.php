<div class="control-group ">
	<label for="Seo_title" class="control-label">Заголовок (title)</label>
	<div class="controls">
		<input type="text" value="<?=$seo->title;?>" name="Seo[title]" maxlength="255" class="span5">
	</div>
</div>

<div class="control-group ">
	<label for="Seo_description" class="control-label">Описание (description)</label>
	<div class="controls">
		<input type="text" value="<?=$seo->description;?>" name="Seo[description]" maxlength="255" class="span5">
	</div>
</div>

<div class="control-group ">
	<label for="Seo_keywords" class="control-label">Ключевые слова (keywords)</label>
	<div class="controls">
		<input type="text" value="<?=$seo->keywords;?>" name="Seo[keywords]" maxlength="255" class="span5">
	</div>
</div>

<?=CHtml::hiddenField('Seo[entity]',$seo->entity);?>
<?=CHtml::hiddenField('Seo[type]',$seo->type);?>
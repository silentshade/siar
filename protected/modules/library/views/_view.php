<div class="biblio page-content"> <!-- Book block -->
	<div class="biblio__left">
		<img src="/images/library/small/<?=SiteHelper::returnOneImages($data->images);?>" alt="" class="biblio__img">
		<?
		if($data->file){
			echo '<a href="/uploads/library/'.$data->file.'" class="biblio__btn" target=_blank>Скачать</a>';
		}
		?>
	</div>
	<div class="biblio__right">
		<div class="biblio__title" name="anchor-to-book-<?=$data->id;?>"><?=CHtml::encode($data->name);?></div>
		<div class="biblio__lead">
			<h3 class="biblio__h3"><strong>Автор:</strong> <?=$data->author;?></h3>
			<h3 class="biblio__h3"><strong>Издатель:</strong> <?=$data->publisher;?></h3>
			<h3 class="biblio__h3"><strong>Год:</strong> <?=Yii::app()->dateFormatter->format("yyyy", $data->date_published);?></h3>
		</div>
		<div class="biblio__text"><?=$data->text;?></div>
	</div>
</div>
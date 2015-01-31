<div class="magazines-row__item"> <!-- Magazine -->
	<img src="/images/journal/small/<?=SiteHelper::returnOneImages($data->images);?>" alt="" class="magazines-row__img">
	<div class="magazines-row__m-text">
		<h3 class="magazines-row__m-title">Инфекции в хирургии</h3>
		<hr class="magazines-row__m-hr">
		<p>Том: <?=$data->tom;?></p>
		<p><?=$data->type;?>: <?=$data->nomer;?></p>
		<p>Год: <?=Yii::app()->dateFormatter->format("yyyy", $data->date_published);?></p>
		<?
		if($data->file){
			echo '<a href="/uploads/journal/'.$data->file.'" class="magazines-row__btn" target=_blank>Скачать</a>';
		}
		?>
	</div>
</div>
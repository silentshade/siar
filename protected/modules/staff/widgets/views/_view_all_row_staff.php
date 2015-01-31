<div class="row"> <!-- first wide worker card-->
	<article class="worker-card"> <!-- worker card-->
		<img src="/images/staff/small/<?=SiteHelper::returnOneImages($value->images);?>" alt="" class="worker-card__img">
		<div class="worker-card__about text">
			<h2 class="h2-blue"><?=$value->job;?></h2>
			<h2 class="h2-black"><?=$value->name;?></h2>
			<?=$value->text;?>
		</div>
	</article>
</div>
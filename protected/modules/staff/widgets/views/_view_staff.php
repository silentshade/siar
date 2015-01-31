<article class="worker-card-in-col"> <!-- worker card-->
	<? if($value->images): ?>
	<img src="/images/staff/small/<?=SiteHelper::returnOneImages($value->images);?>" alt="" class="worker-card-in-col__img">
	<? endif; ?>
	<div class="worker-card-in-col__about text<? if(!$value->images) echo ' worker-card-in-col__about--wo-img'; ?>">
		<h2 class="h2-blue"><?=$value->job;?></h2>
		<h2 class="h2-black h2-black--workers"><?=$value->name;?></h2>
		<?=$value->text;?>
	</div>
</article>
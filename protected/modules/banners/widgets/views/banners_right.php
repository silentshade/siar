<?php if($items): ?>
<ul class="as-banners"> <!-- banners -->
	<? foreach ($items as $value): ?>
		<li class="as-banners__item"><a href="<?=$value->text;?>" target="_blank"><img src="/images/banners/right/<?=SiteHelper::returnOneImages($value->images);?>" alt="" class="as-banners__img"></a></li>
	<? endforeach;?>
</ul>
<? endif; ?>
<?php if($items): ?>
<div class="row"> <!-- banner on index page-->
	<div class="index-lead__banner">
	<? foreach ($items as $value): ?>
		<a href="<?=$value->text;?>" target="_blank"><img src="/images/banners/page/<?=SiteHelper::returnOneImages($value->images);?>" alt="" class="index-lead__banner-img"></a>
	<? endforeach;?>
	</div>
</div>
<? endif; ?>
<div class="product type-product">
	<a href="<?=SiteHelper::str2url($data->name).'-p'.$data->id;?>">
		<img src="/images/items/small/<?=SiteHelper::returnOneImages($data->images);?>" alt="<?=CHtml::encode($data->name);?>"/>
		<div><?=CHtml::encode($data->name);?></div>
	</a>

	<span class="price">
		<? if($data->articul) echo '<div>Артикул: '.$data->articul.'</div>'; ?>
		<span class="amount"><?=CenterServiceHelper::$status[$data->status];?>, <?=SiteHelper::unsignZeros($data->price,'',0);?> грн.</span>
	</span>
</div>
<div class="clear"></div>
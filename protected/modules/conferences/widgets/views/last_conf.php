
<section class="as-conferences"> <!-- conferences -->
	<h2 class="as-conferences__title">Ближайшие конференции</h2>
	<hr class="hr">

	<ul>
<?php if($items): ?>
		<? foreach ($items as $value): ?>
		<li class="as-conferences__item">
			<time class="as-conferences__time"><?=$value->getConfDate();?></time>
			<a href="/<?=SiteHelper::str2url($value->name).'-c'.$value->id;?>" class="as-conferences__preview"><?=CHtml::encode($value->name);?></a>
		</li>
		<? endforeach; ?>
<? else: ?>
		<li class="as-conferences__item" style="font-size: 10px;text-align: center;">
			Записей не найдено
		</li>
<? endif; ?>
	</ul>

	<a href="/konferencii" class="as-conferences__btn">Все конференции</a>
</section>


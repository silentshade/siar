<?php if($news): ?>
<div class="b-news-line">
	<div class="b-container">
		<h2>НОВЫЕ АКЦИИ И НОВОСТИ!</h2>
		<a href="/news" class="b-see-all">Смотреть все</a>
		<div class="b-items">
			<?foreach ($news as $value): ?>
			<div class="b-item">
				<a href="/<?=SiteHelper::str2url($value->name).'-n'.$value->id;?>"><img src="/images/news/middle/<?=SiteHelper::returnOneImages($value->images);?>" alt=""></a>
				<div class="b-date"><?=Yii::app()->dateFormatter->format("dd.MM.yyyy", $value->created);?></div>
				<div class="b-link">
					<a href="/<?=SiteHelper::str2url($value->name).'-n'.$value->id;?>"><?=CHtml::encode($value->name);?></a>
				</div>
			</div>
			<? endforeach; ?>
		</div>
	</div>
</div>
<? endif; ?>
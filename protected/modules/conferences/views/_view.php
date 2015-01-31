<li class="conferences__item">
	<time class="conferences__time"><?=$data->getConfDate();?></time>
	<a href="/<?=SiteHelper::str2url($data->name).'-c'.$data->id;?>" class="conferences__preview"><?=CHtml::encode($data->name);?></a>
</li>
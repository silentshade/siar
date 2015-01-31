<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red">Конференции</h2>
	<hr class="page-lead__hr">
</div>




<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/_view',
	'emptyText'=>'Не найдено конференций',
	'itemsTagName'=>'ul',
	'itemsCssClass'=>'conferences page-content',
	'ajaxUpdate'=>false,
	'template'=>"{pager}{items}{pager}",
	'htmlOptions'=>array('class'=>''),
	'pagerCssClass'=>'pagination page-content',
	'pager'=>array(
		'class'=>'CCustomLinkPager',
		/*'firstPageLabel'=>'Первая',
		'lastPageLabel'=>'Последняя',*/
		'prevPageLabel'=>'<',
		'nextPageLabel'=>'>',
		'maxButtonCount'=>5,
		'internalPageCssClass'=>'pagination__item',
		'selectedPageCssClass'=>'pagination__link--active',
		'previousPageCssClass'=>'pagination__item',
		'nextPageCssClass'=>'pagination__item',
		'header'=>false,
		'cssFile'=>false,
		'htmlOptions'=>array(
			'class'=>'ul'
		)
	),
)); ?>
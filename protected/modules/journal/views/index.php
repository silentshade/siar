<div class="page-lead"> <!-- Page leading text -->
	<h2 class="h2-red"><?=CHtml::encode($model->name);?></h2>
	<hr class="page-lead__hr">
</div>

<div class="page-content text"> <!-- Page content text -->
	<?=$model->text;?>
</div>

<div class="page-content"> <!-- Accordion block -->
	<div> <!-- Accordion links -->
		<a href="javascript:void(0);" class="accordionItem__link"><?=$model->redactor_collegy;?></a>
		<span class="accordionItem__line">&nbsp | &nbsp</span>
		<a href="javascript:void(0);" class="accordionItem__link"><?=$model->redactor_advice;?></a>
	</div>

	<div> <!-- Accordion texts -->
		<div class="accordionItem__text js-hide">
			<?=$model->redactor_collegy_text;?>
		</div>
		<div class="accordionItem__text js-hide">
			<?=$model->redactor_advice_text;?>
		</div>
	</div>
</div>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/_view',
	'emptyText'=>'Не найдено журналов',
	'itemsCssClass'=>'row magazines-row',
	'ajaxUpdate'=>false,
	'template'=>"{pager}<div>{items}</div>{pager}",
	'htmlOptions'=>array('class'=>'page-lead'),
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
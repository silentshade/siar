<link rel="stylesheet" type="text/css" href="/css/pager.css" />
<h2 class="search-head">Поиск - <?=CHtml::encode($_GET['q']);?></h2>
<?php
	$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			'emptyText'=>'<div style="margin: 10px; padding:10px;">Ничего не найдено</div>',
			'template'=>'{items} <div class="clearfix"></div> {pager} {summary}',
			'ajaxUpdate'=>false,
			'cssFile'=>false,
			'pager'=>array(
				'cssFile'=>false,
				'header'=>false,
				'nextPageLabel'=>'>',
				'prevPageLabel'=>'<'
			),
			//'itemsTagName'=>'ul',
			'itemsCssClass'=>'products',
			'summaryCssClass'=>'woocommerce-result-count',
			//'enablePagination'=>false,
	));
?>
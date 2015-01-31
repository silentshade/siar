<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Страницы сайта',
);

$cs = Yii::app()->clientScript;
$cs->registerScript('fancybox',"$(document).on('click','#grid a.delete',function() {
	if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
	var th=this;
	var afterDelete=function(){};
	$.fn.yiiGridView.update('grid', {
		type:'POST',
		url:$(this).attr('href'),
		success:function(data) {
			$.fn.yiiGridView.update('grid');
			afterDelete(th,true,data);
		},
		error:function(XHR) {
			return afterDelete(th,false,XHR);
		}
	});
	return false;
});",CClientScript::POS_END);
?>

<h1>Страницы сайта</h1>


<?
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'grid',
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'template'=>"{items} {summary} {pager}",
	'summaryText'=>'{start}-{end} из {count}',
	'enableSorting'=>false,
	'filter' => $model,
	'afterAjaxUpdate'=>'function(id, data){
		var $data=$(data);
		$("[rel=tooltip]").tooltip();
		$(".container>ul").replaceWith($data.find(".container>ul"));

		$("#tabs>ul>li").each(function(index, element){
		  $("#tabs>ul>li").eq(index).find("a").replaceWith($data.find("#tabs>ul>li").eq(index).find("a"));
		});

		$(".grid-view").each(function(indx, element){
		  $("#"+$(element).attr("id")).replaceWith($data.find("#"+$(element).attr("id")));
		});
	}',
	'columns'=>array(
		array('name'=>'name','header'=>'Название','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))','htmlOptions'=>array('class'=>'')),
		//array('name'=>'header','type'=>'raw','value'=>'Pages::model()->yes_no[$data->header]','filter'=>Pages::model()->yes_no,'htmlOptions'=>array('class'=>'')),
		//array('name'=>'footer','type'=>'raw','value'=>'Pages::model()->yes_no[$data->footer]','filter'=>Pages::model()->yes_no,'htmlOptions'=>array('class'=>'')),
		array('name'=>'modified','type'=>'raw','value'=>'Yii::app()->dateFormatter->format("dd MMMM yyyy HH:ss", $data->modified)','htmlOptions'=>array('style'=>'width:190px;')),
		array('name'=>'alias','header'=>'Ссылка','type'=>'raw','value'=>'$data->visible ? "<a href=/".$data->alias." target=_blank>Перейти</a>" : ""','htmlOptions'=>array('style'=>'width:60px;')),
		array('header'=>'','type'=>'raw','value'=>'$data->delete ? "<a href=/admin/pages/delete/".$data->id." rel=tooltip title=Удалить class=delete><i class=icon-trash></i></a>" : ""','htmlOptions'=>array('style'=>'width:10px;')),
	),
	'pager'=>array(
		'firstPageLabel'=>'<<',
		//'prevPageLabel'=>'<',
		//'nextPageLabel'=>'>',
		'lastPageLabel'=>'>>',
		//'cssFile'=>false,
		//'header'=>false
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast'=>true
	)
));
?>
<a href="/admin/<?=Yii::app()->controller->id;?>/create" class="btn btn-success">Добавить</a>
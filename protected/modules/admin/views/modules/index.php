<?php
$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
	'Модули',
);
?>
<script>
function turnModuleON(id){
	$('#grid').addClass('grid-view-loading');
	 $.ajax({
		url: '/admin/modules/TurnModule',
		type: 'GET',
		data: {
			'action': 'ON',
			'id': id
		},
		success: function(data) {
			$.fn.yiiGridView.update('grid');
		}
	});
}
function turnModuleOFF(id){
	if(confirm('Отключить модуль? Внимание будут удалены все записи, и изображения связанные с модулем!')){
		$('#grid').addClass('grid-view-loading');
		 $.ajax({
			url: '/admin/modules/TurnModule',
			type: 'GET',
			data: {
				'action': 'OFF',
				'id': id
			},
			success: function(data) {
				$.fn.yiiGridView.update('grid');
			}
		});
	}
}
</script>

<h1>Модули</h1>

<?
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'grid',
	'type'=>'bordered condensed',
	'htmlOptions'=>array('class'=>'grid-view module-grid'),
	'dataProvider'=>$model->search(),
	'template'=>"{items} {summary} <button class='btn btn-small pull-right btn-primary' type=button onclick=$.fn.yiiGridView.update('grid')>Обновить</button> {pager}",
	'summaryText'=>'{start}-{end} из {count}',
	//'enableSorting'=>false,
	'afterAjaxUpdate'=>'function(id, data){
		$(".sidebar-nav").replaceWith($(data).find(".sidebar-nav"));
	}',
	'filter' => $model,
	'columns'=>array(
		array('name'=>'name','header'=>'Название','type'=>'raw','value'=>'$data->state==1 ? CHtml::link(CHtml::encode($data->name." [v.".$data->version."]"), array("update", "id"=>$data->module)) : CHtml::encode($data->name." [v.".$data->version."]")','htmlOptions'=>array('class'=>'')),
		array(
			'name' => 'state',
			'type'=>'raw',
			'value'=>'$data->state==1 ? "Установлен" : "Не установлен"',
			'htmlOptions'=>array('style'=>'width:140px;'),
			'filter'=>SiteHelper::$yes_no,
		),
		array('header' => '<span rel=tooltip title="Действие"></span>',
				'class'=>'EButtonColumnWithClearFilters',
				//'class' => 'bootstrap.widgets.TbButtonColumn',
				'template' => '{update} {on}{off}',
				'buttons'=>array
				(
					'update' => array
					(
						'url'=>'$data->state==1 ? "/admin/modules/update/".$data->module : "hide"',
					),
					'on' => array
					(
						'label'=>'<i class="icon-remove"></i>',
						'url'=>'$data->module',
						'visible'=>'$data->state=="1" && $data->delete=="1"',
						'options'=>array(
							'onclick'=>'turnModuleOFF($(this).attr("href"));return false;',
							//'class'=>'btn btn-mini btn-danger',
							'title'=>'Отключить',
						),
					),
					'off' => array
					(
						'label'=>'<i class="icon-ok"></i>',
						'url'=>'$data->module',
						'visible'=>'$data->state=="0"',
						'options'=>array(
							'onclick'=>'turnModuleON($(this).attr("href"));return false;',
							//'class'=>'btn btn-mini',
							'title'=>'Включить',
						),
					),
				),
				'htmlOptions'=>array('style'=>'text-align:center;')
		)
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
<?php
/**
 * Customized CGridView to use styles from bootstrap
 */
Yii::import('bootstrap.widgets.TbGridView');
class MGridView extends TbGridView
{
    public $id = 'grid';
    public $type='bordered condensed';
    public $template="{items} {summary} <button class='btn btn-small pull-right btn-primary' type=button onclick=$.fn.yiiGridView.update('grid')>Обновить</button> {pager}";
    public $summaryText='{start}-{end} из {count}';
    public $enableSorting=true;
	
    public $pager=array(
		'firstPageLabel'=>'<<',
		//'prevPageLabel'=>'<',
		//'nextPageLabel'=>'>',
		'lastPageLabel'=>'>>',
		//'cssFile'=>false,
		//'header'=>false
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast'=>true
	);

	public function init()
	{
		parent::init();
		$this->setId($this->id);
	}
}

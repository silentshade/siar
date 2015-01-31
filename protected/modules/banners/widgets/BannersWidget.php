<?php
Yii::import('banners.models.Banners');
Yii::import('admin.components.MainModel');


class BannersWidget extends CWidget
{
	public $limit=1;
	public $place=0;

    public function run()
    {
        $items = Banners::model()->findAll(array(
			'order'=>'sort desc',
			'condition'=>'published=1 and place=:place',
			'params'=>array(':place'=>$this->place),
			'offset'=>0,
			'limit'=>$this->limit
		));

		if($this->place==0)
			$this->render('banners_right', array('items'=>$items));
		if($this->place==1)
			$this->render('banners_index', array('items'=>$items));
    }
}
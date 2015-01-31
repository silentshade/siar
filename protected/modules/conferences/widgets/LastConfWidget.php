<?php
Yii::import('conferences.models.Conferences');
Yii::import('admin.components.MainModel');


class LastConfWidget extends CWidget
{
    public $limit = 3;

    public function run()
    {
        $items = Conferences::model()->findAll(array(
			'order'=>'begin_conf desc',
			//'condition'=>'published=1',
			'condition'=>'published=1 and end_conf>NOW()',
			'offset'=>0,
			'limit'=>$this->limit
		));
        $this->render('last_conf', array('items'=>$items));
    }
}
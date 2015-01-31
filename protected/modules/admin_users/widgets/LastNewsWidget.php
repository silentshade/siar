<?php
Yii::import('news.models.News');
Yii::import('admin.components.MainModel');


class LastNewsWidget extends CWidget
{
    public $limit = 3;

    public function run()
    {
        $news = News::model()->findAll(array(
			'order'=>'created desc',
			'condition'=>'published=1',
			'offset'=>0,
			'limit'=>$this->limit
		));
        $this->render('last_news', array('news'=>$news));
    }
}
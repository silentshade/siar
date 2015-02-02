<?php

class MainController extends FrontController
{
	public function actionIndex()
	{
		Yii::import('ext.feed.*');
		Yii::import('conferences.models.Conferences');
		Yii::import('journal.models.Journal');
		Yii::import('library.models.Library');
		$feed = new EFeed();

		$feed->title= 'Лента RSS';
		//$feed->description = '';

		$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
		$feed->addChannelTag('link', Yii::app()->getBaseUrl(true).'/feed' );

		$conf=Conferences::model()->findAll(array('order'=>'t.begin_conf DESC','condition'=>'published=1', 'offset'=>0, 'limit'=>Yii::app()->params['feed_limit']));
		if($conf)
			foreach ($conf as $value) {
				$items[strtotime($value->begin_conf)]=array(
					'title'=>$value->name,
					'link'=>Yii::app()->getBaseUrl(true).'/'.SiteHelper::str2url($value->name).'-c'.$value->id,
					'date'=>$value->begin_conf,
					'description'=>$value->text
				);
			}

		$journal=Journal::model()->findAll(array('order'=>'t.created DESC','condition'=>'published=1', 'offset'=>0, 'limit'=>Yii::app()->params['feed_limit']));
		if($journal)
			foreach ($journal as $value) {
				$items[strtotime($value->created)]=array(
					'title'=>$value->name,
					'link'=>Yii::app()->getBaseUrl(true).'/journal',
					'date'=>$value->created,
					'description'=>'Том: '.$value->tom.'. '.$value->type.': '.$value->nomer
				);
			}

		$library=Library::model()->findAll(array('order'=>'t.created DESC','condition'=>'published=1', 'offset'=>0, 'limit'=>Yii::app()->params['feed_limit']));
		if($library)
			foreach ($library as $value) {
				$items[strtotime($value->created)]=array(
					'title'=>$value->name,
					'link'=>Yii::app()->getBaseUrl(true).'/library',
					'date'=>$value->created,
					'description'=>$value->text
				);
			}



		if($items){
			krsort($items);
			$items=array_slice($items, 0, Yii::app()->params['feed_limit']);
			foreach ($items as $value) {
				$item = $feed->createNewItem();

				$item->title = $value['title'];
				$item->link = $value['link'];
				$item->date = $value['date'];
				//$item->description = $value['description'];
				$item->description = SiteHelper::wordsLimit($value['description'], Yii::app()->params['feed_limit_word_description']);

				//$item->addTag('author', 'rss4kindle.com.ua');
				$item->addTag('guid', $value['link'],array('isPermaLink'=>'false'));

				$feed->addItem($item);
			}
		}

		$this->beginClip('rss');
			$feed->generateFeed();
		$this->endClip();
		//file_put_contents('rss.xml',$this->clips['rss']);
		header("Content-type: text/xml");
		echo $this->clips['rss'];
		/*Yii::app()->user->setFlash('message','RSS сгенерировано');
		$this->redirect('index');*/
	}
}
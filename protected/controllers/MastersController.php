<?php

class MastersController extends Controller
{
	public function actionIndex()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>17,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$criteria=new CDbCriteria(array(
			//'join'=>'left join articles on articles.id left join articles as articles1 on articles1.id',
			'order'=>'t.sort asc'
		));

		$model=Pages::model()->findByAttributes(array('alias'=>'masters','visible'=>1));

		$items=new CActiveDataProvider('Masters',array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
		$page=Pages::model()->findByAttributes(array('alias'=>'masters','visible'=>1));

		$this->render('index',array('items'=>$items,'model'=>$model,'page'=>$page));
	}
}
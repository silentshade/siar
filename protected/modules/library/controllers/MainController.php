<?php

class MainController extends FrontController
{
	public function actionIndex()
	{
		$page= SeoPages::model()->findByAttributes(array('module'=>'library'));
		SeoHelper::cacheSeoPage($page->id, 4);

		$criteria=new CDbCriteria(array(
			'condition'=>'t.published=1',
			//'join'=>'left join articles on articles.id left join articles as articles1 on articles1.id left join articles as articles2 on articles2.id',
			'order'=>'t.id desc'
		));

		$pagination = new CPagination;
		$pagination->pageSize=Yii::app()->params['library_pagination'];
		$pagination->pageVar='page';

		$dataProvider=new CActiveDataProvider('Library',array(
			'criteria'=>$criteria,
			'pagination'=>$pagination
		));


		$this->render('/index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionView()
	{
		$model=$this->loadModel($_GET['id']);
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>$this->module->seo_type,'module'=>$this->module->getName()));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}else{
			$this->pageTitle=$model->name;
			$this->metaDescription=$model->name;
			$this->metaKeywords=$model->name;
		}

		$this->render('/view',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Library::model()->findByPk($id);
		if($model===null || $model->published==0)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
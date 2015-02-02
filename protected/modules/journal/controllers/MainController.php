<?php

class MainController extends FrontController
{
	public function actionIndex()
	{
		$model=$this->loadModel();
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

		$criteria=new CDbCriteria(array(
			'condition'=>'t.published=1',
			'order'=>'t.id desc'
		));

		$pagination = new CPagination;
		$pagination->pageSize=Yii::app()->params['journal_pagination'];
		$pagination->pageVar='page';

		$dataProvider=new CActiveDataProvider('Journal',array(
			'criteria'=>$criteria,
			'pagination'=>$pagination
		));


		$this->render('/index', array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		$model=JournalPage::model()->find();
		if($model===null)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
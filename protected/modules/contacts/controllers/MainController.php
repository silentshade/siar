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


		$this->render('/index',array('model'=>$model));
	}

	public function loadModel()
	{
		$model=Contacts::model()->find();
		if($model===null)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
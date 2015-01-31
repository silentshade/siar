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

		if(Yii::app()->user->isGuest && isset($_GET['login'])){
			Yii::app()->clientScript->registerScript('login_require','$("#LoginForm_username").focus();',CClientScript::POS_READY);
		}

		$this->render('/index',array('model'=>$model));
	}

	public function loadModel()
	{
		$model=IndexPage::model()->find();
		if($model===null)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
<?php

class SeopagesController extends CAdminController
{
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>4));

		if(isset($_POST['SeoPages']))
		{
			$model->attributes=$_POST['SeoPages'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'seo'=>$seo,
		));
	}

	public function actionIndex()
	{
		$model=new SeoPages('search');
		if(isset($_GET['SeoPages']))
		$model->attributes=$_GET['SeoPages'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=SeoPages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

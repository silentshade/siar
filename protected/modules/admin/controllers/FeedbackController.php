<?php

class FeedbackController extends CAdminController
{
	public function actionIndex()
	{
		$model=new Feedback('search');
		if(isset($_GET['Feedback']))
		$model->attributes=$_GET['Feedback'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionView($id) {
		$model=$this->loadModel($id);

		$this->render('view',array('model'=>$model));
	}

	public function loadModel($id)
	{
		$model=Feedback::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Страница не найдена.');
		return $model;
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
}

<?php

class ServicesController extends CAdminController
{
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Uslugi']))
		{
			$model->attributes=$_POST['Uslugi'];

			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionIndex()
	{
		$model=new Uslugi('search');
		if(isset($_GET['Uslugi']))
		$model->attributes=$_GET['Uslugi'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Uslugi::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}

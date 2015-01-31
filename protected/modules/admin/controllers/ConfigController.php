<?php

class ConfigController extends CAdminController
{
	public function actionCreate()
    {
        $model=new Config;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Config']))
        {
            $model->attributes=$_POST['Config'];

			if($model->save()){
				$this->redirect(array('index'));
			}
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Config']))
		{
			$model->attributes=$_POST['Config'];

			if($model->save()){
				new MyConfig();
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionIndex()
	{
		$model=new Config('search');
		if(isset($_GET['Config']))
			$model->attributes=$_GET['Config'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function loadModel($id)
	{
		$model=Config::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
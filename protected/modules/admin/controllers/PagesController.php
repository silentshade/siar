<?php

class PagesController extends CAdminController
{
	public function actions()
    {
        return array(
            'fileUpload'=>'ext.redactor.actions.FileUpload',
            'imageUpload'=>'ext.redactor.actions.ImageUpload',
            'imageList'=>'ext.redactor.actions.ImageList',
        );
    }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>3));
		if(isset($_POST['DiscountForm'])){
			$model->attributes=$_POST['Pages'];
			$model->text=serialize($_POST['DiscountForm']);
			if($model->save())
				$this->redirect(array('pages/update?id='.$model->id));
		}elseif(isset($_POST['AboutForm'])){
			$model->attributes=$_POST['Pages'];
			$model->text=serialize($_POST['AboutForm']);
			if($model->save())
				$this->redirect(array('pages/update?id='.$model->id));
		}elseif(isset($_POST['ContactPage'])){
			$model->attributes=$_POST['Pages'];
			$model->text=serialize($_POST['ContactPage']);
			if($model->save())
				$this->redirect(array('pages/update?id='.$model->id));
		}elseif(isset($_POST['Pages']))
		{
			$model->attributes=$_POST['Pages'];
			if($model->save())
				$this->redirect(array('pages/update?id='.$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'seo'=>$seo,
		));
	}

	public function actionIndex()
	{
		$model=new Pages('search');
		$model->unsetAttributes();
		if(isset($_GET['Pages']))
		$model->attributes=$_GET['Pages'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model=new Pages();

		if(isset($_POST['Pages']))
		{
			$model->attributes=$_POST['Pages'];
			if($model->save())
				$this->redirect(array('pages/update?id='.$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/pages');
	}
}

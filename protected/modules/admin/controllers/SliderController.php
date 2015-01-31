<?php

class SliderController extends CAdminController
{
	public function actionCreate()
	{
		$model=new Slider;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Slider']))
		{
			$model->attributes = $_POST['Slider'];
			$model->images[] = CUploadedFile::getInstance($model, 'images');

			if ($model->save()) {
				$model->SaveImages();
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Slider']))
		{
			$model->attributes=$_POST['Slider'];

			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDeleteitem()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel($_POST['id']);

			if(is_file($_SERVER['DOCUMENT_ROOT'].'/images/slideshow/'.$model->image)) {
				unlink($_SERVER['DOCUMENT_ROOT'].'/images/slideshow/'.$model->image);
			}
			$model->delete();

		} else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle=Yii::app()->params['siteName'].' - Слайдер - Админ панель';

		$criteria=new CDbCriteria(array(
			'order'=>'sort DESC'
		));

		$dataProvider=new CActiveDataProvider('Slider',array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Slider::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function actionSet_sort()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$sort=$_POST['sort'];
			$menu=new Slider();
			$menu->set_sort($sort);
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');

	}
}

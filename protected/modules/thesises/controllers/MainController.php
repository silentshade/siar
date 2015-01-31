<?php

class MainController extends FrontController
{
	public function init()
	{
		if(isset(Yii::app()->user->admin) && !Yii::app()->user->isGuest){
			$this->redirect('/admin');
		}

		return parent::init();
	}

	public function accessRules()
    {
        return array(
			array('allow',
				'expression'=> '!Yii::app()->user->isGuest',
			),

            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

	public function actionIndex()
	{
		$model=new Thesises('create');
		$user=$this->loadModelUser();

		if(isset($_POST[CHtml::modelName($model)])){
			$model->name_conf = $_POST[CHtml::modelName($model)]['name_conf'];
			$model->name_thesis = $_POST[CHtml::modelName($model)]['name_thesis'];
			$model->text = $_POST[CHtml::modelName($model)]['text'];
			$model->user_id=Yii::app()->user->getid();
			$model->file=CUploadedFile::getInstance($model,'file');
			if ($model->save())
			{
				Thesises::model()->updateByPk($model->id, array('file'=>$model->id.'_'.$model->file));
				$model->file->saveAs('uploads/thesises/'.$model->id.'_'.$model->file);

				Yii::app()->user->setFlash('success','Ваши тезисы были успешно отправлены');
				$this->redirect('/thesises');
			}
		}

		$this->render('/index', array(
			'model'=>$model,
			'user'=>$user,
		));
	}

	public function loadModelUser()
	{
		Yii::import('users.models.User');

		$model=User::model()->findByPk(Yii::app()->user->getid());
		if($model===null || $model->blocked==1)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
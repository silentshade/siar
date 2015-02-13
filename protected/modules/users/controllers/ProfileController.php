<?php

class ProfileController extends FrontController
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
		$this->pageTitle='Профиль';
		
		$model=$this->loadModel();

		if(isset($_POST[CHtml::modelName($model)])){
			$model->lastname = $_POST[CHtml::modelName($model)]['lastname'];
			$model->firstname = $_POST[CHtml::modelName($model)]['firstname'];
			$model->midname = $_POST[CHtml::modelName($model)]['midname'];
			$model->workplace = $_POST[CHtml::modelName($model)]['workplace'];
			$model->job = $_POST[CHtml::modelName($model)]['job'];
			$model->email = $_POST[CHtml::modelName($model)]['email'];
			$model->birthday = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];

			$model->image=CUploadedFile::getInstance($model,'image');
			if ($model->save())
			{
				if($model->image){
					$filename=$model->id.'_'.$model->image;
					User::model()->updateByPk($model->id, array('images'=>$filename));
					$model->image->saveAs('images/users/'.$filename);

					$sizes=AdminImagesSizes::model()->findAllByAttributes(array('module'=>'users'));
					if($sizes){
						$imagePath=$_SERVER['DOCUMENT_ROOT'].'/images/users/';
						foreach ($sizes as $size) {
							AdminHelper::generateImage($imagePath,$filename, $size);
						}
					}
				}

				if(!empty($_POST[CHtml::modelName($model)]['repeat_password']) && !empty($_POST[CHtml::modelName($model)]['password'])){
					$model->repeat_password = $_POST[CHtml::modelName($model)]['repeat_password'];
					if ($model->validatePassword($_POST[CHtml::modelName($model)]['password']) && $model->validate()){
						$model->password=$model->hashPassword($_POST[CHtml::modelName($model)]['repeat_password']);
						if ($model->save()){
							Yii::app()->user->setFlash('message','Ваш пароль был успешно изменен');
							$this->redirect('/profile');
						}
					} else
						$model->addError('password', 'Не правильный пароль');
				}else
					$this->redirect(array('/profile'));
			}
		}
		$model->password='';
        $model->repeat_password='';

		$this->render('/index', array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function loadModel()
	{
		$model=User::model()->findByPk(Yii::app()->user->getid());
		if($model===null || $model->blocked==1)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
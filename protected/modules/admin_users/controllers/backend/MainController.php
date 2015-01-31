<?php

class MainController extends CrudAdminModuleController
{
	public function actionPasschange()
	{
		$model=$this->loadModel(Yii::app()->user->getid());

		$model->setScenario('passchange');
        if (isset($_POST['AdminUsers'])) {
            $model->repeat_password = $_POST['AdminUsers']['repeat_password'];
            if ($model->validatePassword($_POST['AdminUsers']['password']) && $model->validate()){
				$model->password=$model->hashPassword($_POST['AdminUsers']['repeat_password']);
				if ($model->save()){
					Yii::app()->user->setFlash('message','Ваш пароль был успешно изменен');
					$this->redirect('passchange');
				}
            } else
                $model->addError ('password', 'Не правильный пароль');
        }
        $model->password='';
        $model->repeat_password='';
        $this->render('passchange', array('model' => $model,));
	}

	public function actionCreate()
	{
		$model=new AdminUsers();

		if(isset($_POST['AdminUsers']))
		{
			$model->attributes=$_POST['AdminUsers'];

			$model->setScenario('passchange');
			$model->repeat_password = $_POST['AdminUsers']['repeat_password'];
			$model->password=$model->hashPassword($_POST['AdminUsers']['password']);
			if(!empty($_POST['AdminUsers']['password']) && $_POST['AdminUsers']['password']==$_POST['AdminUsers']['repeat_password'] && $model->validate()){
				if ($model->save()){
					//$model->saveRights();
					Yii::app()->user->setFlash('message','Пароль пользователя "'.$model->email.($model->name ? ' - '.$model->name : '').'" был успешно изменен');
				}
			} else
				$model->addError('password', 'Пароли не совпадают');

			if(!$model->hasErrors() && $model->save()){
				//$model->saveRights();
				$this->redirect(array('index'));
			}
		}else{
			$model->password='';
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->setScenario('update');

		if(isset($_POST['AdminUsers']))
		{
			$password=$model->password;
			$model->attributes=$_POST['AdminUsers'];
			$model->password=$_POST['AdminUsers']['password'];

			if(empty($model->password)){
				$model->password=$password;
			}else{
				$model->setScenario('passchange');

				$model->repeat_password = $_POST['AdminUsers']['repeat_password'];
				if($_POST['AdminUsers']['password']==$_POST['AdminUsers']['repeat_password'] && $model->validate()){
					$model->password=$model->hashPassword($_POST['AdminUsers']['repeat_password']);
					if ($model->save()){
						//$model->saveRights();
						Yii::app()->user->setFlash('message','Пароль пользователя "'.$model->email.($model->name ? ' - '.$model->name : '').'" был успешно изменен');
					}
				} else{
					$model->addError('password', 'Пароли не совпадают');
				}
			}



			if(!$model->hasErrors() && $model->save()){
				//$model->saveRights();
				$this->redirect(array('index'));
			}
		}else{
			$model->password='';
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
}

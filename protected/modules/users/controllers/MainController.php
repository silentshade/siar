<?php

class MainController extends FrontController
{
	public function actionLogin()
    {
		Yii::import('users.models.LoginForm');

        if(!Yii::app()->user->isGuest){
			$this->redirect('/profile');
			Yii::app()->end();
		}
		$model= new LoginForm;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			$errors = CActiveForm::validate($model);
			if ($errors != '[]') {
				echo $errors;
				Yii::app()->end();
			}elseif ($model->validate()) {
				echo CJSON::encode(
					array(
						'authenticated' => true,
						'redirectUrl' => '/profile',
					)
				);
				Yii::app()->end();
			}
			Yii::app()->end();
		}
    }

	public function actionRegistration()
    {
		Yii::import('users.models.User');

		if(!empty($_POST['phone'])){
			$this->redirect('/');
		}

        if(!Yii::app()->user->isGuest){
			$this->redirect('/profile');
			Yii::app()->end();
		}
		$model= new User('registration');

		if(isset($_POST[CHtml::modelName($model)])){
			$model->lastname = $_POST[CHtml::modelName($model)]['lastname'];
			$model->firstname = $_POST[CHtml::modelName($model)]['firstname'];
			$model->midname = $_POST[CHtml::modelName($model)]['midname'];
			$model->workplace = $_POST[CHtml::modelName($model)]['workplace'];
			$model->job = $_POST[CHtml::modelName($model)]['job'];
			$model->email = $_POST[CHtml::modelName($model)]['email'];
			$model->birthday = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
			$model->image=CUploadedFile::getInstance($model,'image');
			if ($model->validate())
			{
				$password=uniqid();
				$model->password=$model->hashPassword($password);
				$model->login=explode('@', $model->email)[0];
				if($model->save()){

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

					$title="Данные для авторизации";
					$text = 'Здравствуйте, '.$model->firstname.' '.$model->midname.'<br><br>
					Ваши данные для авторизации на РАСХИ:<br><br>
					Имя пользователя: '.$model->login.'<br>
					Пароль: '.$password.'<br><br>
					После успешной авторизации на РАСХИ (<a href="'.Yii::app()->request->getBaseUrl(true).'">'.Yii::app()->request->getBaseUrl(true).'</a>), вы сможете изменить свой пароль.<br><br>
					С уважением, Администрация';

					SiteHelper::mail_with_body($model->email, $title, 'registration',array('text'=>$text,'id'=>$model->id),'main','application.modules.users.views.email');

					Yii::app()->user->setFlash('success','Вы успешно зарегистрировались. Проверьте почту');
					$this->redirect('/request-an-account');
				}
			}
		}

		$this->render('/registration',array('model'=>$model));
    }

	public function actionRemind() {
		if(Yii::app()->user->isGuest){
			$form_model=new RemindForm();

			if(isset($_POST['RemindForm']['username'])){
				$form_model->username=$_POST['RemindForm']['username'];
				if($form_model->validate()){
					$user=User::model()->find(array('condition'=>'email=:email OR login=:login', 'params'=>array(':login'=>$form_model->username, ':email'=>$form_model->username)));
					if($user){
						$hash = md5(mktime().uniqid());

						UserRemind::model()->deleteAllByAttributes(array('user'=>$user->id));

						$user_remind=new UserRemind();
						$user_remind->hash=$hash;
						$user_remind->user=$user->id;
						if($user_remind->save()){
							$title="Восстановление пароля";
							$text = 'Здравствуйте!<br><br>
							Вы, или кто-то другой запросили восстановление пароля на сайте '.Yii::app()->request->getBaseUrl(true).'.<br>
							Если это действительно сделали вы, то для смены пароля перейдите по ссылке:<br><a href="'.Yii::app()->request->getBaseUrl(true).'/users/reminder?h='.$hash.'">'.Yii::app()->request->getBaseUrl(true).'/users/reminder?h='.$hash.'</a><br><br><br>
							Если вы не запрашивали восстановление пароля или кто-то случайно указал твой e-mail адрес, то просто удалите это письмо.';

							SiteHelper::mail_with_body(
								$user->email,
								$title,
								'remind',
								array(
									'text'=>$text
								),
								'main',
								'application.modules.users.views.email'
							);
						}
						Yii::app()->user->setFlash('success','Проверьте ваш email');
						$this->redirect('/');
					}else{
						$form_model->addError('username', 'Email или логин не найден');
					}
				}
			}else{
				$this->render('/remind',array('model'=>$form_model));
			}
		}else{
			$this->redirect('/');
		}
	}

	public function actionReminder(){
		if(isset($_GET['h'])){
			$user_remind=UserRemind::model()->findByAttributes(array('hash'=>$_GET['h']));
			if($user_remind){
				$password=uniqid();
				$model=User::model()->findByPk($user_remind->user);
				$model->password=$model->hashPassword($password);
				if($model->save(false)){
					$title="Вы запросили смену пароля";
					$text = 'Здравствуйте, '.$model->firstname.' '.$model->midname.'<br><br>
					Ваши данные для авторизации на РАСХИ:<br><br>
					Имя пользователя: '.$model->login.'<br>
					Пароль: '.$password.'<br><br>
					После успешной авторизации на РАСХИ (<a href="'.Yii::app()->request->getBaseUrl(true).'">'.Yii::app()->request->getBaseUrl(true).'</a>), вы сможете изменить свой пароль.<br><br>
					С уважением, Администрация';

					SiteHelper::mail_with_body($model->email, $title, 'registration',array('text'=>$text,'id'=>$model->id),'main','application.modules.users.views.email');

					Yii::app()->user->setFlash('success','Вы успешно восстановили пароль. Проверьте почту');
					$this->redirect('/');
				}
			}else
				$this->redirect('/');
		}else
			$this->redirect('/');
	}

	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null || $model->published==0)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
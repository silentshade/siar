<?php

class MainController extends FrontController
{
	public function actionRemind() {
		if(Yii::app()->user->isGuest){
			$model=new Users('remind');

			if(isset($_POST['Users']['email'])){
				$email=$_POST['Users']['email'];

				$model->email=$email;

				$user=Users::model()->findByAttributes(array('email'=>$email));
				if($user && !empty($email)){
					$hash = md5(mktime().uniqid());

					UserRemind::model()->deleteAllByAttributes(array('user'=>$user->id));

					$user_remind=new UserRemind();
					$user_remind->hash=$hash;
					$user_remind->user=$user->id;
					if($user_remind->save()){
						$title="Восстановление пароля на сайте RSS для Kindle";
						$text = 'Здравствуйте!<br><br>
						Вы, или кто-то другой запросили восстановление пароля на сайте '.Yii::app()->request->getBaseUrl(true).'.<br>
						Если это действительно сделали вы, то для смены пароля перейдите по ссылке:<br><a href="'.Yii::app()->request->getBaseUrl(true).'/user/reminder?h='.$hash.'">'.Yii::app()->request->getBaseUrl(true).'/user/reminder?h='.$hash.'</a><br><br><br>
						Если вы не запрашивали восстановление пароля или кто-то случайно указал твой e-mail адрес, то просто удалите это письмо.';

						SiteHelper::mail_with_body($user->email, $title, $text,$user->id);
					}
					Yii::app()->user->setFlash('success','Проверьте ваш email');
					$this->redirect('/login');
				}else{
					$model->addError('email', 'Email не найден');
				}
			}else{
				$this->render('remind',array('model'=>$model));
			}
		}else{
			$this->redirect('/');
		}
	}

	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null || $model->published==0)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}
}
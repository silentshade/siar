<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		$this->layout='//layouts/full';
		//$about=Pages::model()->findByAttributes(array('dev_alias'=>'site_index_about'));

		$page= SeoPages::model()->findByAttributes(array('module'=>'index'));
		//$seo=
		SeoHelper::cacheSeoPage($page->id, 4);
		/*if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}*/

		$this->render('index',array('about'=>$about));
	}

	public function actionTest(){
		Yii::import('news.install.InstallHelper');
		Yii::import('admin.models.AdminModules');
		$ih=new InstallHelper();
		$module=AdminModules::model()->findByAttributes(array('module'=>'news','state'=>1));
		if(!$module){
			$ih->install();
			echo 'install';
		}else{
			$ih->uninstall();
			echo 'uninstall';
		}

		//$ih->regenerateImages();
		//echo 'regenerate';
		Yii::app()->end();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->pageTitle=Yii::app()->name . ' - Ошибка';
		$this->breadcrumbs=array(
			'Ошибка',
		);

		if($error=Yii::app()->errorHandler->error)
		{
			error_log(date('Y-m-j H-i-s').' '.$error['code'].' '.$error['message'].' '.$_SERVER[REQUEST_URI].' '.$_SERVER['HTTP_USER_AGENT'].' '.$_SERVER['REMOTE_ADDR']."\n", 3,dirname($_SERVER['SCRIPT_FILENAME'])."/error_log");

			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else{
				$model=Pages::model()->findByAttributes(array('alias'=>'404','visible'=>1));
				if($model){
					$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>3));
					if($seo){
						$this->pageTitle=$seo->title;
						$this->metaDescription=$seo->description;
						$this->metaKeywords=$seo->keywords;
					}else{
						$this->pageTitle=$model->name;
						$this->metaDescription=$model->name;
						$this->metaKeywords=$model->name;
					}
				}

				$this->render('error', array('model'=>$model));
			}
		}
	}

	public function actionContact()
	{
		$model=new Feedback;
		if(isset($_POST))
		{
			$model->name=$_POST['name'];
			$model->email=$_POST['email'];
			$model->text=$_POST['text'];
			if($model->save())
			{
				$message=$model->name.' ('.$model->email.')<br>';
				$message.=$model->text;
				SiteHelper::mail_utf8(Yii::app()->params['adminEmail'],$model->name,$model->email, 'Сообщение в обратной связи №'.$model->id, $message);

				/*$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);*/
				//Yii::app()->user->setFlash('contact','Спасибо за сообщение! Мы ответим как можно скорее.');
			}
		}
		$this->redirect('/contacts');
	}


}
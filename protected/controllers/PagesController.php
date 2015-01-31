<?php

class PagesController extends Controller
{
	public function actionView()
	{
		$model=$this->loadModel($_GET['page']);


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

		if($_GET['page']=='opt'){
			$form_model=new ContactForm;
			if(isset($_POST['ContactForm']))
			{
				if(!empty($_POST['password'])){
					error_log('['.date("Y-m-d H:i:s").'] spam_email='.$_POST['ContactForm']['email'].' user-agent='.$_SERVER['HTTP_USER_AGENT'].' ip='.$_SERVER['REMOTE_ADDR'].' '.$_POST['password'].' '.$_POST['ContactForm']['name']."\n", 3, dirname($_SERVER['SCRIPT_FILENAME'])."/spam_log");
					$this->redirect('/');
				}

				$form_model->attributes=$_POST['ContactForm'];
				if($form_model->validate())
				{
					Yii::app()->session->add("opt", true);

					$name='=?UTF-8?B?'.base64_encode(Yii::app()->params['siteName']).'?=';
					$subject='=?UTF-8?B?'.base64_encode($form_model->name.' ('.$form_model->email.')').'?=';
					$headers="From: $name <".Yii::app()->params['siteEmail'].">\r\n".
						"Reply-To: {$form_model->email}\r\n".
						"MIME-Version: 1.0\r\n".
						"Content-type: text/plain; charset=UTF-8";

					mail(Yii::app()->params['adminEmail'],$subject,$form_model->name.' ('.$form_model->email.') '. $form_model->phone,$headers);
					Yii::app()->user->setFlash('contact','Спасибо за сообщение! Мы ответим как можно скорее.');
					$this->refresh();
				}
			}
		}


		$this->render('view',array(
			'model'=>$model,
			'form_model'=>$form_model,
		));
	}

	public function actionView_dynamic()
	{
		$model=$this->loadModelDynamic($_GET['id']);


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

		$this->render('view_dynamic',array(
			'model'=>$model,
		));
	}



	private function loadModel($page)
	{
		$model=Pages::model()->findByAttributes(array('alias'=>$page,'visible'=>1));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	private function loadModelDynamic($page)
	{
		$model=Pages::model()->findByAttributes(array('id'=>$page,'visible'=>1));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionAbout()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>16,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$model=$this->loadModel($_GET['page']);
		$this->render('about',array('model'=>$model));
	}

	public function actionDiscount()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>15,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$model=$this->loadModel($_GET['page']);
		$this->render('discount',array('model'=>$model));
	}

	public function actionContacts()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>3,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$model=$this->loadModel($_GET['page']);
		$this->render('contacts',array('model'=>$model));
	}

	public function actionServices()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>9,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$model=$this->loadModel($_GET['page']);

		$uslugi=Uslugi::model()->findAll();

		$this->render('services',array('model'=>$model,'uslugi'=>$uslugi));
	}
}
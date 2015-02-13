<?php

class MainController extends CrudAdminModuleController
{
	public function actionMailall(){
		set_time_limit(5000);

		$mailings=Mailing::model()->findAllByAttributes(array('sented'=>0));
		if($mailings){
			foreach ($mailings as $mailing) {
				if($mailing && $mailing->email){
					$emails=explode(',',$mailing->email);
					if($emails){
						foreach ($emails as $email) {
							SiteHelper::mail_with_body(
								$email,
								$mailing->name,
								'mailing',
								array(
									'text'=>$mailing->text
								),
								'main',
								'application.modules.mailing.views.email'
							);
							$i++;
						}
					}

					$mailing->sented=1;
					$mailing->save();


				}
			}

			Yii::app()->user->setFlash('success','Рассылки отправлены');
		}else{
			Yii::app()->user->setFlash('error','Нет активных рассылок');
		}

		$this->redirect('/admin/mailing');
	}

	public function actionMail(){
		set_time_limit(5000);

		$mailing=Mailing::model()->findByAttributes(array('sented'=>0, 'id'=>$_GET['id']));
		if($mailing && $mailing->email){
			$emails=explode(',',$mailing->email);
			if($emails){
				foreach ($emails as $email) {
					SiteHelper::mail_with_body(
						$email,
						$mailing->name,
						'mailing',
						array(
							'text'=>$mailing->text
						),
						'main',
						'application.modules.mailing.views.email'
					);
					$i++;
				}
			}

			$mailing->sented=1;
			$mailing->save();


			Yii::app()->user->setFlash('success','Рассылка отправлена');
		}else{
			Yii::app()->user->setFlash('error','Рассылка уже отправлена');
		}

		$this->redirect('/admin/mailing');
	}
}

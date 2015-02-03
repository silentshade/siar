<?php
class MailingCommand extends CConsoleCommand
{
	public function init()
	{
		set_time_limit(5000);
	}

	public function actionMail(){

		$mailing=Mailing::model()->findByAttributes(array('sented'=>0));
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
}

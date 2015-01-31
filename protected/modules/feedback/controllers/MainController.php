<?php

class MainController extends FrontController
{
	public function actionSend()
	{
		$model=new Feedback();
		if(isset($_POST))
		{
			$model->name=$_POST[CHtml::modelName($model)]['name'];
			$model->email=$_POST[CHtml::modelName($model)]['email'];
			$model->theme=$_POST[CHtml::modelName($model)]['theme'];
			$model->text=$_POST[CHtml::modelName($model)]['text'];
			if($model->save())
			{
				if(Yii::app()->params['feedback_emails'])
					SiteHelper::mail_with_body(
						Yii::app()->params['feedback_emails'],
						'Сообщение в обратной связи №'.$model->id,
						'feedback',
						array(
							'model'=>$model
						),
						'main',
						'application.modules.feedback.views.email'
					);
				Yii::app()->user->setFlash('success', Yii::app()->params['feedback_text']);
			}else{
				Yii::app()->user->setFlash('error','Произошла ошибка');
			}
		}

		$this->redirect('/contacts');
	}
}
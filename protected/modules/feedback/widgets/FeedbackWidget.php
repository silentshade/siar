<?php
Yii::import('feedback.models.Feedback');
Yii::import('admin.components.MainModel');


class FeedbackWidget extends CWidget
{
    public function run()
    {
        $model = new Feedback();
        $this->render('feedback', array('model'=>$model));
    }
}
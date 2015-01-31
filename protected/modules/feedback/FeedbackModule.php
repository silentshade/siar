<?php

class FeedbackModule extends Module
{
	public $version='1';
	public $name='Обратная связь';
	public $path_images='';
	public $model=Feedback;

	public function getMenuItems(){
		return array(
            array('label' => 'Обратная связь'),
			array('label' => 'Обратная связь', 'icon' => 'icon-file', 'url' => '/admin/feedback', 'active' => Yii::app()->controller->id=='feedback' && Yii::app()->controller->action->id=='index'),
        );
	}
}

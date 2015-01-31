<?php

class ConferencesModule extends Module
{
	public $version='1';
	public $name='Конференции';
	public $path_images='';
	public $model=Conferences;
	public $seo_type=9;

	public function getMenuItems(){
		return array(
            array('label' => 'Конференции'),
			array('label' => 'Конференции', 'icon' => 'icon-file', 'url' => '/admin/conferences', 'active' => Yii::app()->controller->id=='conferences' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить конференцию', 'icon' => 'icon-plus-sign', 'url' => '/admin/conferences/create', 'active' => Yii::app()->controller->id=='conferences' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}

	public static function rules()
    {
        return array(
			'konferencii'=>'conferences/main/index',
            '<conferences:.*?>-c<id:\d+>'=>'conferences/main/view',
        );
    }
}

<?php

class BannersModule extends Module
{
	public $version='1';
	public $name='Баннеры';
	public $path_images='banners';
	public $model=Banners;

	public function getMenuItems(){
		return array(
            array('label' => 'Баннеры'),
			array('label' => 'Баннеры', 'icon' => 'icon-file', 'url' => '/admin/banners', 'active' => Yii::app()->controller->id=='banners' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить баннер', 'icon' => 'icon-plus-sign', 'url' => '/admin/banners/create', 'active' => Yii::app()->controller->id=='library' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}
}

<?php

class MailingModule extends Module
{
	public $version='1';
	public $name='Рассылки';
	public $path_images='';
	public $model=Mailing;

	public function getMenuItems(){
		return array(
            array('label' => 'Рассылки'),
			array('label' => 'Рассылки', 'icon' => 'icon-file', 'url' => '/admin/mailing', 'active' => Yii::app()->controller->id=='mailing' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить рассылку', 'icon' => 'icon-plus-sign', 'url' => '/admin/mailing/create', 'active' => Yii::app()->controller->id=='library' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}
}

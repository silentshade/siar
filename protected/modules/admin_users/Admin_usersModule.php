<?php

class Admin_usersModule extends Module
{
	public $version='1';
	public $name='Администраторы';
	public $path_images='admin_users';
	public $model=AdminUsers;
	//public $seo_type=2;
	public $delete=false;

	public function getMenuItems(){
		return array(
            array('label' => 'Администраторы'),
			array('label' => 'Администраторы', 'icon' => 'icon-file', 'url' => '/admin/admin_users', 'active' => Yii::app()->controller->id=='admin_users' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить', 'icon' => 'icon-plus-sign', 'url' => '/admin/admin_users/create', 'active' => Yii::app()->controller->id=='admin_users' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}
}

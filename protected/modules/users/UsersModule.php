<?php

class UsersModule extends Module
{
	public $version='1';
	public $name='Пользователи';
	public $path_images='users';
	public $model=User;
	//public $seo_type=2;
	//public $delete=false;

	public function getMenuItems(){
		return array(
            array('label' => 'Пользователи'),
			array('label' => 'Пользователи', 'icon' => 'icon-file', 'url' => '/admin/users', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить пользователя', 'icon' => 'icon-plus-sign', 'url' => '/admin/users/create', 'active' => Yii::app()->controller->id=='users' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}

	public static function rules()
    {
        return array(
            'users/login'=>'users/main/login',
            'request-an-account'=>'users/main/registration',
            'profile'=>'users/profile/index',
            'logout'=>'users/profile/logout',
            'remind'=>'users/main/remind',
            'users/reminder'=>'users/main/reminder',
        );
    }
}

<?php

class LibraryModule extends Module
{
	public $version='1';
	public $name='Библиотека';
	public $path_images='library';
	public $model=Library;

	public function getMenuItems(){
		return array(
            array('label' => 'Библиотека'),
			array('label' => 'Библиотека', 'icon' => 'icon-file', 'url' => '/admin/library', 'active' => Yii::app()->controller->id=='library' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить книгу', 'icon' => 'icon-plus-sign', 'url' => '/admin/library/create', 'active' => Yii::app()->controller->id=='library' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}

	public static function rules()
    {
        return array(
			'library'=>'library/main/index',
        );
    }
}

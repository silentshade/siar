<?php

class IndexModule extends Module
{
	public $version='1';
	public $name='Главная страница';
	public $path_images='';
	public $model=IndexPage;
	public $seo_type=6;
	public $delete=false;

	public function getMenuItems(){
		return array(
            array('label' => 'Главная страница'),
			array('label' => 'Главная страница', 'icon' => 'icon-file', 'url' => '/admin/index', 'active' => Yii::app()->controller->id=='index' && Yii::app()->controller->action->id=='index'),
        );
	}

	public static function rules()
    {
        return array(
            '/'=>'index/main/index',
        );
    }
}

<?php

class SearchModule extends Module
{
	public $version='1';
	public $name='Поиск';
	public $path_images='';
	public $model=Search;
	public $seo_type=15;

	public function getMenuItems(){
		return array(
            array('label' => 'Поиск'),
			array('label' => 'Поиск', 'icon' => 'icon-file', 'url' => '/admin/search', 'active' => Yii::app()->controller->id=='search' && Yii::app()->controller->action->id=='index'),
        );
	}

	public static function rules()
    {
        return array(
            'search?q=<q:\w+>'=>'search/main/index',
        );
    }
}

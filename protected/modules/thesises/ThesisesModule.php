<?php

class ThesisesModule extends Module
{
	public $version='1';
	public $name='Тезисы';
	public $path_images='';
	public $model=Thesises;

	public function getMenuItems(){
		return array(
            array('label' => 'Тезисы'),
			array('label' => 'Тезисы', 'icon' => 'icon-file', 'url' => '/admin/thesises', 'active' => Yii::app()->controller->id=='thesises' && Yii::app()->controller->action->id=='index'),
        );
	}

	public static function rules()
    {
        return array(
			'thesises'=>'thesises/main/index',
        );
    }
}

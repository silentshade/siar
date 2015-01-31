<?php

class JournalModule extends Module
{
	public $version='1';
	public $name='Журнал';
	public $path_images='journal';
	public $model=Journal;
	public $seo_type=8;

	public function getMenuItems(){
		return array(
            array('label' => 'Журнал'),
			array('label' => 'Журнал', 'icon' => 'icon-file', 'url' => '/admin/journal', 'active' => Yii::app()->controller->id=='journal' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить журнал', 'icon' => 'icon-plus-sign', 'url' => '/admin/journal/create', 'active' => Yii::app()->controller->id=='journal' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
			array('label' => 'Страница журналов', 'icon' => 'icon-file', 'url' => '/admin/journal/page/index', 'active' => Yii::app()->controller->id=='journal' && Yii::app()->controller->action->id=='index'),
        );
	}

	public static function rules()
    {
        return array(
			'journal'=>'journal/main/index',
        );
    }
}

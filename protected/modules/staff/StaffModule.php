<?php

class StaffModule extends Module
{
	public $version='1';
	public $name='Сотрудники';
	public $path_images='staff';
	public $model=Staff;

	public function getMenuItems(){
		return array(
            array('label' => 'Сотрудники'),
			array('label' => 'Сотрудники', 'icon' => 'icon-file', 'url' => '/admin/staff', 'active' => Yii::app()->controller->id=='staff' && Yii::app()->controller->action->id=='index'),
			array('label' => 'Добавить сотрудника', 'icon' => 'icon-plus-sign', 'url' => '/admin/staff/create', 'active' => Yii::app()->controller->id=='staff' && Yii::app()->controller->action->id=='create', 'linkOptions' => array('class' => 'sub')),
        );
	}
}

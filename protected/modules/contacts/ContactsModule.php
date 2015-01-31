<?php

class ContactsModule extends Module
{
	public $version='1';
	public $name='Контакты';
	public $path_images='';
	public $model=Contacts;
	public $seo_type=7;

	public function getMenuItems(){
		return array(
            array('label' => 'Контакты'),
			array('label' => 'Контакты', 'icon' => 'icon-file', 'url' => '/admin/contacts', 'active' => Yii::app()->controller->id=='contacts' && Yii::app()->controller->action->id=='index'),
        );
	}

	public static function rules()
    {
        return array(
            'contacts'=>'contacts/main/index',
        );
    }
}

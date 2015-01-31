<?php

class AdminModule extends Module
{
    public $defaultController = 'admin';
	public $version='1';
	public $name='Админка';
	public $not_menu=true;
	public $delete=false;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'application.modules.admin.components.*',
			'application.modules.admin.components.widgets.*',
		));
	}
}

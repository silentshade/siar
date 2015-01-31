<?php
/**********************************************************************************************
*                            CMS Open Business Card
*                              -----------------
*	version				:	1.3.1
*	copyright			:	(c) 2014 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Business Card
*
* Open Business Card is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Business Card is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/



class Module extends CWebModule {

	public $defaultController = 'main';
	public $not_menu=false;
	public $delete=true;

	public function init() {
		$this->setImport(array(
			'application.modules.'.$this->getName() . '.models.*',
			'application.modules.'.$this->getName() . '.components.*',
			'application.modules.admin.models.*',
			'application.modules.admin.components.*',
			'application.modules.admin.components.widgets.*',
		));

		$this->setViewPath(Yii::app()->getBasePath() . '/modules/' . $this->getName(). '/views');
	}

	public function getMenuItems(){

	}
}

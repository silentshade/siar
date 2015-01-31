<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends Controller
{
	public function init()
	{
		if(!$this->module->not_menu){
			$find=AdminModules::model()->countByAttributes(array('module'=>$this->module->getName(),'state'=>1));
			if(!$find){
				throw new CHttpException(404,'Страница не найдена');
			}
		}
	}
}
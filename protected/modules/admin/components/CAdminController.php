<?php

class CAdminController extends Controller
{
	public $layout='/layouts/admin_column';

	public function init()
	{
		Yii::app()->getComponent('bootstrap');

		if(isset(Yii::app()->user->admin) && !Yii::app()->user->isGuest){

		}else{
			if(Yii::app()->user->isGuest){
				$this->forward('/admin/login');
			}else{
				$this->redirect('/');
			}
		}

		return parent::init();
	}

    public function accessRules()
    {
        return array(
			array('allow',
				'expression'=> '!Yii::app()->user->isGuest',
			),

            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

	protected function beforeAction($action)
	{
		if($action->id=='index' && $_SERVER['REQUEST_URI']!='/admin/'.$action->controller->id.'/index' && $_SERVER['REQUEST_URI']!='/admin/'.$action->controller->id && !isset($_GET['export_xls'])
			&& !isset($_GET['export']) && !isset($_GET['export_mnemo']) && !isset($_GET['export_english'])){
			$filter=AdminFilters::model()->findByAttributes(array('user'=>Yii::app()->user->getID(),'controller'=>$action->controller->id));
			if(!$filter){
				$filter=new AdminFilters();
				$filter->controller=$action->controller->id;
				$filter->filter=  serialize($_GET);
				$filter->uri= Yii::app()->getRequest()->getUrl();
				$filter->save();
			}else{
				$filter->controller=$action->controller->id;
				$filter->filter=serialize($_GET);
				$filter->uri=Yii::app()->getRequest()->getUrl();
				$filter->save();
			}
		}
		if($action->id=='index' && !isset($_GET['ajax'])){
			$filter=AdminFilters::model()->findByAttributes(array('user'=>Yii::app()->user->getID(),'controller'=>$action->controller->id));
			if($filter){
				//$this->redirect($filter->filter);
				$_GET=unserialize($filter->filter);
				$_POST['grid_keys']=$filter->uri;
			}
		}


		return true;
	}

	public function actionProcessItems(){
		if($_POST['selectedItems']=='delete'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->delete();
				}
			}
		}

		if($_POST['selectedItems']=='publish'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->published=1;
					$model->save();
				}
			}
		}

		if($_POST['selectedItems']=='unpublish'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->published=0;
					$model->save();
				}
			}
		}

		if($_POST['selectedItems']=='active'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->active=1;
					$model->save();
				}
			}
		}

		if($_POST['selectedItems']=='unactive'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->active=0;
					$model->save();
				}
			}
		}

		if($_POST['selectedItems']=='event'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->state=1;
					$model->save();
				}
			}
		}

		if($_POST['selectedItems']=='unevent'){
			$selectedIds = $_POST['selectedIds'];
			if(count($selectedIds)>0)
			{
				foreach($selectedIds as $ids)
				{
					$model=$this->loadModel($ids);
					$model->state=1;
					$model->save();
				}
			}
		}
	}

	public function actionSavestate(){
		if($_POST['action']=='hide')
			setcookie('admin_menu_hide', '1', time()+60*60*24*365, '/admin', $_SERVER['HTTP_HOST']);
		else
			setcookie('admin_menu_hide', '', time() - 3600, '/admin', $_SERVER['HTTP_HOST']);
	}
}

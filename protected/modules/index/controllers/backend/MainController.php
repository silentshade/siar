<?php

class MainController extends CrudAdminModuleController
{
	public function actionIndex()
	{
		$model=$this->loadModel();

		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>Yii::app()->getModule($this->module->id)->seo_type));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST[$model->getModelName()]))
		{
			$model->attributes=$_POST[$model->getModelName()];

			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('index',array(
			'model'=>$model,
			'seo'=>$seo,
		));
	}

	public function loadModel()
	{
		$model=call_user_func_array(array(&$this->model, 'model'), array())->find();
		if($model===null){
			$model=new $this->model;
			$model->save(false);
		}
		return $model;
	}
}

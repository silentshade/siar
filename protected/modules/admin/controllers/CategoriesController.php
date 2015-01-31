<?php

class CategoriesController extends CAdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Categories;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
			$model->attributes=$_POST['Categories'];

			if ($model->save()) {
				$this->redirect(array('index'));
			}
		}

		$groups=Categories::model()->findAll(
			array(
				'order'=>'t.parent, t.name'
			)
		);

		$new_array=array();
		foreach ($groups as $group) {
			if($group->parent<=0){
				$new_array[$group->id]=$group->name;
				$new_array=$this->selectSearch($groups,$new_array,$group->id);
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'select_search'=>$new_array
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>SeoHelper::$Сategories));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Categories']))
		{
			$model->attributes=$_POST['Categories'];

			if ($model->save()) {
				$this->redirect(array('index'));
			}
		}

		$groups=Categories::model()->findAll(
			array(
				'order'=>'t.parent, t.name'
			)
		);

		$new_array=array();
		foreach ($groups as $group) {
			if($group->parent<=0){
				$new_array[$group->id]=$group->name;
				$new_array=$this->selectSearch($groups,$new_array,$group->id);
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'seo'=>$seo,
			'select_search'=>$new_array

		));
	}

	private function selectSearch($groups,$arr,$parent,$t='&nbsp;&nbsp;&nbsp;') {
		foreach ($groups as $group) {
			if($parent==$group->parent){
				$arr[$group->id]=$t.$group->name;
				$arr=$this->selectSearch($groups,$arr,$group->id,$t.'&nbsp;&nbsp;&nbsp;');
			}
		}
		return $arr;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/categories'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Categories',
				array('criteria'=>array(
					'order'=>'id DESC',
				))
		);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Categories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

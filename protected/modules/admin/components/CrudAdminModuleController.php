<?php

class CrudAdminModuleController extends AdminModuleController
{
   public function actions()
    {
        return array(
            'fileUpload'=>'ext.redactor.actions.FileUpload',
            'imageUpload'=>'ext.redactor.actions.ImageUpload',
            'imageList'=>'ext.redactor.actions.ImageList',
        );
    }

	public function actionCreate()
	{
		$model=new $this->model;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST[$model->getModelName()]))
		{
			$model->attributes=$_POST[$model->getModelName()];

			if(isset($_POST[$model->getModelName()]['updatedimage']))
				AdminHelper::returnDeleteImages($_POST[$model->getModelName()]['updatedimage'],'/images/'.$this->module->path_images.'/',$this->module->getName());

			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>2));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST[$model->getModelName()]))
		{
			$model->attributes=$_POST[$model->getModelName()];

			if(isset($_POST[$model->getModelName()]['updatedimage']))
				AdminHelper::returnDeleteImages($_POST[$model->getModelName()]['updatedimage'],'/images/'.$this->module->path_images.'/',$this->module->getName());

			if($model->save()){
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'seo'=>$seo,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->breadcrumbs=array('Панель администратора'=>array('/admin'),
			$this->module->name,
		);

		$model=new $this->model('search');
		$model->unsetAttributes();
		if(isset($_GET[$model->getModelName()]))
		$model->attributes=$_GET[$model->getModelName()];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionView()
	{
		$model=$this->loadModel($_GET['id']);

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=call_user_func_array(array(&$this->model, 'model'), array())->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionUpload() {
		$id=$_POST['_uid'];
		$types=array('gif','png','jpg','jpeg');
		$file=CUploadedFile::getInstanceByName('Filedata');
		if($file){
			$model=call_user_func_array(array(&$this->model, 'model'), array())->findBypk($id);

			$path_info = AdminHelper::full_pathinfo($file->name);
			$ext=strtolower($path_info['extension']);
			if(in_array($ext, $types)){
				$imagePath=$_SERVER['DOCUMENT_ROOT'].'/images/'.$this->module->path_images.'/';

				$name = ($model ? $model->id : '') . '_' .$i. '.' . $ext;
				while (file_exists($imagePath . $name)) {
					$i++;
					$name = ($model ? $model->id : '') . '_' .$i. '.' . $ext;
				}

				if(!$file->saveAs($imagePath.$name)) throw new CHttpException(500);

				$sizes=AdminImagesSizes::model()->findAllByAttributes(array('module'=>$this->module->getName()));
				if($sizes){
					foreach ($sizes as $size) {
						AdminHelper::generateImage($imagePath,$name, $size);
					}
				}

				$uploaded = new stdClass();
				$uploaded->{'name'} = $name;
				$uploaded->{'src'} = $name.'?'.  uniqid();
				echo json_encode($uploaded);
			} else{
				$uploaded = new stdClass();
				$uploaded->{'error'} = 'types error';
				echo json_encode($uploaded);
			}
		  }
	}

	public function actionJUpload() {
		$imagePath=$_SERVER['DOCUMENT_ROOT'].'/images/'.$this->module->path_images.'/';
		$data = array(
			'error' => true,
		);

		$field=key(current($_FILES)['name']);
		$modelName=key($_FILES);
		$path=isset($_POST[$modelName][$field.'_']['path']) ? $_POST[$modelName][$field.'_']['path'] : '';
		//print_r($_POST);
		//return;
		$model=$modelName::model()->findByPk($_POST[$modelName]['id']);
		if(!$model)
			$model=new $modelName();
		//$modelName = CHtml::modelName($model);

        if (Yii::app()->request->isAjaxRequest) {
			$file = CUploadedFile::getInstance($model, $field);
			if (!is_null($file)) {
				$mime=$file->getType();
				if(in_array(str_replace('image/', '', $mime), array('jpg','jpeg','png','gif'))){
					$name=SiteHelper::str2url($model->name).'_'.  uniqid();
					$ext=str_replace('image/', '', $mime);
					if(file_exists($imagePath.$name.'.'.$ext)){
						 $name=SiteHelper::str2url($model->name).'_'.$i++;
					}

					$name=$name.'.'.$ext;
					$model->$field=$name;

					if(!$file->saveAs($imagePath.$name)) throw new CHttpException(500);

					if(isset($_POST[$modelName][$field.'_']['module_sizes'])){
						$sizes=AdminImagesSizes::model()->findAllByAttributes(array('module'=>$this->module->getName()));
						if($sizes){
							foreach ($sizes as $size) {
								AdminHelper::generateImage($imagePath,$name, $size);
							}
						}
					}

					if(isset($_POST[$modelName][$field.'_']['resize'])){
						$resize=$_POST[$modelName][$field.'_']['resize'];
						$resize_arr=explode(',',$resize);
						if($resize_arr){
							foreach ($resize_arr as $resize_value) {
								$resize_value_arr=explode(':', $resize_value);
								$path_res=$resize_value_arr[0];
								$wh=explode('*',$resize_value_arr[1]);

								if(isset($_POST[$modelName][$field.'_']['crop']) && $_POST[$modelName][$field.'_']['crop']=='true'){
									copy($imagePath.$name,$imagePath.$path_res. $name);
									CenterServiceHelper::thumb($imagePath.$path_res. $name, $wh[0], $wh[1], "crop", "", "");
								}else{
									$img = Yii::app()->image->load($imagePath.$name);
									$img->resize($wh[0], $wh[1], Image::AUTO);
									$img->save($imagePath.$path_res. $name);
								}
							}
						}
					}

					//if ($model->save()) {
						$data = array(
							'error' => false,
							'image' => array(
								'id' => $model->$field,
								'src' => '/images/'.$this->module->path_images.'/'.$path.$model->$field.'?='.$model->modified,
								'actions' => array(
									'delete' => Yii::app()->createUrl('/cabinet/settings/ImageDelete', array(
										'file_id' => $model->$field
									)),
								),
							),
						);
					//}
				}
			}
		}

		echo CJSON::encode($data);
	}


	public function actionJUploadFile() {
		$imagePath=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$this->module->getName().'/';
		$data = array(
			'error' => true,
		);

		$field=key(current($_FILES)['name']);
		$modelName=key($_FILES);
		//print_r($_POST);
		//return;
		$model=$modelName::model()->findByPk($_POST[$modelName]['id']);
		if(!$model)
			$model=new $modelName();
		//$modelName = CHtml::modelName($model);

        if (Yii::app()->request->isAjaxRequest) {
			$file = CUploadedFile::getInstance($model, $field);
			if (!is_null($file)) {
				$ext=$file->getExtensionName();
				error_log($ext);
				///if(in_array(str_replace('image/', '', $mime), array('jpg','jpeg','png','gif'))){
					$name=SiteHelper::str2url($model->name).'_'.  uniqid();
					if(file_exists($imagePath.$name.'.'.$ext)){
						 $name=SiteHelper::str2url($model->name).'_'.$i++;
					}

					$name=$name.'.'.$ext;
					$model->$field=$name;

					if(!$file->saveAs($imagePath.$name)) throw new CHttpException(500);

					//if ($model->save()) {
						$data = array(
							'error' => false,
							'image' => array(
								'id' => $model->$field,
								'src' => '/uploads/'.$this->module->getName().'/'.$model->$field,
								'actions' => array(
									'delete' => Yii::app()->createUrl('/cabinet/settings/ImageDelete', array(
										'file_id' => $model->$field
									)),
								),
							),
						);
					//}
				//}
			}
		}

		echo CJSON::encode($data);
	}
}

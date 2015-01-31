<?php

class ItemsController extends CAdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Items;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Items']))
		{
			$model->attributes = $_POST['Items'];

			if(isset($_FILES['Items']['name']['image']))
			foreach ($_FILES['Items']['name']['image'] as $key=>$image) {
				$model->image[] = CUploadedFile::getInstance($model, 'image[' . $key . ']');
			}

			if ($model->save()) {
				/*$items_sizes=$_POST['items_sizes'];
				if(!empty($items_sizes)){
					foreach ($items_sizes['id'] as $value=>$key) {
						if(!empty($items_sizes['size'][$value]) && !empty($items_sizes['text'][$value]) && !empty($items_sizes['price'][$value])){
							$find=ItemSizes::model()->findByPk($value);
							if($find){
								if($items_sizes['delete'][$value]){
									$find->delete();
								}else{
									$find->size=$items_sizes['size'][$value];
									$find->text=trim($items_sizes['text'][$value]);
									$find->price=$items_sizes['price'][$value];
									$find->save();
								}

							}else{
								$item_size= new ItemSizes();
								$item_size->item=$model->id;
								$item_size->size=$items_sizes['size'][$value];
								$item_size->text=trim($items_sizes['text'][$value]);
								$item_size->price=$items_sizes['price'][$value];
								$item_size->save();
							}

						}
					}
				}
				if(ItemSizes::model()->countByAttributes(array('item'=>$model->id))==0);
					Yii::app()->user->setFlash('error','Хотя бы один комплект должен быть заполнен, товар появится на сайте, только после заполнения комплекта');
				 * */
				$model->SaveImages();
				$this->redirect(array('items/update?id='.$model->id));
			}
		}


		$groups=Categories::model()->findAll(
			array(
				'order'=>'t.parent, t.name'
			)
		);
		$new_array=array();
		if($groups)
		foreach ($groups as $group) {
			if($group->parent==0){
				$new_array[$group->name]=$this->selectSearch($groups,array(),$group->id);
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
		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>SeoHelper::$Items));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		if(isset($_POST['Items']))
		{
			$model->attributes=$_POST['Items'];
			//$model->best=$_POST['Items']['best'];


			if(isset($_FILES['Items']['name']['image']))
			foreach ($_FILES['Items']['name']['image'] as $key=>$image) {
				$model->image[] = CUploadedFile::getInstance($model, 'image[' . $key . ']');
			}

			if(isset($_POST['Items']['updatedimage']))
				SiteHelper::deleteImages($_POST['Items']['updatedimage'],'/images/items/');

			if ($model->save()) {
			/*	$items_sizes=$_POST['items_sizes'];
//				echo '<pre>';
//				print_r($_POST['items_sizes']);
//				echo '</pre>';
				if(!empty($items_sizes)){
					foreach ($items_sizes['id'] as $value=>$key) {
						if(!empty($items_sizes['size'][$value]) && !empty($items_sizes['text'][$value]) && !empty($items_sizes['price'][$value])){
							$find=ItemSizes::model()->findByPk($value);
							if($find){
								if($items_sizes['delete'][$value]){
									$find->delete();
								}else{
									$find->size=$items_sizes['size'][$value];
									$find->text=trim($items_sizes['text'][$value]);
									$find->price=$items_sizes['price'][$value];
									$find->status=$items_sizes['status'][$value];
									$find->save();
								}

							}else{
								$item_size= new ItemSizes();
								$item_size->item=$model->id;
								$item_size->size=$items_sizes['size'][$value];
								$item_size->text=trim($items_sizes['text'][$value]);
								$item_size->price=$items_sizes['price'][$value];
								$item_size->status=$items_sizes['status'][$value];
								$item_size->save();
							}

						}
					}
				}
				if(ItemSizes::model()->countByAttributes(array('item'=>$model->id))==0)
					Yii::app()->user->setFlash('error','Хотя бы один комплект должен быть заполнен, товар появится на сайте, только после заполнения комплекта');
			 * */
				$model->SaveImages();
				$this->redirect(array('items/update?id='.$model->id));
			}
		}

		$groups=Categories::model()->findAll(
			array(
				'order'=>'t.parent, t.name'
			)
		);
		$new_array=array();
		if($groups)
		foreach ($groups as $group) {
			if($group->parent==0){
				$new_array[$group->name]=$this->selectSearch($groups,array(),$group->id);
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'seo'=>$seo,
			'select_search'=>$new_array
		));
	}


	public function actionCopy($id)
	{
		$model=$this->loadModel($id);
		//$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>1));

		$item=new Items();
		$model->id='';
		$item->attributes=$model->attributes;
		$item->images='';
		$item->copy=1;
		if($item->save()){
			//$item->SaveImagesCopy($model->images);

			/*if($seo){
				$new_seo=new Seo();
				$new_seo->attributes=$seo->attributes;
				$new_seo->entity=$item->id;
				$new_seo->save();
			}*/
		}

		$this->redirect(array('items/update?id='.$item->id));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/items');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(Yii::app()->request->getParam('export')) {
			$this->actionExportXls();
			Yii::app()->end();
		}

		$model=new Items('search');
		$model->unsetAttributes();
		if(isset($_GET['Items']))
		$model->attributes=$_GET['Items'];



		$groups=Categories::model()->findAll(
			array(
				'order'=>'t.parent, t.name'
			)
		);

		$new_array=array();
		if($groups)
		foreach ($groups as $group) {
			if($group->parent<=0){
				$new_array[$group->id]=$group->name;
				$new_array=$this->selectSearch($groups,$new_array,$group->id);
			}
		}

		$this->render('index',array(
			'model'=>$model,
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Items::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='items-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchFilters()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$category = Yii::app()->request->getParam('catid');
			$id = Yii::app()->request->getParam('id');
            if ($category!=null)
            {
				//$cat=Category2::model()->findByPk($category);
				$groups=Attr::model()->findAll(array('condition'=>'FIND_IN_SET('.$category.',catid)'));

				if($groups){
					$this->renderPartial('_filters',array('groups'=>$groups,'item'=>$id ? $id : 0));
				}
            }
        }
        else
            throw new CHttpException(404);
	}

	public function actionSet_sort()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$sort=$_POST['sort'];
			$elements=explode(',',$sort);
			$i=1;
			if (!empty($elements)){
				foreach ($elements as $value) {
					Items::model()->updateByPk(
						$value,
						array('order'=>$i)
					);
					$i++;
				}
			}
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}


	private function getData() {
		$model=new Items('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Items'])) {
			$model->attributes=$_GET['Items'];
		}

		$dp = $model->search();
		$dp->setPagination(false);

		return $models = $dp->getData();
	}


	public function actionExportXls(){
		$models=$this->getData();

		$phpExcelPath = Yii::getPathOfAlias('application.vendors.PHPExcel');
		include(Yii::getPathOfAlias('application.vendors') . DIRECTORY_SEPARATOR . 'PHPExcel.php');
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
		$objPHPExcel = PHPExcel_IOFactory::load(dirname($_SERVER['SCRIPT_FILENAME'])."/uploads/example.xls");
		$row = 2;
		foreach ($models as $model) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, CHtml::value($model,'id'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, CHtml::value($model,'name'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, CHtml::value($model,'articul'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, CHtml::value($model,'price'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, CHtml::value($model,'quantity'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $model->brand->name);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, SiteHelper::$status[$model->status]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, SiteHelper::$yes_no[$model->active]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, CHtml::value($model,'desc'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, CHtml::value($model,'fulltext'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, CHtml::value($model,'description_brand'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, CHtml::value($model,'video'));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $model->category->globalcat->globalcat->name);
			$row++;
		}
		ob_start();
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		$s = ob_get_contents();
		ob_end_clean();
		Yii::app()->user->setState('export_xls', $s);
	}

	public function actionGetExportFile()
	{
		Yii::app()->request->sendFile('items-'.date('Y-m-j H-i-s').'.xls',Yii::app()->user->getState('export_xls'));
		Yii::app()->user->clearState('export_xls');
	}

	public function actionImportXls(){
		if(is_uploaded_file($_FILES['file']["tmp_name"])){
			$phpExcelPath = Yii::getPathOfAlias('application.vendors.PHPExcel');
			include(Yii::getPathOfAlias('application.vendors') . DIRECTORY_SEPARATOR . 'PHPExcel.php');

			//copy($_FILES['file']["tmp_name"], dirname($_SERVER['SCRIPT_FILENAME']).'/xls/'.uniqid().'.xls');
			$tname='uploads/xls/'.uniqid().'.xls';
			move_uploaded_file($_FILES['file']["tmp_name"], $tname);
			$objReader = PHPExcel_IOFactory::createReaderForFile(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$tname);
			$objReader->setReadDataOnly(true);
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
			$objPHPExcel = PHPExcel_IOFactory::load(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$tname);
			unset($objReader);
			$row = 2; $end=true;
			do{
				if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue()=='')
					$end=false;
				else{
					$data[$row-2]=new stdClass();
					$data[$row-2]->id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
					$data[$row-2]->name=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
					$data[$row-2]->articul=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
					$data[$row-2]->price=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
					$data[$row-2]->quantity=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();

					$brand_cell=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
					$brand_id='';
					if($brand_cell){
						$brand=Brand::model()->findByAttributes(array('name'=>$brand_cell));
						if($brand){
							$brand_id=$brand->id;
						}
					}
					$data[$row-2]->brand_id=$brand_id;

					$data[$row-2]->status=array_search($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue(), SiteHelper::$status);
					$data[$row-2]->active=array_search(trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue()), SiteHelper::$yes_no);
					$data[$row-2]->desc=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
					$data[$row-2]->fulltext=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
					$data[$row-2]->description_brand=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
					$data[$row-2]->video=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();

					$category_cell=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getValue();
					$category_id='';
					if($category_cell){
						$category=Category2::model()->findByAttributes(array('name'=>$category_cell));
						if($category){
							$category_id=$category->id;
						}
					}
					$data[$row-2]->catid=$category_id;



					$row++;
				}
			} while($end);
			unset($objPHPExcel);
			/* PHPExcel */
			$i=2;

			foreach ($data as $value) {
				$find=Items::model()->findByPk($value->id);
				if($find && !empty($value->id)){
					$model=$find;
				}else{
					$model= new Items();
				}
				$model->name=trim($value->name);
				$model->articul=trim($value->articul);
				$model->price=trim($value->price);
				$model->quantity=trim($value->quantity);
				$model->brand_id=trim($value->brand_id);
				$model->status=trim($value->status);
				$model->active=trim($value->active);
				$model->desc=trim($value->desc);
				$model->fulltext=trim($value->fulltext);
				$model->description_brand=trim($value->description_brand);
				$model->video=trim($value->video);
				$model->catid=trim($value->catid);
				$model->save();
				$i++;
			}
		}
		$this->redirect('/admin/items');
	}
}

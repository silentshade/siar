<?php
class ItemsController extends Controller {

	public function actionView(){
		$model=$this->loadModel($_GET['id']);

		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>SeoHelper::$Items));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}else{
			$this->pageTitle=$model->name;
			$this->metaDescription=$model->name;
			$this->metaKeywords=$model->name;
		}

		
		$this->render('view',array('model'=>$model));
	}

	private function loadModel($id)
	{
		$model=Items::model()->findByPk($id,'active=1');
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
<?php
class GalleryController extends Controller {
	public function actionIndex(){
		$seo=Seo::model()->findByAttributes(array('entity'=>18,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}


		$albums=Albums::model()->findAll(array('order'=>'sort asc'));
		if($albums){
			$model=Albums::model()->findByPk(isset($_GET['id']) ? $_GET['id'] : $albums[0]->id);
		}

		$page=Pages::model()->findByAttributes(array('alias'=>'gallery','visible'=>1));
		$this->render('index',array('albums'=>$albums,'model'=>$model,'page'=>$page));
	}
}
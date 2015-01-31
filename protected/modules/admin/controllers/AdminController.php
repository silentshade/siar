<?php

class AdminController extends CAdminController
{

    public function actionIndex()
    {
		$this->pageTitle=Yii::app()->params['siteName'].' - Панель администратора';
        $this->render('index');
    }

	public function actionGenerateImage(){
		$items=News::model()->findAll(array('condition'=>'images<>""'));
		if($items){
			$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/news/';
			foreach ($items as $item) {
				$images=SiteHelper::returnArrayImagesFromDB($item->images);
				if($images){
					foreach ($images as $name) {
						if(is_file($imagePath. $name)){							
							$image = Yii::app()->image->load($imagePath. $name);
							$image->resize(88, 88, Image::AUTO);
							$image->save($imagePath .'mini/'. $name);

							copy($imagePath. $name,$imagePath .'small/'. $name);
							CenterServiceHelper::thumb($imagePath .'small/'. $name, 157, 157, "crop", "", "");

							copy($imagePath. $name,$imagePath .'middle/'. $name);
							CenterServiceHelper::thumb($imagePath .'middle/'. $name, 290, 136, "crop", "", "");
						}
					}
				}
			}
		}
		echo 'finished';
	}
}

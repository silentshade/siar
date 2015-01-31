<?php

class SearchController extends Controller
{
	public function actionIndex()
    {
		$this->pageTitle=Yii::t('main','Поиск').' - '.CHtml::encode($_GET['q']);

		$criteria=new CDbCriteria();
		$criteria->condition='t.active=1 AND (t.name LIKE :q OR t.articul LIKE :q OR t.desc LIKE :q)';
		$criteria->params=array(':q'=>"%".$_GET['q']."%");
		

		$dataProvider=new CActiveDataProvider('Items', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>Yii::app()->params['numItems'],
					'pageVar'=>'page',
				),
				'sort'=>array(
					'defaultOrder'=>'name'
				)
			)
		);

		$this->render('index',array('dataProvider'=>$dataProvider));
    }
}
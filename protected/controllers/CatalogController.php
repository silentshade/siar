<?php
class CatalogController extends Controller {

	public function actionIndex(){
		$seo=Seo::model()->findByAttributes(array('entity'=>2,'type'=>4));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}

		$criteria=new CDbCriteria();
		$criteria->condition='t.active=1';
		if(isset($_GET['id'])){
			$ids=array_unique(CenterServiceHelper::getCatIds($_GET['id'],array()));
			$criteria->addInCondition('t.catid', $ids);
		}

		$dataProvider=new CActiveDataProvider('Items', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>Yii::app()->params['numItems'],
					'pageVar'=>'page',
				),
				'sort'=>array(
					'defaultOrder'=>'t.status asc, t.name asc'
				)
			)
		);

		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionSearch() {
		$seo=Seo::model()->findByAttributes(array('entity'=>2,'type'=>4));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}

		$criteria=new CDbCriteria();
		$criteria->condition='active=1';
		$criteria->compare('size_width', $_GET['size_width']);
		$criteria->compare('size_height', $_GET['size_height']);
		$criteria->compare('size_duym', $_GET['size_duym']);
		$criteria->compare('sezon', $_GET['sezon']);


		$dataProvider=new CActiveDataProvider('Items', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>'4',
					'pageVar'=>'page',
				),
				'sort'=>array(
					'defaultOrder'=>'name'
				)
			)
		);

		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionQuickSearch() {
		$criteria=new CDbCriteria();
		$criteria->condition='t.active=1 AND (t.name LIKE :q OR t.articul LIKE :q OR t.desc LIKE :q)';
		$criteria->params=array(':q'=>"%".$_GET['term']."%");
		$criteria->order='t.name asc';
		$criteria->limit=10;

		$items=Items::model()->findAll($criteria);

		if($items){
			foreach ($items as $value) {
				$objects[]=array(
					'value'=>$value->name,
					'url'=>SiteHelper::str2url($value->name).'-p'.$value->id,
					'image'=>SiteHelper::returnOneImages($value->images),
					'description'=>'<div class="text">'.$value->name.' <br><span>'.SiteHelper::unsignZeros($value->price,'',0).' грн.</span></div>',
				);
			}
		}
		echo json_encode($objects);
	}
}
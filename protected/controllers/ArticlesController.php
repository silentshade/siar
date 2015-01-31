<?php
class ArticlesController extends Controller {

	public function actionIndex(){
		$seo=Seo::model()->findByAttributes(array('entity'=>4,'type'=>4));
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

		$dataProvider=new CActiveDataProvider('Articles', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>Yii::app()->params['numItems'],
					'pageVar'=>'page',
				),
				'sort'=>array(
					'defaultOrder'=>'t.created desc'
				)
			)
		);

		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionView(){
		$model=$this->loadModel($_GET['id']);

		$seo=Seo::model()->findByAttributes(array('entity'=>$model->id,'type'=>SeoHelper::$Articles));
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
		$model=Articles::model()->findByPk($id,'active=1');
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
<?php
Yii::import('journal.models.Journal');
Yii::import('conferences.models.Conferences');
//Yii::import('search.models.Search');

class MainController extends FrontController
{
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'condition'=>'t.published=1',
			//'join'=>'left join articles on articles.id left join articles as articles1 on articles1.id left join articles as articles2 on articles2.id',
			'order'=>'t.created desc'
		));

		if(isset($_POST['q'])){
			$criteria2 = new CDbCriteria;
			$criteria2->addSearchCondition('name', $_POST['q'], true, 'OR');
			$criteria2->addSearchCondition('text', $_GET['q'], true, 'OR');

			$criteria->mergeWith($criteria2);


			$find=Search::model()->find(array('order'=>'id desc'));
			if($find && $find->name==$_POST['q']){
				$find->save();
			}else{
				$command=Yii::app()->db->createCommand("INSERT INTO search SET name=:q,created=NOW(),modified=NOW()");
				$command->bindParam(':q',$_POST['q']);
				$command->execute();
				/*$search=new Search();
				$search->name=$_GET['q'];
				$search->save();
				if($search->save()){
					echo 'saved';
				}else{
					echo 'not saved';
					print_r($search->getErrors());
				}*/
			}
		}

		$criteria->offset=0;
		$criteria->limit=Yii::app()->params['search_pagination'];

		$items=Conferences::model()->findAll($criteria);

		$this->renderPartial('/index', array(
			'items'=>$items,
		));
	}

	/*public function loadModel($id)
	{
		$model=Actions::model()->findByPk($id);
		if($model===null || $model->published==0)
			throw new CHttpException(404,'Страница не найдена');
		return $model;
	}*/
}
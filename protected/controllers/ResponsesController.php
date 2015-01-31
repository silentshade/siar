<?php

class ResponsesController extends Controller
{
	public function actionIndex()
	{
		$seo=Seo::model()->findByAttributes(array('entity'=>14,'type'=>3));
		if($seo){
			$this->pageTitle=$seo->title;
			$this->metaDescription=$seo->description;
			$this->metaKeywords=$seo->keywords;
		}
		$criteria=new CDbCriteria(array(
			'condition'=>'t.published=1',
			//'join'=>'left join articles on articles.id left join articles as articles1 on articles1.id left join articles as articles2 on articles2.id',
			'order'=>'t.created desc'
		));

		$pagination = new CPagination;
		$pagination->pageSize=6;
		$pagination->pageVar='page';

		$items=new CActiveDataProvider('Response',array(
			'criteria'=>$criteria,
			'pagination'=>$pagination
		));

		$page=Pages::model()->findByAttributes(array('alias'=>'responses','visible'=>1));

		$this->render('index',array('items'=>$items,'page'=>$page));
	}

	public function actionAdd() {
		if(isset($_POST))
		{
			$model=new Response;
			$model->name=$_POST['name'];
			$model->rate=$_POST['rate'];
			$model->text=strip_tags($_POST['text']);

			if($model->save()){
				$this->redirect('/responses');
			}
		}

		$this->redirect('/responses');
	}
}
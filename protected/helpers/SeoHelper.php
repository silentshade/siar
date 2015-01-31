<?php
/**
 * Хелпер со вспомогательными функциями, те функции,
 * которые можно использовать на всем пути приложения,
 * без создания экземпляра класса, путем вызова статических функции и свойств.
 */
class SeoHelper
{
	public static $Сategories=20;
	public static $Items=22;
	public static $News=23;
	public static $Articles=28;

	public static function cacheSeoPage($entity,$type,$model=NULL){
		if(Yii::app()->hasComponent('cache')){
			$seo = Yii::app()->cache->get('seo_'.$entity.$type);
		}

		if(!$seo){
			$seo=Seo::model()->find(array(
				'select'=>'title,description,keywords',
				'condition'=>'entity=:entity AND type=:type',
				'params'=>array(':entity'=>$entity,':type'=>$type)
				)
			);
			if(Yii::app()->hasComponent('cache'))
				Yii::app()->cache->set('seo_'.$entity.$type, $seo, Yii::app()->params['cache_time']);
		}

		$page = (int)Yii::app()->request->getQuery('page', 1);

		if($seo){
			Yii::app()->controller->pageTitle=$seo->title. ($page > 1 ? ' - Страница ' . $page : '');
			Yii::app()->controller->metaDescription=$seo->description. ($page > 1 ? ' - Страница ' . $page : '');
			Yii::app()->controller->metaKeywords=$seo->keywords. ($page > 1 ? ' - Страница ' . $page : '');
		}elseif($model){
			$this->pageTitle=$model->name. ($page > 1 ? ' - Страница ' . $page : '');
			$this->metaDescription=$model->name. ($page > 1 ? ' - Страница ' . $page : '');
			$this->metaKeywords=$model->name. ($page > 1 ? ' - Страница ' . $page : '');
		}
	}
}
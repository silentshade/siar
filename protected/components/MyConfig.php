<?php

class MyConfig extends CApplicationComponent
{
    public $cachingTime;
	public static $cacheName = 'app_params';

	public function init(){
		$this->cachingTime = 3600;
		try{
			$this->loadConfig();
		} catch (Exception $e) {
			
		}
	}

	private function loadConfig() {
		if(Yii::app()->hasComponent('cache'))
			$model = Yii::app()->cache->get(self::$cacheName);
		if(!$model) {
			$model=Yii::app()->db->createCommand('SELECT param,value FROM {{config}}')->setFetchMode(PDO::FETCH_OBJ)->queryAll();
			if(Yii::app()->hasComponent('cache'))
				Yii::app()->cache->set(self::$cacheName, $model, $this->cachingTime);
		}
		foreach ($model as $key) {
			Yii::app()->params[$key->param] = $key->value;
		}
	}

	public static function clearCache(){
		if(Yii::app()->hasComponent('cache'))
			Yii::app()->cache->delete(self::$cacheName);
	}
}
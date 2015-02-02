<?php

class FeedInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=false;
	public $module;
	public $images=array();

	protected function upSql(){
		$config=new Config();
		$config->module=$this->module;
		$config->param=$this->module.'_limit';
		$config->value=20;
		$config->default=20;
		$config->label='Максимальное кол-во элементов в ленте';
		$config->type='int';
		$config->save();

		$config=new Config();
		$config->module=$this->module;
		$config->param=$this->module.'_limit_word_description';
		$config->value=20;
		$config->default=20;
		$config->label='Максимальное кол-во слов в описании записи';
		$config->type='int';
		$config->save();
	}

	protected function downSql(){
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

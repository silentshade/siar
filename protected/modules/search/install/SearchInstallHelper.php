<?php

class SearchInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `search`;
CREATE TABLE `search` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='search';
		$config->param='search_pagination';
		$config->value=10;
		$config->default=10;
		$config->label='Кол-во результатов на странице';
		$config->type='int';
		$config->save();

		$pages=new SeoPages();
		$pages->module='search';
		$pages->name='Поиск';
		$pages->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('search');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		Pages::model()->deleteAllByAttributes(array('alias'=>'search'));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

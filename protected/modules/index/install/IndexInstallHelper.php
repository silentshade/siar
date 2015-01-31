<?php

class IndexInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;
	public $images=array();

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `index_page`;
CREATE TABLE `index_page` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок 1 (слева)',
  `text` varchar(255) NOT NULL COMMENT 'Текст 1 (слева)',
  `name2` varchar(255) NOT NULL COMMENT 'Заголовок 2 (справа)',
  `text2` text NOT NULL COMMENT 'Текст 2 (справа)',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('index');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

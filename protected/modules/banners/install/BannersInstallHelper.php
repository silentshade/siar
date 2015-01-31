<?php

class BannersInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=false;
	public $module;
	public $images=array(
		'admin'=>array(
			'width'=>88,
			'heigth'=>88,
			'method'=>'auto'
		),
		'right'=>array(
			'width'=>120,
			'heigth'=>210,
			'method'=>'width'
		),
		'page'=>array(
			'width'=>659,
			'heigth'=>240,
			'method'=>'width'
		),
	);

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Ссылка',
  `sort` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT 'Сортировка',

  `place` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'Место',
  `views` smallint(6) unsigned NOT NULL COMMENT 'Просмотров',
  `clicked` smallint(6) unsigned NOT NULL COMMENT 'Кликов',

  `images` varchar(255) DEFAULT NULL COMMENT 'Баннер',

  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Опубликовано',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('banners');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

<?php

class StaffInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;
	public $images=array(
		'admin'=>array(
			'width'=>88,
			'heigth'=>88,
			'method'=>'auto'
		),
		'small'=>array(
			'width'=>100,
			'heigth'=>140,
			'method'=>'width'
		),
	);

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'ФИО',
  `job` varchar(255) NOT NULL COMMENT 'Должность',
  `text` text NOT NULL COMMENT 'Описание',

  `images` varchar(255) DEFAULT NULL COMMENT 'Фото',
  `sort` smallint(6) unsigned DEFAULT '0' COMMENT 'Сортировка',

  `all_row` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Вывести на всю строку',

  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Опубликовано',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('staff');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

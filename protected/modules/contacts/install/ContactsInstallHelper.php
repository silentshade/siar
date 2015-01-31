<?php

class ContactsInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=false;
	public $module;
	public $images=array();

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Текст',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$pages=new SeoPages();
		$pages->module='contacts';
		$pages->name='Контакты';
		$pages->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('contacts');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		Pages::model()->deleteAllByAttributes(array('alias'=>'contacts'));
	}
}

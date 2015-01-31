<?php

class LibraryInstallHelper extends MainInstallHelper {
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
			'width'=>90,
			'heigth'=>140,
			'method'=>'width'
		),
	);

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `library`;
CREATE TABLE `library` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Описание',
  `author` varchar(255) NOT NULL COMMENT 'Автор',
  `date_published` date NOT NULL COMMENT 'Дата публикации',
  `publisher` varchar(255) NOT NULL COMMENT 'Издатель',

  `images` varchar(255) DEFAULT NULL COMMENT 'Обложка',
  `file` varchar(255) DEFAULT NULL COMMENT 'Файл',


  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Опубликовано',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='library';
		$config->param='library_pagination';
		$config->value=4;
		$config->default=4;
		$config->label='Кол-во книг на странице';
		$config->type='int';
		$config->save();

		$pages=new SeoPages();
		$pages->module='library';
		$pages->name='Страница библиотеки';
		$pages->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('library');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

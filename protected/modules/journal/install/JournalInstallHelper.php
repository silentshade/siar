<?php

class JournalInstallHelper extends MainInstallHelper {
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
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `date_published` date NOT NULL COMMENT 'Дата выпуска журнала',
  `tom` varchar(255) NOT NULL COMMENT 'Том',
  `type` varchar(255) NOT NULL COMMENT 'Тип',
  `nomer` varchar(255) NOT NULL COMMENT 'Номер',

  `images` varchar(255) DEFAULT NULL COMMENT 'Обложка',
  `file` varchar(255) DEFAULT NULL COMMENT 'Файл',


  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Опубликовано',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `journal_page`;
CREATE TABLE `journal_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Описание',

  `redactor_collegy` varchar(255) NOT NULL COMMENT 'Редакционная коллегия',
  `redactor_collegy_text` text NOT NULL COMMENT 'Состав коллегии',
  `redactor_advice` varchar(255) NOT NULL COMMENT 'Редакционный совет',
  `redactor_advice_text` text NOT NULL COMMENT 'Состав совета',


  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='journal';
		$config->param='journal_pagination';
		$config->value=12;
		$config->default=12;
		$config->label='Кол-во журналов на странице';
		$config->type='int';
		$config->save();

		/*$pages=new SeoPages();
		$pages->module='journal';
		$pages->name='Страница журнала';
		$pages->save();*/
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('journal');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

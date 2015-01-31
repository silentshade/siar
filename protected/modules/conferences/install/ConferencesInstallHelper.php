<?php

class ConferencesInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;
	public $images=array();

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `conferences`;
CREATE TABLE `conferences` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Описание',
  `begin_conf` datetime NOT NULL COMMENT 'Начало конференции',
  `end_conf` datetime NOT NULL COMMENT 'Конец конференции',

  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Опубликовано',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='conferences';
		$config->param='conferences_pagination';
		$config->value=20;
		$config->default=20;
		$config->label='Кол-во конференций на странице';
		$config->type='int';
		$config->save();

		$config=new Config();
		$config->module='conferences';
		$config->param='conferences_count_left_block';
		$config->value=5;
		$config->default=5;
		$config->label='Кол-во конференций в блоке слева';
		$config->type='int';
		$config->save();

		$pages=new SeoPages();
		$pages->module='conferences';
		$pages->name='Страница конференций';
		$pages->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('conferences');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

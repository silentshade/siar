<?php

class MailingInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `mailing`;
CREATE TABLE `mailing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Тема',
  `email` text NOT NULL COMMENT 'Email',
  `text` text NOT NULL COMMENT 'Текст',
  `sented` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Отправлена',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		/*$config=new Config();
		$config->module=$this->module;
		$config->param=$this->module.'_pagination';
		$config->value=50;
		$config->default=50;
		$config->label='Кол-во отправляемых email за раз';
		$config->type='int';
		$config->save();*/
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('mailing');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

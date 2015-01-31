<?php

class Admin_usersInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;
	public $images=array(
		'admin'=>array(
			'width'=>88,
			'heigth'=>88,
			'method'=>'crop'
		),
		'small'=>array(
			'width'=>150,
			'heigth'=>150,
			'method'=>'auto'
		),
	);

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `user`;
CREATE TABLE `admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `images` text,
  `lastlogin` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

/*		$config=new Config();
		$config->module='news';
		$config->param='news_pagination';
		$config->value=10;
		$config->default=10;
		$config->label='Кол-во новостей на странице';
		$config->type='int';
		$config->save();

		$pages=new Pages();
		$pages->alias='news';
		$pages->name='Новости';
		$pages->controller='news';
		$pages->visible=1;
		$pages->delete=0;
		$pages->save();*/
	}

	protected function downSql(){
		/*Yii::app()->db->createCommand()->dropTable('news');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		Pages::model()->deleteAllByAttributes(array('alias'=>'news'));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));*/
	}
}

<?php

class UsersInstallHelper extends MainInstallHelper {
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
			'width'=>100,
			'heigth'=>100,
			'method'=>'crop'
		),
	);

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL COMMENT 'Логин',
  `email` varchar(255) NOT NULL COMMENT 'Email',
  `password` varchar(32) NOT NULL COMMENT 'Пароль',
  `hash` varchar(32) NOT NULL,

  `firstname` varchar(255) NOT NULL COMMENT 'Имя',
  `lastname` varchar(255) NOT NULL COMMENT 'Фамилия',
  `midname` varchar(255) NOT NULL COMMENT 'Отчество',
  `workplace` varchar(255) NOT NULL COMMENT 'Место работы',
  `job` varchar(255) NOT NULL COMMENT 'Работа',
  `address` varchar(255) NULL COMMENT 'Адрес',
  `birthday` date NOT NULL COMMENT 'Дата рождения',

  `images` text COMMENT 'Аватар',
  `lastlogin` datetime DEFAULT NULL,

  `logincount` int(11) unsigned DEFAULT 0 NOT NULL,
  `failedlogincount` int(11) unsigned DEFAULT 0 NOT NULL,

  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `blocked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `user_remind`;
CREATE TABLE `user_remind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;")->execute();

		$config=new Config();
		$config->module=$this->module;
		$config->param=$this->module.'_ext';
		$config->value='jpeg,jpg,gif,png';
		$config->default='jpeg,jpg,gif,png';
		$config->label='Доступные файлы для загрузки';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->module=$this->module;
		$config->param=$this->module.'_size';
		$config->value='100';
		$config->default='100';
		$config->label='Размер файла в Кб';
		$config->help='1Mb=1024kb';
		$config->type='int';
		$config->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('users');
		Yii::app()->db->createCommand()->dropTable('user_remind');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

<?php

class AdminInstallHelper extends MainInstallHelper {
	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `admin_filters`;
			CREATE TABLE `admin_filters` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`user` int(10) unsigned NOT NULL,
			`controller` varchar(255) NOT NULL,
			`filter` text,
			`uri` text,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		  ")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `admin_images_sizes`;
			CREATE TABLE `admin_images_sizes` (
		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`module` varchar(255) NOT NULL,
		`size` varchar(255) NOT NULL,
		`width` smallint(5) unsigned NOT NULL,
		`heigth` smallint(5) unsigned NOT NULL,
		`method` varchar(255) NOT NULL,
		`created` datetime DEFAULT NULL,
		`modified` datetime DEFAULT NULL,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `admin_modules`;
			CREATE TABLE `admin_modules` (
  `module` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - not installed;\r\n1 - installed;',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `delete` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `seo`;
			CREATE TABLE `seo` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`entity` int(11) NOT NULL,
			`type` tinyint(1) NOT NULL COMMENT '1-товар;2-новость;3-страница сайта;',
			`module` varchar(255) DEFAULT NULL,
			`title` varchar(255) NOT NULL,
			`description` varchar(255) NOT NULL,
			`keywords` varchar(255) NOT NULL,
			`created` datetime DEFAULT NULL,
			`modified` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `entity` (`entity`,`type`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `seo_pages`;
			CREATE TABLE `seo_pages` (
		`id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL,
		`module` varchar(255) DEFAULT NULL,
		`created` datetime DEFAULT NULL,
		`modified` datetime DEFAULT NULL,
		PRIMARY KEY (`id`)
	  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	  ")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `pages`;
			CREATE TABLE `pages` (
		`id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL,
		`alias` varchar(255) DEFAULT NULL,
		`text` text NOT NULL,
		`created` datetime DEFAULT NULL,
		`modified` datetime DEFAULT NULL,
		`visible` tinyint(1) DEFAULT '1',
		`delete` tinyint(1) unsigned DEFAULT '1',
		`in_footer` tinyint(1) unsigned NOT NULL DEFAULT '0',
		`in_header` tinyint(1) unsigned NOT NULL DEFAULT '0',
		`controller` varchar(255) DEFAULT NULL,
		`action` varchar(255) DEFAULT NULL,
		`dev_alias` varchar(255) DEFAULT NULL,
		`header_order` smallint(5) unsigned NOT NULL DEFAULT '0',
		`footer_order` smallint(5) unsigned NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `config`;
			CREATE TABLE `config` (
		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`section` varchar(255) NOT NULL,
		`module` varchar(255) DEFAULT NULL,
		`param` varchar(128) NOT NULL,
		`value` text NOT NULL,
		`default` text NOT NULL,
		`label` varchar(255) NOT NULL,
		`type` enum('string','bool','text','html','email','int') NOT NULL,
		`modified` datetime DEFAULT NULL,
		`notDelete` tinyint(1) unsigned NOT NULL DEFAULT '0',
		`help` varchar(255) DEFAULT NULL,
		`visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
		PRIMARY KEY (`id`),
		UNIQUE KEY `param` (`param`) USING BTREE
	  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->section='Главные';
		$config->module='';
		$config->param='siteheart';
		$config->value='';
		$config->default='';
		$config->label='Код чата siteheart';
		$config->type='text';
		$config->save();

		$config=new Config();
		$config->section='Почта';
		$config->module='';
		$config->param='noreplyEmail';
		$config->value='test@example.com';
		$config->default='';
		$config->label='No-reply email';
		$config->type='text';
		$config->save();

		$config=new Config();
		$config->section='Почта';
		$config->module='';
		$config->param='fromName';
		$config->value='TestSite';
		$config->default='';
		$config->label='Имя при отправке почты с сайта';
		$config->type='text';
		$config->save();

		$config=new Config();
		$config->section='Соцсети';
		$config->module='';
		$config->param='twitter_link';
		$config->value='#';
		$config->default='';
		$config->label='Ссылка на twitter';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->section='Соцсети';
		$config->module='';
		$config->param='facebook_link';
		$config->value='#';
		$config->default='';
		$config->label='Ссылка на facebook';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->section='Соцсети';
		$config->module='';
		$config->param='youtube_link';
		$config->value='#';
		$config->default='';
		$config->label='Ссылка на youtube';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->section='Админка';
		$config->module='';
		$config->param='siteName';
		$config->value='Test';
		$config->default='';
		$config->label='Название сайта';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->section='Сайт';
		$config->module='';
		$config->param='google_analitika';
		$config->value='';
		$config->default='';
		$config->label='Google аналитика';
		$config->type='text';
		$config->save();

		$pages=new SeoPages();
		$pages->module='index';
		$pages->name='Главная';
		$pages->save();

		$pages=new Pages();
		$pages->name='404';
		$pages->alias='404';
		$pages->delete=0;
		$pages->save(false);

		/*$pages=new Pages();
		$pages->name='О компании';
		$pages->alias='about';
		$pages->delete=0;
		$pages->save(false);*/

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

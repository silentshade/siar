<?php

class FeedbackInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=false;
	public $module;
	public $images=array();

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Имя',
  `email` varchar(255) NOT NULL COMMENT 'Email',
  `theme` varchar(255) NOT NULL COMMENT 'Тема',
  `text` text NOT NULL COMMENT 'Текст',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='feedback';
		$config->param='feedback_emails';
		$config->value='';
		$config->default='';
		$config->label='Email';
		$config->help='Можно ввести несколько email, через запятую, на них будут отправлены письма';
		$config->type='text';
		$config->save();

		$config=new Config();
		$config->module='feedback';
		$config->param='feedback_text';
		$config->value='Ваше сообщение успешно отправлено';
		$config->default='Ваше сообщение успешно отправлено';
		$config->label='Текст после отправки';
		$config->help='Текст, который отображается пользователю после отправки';
		$config->type='text';
		$config->save();

		$config=new Config();
		$config->module='feedback';
		$config->param='feedback_theme';
		$config->value='Вопросы по сайту;Общие вопросы';
		$config->default='Вопросы по сайту;Общие вопросы';
		$config->label='Темы для обратной связи';
		$config->help='Можно ввести несколько тем, разделять точкой с запятой';
		$config->type='text';
		$config->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('feedback');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		Pages::model()->deleteAllByAttributes(array('alias'=>'feedback'));
	}
}

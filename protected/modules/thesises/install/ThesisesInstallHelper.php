<?php

class ThesisesInstallHelper extends MainInstallHelper {
	public $path_images;
	public $uploads_dir=true;
	public $module;
	public $images=array();

	protected function upSql(){
		Yii::app()->db->createCommand("DROP TABLE IF EXISTS `thesises`;
CREATE TABLE `thesises` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_conf` varchar(255) NOT NULL COMMENT 'Название конференции',
  `name_thesis` varchar(255) NOT NULL COMMENT 'Название тезиса',
  `text` text NOT NULL COMMENT 'Комментарий к тезису',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',

  `file` varchar(255) DEFAULT NULL COMMENT 'Сопровождающий документ',

  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;")->execute();

		$config=new Config();
		$config->module='thesises';
		$config->param='thesises_ext';
		$config->value='jpg,gif,png,doc,docx,xls,xlsx,txt';
		$config->default='jpg,gif,png,doc,docx,xls,xlsx,txt';
		$config->label='Доступные файлы для загрузки';
		$config->type='string';
		$config->save();

		$config=new Config();
		$config->module='thesises';
		$config->param='thesises_size';
		$config->value='25';
		$config->default='25';
		$config->label='Размер файла в Мб';
		$config->type='int';
		$config->save();
	}

	protected function downSql(){
		Yii::app()->db->createCommand()->dropTable('thesises');
		Config::model()->deleteAllByAttributes(array('module'=>$this->module));
		SeoPages::model()->deleteAllByAttributes(array('module'=>$this->module));
		AdminImagesSizes::model()->deleteAllByAttributes(array('module'=>$this->module));
	}
}

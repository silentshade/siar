<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class InstallForm extends CFormModel
{
	public $db_host = 'localhost';
	public $db_user = 'root';
	public $db_port = '3306';
	public $db_password;
	public $db_name;
	//public $db_prefix = 'corp_';

	public $admin_email;
	public $admin_password;

	public function rules()	{
		return array(
			array('db_user, db_host, db_name, admin_password, admin_email', 'required'),
			array('admin_email', 'email'),
			//array('db_user, db_password, db_name', 'length', 'max' => 30),
			array('db_host', 'length', 'max' => 50),
			array('admin_password', 'length', 'max' => 20, 'min' => 6),
			array('db_port', 'length', 'max' => 5),
			array('db_port', 'numerical', 'allowEmpty' => true, 'integerOnly' => true),
			array('db_port,db_password', 'safe'),
		);
	}

	public function attributeLabels() {
		return array(
			'db_host' => 'Сервер базы данных',
			'db_port' => 'Порт базы данных',
			'db_user' => 'Имя пользователя БД',
			'db_password' => 'Пароль пользователя БД',
			'db_name' => 'Имя базы данных',
			//'dbPrefix' => 'Префикс для таблиц',
			'admin_password' => 'Пароль администратора',
			'admin_email' => 'Email администратора'
		);
	}
}
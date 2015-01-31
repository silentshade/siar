<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactPage extends CFormModel
{
	public $text_up;
	public $phone;
	public $address;
	public $address_input;
	public $location;
	public $zoom;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('name, email, body', 'required', 'message'=>'Поле "{attribute}" должно быть заполнено.'),
			// email has to be a valid email address
			//array('email', 'email'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'text_up'=>'Текст вверху страницы',
			'phone'=>'Телефоны',
			'address'=>'Адрес',
			'location'=>'Карта',
			'address_input'=>'Поиск по карте',
		);
	}
}
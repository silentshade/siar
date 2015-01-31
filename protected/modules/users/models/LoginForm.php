<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'Логин или email',
			'password'=>'Пароль',
			'rememberMe'=>'Запомнить',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$identity = new UserIdentity($this->username, $this->password);
			$identity->authenticate();
			switch ($identity->errorCode) {
				case UserIdentity::ERROR_NONE:
					$duration = 60 * 60 * 24 * 30;
					Yii::app()->user->login($identity, $duration);
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username', 'Неправильный email');
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError('password', 'Неправильный пароль');
					break;
			}
		}
	}
}

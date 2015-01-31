<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate($nopass=false)
	{
		Yii::import('admin_users.models.AdminUsers');
		$user=AdminUsers::model()->find(array(
			'condition'=>'email=:email OR login=:login',
			'params'=>array(':email'=>$this->username, ':login'=>$this->username)
			)
		);
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else{
			if(!$nopass){
				if(!$user->validatePassword($this->password))
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}

			if($this->errorCode!==self::ERROR_PASSWORD_INVALID){
				$this->_id=$user->id;
				$this->setState('email', $user->email);
				$this->setState('login', $user->login);

				if($user->admin)
					$this->setState('admin', 1);

				$user->lastlogin=date('Y-m-j H-i-s');
				$user->save();

				$this->errorCode=self::ERROR_NONE;
			}
		}
		return !$this->errorCode;
	}

	public function getid()
	{
		return $this->_id;
	}
}
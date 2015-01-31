<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate($nopass=false)
	{
		Yii::import('users.models.User');
		$user=User::model()->find(array(
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
				$this->setState('name', $user->firstname.' '.$user->midname);

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
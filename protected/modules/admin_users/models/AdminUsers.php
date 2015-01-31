<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $lastlogin
 */
class AdminUsers extends MainModel
{
	public $image;
	public $repeat_password;
	public $module='admin_users';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login', 'required'),
			array('email', 'email'),
			array('email, login', 'unique'),
			array('email, password', 'required','on'=>'login'),
			array('password, repeat_password', 'required', 'on'=>'passchange','message'=>'Необходимо заполнить поле'),
			array('password, repeat_password', 'length', 'min'=>5, 'on'=>'passchange', 'tooShort'=>'Минимальная длина пароля 5 символов'),
			array('email', 'unique', 'on'=>'registration'),
			array('email,name', 'length', 'max'=>255),
			array('email,password', 'required', 'on'=>'registration'),
			array('lastlogin,admin,images', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, lastlogin', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'login' => 'Логин',
			'name' => 'ФИО',
			'images' => 'Фото',
			'password' => 'Пароль',
			'repeat_password' => 'Повторите пароль',
			'lastlogin' => 'Посл. посещение',
			'admin' => 'Админ',
			'created' => 'Created',
			'modified' => 'Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('lastlogin',$this->lastlogin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function hashPassword($password) {
		//return md5(md5($password).'Lkd4@kd0');
		return md5($password);
	}

	public function validatePassword($password) {
		return $this->hashPassword($password)===$this->password;
	}
}
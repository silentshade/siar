<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $hash
 * @property string $firstname
 * @property string $lastname
 * @property string $midname
 * @property string $workplace
 * @property string $job
 * @property string $address
 * @property string $birthday
 * @property string $images
 * @property string $lastlogin
 * @property string $logincount
 * @property string $failedlogincount
 * @property string $created
 * @property string $modified
 * @property integer $blocked
 */
class User extends MainModel
{
	public $image;
	public $repeat_password;
	public $module='users';
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('email, firstname, lastname, midname, birthday', 'required'),
            array('blocked', 'numerical', 'integerOnly'=>true),
            array('login, email, firstname, lastname, midname, workplace, job, address', 'length', 'max'=>255),
            array('password, hash', 'length', 'max'=>32),
            array('logincount, failedlogincount', 'length', 'max'=>11),
            array('images, lastlogin, created, modified', 'safe'),

			array(
				'image', 'file',
				'types'=>Yii::app()->params['users_ext'],
				'maxSize'=>Yii::app()->params['users_size']*1024,
				'tooLarge'=>'Размер файла слишком велик, он не должен превышать '.Yii::app()->params['users_size'].'kb',
				'allowEmpty' => true
			),

			array('email, password', 'required','on'=>'login'),
			array('email', 'unique', 'on'=>'registration'),
			array('email', 'email'),
			array('password, repeat_password', 'required', 'on'=>'passchange','message'=>'Необходимо заполнить поле'),
			array('password, repeat_password', 'length', 'min'=>5, 'on'=>'passchange', 'tooShort'=>'Минимальная длина пароля 5 символов'),

            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, login, email, password, hash, firstname, lastname, midname, workplace, job, address, birthday, images, lastlogin, logincount, failedlogincount, created, modified, blocked', 'safe', 'on'=>'search'),
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
            'login' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'hash' => 'Hash',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'midname' => 'Отчество',
            'workplace' => 'Место работы',
            'job' => 'Должность',
            'address' => 'Адрес',
            'birthday' => 'Дата рождения',
            'images' => 'Фотография',
            'repeat_password' => 'Повторите пароль',
			'lastlogin' => 'Посл. посещение',
            'logincount' => 'Logincount',
            'failedlogincount' => 'Failedlogincount',
            'created' => 'Created',
            'modified' => 'Modified',
            'blocked' => 'Blocked',
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

		$criteria->compare('id',$this->id,true);
        $criteria->compare('login',$this->login,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('hash',$this->hash,true);
        $criteria->compare('firstname',$this->firstname,true);
        $criteria->compare('lastname',$this->lastname,true);
        $criteria->compare('midname',$this->midname,true);
        $criteria->compare('workplace',$this->workplace,true);
        $criteria->compare('job',$this->job,true);
        $criteria->compare('address',$this->address,true);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('images',$this->images,true);
        $criteria->compare('lastlogin',$this->lastlogin,true);
        $criteria->compare('logincount',$this->logincount,true);
        $criteria->compare('failedlogincount',$this->failedlogincount,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('modified',$this->modified,true);
        $criteria->compare('blocked',$this->blocked);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function hashPassword($password) {
		return md5($password);
	}

	public function validatePassword($password) {
		return $this->hashPassword($password)===$this->password;
	}
}
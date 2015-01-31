<?php

/**
 * This is the model class for table "admin_rights".
 *
 * The followings are the available columns in table 'admin_rights':
 * @property string $id
 * @property string $user
 * @property integer $rights
 * @property integer $add_by
 * @property string $created
 */
class AdminRights extends CActiveRecord
{
	const RESPONSE_MODERATOR='1';
	const RESPONSE_MODERATOR_ANSWER='6';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminRigths the static model class
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
		return 'admin_rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, add_by,rights', 'required'),
			array('rights, add_by', 'numerical', 'integerOnly'=>true),
			array('user', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user, rights, add_by, created', 'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'Users', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'User',
			'rights' => 'Rigths',
			'add_by' => 'Add By',
			'created' => 'Created',
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
		$criteria->compare('user',$this->user,true);
		$criteria->compare('rights',$this->rights);
		$criteria->compare('add_by',$this->add_by);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created=date('Y-m-j H-i-s');
			}

			return true;
		}
		else
			return false;
	}
}
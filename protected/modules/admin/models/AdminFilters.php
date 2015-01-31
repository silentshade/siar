<?php

/**
 * This is the model class for table "admin_filters".
 *
 * The followings are the available columns in table 'admin_filters':
 * @property string $id
 * @property string $user
 * @property string $controller
 * @property string $filter
 */
class AdminFilters extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminFilters the static model class
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
		return 'admin_filters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('controller', 'required'),
			array('user', 'length', 'max'=>10),
			array('controller', 'length', 'max'=>255),
			array('filter,uri', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user, controller, filter', 'safe', 'on'=>'search'),
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
			'user' => 'User',
			'controller' => 'Controller',
			'filter' => 'Filter',
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
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('filter',$this->filter,true);

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
				$this->user=Yii::app()->user->getID();
			}
			//$this->filter=str_replace(array('&ajax=grid'), '', $this->filter);
			//$this->filter=str_replace(array('&alrr'), '', $this->filter);

			return true;
		}
		else
			return false;
	}
}
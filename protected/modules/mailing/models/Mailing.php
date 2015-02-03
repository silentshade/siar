<?php

/**
 * This is the model class for table "mailing".
 *
 * The followings are the available columns in table 'mailing':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $text
 * @property integer $sented
 * @property string $created
 * @property string $modified
 */
class Mailing extends MainModel
{
	public $module='mailing';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mailing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, text', 'required'),
			array('sented', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, text, sented, created, modified', 'safe', 'on'=>'search'),
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
			'name' => 'Тема',
			'email' => 'Email',
			'text' => 'Текст',
			'sented' => 'Отправлена',
			'created' => 'Добавлена',
			'modified' => 'Изменена',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sented',$this->sented);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mailing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

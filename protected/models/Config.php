<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property string $id
 * @property string $section
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 * @property string $modified
 * @property integer $notDelete
 */
class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
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
		return '{{config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'safe'),
			array('notDelete', 'numerical', 'integerOnly'=>true),
			array('section, label', 'length', 'max'=>255),
			array('param', 'length', 'max'=>128),
			array('type', 'length', 'max'=>6),
			array('section, label, param,default,modified, type,help', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, section, param, value, default, label, type, modified, notDelete,module', 'safe', 'on'=>'search'),
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
			'section' => 'Категория',
			'param' => 'Параметр',
			'value' => 'Значение',
			'default' => 'По умолчанию',
			'label' => 'Название',
			'type' => 'Тип',
			'modified' => 'Изменен',
			'notDelete' => 'Not Delete',
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

		$criteria->condition='t.section<>""';

		$criteria->compare('id',$this->id,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('default',$this->default,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('notDelete',$this->notDelete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->modified=date('Y-m-j H-i-s');
			MyConfig::clearCache();

			return true;
		}
		else
			return false;
	}
}
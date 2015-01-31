<?php

/**
 * This is the model class for table "seo".
 *
 * The followings are the available columns in table 'seo':
 * @property string $id
 * @property integer $entity
 * @property integer $type
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $created
 * @property string $modified
 */
class Seo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Seo the static model class
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
		return 'seo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity, type, title, description, keywords', 'required'),
			array('entity, type', 'numerical', 'integerOnly'=>true),
			array('title, description, keywords,module', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entity, type, title, description, keywords, created, modified', 'safe', 'on'=>'search'),
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
			'entity' => 'Entity',
			'type' => 'Type',
			'title' => 'Title',
			'description' => 'Description',
			'keywords' => 'Keywords',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('entity',$this->entity);
		$criteria->compare('type',$this->type);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

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
			} else {
				$this->modified=date('Y-m-j H-i-s');
			}

			return true;
		}
		else
			return false;
	}

	protected function afterSave()
	{
		$this->cacheReset();
	}

	protected function afterDelete()
	{
		$this->cacheReset();
	}

	private function cacheReset(){
		if(Yii::app()->hasComponent('cache'))
			Yii::app()->cache->delete('seo_'.$this->entity.$this->type);
	}
}
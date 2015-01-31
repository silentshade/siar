<?php

/**
 * This is the model class for table "journal".
 *
 * The followings are the available columns in table 'journal':
 * @property string $id
 * @property string $name
 * @property string $date_published
 * @property string $tom
 * @property string $type
 * @property string $nomer
 * @property string $images
 * @property string $file
 * @property string $created
 * @property string $modified
 * @property integer $published
 */
class Journal extends MainModel
{
	public $image;
	public $module='journal';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'journal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date_published, tom, type, nomer', 'required'),
			array('published', 'numerical', 'integerOnly'=>true),
			array('name, tom, type, nomer, images, file', 'length', 'max'=>255),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, date_published, tom, type, nomer, images, file, created, modified, published', 'safe', 'on'=>'search'),
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
			'name' => 'Заголовок',
			'date_published' => 'Дата выпуска журнала',
			'tom' => 'Том',
			'type' => 'Тип',
			'nomer' => 'Номер',
			'images' => 'Обложка',
			'file' => 'Файл',
			'created' => 'Created',
			'modified' => 'Modified',
			'published' => 'Опубликовано',
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
		$criteria->compare('date_published',$this->date_published,true);
		$criteria->compare('tom',$this->tom,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('nomer',$this->nomer,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);
		$criteria->compare('published',$this->published);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Journal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
